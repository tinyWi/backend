<?php
/**
 * desc   Platform
 * date   2016-2-25 18:02:40
 * author xupin
 **/
class Platform extends CActiveRecord {
	
	protected $connection = null;
	
	public function __construct(){
		@$this->connection = Yii::app()->session['platform'];
		@$this->connection->charset = Consts::MYSQL_CHARSET;
	}

	public function getDbConnection() {
		return $this->connection = Yii::app()->Platform;
	}

	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	public function tableName(){
		return 'platform';
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