<?php
/**
 * desc   错误处理
 * date   2015-12-10 12:16:58
 * author xupin
 **/
class ErrorController extends Controller
{

	// 报错
	// 2016-6-22 15:11:34
	public function actionError(){
		$errArr = Yii::app()->errorHandler->error;
		switch($errArr['code']){
			case 404:
				$this->render('404');
				break;
			default:
//				echo "<script> alert('发现异常,已通知程序猿同学抢修!'); window.history.back(-1);</script>";
//				Email::connect()->postEmail( '1@qq.com;2@qq.com', "UEA ERR {$errArr['code']},{$errArr['message']}", str_replace( "\n", '<br/>', $errArr['trace']));
				$this->render('500');
				break;
		}
	}
}