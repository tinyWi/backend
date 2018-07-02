<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	// before
	public function beforeAction($action){
		$ctrlName = ucfirst($action->controller->id);
		$actionName = ucfirst($action->id);
		$ctrlActList = CacheMemcached::connect()->get( 'premission_' . Yii::app()->session['user']['uid']);
		if( !in_array( $ctrlName . $actionName, $ctrlActList? unserialize( $ctrlActList): []) && !in_array( $ctrlName, Consts::$allowCtrlList) && !in_array( $actionName, Consts::$allowActList)){
			Permission::isExec( $ctrlName, $actionName);
		}
		if(Yii::app()->session['actionName'] != $actionName){
			if(Yii::app()->session['ctrlName'] != $ctrlName){
				Yii::app()->session['ctrlName'] = $ctrlName;
			}
			Yii::app()->session['actionName'] = $actionName;
		}
		return true;
	}

	// after
	public function afterAction($action){
		// code
	}
}