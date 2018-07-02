<?php
/**
 * desc   Uer
 * date   2016-2-18 09:49:13
 * author xupin
 **/
class Uer extends CActiveRecord {

    public function getDbConnection() {
        return Yii::app()->UER;
    }
	
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	public function tableName(){
		return 'uer';
	}

	public function insert( $sql){
		$this->getDbConnection()->createCommand( $sql)->execute();
		return $this->getDbConnection()->getLastInsertID();
	}

	public function update( $sql){
		return $this->getDbConnection()->createCommand( $sql)->execute();
	}
	
	public function selectRow( $sql){
		return $this->getDbConnection()->createCommand( $sql)->queryRow();
	}
	
	public function select( $sql){
		return $this->getDbConnection()->createCommand( $sql)->queryAll();
	}
}