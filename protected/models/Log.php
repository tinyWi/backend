<?php
/**
 * desc   Log
 * date   2016-2-25 16:48:21
 * author xupin
 **/
class Log extends CActiveRecord {

	protected $connection = null;
	
	public function __construct(){
		$this->connection = Yii::app()->session['log'];
		$this->connection->charset = Consts::MYSQL_CHARSET;
	}
	
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	public function tableName(){
		return 'log';
	}

	public function update( $sql){
		return $this->connection->createCommand( $sql)->execute();
	}
	
	public function selectRow( $sql){
		return $this->connection->createCommand( $sql)->queryRow();
	}
	
	public function select( $sql){
		return $this->connection->createCommand( $sql)->queryAll();
	}
}