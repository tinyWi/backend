<?php
/**
 * desc   宏定义
 * date   2015-12-14 17:28:36
 * author xupin
 **/
class Consts {

	// 程序执行通用返回值
	const EXEC_STATUS_SUCC = 0;
	const EXEC_STATUS_FAIL = -1;

	// 数据库
	const MYSQL_CHARSET = 'utf8';
	const DATABASE_MHA1 = 'mha1';
	const DATABASE_MHA2 = 'mha2';
	const DATABASE_MAIN_PREFIX = '_main';
	const DATABASE_LOG_PREFIX = '_log';
	static $mhaList = array(
		self::DATABASE_MHA1=>'10.11.6.220',
		self::DATABASE_MHA2=>'10.11.6.230'
	);

	// 是否邮箱登录
	const USER_EMAIL_LOGIN = 1;

	// 表
	const TABLE_MAIN = 1;
	const TABLE_LOG = 2;
	const TABLE_PLATFORM = 3;
	const TABLE_UEA = 4;
	const TABLE_UER = 5;

	// 权限类型
	const AUTH_OPRATION = 0;
	const AUTH_TASK = 1;
	const AUTH_ROLE = 2;

	// 数量缺省值
	const NUM_VALUE = 0;

	// 查询方式
	const EQUAL_SELECT = 1; // 精确查询
	const LIKE_SELECT = 2; // 模糊查询

	// 游戏玩家名标识符
	const GAME_NAME_IDENT = '.S';

	// 时间秒数
	const DAY_SEC = 86400;
	const HOUR_SEC = 3600;
	const MIN_SEC = 60;
	const MIL_SEC = 1000;

	// 后台用户状态
	const USER_STATUS_FREEZE = -1;
	const USER_STATUS_PAUSE = 0;
	const USER_STATUS_ONLINE = 1;
	const USER_NOTFOUND = 2;
	const USER_EMAIL_USED = 3;
	const USER_EMAIL_NOTFOUND = 4;
	const USER_PASSWORD_ERROR = 5;
	const USER_INFO_RIGHT = 6;
	const USER_WAIT_CHECK = 7;

	// 非权限类
	static $allowCtrlList = array(
		'Api',
		'Index',
		'Test',
		'Ajax',
		'Error'
	);

	// 非权限方法
	static $allowActList = array(
		'UserMod'
	);
}
