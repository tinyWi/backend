<?php
/**
 * desc   语言包
 * date   2015-12-10 14:18:52
 * author xupin
 **/
class Lang {
	
	static $cn = array(
		"people"=>"人",
		"yesterday"=>"昨天",
		"today"=>"今天"
	);
	
	static $en = array(
		"people"=>"people",
		"yesterday"=>"yesterday",
		"today"=>"today"
	);
	
	static public function getTexts( $param){
		$lang = Functions::getParam("lang");
		if( "en" == strtolower($lang)){
			return self::$en[$param];
		}else{
			return self::$cn[$param];
		}
	}
}