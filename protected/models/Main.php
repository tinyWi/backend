<?php
/**
 * desc   Main
 * date   2015-12-8 15:27:48
 * author xupin
 **/
class Main extends CActiveRecord {
	
	protected $connection = null;
	
	public function __construct(){
		$this->connection = Yii::app()->session['main'];
		$this->connection->charset = Consts::MYSQL_CHARSET;
	}
	
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	public function tableName(){
		return 'main';
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