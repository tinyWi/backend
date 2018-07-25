<?php
/**
 * desc   公共方法
 * date   2014-7-21 10:58:45
 * author xupin
 **/
class Functions {

	// 设置session
	static public function setSession( $param, $value){
		if( $value && self::getSession( $param) != $value){
			return Yii::app()->session[$param] = $value;
		}else{
			return Yii::app()->session[$param];
		}
	}

	// 获取session
	static public function getSession( $param){
		return Yii::app()->session[$param];
	}

	// 参数获取
	static public function getParam($param, $defVal = ''){ // 可传第二参数,yii自带
		$value = Yii::app()->request->getParam($param, $defVal);
		if(!is_array($value)){
			$value = trim($value);
			if($param == 'zone'){
				return self::setSession( 'zone', $value);
			}elseif($param == 'name'){
				return self::getUserList( $value);
			}elseif($param == 'date'){
				return self::setSession( 'date', $value);
			}elseif($param == 'sDate'){
				return self::setSession( 'sDate', $value);
			}elseif($param == 'eDate'){
				return self::setSession( 'eDate', $value);
			}
		}
		return $value;
	}

	// 格式化输出
	static public function dump( $data){
		echo '<pre>';
		CVarDumper::dump( $data);
		echo '</pre>';
	}
	
	// 实时输出
	static public function realTimeOutput( $dataString){
		echo $dataString;
		echo str_repeat( ' ', 1024*4);
		ob_flush();
		flush();
	}
	
	// 秒数转换时间格式
	static public function second2Time( $second){
		$day    = floor( $second / Consts::DAY_SEC);
		$hour   = floor(( $second - Consts::DAY_SEC * $day) / Consts::HOUR_SEC);
		$minute = floor(( $second - ( Consts::HOUR_SEC * $hour) - ( Consts::DAY_SEC * $day)) / Consts::MIN_SEC);
		$second = floor(( $second - ( Consts::HOUR_SEC * $hour) - ( Consts::DAY_SEC * $day) - ( Consts::MIN_SEC * $minute)) % Consts::MIN_SEC);
		$timeText = '';
		if($day){
			$timeText .= $day . '天';
		}
		if($hour){
			$timeText .= $hour . '时';
		}
		if($minute){
			$timeText .= $minute . '分';
		}
		if($second){
			$timeText .= $second . '秒';
		}
		return $timeText;
	}

	// 字节转换单位
	static public function byte2Format( $byte){
		$kb = 1024;         // Kilobyte
		$mb = 1024 * $kb;   // Megabyte
		$gb = 1024 * $mb;   // Gigabyte
		$tb = 1024 * $gb;   // Terabyte
		if($byte < $kb){
			return $byte.' B';
		}else if($byte < $mb){
			return round($byte/$kb,2).' KB';
		}else if($byte < $gb){
			return round($byte/$mb,2).' MB';
		}else if($byte < $tb){
			return round($byte/$gb,2).' GB';
		}else{
			return round($byte/$tb,2).' TB';
		}
	}

	// 返回两段时间内的时间列表(包含起止时间)
	static public function date2Array( $sDate, $eDate, $isTime = false){
		if(!$isTime){
			$sDate = strtotime($sDate);
			$eDate = strtotime($eDate);
		}
		$dateArray = [];
		while ($sDate <= $eDate){
			array_push($dateArray,date('Y-m-d',$sDate));
			$sDate = strtotime('+1 day',$sDate);
		}
		return $dateArray;
	}

	// 两段时间内多少天
	static public function days( $sDate, $eDate){
		$sTime = strtotime( $sDate);
		$eTime = strtotime( $eDate);
		return ( $eTime - $sTime) / Consts::DAY_SEC;
	}

	// 两段时间的分钟
	static public function minutes( $sDate, $eDate){
		$sTime = strtotime( $sDate);
		$eTime = strtotime( $eDate);
		return ( $eTime - $sTime) / Consts::MIN_SEC;
	}
	
	// 跳转函数
	static public function jump( $url, $content = ''){
		header('Content-Type:text/html;charset=utf-8');
		if( $content){
			echo "<script> alert('{$content}'); </script>";
		}
		echo "<meta http-equiv='Refresh' content='0;URL={$url}'>";
		exit;
	}
	
	// 小数转换百分比
	static public function ratio( $decimals, $retain = 4){
		if( 1 == $decimals){
			return $decimals*100 . '%';
		}
		return round( $decimals, $retain)*100 . '%';
	}

	// 小数
	static public function decimal( $dividend, $divisor, $retain = 2){
		if(!$dividend || !$divisor){
			return 0;
		}
		return round( $dividend / $divisor, $retain);
	}

	// 自动识别转码
	static public function iconv( $data, $outcode = 'UTF-8') {
		$encode = mb_detect_encoding( $data, ['UTF-8','ASCII','GBK','GB2312','BIG5','JIS','eucjp-win','sjis-win','EUC-JP']);
		return $encode != $outcode? mb_convert_encoding( trim( $data), $outcode, $encode): $data;
	}

	// 获取客户端ip
	static public function getIP() {
        if (isset($_SERVER)){
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else if (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } else {
                $ip = isset( $_SERVER['REMOTE_ADDR'])? $_SERVER['REMOTE_ADDR']: '127.0.0.1';
            }
        } else {
            if (getenv('HTTP_X_FORWARDED_FOR')){
                $ip = getenv('HTTP_X_FORWARDED_FOR');
            } else if (getenv('HTTP_CLIENT_IP')) {
                $ip = getenv('HTTP_CLIENT_IP');
            } else {
                $ip = getenv('REMOTE_ADDR');
            }
        }
        return $ip;
	}

	// 验证码
	static public function getCheckCode( $length = 5){
		return substr( str_shuffle( '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
	}

	// check db connect
	static public function checkDBConnect( $host = '', $user = '', $pwd = '', $db = '', $port = '3306'){
		try{
			if(filter_var( $host, FILTER_VALIDATE_IP)){
				$mysqli = mysqli_init();
				$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 3); // 3秒超时放弃连接
				$conn = @$mysqli->real_connect( $host, $user, $pwd, $db, $port);
				return $conn? true: false;
			}
		}catch (Exception $e){
			// exception
		}
		return false;
	}

	// shell
    // 2016-10-9 11:54:32
    static public function shell( $sh){
        return trim(shell_exec( $sh));
    }
}
