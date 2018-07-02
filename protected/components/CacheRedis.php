<?php
/**
 * desc   redis
 * date   2016-8-25 21:10:27
 * author xupin
 **/
class CacheRedis {

	// redis对象容器
	private static $__redis;

	// redis链接容器
	private static $__conn;

	// lpush
	static public function lpush( $key, $value){
		return self::$__conn->lpush( $key, $value);
	}

	// rpop
	static public function rpop( $key){
		return self::$__conn->rpop( $key);
	}

	// 创建连接redis对象
	static public function connect(){
		if(!(self::$__conn instanceof redis)){
			self::$__conn = new redis;
			self::$__conn->connect( '127.0.0.1', 6379);
		}
		if(!(self::$__redis instanceof self)){
			self::$__redis = new self;
		}
		return self::$__redis;
	}
}