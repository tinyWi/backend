<?php
/**
 * desc   一个牛逼的db操作类
 * date   2016-12-2 15:38:14
 * author FBI Warning
 **/
class NDb{

	// db操作类对象容器
	private static $__db;
	// db链接容器
	private static $__conn;
	// 表名
	protected static $_table;
	// 操作
	protected static $_option = [];
	// sql
	protected static $_sql;

	public function table( $table){
		self::$_table = $table;
		return self::$__db;
	}

	public function where( $whereArr = []){
		$where = 'where';
		foreach ($whereArr as $value) {
			$where .= ' ' . $value;
		}
		self::_setOption( 'where', $where);
		if('where' == $where){
			unset(self::$_option['where']);
		}
		return self::$__db;
	}

	public function groupBy( $field){
		self::_setOption( 'groupBy', "group by {$field}");
		return self::$__db;
	}

	public function orderBy( $field, $way = 'asc'){
		self::$_option['orderBy'] = "order by `{$field}` {$way}";
		return self::$__db;
	}

	public function limit( $field){
		self::_setOption( 'limit', "limit {$field}");
		return self::$__db;
	}

	protected function _setOption( $option, $value){
		if(!isset(self::$_option[$option])){
			self::$_option[$option] = '';
		}
		self::$_option[$option] = $value;
	}

	protected function _getOption( $option){
		return isset( self::$_option[$option])? self::$_option[$option]: '';
	}

	protected function _buildSql( $func, $moods = false){
		$table = self::$_table;
		$where = self::_getOption('where');
		$orderBy = self::_getOption('orderBy');
		$groupBy = self::_getOption('groupBy');
		$limit = self::_getOption('limit');
		switch ($func) {
			case 'insert' == $func:
				$k = $v = [];
				foreach ($moods as $key => $value) {
					$k[] = "`{$key}`";
					$v[] = "'{$value}'";
				}
				$k = implode( ',', $k);
				$v = implode( ',', $v);
				self::$_sql = "insert into `{$table}`({$k}) values({$v});";
				break;
			case 'select' == $func:
				self::$_sql = "select {$moods} from `{$table}` {$where} {$groupBy} {$orderBy} {$limit};";
				break;
			case 'selectRow' == $func:
				self::$_sql = "select {$moods} from `{$table}` {$where} {$groupBy} {$orderBy} limit 1;";
				break;
			case 'update' == $func:
				$setVal = [];
				foreach ($moods as $key => $value) {
					$setVal[] = " `{$key}` = '{$value}'";
				}
				$setVal = implode( ',', $setVal);
				self::$_sql = "update `{$table}` set {$setVal} {$where};";
				break;
			case 'delete' == $func:
				self::$_sql = "delete from `{$table}` {$where};";
				break;
			default:
				self::$_sql = '';
				break;
		}
		self::$_option = [];
		return self::$_sql;
	}

	public function getSql(){
		return self::$_sql;
	}

	public function insert( $data){
		return self::$__conn->createCommand( self::_buildSql( __FUNCTION__, $data))->execute();
	}

	public function delete(){
		return self::$__conn->createCommand( self::_buildSql( __FUNCTION__))->execute();
	}

	public function update( $data){
		return self::$__conn->createCommand( self::_buildSql( __FUNCTION__, $data))->execute();
	}

	public function select( $attr = '*'){
		return self::$__conn->createCommand( self::_buildSql( __FUNCTION__, $attr))->queryAll();
	}

	public function selectRow( $attr = '*'){
		return self::$__conn->createCommand( self::_buildSql( __FUNCTION__, $attr))->queryRow();
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
		self::$__conn->charset = Consts::MYSQL_CHARSET;
		if(!(self::$__db instanceof NDb)){
			self::$__db = new NDb;
		}
		return self::$__db;
	}
}