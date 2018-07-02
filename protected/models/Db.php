<?php
/**
 * desc   Db
 * date   2016-2-25 19:18:38
 * author xupin
 **/
class Db{

	// db操作类对象容器
	private static $__db;
	// db链接容器
	private static $__conn;

	public function insert( $sql){
		return self::$__conn->createCommand( $sql)->execute();
	}

	public function delete( $sql){
		return self::$__conn->createCommand( $sql)->execute();
	}

	public function update( $sql){
		return self::$__conn->createCommand( $sql)->execute();
	}

	public function select( $sql){
		return self::$__conn->createCommand( $sql)->queryAll();
	}

	public function selectRow( $sql){
		return self::$__conn->createCommand( $sql)->queryRow();
	}

	// 创建连接db对象
	static public function connect( $dbName = ''){
		switch ( $dbName) {
			case 'uea' == $dbName:
				self::$__conn = Yii::app()->UEA;
				break;
			case 'uer' == $dbName:
				self::$__conn = Yii::app()->UER;
				break;
			case 'main' == $dbName:
				self::$__conn = Yii::app()->session['main'];
				break;
			case 'log' == $dbName:
				self::$__conn = Yii::app()->session['log'];
				break;
			case 'platform' == $dbName:
				self::$__conn = Yii::app()->session['platform'];
				break;
			default:
				self::$__conn = Yii::app()->UEA;
				break;
		}
		if($dbName && !self::$__conn){
			throw new Exception('该区服对象未创建'); 
		}
		self::$__conn->charset = Consts::MYSQL_CHARSET;
		if(!(self::$__db instanceof Db)){
			self::$__db = new Db;
		}
		return self::$__db;
	}
}