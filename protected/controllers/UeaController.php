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

	// 猜猜模板管理
	public function actionGuessTemplate(){
		$templateList = NDb::connect(CAICAI)->table('cc_guess_template')->select();
		$listData['templateList'] = $templateList;
		$this->render('guessTemplate',$listData);
	}

	// 批量导入模板
	public function actionBatchGuessTemplate(){
		$subBtn = Functions::getParam('sub');
		if($subBtn){
			if(isset($_FILES['file']) && is_uploaded_file($_FILES['file']['tmp_name'])){
				$phpexcel = new PHPExcel;
				$excelReader = PHPExcel_IOFactory::createReader('Excel2007');
				$excelReader->setReadDataOnly(true);
				$phpexcel = $excelReader->load($_FILES['file']['tmp_name'])->getSheet(0)->toArray();
				$answerExcel = $excelReader->load($_FILES['file']['tmp_name'])->getSheet(1)->toArray();
				array_shift($phpexcel);
				array_shift($answerExcel);
				foreach( $phpexcel AS $key => $val){
					$endinfo = json_encode(['answer'=>$answerExcel[$key][1]]);
					try {
						Db::connect(CAICAI)->insert("insert into `cc_guess_template` (`id`,`title`,`note`,`subject_id`,`labels`,`selection`,`odds`,`early_publish`,`late_publish`,`end_bet_time`,`end_time`,`guess_type`,`end_info`)  values ('{$val[0]}','{$val[1]}','{$val[2]}','{$val[3]}','{$val[5]}','{$val[6]}','{$val[7]}','{strtotime($val[9])}','{strtotime($val[10])}','{strtotime($val[11])}','{strtotime($val[12])}','4','{$endinfo}')");
					}catch (Exception $e){
						Console::log("批量导入失败","id 为{$val[0]} 的模板导入失败");
					}
				}
			}
		}
		$this->render('batchGuessTemplate');
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
