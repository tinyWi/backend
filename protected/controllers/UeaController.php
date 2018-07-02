<?php
/**
 * desc   后台
 * date   2015-12-16 14:40:16
 * author xupin
 **/
class UeaController extends Controller
{
	// 用户列表
	public function actionUserList(){
		$userList = NDb::connect(UEA)->table('user')->where(['`status` >= 0'])->orderBy('username')->select();
		$auth = Yii::app()->authManager;
		foreach ($userList as $key => $user){
			$userList[$key]['ipRow'] = IP::ip2addr($user['lastip']);
			if ($roles = $auth->getRoles($user['uid'])) {
				foreach ($roles as $item) {
					$userList[$key]['roleDesc'] = $item->description;
				}
			} else {
				$userList[$key]['roleDesc'] = '普通';
			}
		}
		foreach($userList as $user){
			if(!isset($userArr[$user['roleDesc']])){
				$userArr[$user['roleDesc']] = array();
			}
			array_push($userArr[$user['roleDesc']],$user);

		}
		$listData['roleMap'] = array_unique(array_column($userList,'roleDesc'));
		$listData['userArr'] = $userArr;
		$this->render('userList',$listData);
	}

	// 修改资料
	public function actionUserMod(){
		$uid = Yii::app()->session['user']['uid'];
		$modBtn = Functions::getParam('mod');
		if($modBtn){
			$realname = Functions::getParam('realname');
			$email = Functions::getParam('email');
			$elogin = (int)Functions::getParam('agree');
			$data = [
				'realname'=>$realname,
				'email'=>$email,
				'elogin'=>$elogin
			];
			NDb::connect(UEA)->table('user')->where(["`uid` = '{$uid}'"])->update($data);
			if($password = Functions::getParam('password')) {
				$password = md5($password);
				NDb::connect(UEA)->table('user')->where(["`uid` = '{$uid}'"])->update(['password'=>$password]);
				$this->redirect($this->createUrl('Index/Logout'));
			}
		}
		$listData['userRow'] = NDb::connect(UEA)->table('user')->where(["`uid` = '{$uid}'"])->selectRow();
		$this->render('userMod',$listData);
	}

	// 设置资料
	public function actionUserSet(){
		$uid = Functions::getParam('uid');
		$modBtn = Functions::getParam('mod');
		$auth = Yii::app()->authManager;
		$listData = [];
		if($uid){
			if($modBtn){
				if($password = Functions::getParam('password')) {
					$password = md5(Functions::getParam('password'));
					NDb::connect(UEA)->table('user')->where(["`uid` = '{$uid}'"])->update(['password'=>$password]);
				}
				$status = Functions::getParam('status');
				$email = Functions::getParam('email');
				$role = Functions::getParam('role');
				$elogin = (int)Functions::getParam('agree');
				$realname = Functions::getParam('realname');
				$oldRole = Functions::getParam('oldRole');
				$data = [
					'realname'=>$realname,
					'email'=>$email,
					'elogin'=>$elogin,
					'status'=>$status
				];
				NDb::connect(UEA)->table('user')->where(["`uid` = '{$uid}'"])->update($data);
				if($auth->getRoles( $uid)){
					$auth->revoke( $oldRole, $uid);
				}
				$auth->assign( $role, $uid);
				$this->redirect($this->createUrl('Uea/UserList'));
			}else{
				foreach($auth->getRoles() as $item){
					$listData['roleList'][$item->name] = [
						'name'=>$item->name,
						'desc'=>$item->description
					];
				}
				if('developer' != Yii::app()->session['user']['rolename']){
					unset($listData['roleList']['developer']);
				}
				$listData['userRow'] = NDb::connect(UEA)->table('user')->where(["`uid` = '{$uid}'"])->selectRow();
				if( $roles = $auth->getRoles( $uid)){
					foreach($roles as $item){
						$listData['userRow']['roleRow'] = [
							'name'=>$item->name,
							'desc'=>$item->description
						];
						$oldRole = $item->name;
					}
				}else{
					$listData['userRow']['roleRow'] = [
						'name'=>'',
						'desc'=>''
					];
					$oldRole = '';
				}
				$listData['oldRole'] = $oldRole;
				$listData['uid'] = $uid;
			}
		}else{
			die( '用户编号不可为空.');
		}
		$this->render('userSet',$listData);
	}

	// 操作日志
	public function actionLogList(){
		$logList = is_file(WEB_ROOT . '/assets/log/' . date('Ymd') . '.log')? explode( "\r\n", file_get_contents( WEB_ROOT . '/assets/log/' . date('Ymd') . '.log')): [];
		$listData['logList'] = array_reverse( array_filter( $logList));
		$this->render('logList',$listData);
	}

	// 文件管理
	public function actionFileManage(){
		// 美化文件名
		$asNameList = [
			'.'=>'刷新',
			'..'=>'上一页',
		];
		// 隐藏文件
		$hideList = [
			'.git',
			'.idea',
			'data',
			'tests',
			'migrations',
			'commands',
			'messages',
		];
		$rootPath = Functions::getParam('folder')? Functions::getParam('folder'): Yii::getPathOfAlias('webroot');
		// url防止过长处理
		$checkFileList = explode( '/', $rootPath);
		foreach($checkFileList as $nowKey => $checkFile){
			if(".." == $checkFile){
				$prevKey = $nowKey - 1;
				$prev2Key = $prevKey - 1;
				if(isset($checkFileList[$prevKey]) && (isset($checkFileList[$prev2Key]) && $checkFileList[$prev2Key])){
					unset($checkFileList[$prevKey]);
					unset($checkFileList[$nowKey]);
				}
			}
			if('.' == $checkFile){
				unset($checkFileList[$nowKey]);
			}
		}
		$rootPath = implode( '/', $checkFileList);
		// 如果超出规定目录,重置路径
		$finalFileName = substr( str_replace( ["/uea","/.."], "",Yii::getPathOfAlias('webroot')), strripos( str_replace( ["/uea","/.."], "",Yii::getPathOfAlias('webroot')), "/"));
		if(substr( $rootPath, strripos( $rootPath, "/")) == $finalFileName){
			$hideList[] = "..";
		}
		$listData = [ "fileList"=>[], "folderList"=>[]];
		$fileList = $folderList = [];
		foreach(scandir($rootPath) as $file) {
			if(!in_array( $file, $hideList)) {
				$tempPath = $rootPath . '/' . $file;
				if (isset($asNameList[$file])) {
					$file = $asNameList[$file];
				}
				if (is_dir($tempPath)) {
					$folderList[] = [
						'name' => $file,
						'path' => $tempPath
					];
				} else {
					$fileList[] = [
						'name' => $file,
						'path' => $tempPath,
						'ctime' => filectime($tempPath),
						'mtime' => filemtime($tempPath),
						'atime' => fileatime($tempPath),
						'size' => Functions::byte2Format(filesize($tempPath))
					];
				}
			}
		}
		$listData['folderList'] = $folderList;
		$listData['fileList'] = $fileList;
		$listData['rootPath'] = $rootPath;
		$this->render('fileManage',$listData);
	}

	// 文件视图
	public function actionFileView(){
		$file = Functions::getParam("file");
		$listData = [ 'content'=>'// code null'];
		if(is_file( $file)){
			$listData['content'] = file_get_contents( $file);
		}
		$this->render('fileView',$listData);
	}

	// 权限管理
	public function actionAuth(){
		$role = Functions::getParam('role');
		$listData = ['itemList'=>[],'roleName'=>$role];
		$itemList = $roleList = [];
		$auth = Yii::app()->authManager;
		$taskList = $auth->getAuthItems(Consts::AUTH_TASK);
		foreach($taskList as $task){
			$itemList[$task->description] = [];
			$oprationList = $auth->getItemChildren($task->name);
			foreach($oprationList as $opration){
				$itemList[$task->description][$opration->name] = $opration->description;
			}
		}
		unset($itemList['运维工具']);
		$listData['itemList'] = $itemList;
		if($role){
			$itemList = [];
			$oprationList = $auth->getItemChildren($role);
			foreach($oprationList as $opration){
				$itemList[] = $opration->name;
			}
		}
		$listData['myItemList'] = $itemList;
		$roleObjList = $auth->getAuthItems(Consts::AUTH_ROLE);
		foreach($roleObjList as $role){
			$roleList[$role->name] = [
				'name'=>$role->name,
				'desc'=>$role->description
			];
		}
		unset($roleList['developer']);
		$listData['roleList'] = $roleList;
		$this->render("auth",$listData);
	}

	// 权限初始化
	public function actionAuthInit(){
		// 权限版本 2016-6-27 10:14:09
		Permission::init();
		// 清除缓存
		CacheMemcached::flush();
	}
}
