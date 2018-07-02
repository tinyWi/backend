<?php
/**
 * desc   控制台
 * date   2016-7-12 21:00:35
 * author xupin
 **/
class Console{

	// log
	// 2016-7-12 21:00:544
	static public function log( $logName, $msg){
		self::writeContent( __FUNCTION__, $logName, $msg);
	}

	// info
	// 2016-7-12 21:21:25
	static public function info( $logName, $msg){
		self::writeContent( __FUNCTION__, $logName, $msg);
	}

	// warn
	// 2016-7-12 21:25:52
	static public function warn( $logName, $msg){
		self::writeContent( __FUNCTION__, $logName, $msg);
	}

	// error
	// 2016-7-12 21:26:59
	static public function error( $logName, $msg){
		self::writeContent( __FUNCTION__, $logName, $msg);
	}

	// file name
	// 2016-7-12 21:26:11
	static private function getFileName(){
		$fileName = WEB_ROOT . '/assets/log/' . date('Ymd') . '.log';
		!is_file( $fileName)? fopen( $fileName, 'wb'): true;
		return $fileName;
	}

	// write content
	// 2016-7-12 21:02:20
	static private function writeContent( $logType, $logName, $logMsg){
		try {
			$fileName = self::getFileName();
			if (!($logType = strtoupper($logType)) || !$fileName || !$logName || !$logMsg) {
				return;
			}
			$user = Functions::getUserName();
			$ip = Functions::getIP();
			$content = date("Y-m-d H:i:s") . " [{$logType}]:[{$logName}],{$user},{$ip} => {$logMsg}\r\n";
			file_put_contents( $fileName, $content, FILE_APPEND);
		}catch (Exception $e){
			return;
		}
	}
}
