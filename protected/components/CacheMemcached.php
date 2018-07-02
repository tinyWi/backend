<?php
/**
 * desc   memcached
 * date   2016-1-7 14:58:46
 * author xupin
 **/
class CacheMemcached {

	// 补单列表
	const RES_SUPPL_ORDER_LIST = 'supplOrderList';

	// DBConnect
	const RES_DB__connECT = 'dbConnect';

	// 道具列表
	const RES_ITEM_LIST = 'itemList';

	// 装备列表
	const RES_EQUIP_LIST = 'equipList';

	// 平台列表
	const RES_PLATFORM_LIST = 'platformList';

	// 区服列表
	const RES_ZONE_LIST = 'zoneList';
    const RES_ZONE_ALL_LIST = 'zoneAllList';
	const RES_ZONE_MERGE_LIST = 'zoneMergeList';

	// 任务列表
	const RES_TASK_LIST = 'taskList';

	// 交易物品类型
	const RES_TRADER_CATEGORY_LIST = 'traderCategoryList';
	const RES_TRADER_CELL_LIST = 'traderCellList';

	// mem对象容器
	private static $__mc;

	// mem链接容器
	private static $__conn;

	// 设置缓存
	static public function set( $key, $val, $time = Consts::DAY_SEC){
		self::__getMc();
		return self::$__conn->set( $key, $val, $time);
	}

	// 获取缓存
	static public function get( $key){
		self::__getMc();
		return self::$__conn->get( $key);
	}

	// 删除缓存
	static public function del( $key, $time = 0){
		self::__getMc();
		return self::$__conn->delete( $key, $time);
	}

	// 清除缓存
	static public function flush( $delay = 0){
		self::__getMc();
		return self::$__conn->flush( $delay);
	}

	// 获取所有键
	static public function getAllKey(){
		self::__getMc();
		return self::$__conn->getAllKeys();
	}

	// 获取mem对象
	static private function __getMc(){
		if(!(self::$__conn instanceof memcached)){
			self::$__conn = new memcached;
			self::$__conn->addServer('127.0.0.1',11211);
		}
		return self::$__conn;
	}

    // 创建连接mem对象
    static public function connect(){
        if(!(self::$__conn instanceof memcached)){
            self::$__conn = new memcached;
            self::$__conn->addServer('127.0.0.1',11211);
        }
        if(!(self::$__mc instanceof self)){
            self::$__mc = new self;
        }
        return self::$__mc;
    }
}