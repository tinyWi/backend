<?php
/**
 * desc   主页
 * date   2015-12-9 16:33:02
 * author xupin
 **/
class IndexController extends Controller
{
	// 主页
	public function actionMain(){
		$this->render('main');
	}

	// 首页
	public function actionDefault(){
		$this->render('default');
	}

	// 用户登录
	public function actionLogin(){
		$loginBtn  = Functions::getParam('login');
		$userText = Functions::getParam('username');
		$pwdText = md5(Functions::getParam('password'));
		if(Yii::app()->session['user']['uid']){
			$this->redirect( $this->createUrl( 'Index/Main'));
		}else{
			if( $loginBtn && $userText && $pwdText){
				$ip = Functions::getIP();
				$userRow = Db::connect(UEA)->selectRow("select * from `user` where `username` = '{$userText}' or `email` = '{$userText}'");
				if(!$userRow){
					Functions::jump( $this->createUrl( 'Index/Register'),'很抱歉,该账户不存在(；′⌒`)');
				}
				if($pwdText != $userRow['password']){
					Functions::jump( $this->createUrl( 'Index/Login'),'很抱歉,密码好像不正确(；′⌒`)');
				}
				if(-1 == $userRow['status']){
					Functions::jump( $this->createUrl( 'Index/Login'),'很抱歉,该账户被冻结(；′⌒`)');
				}
				if(!$userRow['status']){
					Functions::jump( $this->createUrl( 'Index/Login'),'很抱歉,该账户待审核(；′⌒`)');
				}
				if(false && strpos( $userRow['allowip'], $ip) === false){
					Functions::jump( $this->createUrl( 'Index/Login'),'很抱歉,该设备未授权(；′⌒`)');
				}
				$time = time();
				$token = md5($time);
				Db::connect(UEA)->update("update `user` set `token` = '{$token}',`lasttime` = {$time},`lastip` = '{$ip}' where `uid` = {$userRow['uid']}");
				$roleList = Yii::app()->authManager->getRoles( $userRow['uid']);
				$rolename = $roledesc = '';
				foreach($roleList as $role){
					$roledesc = $role->description;
					$rolename = $role->name;
				}
				// session存放用户登录信息
				Yii::app()->session['user'] = [
					'uid'=>$userRow['uid'],
					'username'=>$userRow['username'],
					'realname'=>$userRow['realname'],
					'head'=>$userRow['head'],
					'token'=>$token,
					'lasttime'=>$time,
					'lastip'=>$ip,
					'rolename' => $rolename,
					'roledesc' => $roledesc
				];
				// 权限系统需要信息
				Yii::app()->user->id = $userRow['uid'];
				$this->redirect( $this->createUrl( 'Index/Main'));
			}
			$this->render('login',['username'=>$userText]);
		}
	}

	// 用户登出
	public function actionLogout(){
		Yii::app()->user->logout();
		Yii::app()->session->clear();
		Yii::app()->session->destroy();
		$this->redirect( Yii::app()->homeUrl);
	}

	// 用户注册
	public function actionRegister(){
        $regBtn = Functions::getParam('register');
        $emailText = Functions::getParam('email');
        $userText = Functions::getParam('username');
        $pwdText = md5(Functions::getParam('password'));
        $confPwdText = md5(Functions::getParam('confirm_password'));
		if($regBtn){
			if( $userText && $pwdText && $confPwdText === $pwdText){
				$realname = '用户' . rand(1,99); // 随机名
				$elogin = Consts::USER_EMAIL_LOGIN;
				Db::connect(UEA)->insert("INSERT INTO `user`(`elogin`,`email`,`username`,`realname`,`password`,`ctime`,`mtime`) VALUES({$elogin},'{$emailText}','{$userText}','{$realname}','{$pwdText}',unix_timestamp(),unix_timestamp())");
				$userRow = Db::connect(UEA)->selectRow( "select `username`,`uid` from `user` order by `uid` desc limit 1");
				Yii::app()->authManager->assign('platform',$userRow['uid']); // 运维
				$this->redirect( $this->createUrl( 'Index/Login',['username'=>$userRow['username']]));
			}
		}
		$this->render('register',['username'=>$userText]);
	}

	// 验证码界面
	public function actionCheckCode(){
		$checkBtn = Functions::getParam('check');
		$codeText = Functions::getParam('code');
		$username = Yii::app()->session['user']['username'];
		$listData = ['checkMsg'=>'','isCheck'=>false];
		if($checkBtn){
			if(Yii::app()->session['code'] == md5($codeText)){
				$userRow = Db::connect(UEA)->selectRow( "select `allowip` from `user` where `username` = '{$username}' OR `email` = '{$username}'");
                $allowIPArr = $userRow['allowip']? explode(',',$userRow['allowip']): [];
				array_push( $allowIPArr, Functions::getIP());
				$allowIP = implode( ',', $allowIPArr);
				Db::connect(UEA)->update("update `user` set `allowip` = '{$allowIP}' where `username` = '{$username}' OR `email` = '{$username}'");
				$listData['isCheck'] = true;
			}else{
				$listData['checkMsg'] = '验证码错误,请再次输入';
				$listData['isCheck'] = false;
			}
		}
		$this->render('checkCode',$listData);
	}
}