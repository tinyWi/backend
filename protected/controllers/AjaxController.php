<?php
/**
 * desc   ajax
 * date   2016-1-11 12:04:16
 * author xupin
 **/
class AjaxController extends Controller
{
	public function init(){
		$path = Yii::app()->request->getPathInfo();
		$pathArr = explode('/',$path);
		if(!in_array(end($pathArr),Consts::$reqWithoutLogin) && !Yii::app()->session['user']['uid']){
			Functions::jump( yii::app()->createUrl( 'Index/Login'));
		}
	}

	// 用户状态，单用户登录
	public function actionGetUserStatus(){
		$uid = Yii::app()->session['user']['uid'];
		if($uid){
			$userRow = Db::connect(UEA)->selectRow("SELECT `token` FROM `user` WHERE `uid` = '{$uid}'");
            if(Yii::app()->session['user']['token'] == $userRow['token']){
                $result = ['status'=>Consts::EXEC_STATUS_SUCC, 'msg'=>''];
            }else{
                $result = ['status'=>Consts::EXEC_STATUS_FAIL, 'msg'=>'您的账户在别处登录,请您重新登录'];
            }
		}else{
			$result = ['status'=>Consts::EXEC_STATUS_FAIL, 'msg'=>'未检测到登录信息,请您重新登录'];
		}
		die( json_encode( $result));
	}

	// 改变用户状态
	public function actionChangeUserStatus(){
		$uid = Functions::getParam('uid');
		$userRow = Db::connect(UEA)->selectRow("select `status` from `user` where `uid` = '{$uid}'");
		if($userRow['status']){
			$status = Consts::USER_STATUS_PAUSE;
		}else{
			$status = Consts::USER_STATUS_ONLINE;
		}
		Db::connect(UEA)->update("update `user` set `status` = {$status} where `uid` = '{$uid}'");
		$result = ['msg'=>'', 'status'=>$status];
		die(json_encode($result));
	}

	// 检查登录信息
	public function actionLoginCheckInfo(){
		$username = Functions::getParam('username');
		$password = Functions::getParam('password');
		$userRow = Db::connect(UEA)->selectRow( "select * from `user` where `username` = '{$username}' or `email` = '{$username}'");
        if($userRow){
            if($userRow['password'] == $password){
                if($userRow['status'] == Consts::USER_STATUS_ONLINE){
                    $result = ['msg'=>'', 'status'=>Consts::USER_INFO_RIGHT];
                }elseif($userRow['status'] == Consts::USER_STATUS_FREEZE){
	                $result = ['msg'=>'很抱歉,该账户已冻结(；′⌒`)', 'status'=>Consts::USER_STATUS_FREEZE];
                }else{
                    $result = ['msg'=>'很抱歉,该账户待审核(；′⌒`)', 'status'=>Consts::USER_WAIT_CHECK];
                }
            }else{
                $result = ['msg'=>'很抱歉,密码好像不正确(；′⌒`)', 'status'=>Consts::USER_PASSWORD_ERROR];
            }
        }else{
            $result = ['msg'=>'很抱歉,该账户不存在(；′⌒`)', 'status'=>Consts::USER_NOTFOUND];
        }
		die(json_encode($result));
	}

	// 检查IP
	public function actionLoginCheckIp(){
		$username = Functions::getParam('username');
		$userRow = Db::connect(UEA)->selectRow( "select * from `user` where `username` = '{$username}' OR `email` = '{$username}'");
		if(true || in_array( Functions::getIP(), explode(',',$userRow['allowip']))){
			$result = ['msg'=>'', 'status'=>Consts::USER_STATUS_ONLINE];
		}else{
			if(!Yii::app()->session['user']['username']){
				Yii::app()->session['user'] = ['uid'=>0,'username'=>$username];
			}
			if((time() - Yii::app()->session['codetime']) >= Consts::HOUR_SEC/2){
				$code = Functions::getCheckCode();
				if(Email::postEmail( $userRow['email'], '您的 Uye 帐户：来自新电脑的访问', Email::checkCodeTemlate( $username, $code, Functions::getIP()))){
					Console::log( '检查IP',"发送登录验证邮件,验证码: {$code}");
					Yii::app()->session['code'] = md5($code);
					Yii::app()->session['codetime'] = time();
				}
			}
			$result = ['msg'=>'', 'status'=>Consts::USER_STATUS_PAUSE];
		}
		die(json_encode($result));
	}

	// 检查邮箱是否正常以及用户名冲突
	public function actionUserIsValid(){
		$username = Functions::getParam('username');
		$email = Functions::getParam('email');
		$userRow = Db::connect(UEA)->selectRow( "select * from `user` where `email` = '{$email}'");
		if($userRow){
			$result = ['msg'=>'很抱歉,该邮箱已被绑定(；′⌒`)', 'status'=>Consts::USER_EMAIL_USED];
		}else{
			if(filter_var( $email, FILTER_VALIDATE_EMAIL)){
				$userRow = Db::connect(UEA)->selectRow( "select * from `user` where `username` = '{$username}'");
				if($userRow){
					$result = ['msg'=>'很抱歉,该账户已存在(；′⌒`)', 'status'=>Consts::USER_STATUS_ONLINE];
				}else{
					$result = [];
				}
			}else{
				$result = ['msg'=>'很抱歉,该邮箱无效(；′⌒`)', 'status'=>Consts::USER_EMAIL_NOTFOUND];
			}
		}
		die(json_encode($result));
	}

	// 权限修改
	// 2016-6-16 17:51:21
	public function actionAuthMod(){
		$role = Functions::getParam('role');
		$item = Functions::getParam('item');
		if ($role && $item) {
			try {
				// 权限系统对象
				$auth = Yii::app()->authManager;
				$roleitems = $auth->getItemChildren( $role);
				foreach ($roleitems AS $roleitem) {
					$auth->removeItemChild( $role, $roleitem->name);
				}
				foreach ($item AS $val) {
					$auth->addItemChild( $role, $val);
				}
				$modRet = true;
			}catch (Exception $e){
				$modRet = false;
			}
			if($modRet){
				$result = [ 'status' => 0, 'msg' => ''];
				Console::log('权限修改',"操作【权限修改】修改成功,角色 {$role}");
			}else{
				$result = [ 'status' => 1, 'msg' => '修改失败'];
				Console::log('权限修改',"操作【权限修改】修改失败,角色 {$role}");
			}
		}else{
			$result = [ 'status' => 1, 'msg' => '关键参数不可为空'];
			Console::log('权限修改','操作【权限修改】修改失败,关键参数为空');
		}
		die(json_encode($result));
	}

	// 权限添加
	// 2016-6-27 10:11:59
	public function actionAuthAdd(){
		$name = Functions::getParam('name');
		$desc = Functions::getParam('desc');
		if ($name && $desc) {
			try {
				// 权限系统对象
				$auth = Yii::app()->authManager;
				$oprationList = $auth->getItemChildren($name);
				if(!$oprationList){
					$auth->createRole( $name, $desc);
					$modRet = true;
				}else{
					$modRet = false;
				}
			}catch (Exception $e){
				$modRet = false;
			}
			if($modRet){
				$result = [ 'status' => 0, 'msg' => '' ];
				Console::log('权限添加',"操作【权限添加】添加成功,角色 {$name},描述 {$desc}");
			}else{
				$result = [ 'status' => 1, 'msg' => '添加失败'];
				Console::log('权限添加',"操作【权限添加】添加失败,角色 {$name},描述 {$desc}");
			}
		}else{
			$result = [ 'status' => 1, 'msg' => '关键参数不可为空'];
			Console::log('权限添加','操作【权限添加】添加失败,关键参数为空');
		}
		die(json_encode($result));
	}

	// 添加模板
	public function actionTemplateAdd(){
		$title = Functions::getParam('title');
		$desc = Functions::getParam('desc');
		$subjectid = Functions::getParam('subjectid');
		$labels = Functions::getParam('labels');
		$selection = Functions::getParam('selection');
		$odds = Functions::getParam('odds');
		$earlyPub = strtotime(Functions::getParam('earlyPub'));
		$latePub = strtotime(Functions::getParam('latePub'));
		$endBet = strtotime(Functions::getParam('endBet'));
		$end = strtotime(Functions::getParam('end'));
		$endInfo = Functions::getParam('endInfo');
		if($title && $desc && $subjectid && $labels && $selection && $odds && $earlyPub && $latePub && $endBet && $end){
			try {
				$data = [
						'id' => 6666666,
						'title' => $title,
						'desc' => $desc,
						'subject_id' => $subjectid,
						'labels' => $labels,
						'selection' => $selection,
						'odds' => $odds,
						'early_publish' => $earlyPub,
						'late_publish' => $latePub,
						'end_bet_time' => $endBet,
						'end_time' => $end,
						'guess_type' => 4,  // 表示通过后台添加的模板
						'end_info' => json_encode(['answer'=>$endInfo])
					];
				$addResult = NDb::connect(CAICAI)->table('cc_guess_template')->insert($data);
			}catch (Exception $e) {
				$addResult = false;
			}
			if ($addResult) {
				$result = ['status' => 0, 'msg' => ''];
				Console::log("添加模板","成功添加id为{$data['id']} 的模板");
			} else {
				$result = ['status' => -1, 'msg' => '添加失败'];
			}
		} else {
			$result = ['status' => -1, 'msg' => '选项不可为空'];
		}
		die(json_encode($result));
	}

	public function actionTemplateDel(){
		$id = Functions::getParam('templateid');
		if($id){
			NDb::connect(CAICAI)->table('cc_guess_template')->where(["`id`='{$id}'"])->delete();
			$result = ['status'=>0,'msg'=>''];
			Console::log("删除模板","成功删除id为{$id} 的模板");
		}else{
			$result = ['status' => -1, 'msg' => '该记录为空'];
		}
		die(json_encode($result));
	}

	public function actionTemplateGet(){
		$id = Functions::getParam('templateid');
		if($id){
			$row = NDb::connect(CAICAI)->table('cc_guess_template')->where(["`id`='{$id}'"])->selectRow();
			$row['early_publish'] = date('Y-m-d H:i:s', $row['early_publish']);
			$row['late_publish'] = date('Y-m-d H:i:s', $row['late_publish']);
			$row['end_bet_time'] = date('Y-m-d H:i:s', $row['end_bet_time']);
			$row['end_time'] = date('Y-m-d H:i:s', $row['end_time']);
			$row['end_info'] = json_decode($row['end_info'],true)? current(json_decode($row['end_info'],true)): '';
			$result = ['status'=>0,'temRow'=>$row,'msg'=>''];
		}else{
			$result = ['status'=>-1,'msg'=>'该记录为空'];
		}
		die(json_encode($result));
	}

	public function actionTemplateMod(){
		$id = Functions::getParam('id');
		$title = Functions::getParam('title');
		$desc = Functions::getParam('desc');
		$subjectid = Functions::getParam('subjectid');
		$labels = Functions::getParam('labels');
		$selection = Functions::getParam('selection');
		$odds = Functions::getParam('odds');
		$earlyPub = strtotime(Functions::getParam('earlyPub'));
		$latePub = strtotime(Functions::getParam('latePub'));
		$endBet = strtotime(Functions::getParam('endBet'));
		$end = strtotime(Functions::getParam('end'));
		$endInfo = Functions::getParam('endInfo');
		if($id && $title && $desc && $subjectid && $labels && $selection && $odds && $earlyPub && $latePub && $endBet && $end){
			try{
				$data = [
						'title' => $title,
						'desc' => $desc,
						'subject_id' => $subjectid,
						'labels' => $labels,
						'selection' => $selection,
						'odds' => $odds,
						'early_publish' => $earlyPub,
						'late_publish' => $latePub,
						'end_bet_time' => $endBet,
						'end_time' => $end,
						'guess_type' => 4,  // 表示通过后台添加的模板
						'end_info' => json_encode(['answer'=>$endInfo])
						];
				$modResult = NDb::connect(CAICAI)->table('cc_guess_template')->where(["`id`='{$id}'"])->update($data);
			}catch (Exception $e) {
	            $modResult = false;
            }
            if($modResult){
            	$result = ['status' => 0, 'msg' => ''];
            }else{
            	$result = ['status' => -1, 'msg' => '添加失败'];
            }
		}else{
			$result = ['status' => -1, 'msg' => '该记录为空'];
		}
		die(json_encode($result));
	}
}