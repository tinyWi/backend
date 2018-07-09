<?php
class TestController extends Controller{

	public function actionIndex(){
		echo Yii::app()->params['name'];
	}
}