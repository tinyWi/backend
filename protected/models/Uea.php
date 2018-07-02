<?php
/**
 * desc   Uea
 * date   2016-2-25 19:18:38
 * author xupin
 **/
class Uea extends CActiveRecord {

    public function getDbConnection() {
        return Yii::app()->UEA;
    }
	
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	public function tableName(){
		return 'uea';
	}

	public function insert( $sql){
		$this->getDbConnection()->createCommand( $sql)->execute();
		return $this->getDbConnection()->getLastInsertID();
	}

	public function insert2( $table, $attr){
		$this->getDbConnection()->createCommand()->insert( $table, $attr);
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