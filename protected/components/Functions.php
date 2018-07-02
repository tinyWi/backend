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

	// 获取玩家列表
	static public function getUserList( $name){
		$zid = self::getSession( 'zone');
		$ctrlName = Yii::app()->session['ctrlName']; // 获取玩家列表只允许特定菜单的功能使用
		$actionName = Yii::app()->session['actionName'];
		if( ('Tools' == $ctrlName || 'Pay' == $ctrlName) && $name && $zid && !strpos( $name, Consts::GAME_NAME_IDENT)){
			// 设置数据库连接
			Functions::setDBConnect( $zid);
			$charDataList = Db::connect(MAIN)->select("select `name`,`ulevel`,`country`,`profession`,`createtime`,`charid` from `chardata` where `name` like '%{$name}%' order by LENGTH(`name`) asc limit 20"); // 控制数量,防止出现假死问题
			if(count($charDataList) > 1){
				$baseUrl =  Yii::app()->baseUrl;
				$userString = '';
				foreach($charDataList as $charData){
					$tempUrl = Yii::app()->createUrl( $ctrlName . '/' . $actionName, ['name'=>$charData['name']]);
					$tempCountry = Consts::$countryList[$charData['country']];
					$tempCreateTime = date( 'Y-m-d H:i:s', $charData['createtime']);
					$tempProfession = Consts::$professionList[$charData['profession']];
					$userString .= <<<EOF
						<div class="chat-user">
							<div class="chat-user-name">
								<a href="{$tempUrl}">{$tempCountry}-><strong>{$charData['name']}</strong><br/>创建时间：{$tempCreateTime}&nbsp;等级：{$charData['ulevel']}&nbsp;职业：{$tempProfession}&nbsp;CharID：{$charData['charid']}</a>
							</div>
						</div>
EOF;
				}
				echo <<<EOF
					<!DOCTYPE html>
					<html>
					<head>
						<meta charset="utf-8">
						<meta name="viewport" content="width=device-width, initial-scale=1.0">
						<title>游曳联运平台 - 玩家列表</title>
						<meta name="keywords" content="游曳联运平台">
						<meta name="description" content="游曳联运平台">
						<link rel="shortcut icon" href="favicon.ico"> <link href="{$baseUrl}/assets/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
						<link href="{$baseUrl}/assets/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
						<link href="{$baseUrl}/assets/css/plugins/jsTree/style.min.css" rel="stylesheet">
						<link href="{$baseUrl}/assets/css/animate.min.css" rel="stylesheet">
						<link href="{$baseUrl}/assets/css/style.min862f.css?v=4.1.0" rel="stylesheet">
					</head>
					<body class="gray-bg">
						<div class="wrapper wrapper-content  animated fadeInRight">
							<div class="row">
								<div class="col-sm-12">
									<div class="ibox chat-view">
										<div class="ibox-title">
											<small class="pull-right text-muted">检索关键字：<a href="javascripg:;">{$name}</a></small> 玩家列表
										</div>
										<div class="ibox-content">
											<div class="row">
												<div class="col-md-12">
													<div class="users-list">
														{$userString}
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<script src="{$baseUrl}/assets/js/jquery.min.js?v=2.1.4"></script>
						<script src="{$baseUrl}/assets/js/bootstrap.min.js?v=3.3.6"></script>
						<script src="{$baseUrl}/assets/js/content.min.js?v=1.0.0"></script>
					</body>
					</html>
EOF;
				exit;
			}elseif(count($charDataList) == 1){
				return $charDataList[0]['name'];
			}
		}
		return $name;
	}

	// get user name
	static public function getUserName(){
		try{
			return Yii::app()->session['user']['username'];
		}catch (Exception $e){
			return WEB_NAME;
		}
	}

	// set db connect
	static public function setDBConnect( $zid = 0){
		$zoneRow = Db::connect(UER)->selectRow("select * from `zone` where `zid` = '{$zid}'");
		if($zoneRow) {
		    if(CacheMemcached::connect()->get( "db_main_{$zid}") === false){
                $platformRow = Db::connect(UER)->selectRow("select `dbip`,`dbname`,`dbuser`,`dbpwd` from `platform` where `pid` = '{$zoneRow['pid']}'");
                $dbMain = new CDbConnection("mysql:host={$zoneRow['maindbip']};port={$zoneRow['maindbport']};dbname={$zoneRow['maindbname']}", $zoneRow['maindbuser'], $zoneRow['maindbpwd']);
                $dbLog = new CDbConnection("mysql:host={$zoneRow['logdbip']};port={$zoneRow['logdbport']};dbname={$zoneRow['logdbname']}", $zoneRow['logdbuser'], $zoneRow['logdbpwd']);
                $dbPlatform = new CDbConnection("mysql:host={$platformRow['dbip']};dbname={$platformRow['dbname']}", $platformRow['dbuser'], $platformRow['dbpwd']);
                CacheMemcached::connect()->set( "db_main_{$zid}", serialize($dbMain));
                CacheMemcached::connect()->set( "db_log_{$zid}", serialize($dbLog));
                CacheMemcached::connect()->set( "db_platform_{$zid}", serialize($dbPlatform));
            }else{
                $dbMain = unserialize( CacheMemcached::connect()->get( "db_main_{$zid}"));
                $dbLog = unserialize( CacheMemcached::connect()->get( "db_log_{$zid}"));
                $dbPlatform = unserialize( CacheMemcached::connect()->get( "db_platform_{$zid}"));
            }
            Yii::app()->session['main'] = $dbMain;
            Yii::app()->session['log'] = $dbLog;
            Yii::app()->session['platform'] = $dbPlatform;
            return true;
		}
		Console::log('setDBConnect', "【setDBConnect】连接数据库失败,游戏区服编号{$zid}查询不到数据");
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

	// 获取渠道用户表
	static public function getAccountTable( $keyword = ''){
		$accountTableList = [
			Consts::UYE_KEYWORD=>Consts::UYE_ACCOUNT_TABLE,
			Consts::LEDO_ANDROID_KEYWORD=>Consts::LEDO_ACCOUNT_TABLE,
			Consts::LEDO_IOS_KEYWORD=>Consts::LEDO_ACCOUNT_TABLE,
			Consts::TX_KEYWORD=>Consts::TX_ACCOUNT_TABLE,
			Consts::UCQH_KEYWORD=>Consts::UCQH_ACCOUNT_TABLE,
			Consts::UCQH2_KEYWORD=>Consts::UCQH_ACCOUNT_TABLE,
			Consts::BDDK_KEYWORD=>Consts::BDDK_ACCOUNT_TABLE,
			Consts::HW_KEYWORD=>Consts::HW_ACCOUNT_TABLE,
			Consts::MI_KEYWORD=>Consts::MI_ACCOUNT_TABLE,
			Consts::OPPO_KEYWORD=>Consts::OPPO_ACCOUNT_TABLE,
			Consts::QIHO_KEYWORD=>Consts::QIHO_ACCOUNT_TABLE,
			Consts::LNVO_KEYWORD=>Consts::LNVO_ACCOUNT_TABLE,
			Consts::VIVO_KEYWORD=>Consts::VIVO_ACCOUNT_TABLE,
			Consts::FLYME_KEYWORD=>Consts::FLYME_ACCOUNT_TABLE,
			Consts::COPA_KEYWORD=>Consts::COPA_ACCOUNT_TABLE,
			Consts::AMIGO_KEYWORD=>Consts::AMIGO_ACCOUNT_TABLE,
			Consts::PJ_KEYWORD=>Consts::PJ_ACCOUNT_TABLE,
			Consts::DJ_KEYWORD=>Consts::DJ_ACCOUNT_TABLE,
			Consts::PPTV_KEYWORD=>Consts::PPTV_ACCOUNT_TABLE,
			Consts::PYW_KEYWORD=>Consts::PYW_ACCOUNT_TABLE,
			Consts::WDJ_KEYWORD=>Consts::WDJ_ACCOUNT_TABLE,
			Consts::WDJ2_KEYWORD=>Consts::WDJ_ACCOUNT_TABLE,
			Consts::XX_KEYWORD=>Consts::XX_ACCOUNT_TABLE,
			Consts::YY_KEYWORD=>Consts::YY_ACCOUNT_TABLE,
			Consts::LS_KEYWORD=>Consts::LS_ACCOUNT_TABLE,
			Consts::M4399_KEYWORD=>Consts::M4399_ACCOUNT_TABLE,
			Consts::YK_KEYWORD=>Consts::YK_ACCOUNT_TABLE,
			Consts::SAMSUNG_KEYWORD=>Consts::SAMSUNG_ACCOUNT_TABLE,
			Consts::CC_KEYWORD=>Consts::CC_ACCOUNT_TABLE,
			Consts::SOGOU_KEYWORD=>Consts::SOGOU_ACCOUNT_TABLE,
			Consts::EWAN_KEYWORD=>Consts::EWAN_ACCOUNT_TABLE,
			Consts::YS_KEYWORD=>Consts::YS_ACCOUNT_TABLE,
			Consts::TT_KEYWORD=>Consts::TT_ACCOUNT_TABLE,
			Consts::AZ_KEYWORD=>Consts::AZ_ACCOUNT_TABLE,
			Consts::DYLL_KEYWORD=>Consts::DYLL_ACCOUNT_TABLE,
			Consts::HM_KEYWORD=>Consts::HM_ACCOUNT_TABLE,
			Consts::LEBA_KEYWORD=>Consts::LEBA_ACCOUNT_TABLE,
			Consts::TNGB_KEYWORD =>Consts::TNGB_ACCOUNT_TABLE,
			Consts::KUAI_KEYWORD=>Consts::KUAI_ACCOUNT_TABLE,
			Consts::XXGP_KEYWORD=>Consts::XXGP_ACCOUNT_TABLE,
			Consts::AISI_KEYWORD=>Consts::AISI_ACCOUNT_TABLE,
			Consts::PP_KEYWORD=>Consts::PP_ACCOUNT_TABLE,
			Consts::XY_KEYWORD=>Consts::XY_ACCOUNT_TABLE,
			Consts::ITOOLS_KEYWORD=>Consts::ITOOLS_ACCOUNT_TABLE,
			Consts::PYWYY_KEYWORD=>Consts::PYWYY_ACCOUNT_TABLE,
			Consts::X7SY_KEYWORD=>Consts::X7SY_ACCOUNT_TABLE,
			Consts::YINHU_KEYWORD=>Consts::YINHU_ACCOUNT_TABLE,
			Consts::YINHU2_KEYWORD=>Consts::YINHU_ACCOUNT_TABLE,
			Consts::YINHU3_KEYWORD=>Consts::YINHU_ACCOUNT_TABLE,
			Consts::CHHD_KEYWORD=>Consts::CHHD_ACCOUNT_TABLE,
			Consts::HANFENG_KEYWORD=>Consts::HANFENG_ACCOUNT_TABLE,
			Consts::QWAN_KEYWORD=>Consts::QWAN_ACCOUNT_TABLE,
			Consts::XIANQU_KEYWORD=>Consts::XIANQU_ACCOUNT_TABLE,
			Consts::XIANQU2_KEYWORD=>Consts::XIANQU_ACCOUNT_TABLE,
			Consts::DKM_KEYWORD=>Consts::DKM_ACCOUNT_TABLE,
			Consts::DKM2_KEYWORD=>Consts::DKM_ACCOUNT_TABLE,
			Consts::DKMIOS1_KEYWORD=>Consts::DKM_ACCOUNT_TABLE,
			Consts::DKMIOS2_KEYWORD=>Consts::DKM_ACCOUNT_TABLE,
			Consts::PLAY800_KEYWORD=>Consts::PLAY800_ACCOUNT_TABLE,
			Consts::PLAY8002_KEYWORD=>Consts::PLAY800_ACCOUNT_TABLE,
			Consts::JYNX1_KEYWORD=>Consts::JYNX_ACCOUNT_TABLE,
			Consts::JYNX2_KEYWORD=>Consts::JYNX_ACCOUNT_TABLE,
			'twA'=>Consts::TW_ACCOUNT_TABLE,
			Consts::HK_KEYWORD=>Consts::TW_ACCOUNT_TABLE,
			'hkA'=>Consts::TW_ACCOUNT_TABLE,
			Consts::SG_KEYWORD=>Consts::TW_ACCOUNT_TABLE,
			'sgA'=>Consts::TW_ACCOUNT_TABLE
		];
		return isset($accountTableList[$keyword])? $accountTableList[$keyword]: $accountTableList;
	}

	// 渠道充值
	// 2016-8-16 14:48:36
    static public function pay( $oid, $charge, $ordernum, $keyword){
        $orderRow = Db::connect(UER)->selectRow( "select * from `order` where `oid` = '{$oid}' and `charge` = '{$charge}'"); // 订单信息
        if(isset($orderRow['status']) && 0 >= $orderRow['status']){
            // 设置数据库连接
            self::setDBConnect( $orderRow['zid']);
            try{
                $charDataRow = Db::connect(MAIN)->selectRow("select `name` from `chardata` where `charid` = '{$orderRow['charid']}'"); // 查询玩家角色名
            }catch (Exception $e){
                $charDataRow = false;
            }
            if($charDataRow) {

                $serverInfo = Functions::getServerInfo( $orderRow['zid']);

                Console::log('渠道充值', "【{$keyword}】执行GO指令: '{$serverInfo['serverip']}:{$serverInfo['serverport']}' '//sys pay {$orderRow['oid']} {$charDataRow['name']} {$orderRow['iid']} {$charge}'");

                $execRet = slef::shell( GO_CMD . " '{$serverInfo['serverip']}:{$serverInfo['serverport']}' '//sys pay {$orderRow['oid']} {$charDataRow['name']} {$orderRow['iid']} {$charge}'"); // 执行充值

                if(Consts::GO_EXEC_SUCCESS == $execRet){

                    $result = ['status'=>0, 'msg'=>'充值成功'];

                    $orderChargeRow = Db::connect(UER)->selectRow( "select IFNULL( sum(`charge`), 0.00) as `totalcharge` from `order` where `charid` = '{$orderRow['charid']}' and `status` >= 1 limit 1");

                    $totalCharge = $orderChargeRow['totalcharge'] + $charge;

                    Db::connect(UER)->update( "update `order` set `ordernum` = '{$ordernum}',`status` = 1,`totalcharge` = {$totalCharge},`mtime` = unix_timestamp() where `oid` = '{$orderRow['oid']}'");

                    Console::log('渠道充值', "【{$keyword}】充值成功,订单编号 {$oid},金额 {$charge}");
                }else{
                    $result = ['status'=>-1, 'msg'=>'游戏服务器充值失败'];

					Console::log('渠道充值', "【{$keyword}】充值失败,GO执行失败({$execRet}),订单编号 {$oid},金额 {$charge}");
                }
            }else{
                $result = ['status'=>-1, 'msg'=>'获取角色信息失败'];

				Console::log('渠道充值', "【{$keyword}】充值失败,查询不到角色信息,订单编号 {$oid},金额 {$charge}");
            }
        }else{
            if(isset($orderRow['status'])){
                $state = 0;
                $msg = '订单已完成';
            }else{
                $state = -1;
                $msg = '订单不存在';
            }
            $result = ['status'=>$state, 'msg'=>$msg];
			Console::log('渠道充值', "【{$keyword}】充值失败,{$msg},订单编号 {$oid},金额 {$charge},渠道订单编号 {$ordernum},平台 {$keyword}");
        }
        return $result;
    }

	// 腾讯充值
	// 2016-8-16 14:40:25
	static public function txPay( $oid, $charge, $ordernum, $keyword, $name){
		$sciptPayRow = Db::connect(UER)->selectRow("select * from `tx_script_pay` where `name` = '{$name}' order by `oid` desc limit 1");
		$orderRow = Db::connect(UER)->selectRow("select * from `order` where `oid` = '{$oid}' and `status` <= 0 limit 1");
		if($orderRow && $sciptPayRow){
			$pid = $sciptPayRow['pid'];
			$appid = $appkey = $type = '';
			if(Consts::TX_QQ_ID == $pid){
				$appid = Consts::TX_QQ_APPID;
				$appkey = Consts::TX_QQ_APPKEY;
				$type = 'qq';
			}else if(Consts::TX_WX_ID == $pid) {
				$appid = Consts::TX_WX_APPID;
				$appkey = Consts::TX_WX_APPKEY;
				$type = 'wx';
			}
			$openid = $sciptPayRow['openid'];
			$openkey = $sciptPayRow['openkey'];
			$pay_token = $sciptPayRow['pay_token'];
			$pf = $sciptPayRow['pf'];
			$pfkey = $sciptPayRow['pfkey'];
			$zid = $sciptPayRow['zone'];
			$ts = time();
			$params = [
				'openid' => $openid,
				'openkey' => $openkey,
				'pay_token' => $pay_token,
				'ts' => $ts,
				'pf' => $pf,
				'pfkey' => $pfkey,
				'zoneid' => $zid,
				'amt'=>$orderRow['charge'] * Consts::DIAMOND_RATIO,
				'billno'=>$orderRow['oid']
			];
			$sdk = new Api( $appid, $appkey);
			$sdk->setPay( Consts::TX_PAY_APPID, Consts::TX_PAY_APPKEY);
			$sdk->setServerName( 'ysdk.qq.com');
			$ret = $sdk->api_pay( '/mpay/pay_m', $type, $params, 'get', 'https');
			if(0 == $ret['ret'] || 1002215 == $ret['ret']){
				Console::log('腾讯充值',"【{$keyword}】扣费成功,订单号: {$orderRow['oid']}");
				$result = self::pay( $oid, $charge, $ordernum, $keyword);
			}else{
				$msg = "扣费失败,不允许补单({$ret['ret']})";
				$ret = $sdk->api_pay( '/mpay/get_balance_m', $type, $params, 'get', 'https');
				if(0 == $ret['ret']){
					$amt = $orderRow['charge'] * Consts::DIAMOND_RATIO;
					Console::log('腾讯充值',"【{$keyword}】扣费失败,余额不足,请求扣除游戏币: {$amt} 现有游戏币: {$ret['balance']} 订单号: {$orderRow['oid']}");
				}else{
					Console::log('腾讯充值',"【{$keyword}】扣费失败,查询余额失败,订单号: {$orderRow['oid']}");
				}
				$result = ['status'=>-1, 'msg'=>$msg];
			}
		}else{
			$result = ['status'=>-1, 'msg'=>'该订单不可进行补单操作'];
		}
		return $result;
	}

	// 获取渠道列表
	// 2016-7-8 11:54:50
	static public function getKeywordList(){
		return Consts::$keywordList;
	}

	// 获取平台列表
	// 2016-7-6 14:46:12
	static public function getPlatformList(){
		if(CacheMemcached::get( CacheMemcached::RES_PLATFORM_LIST) === false){
			$platformList = Db::connect(UER)->select("select * from `platform` order by `pid` asc");
			CacheMemcached::set( CacheMemcached::RES_PLATFORM_LIST, $platformList, Consts::MIN_SEC * 10);
		}else{
			$platformList = CacheMemcached::get( CacheMemcached::RES_PLATFORM_LIST);
		}
		return $platformList;
	}

	// 获取全部区服列表
	// 2016-7-1 15:46:14
	static public function getZoneList( $type = 'merge'){
	    if('all' == $type){
            if(CacheMemcached::get( CacheMemcached::RES_ZONE_ALL_LIST) === false){
                $zoneList = Db::connect(UER)->select("select * from `zone` order by `pid`,`zid` asc");
                CacheMemcached::set( CacheMemcached::RES_ZONE_ALL_LIST, $zoneList, Consts::MIN_SEC * 10);
            }else{
                $zoneList = CacheMemcached::get( CacheMemcached::RES_ZONE_ALL_LIST);
            }
        }else{
            if(CacheMemcached::get( CacheMemcached::RES_ZONE_LIST) === false){
                $zoneList = Db::connect(UER)->select("select * from `zone` order by `pid`,`zid` asc");
                $zoneNameMap = array_column( $zoneList, 'name', 'zid');
                $zoneMergeList = Db::connect(UER)->select("select `zid`,`zone` from `zone_merge`");
                $mainZidMap = $slaveZidMap = [];
                foreach($zoneMergeList as $zoneMerge){
                    $mainZidMap[$zoneMerge['zid']] = explode( ',', $zoneMerge['zone']);
                    foreach(explode( ',', $zoneMerge['zone']) as $zid){
                        $slaveZidMap[$zid] = true;
                    }
                }
                $platformList = self::getPlatformList();
                $platformMap = array_column( $platformList, 'name', 'pid');
                foreach($zoneList as $key => $zone){
                    if(isset($mainZidMap[$zone['zid']])){
                        $zoneList[$key]['name'] = $platformMap[$zone['pid']] . '-' . $zoneNameMap[current($mainZidMap[$zone['zid']])] . ' - ' . $zoneNameMap[end($mainZidMap[$zone['zid']])];
                    }else if(isset($slaveZidMap[$zone['zid']])){
                        unset($zoneList[$key]);
                    }else{
                    	$zoneList[$key]['name'] = $platformMap[$zone['pid']] . '-' . $zone['name'];
                    }
                }
                CacheMemcached::set( CacheMemcached::RES_ZONE_LIST, $zoneList, Consts::MIN_SEC * 10);
            }else{
                $zoneList = CacheMemcached::get( CacheMemcached::RES_ZONE_LIST);
            }
        }
		return $zoneList;
	}

	// 获取合并后区服列表
	// 2016-7-1 15:46:14
	static public function getZoneMergeList(){
		if(CacheMemcached::get( CacheMemcached::RES_ZONE_MERGE_LIST) === false){
			$zoneMergeList = Db::connect(UER)->select("select * from `zone_merge`");
			CacheMemcached::set( CacheMemcached::RES_ZONE_MERGE_LIST, $zoneMergeList, Consts::MIN_SEC * 10);
		}else{
            $zoneMergeList = CacheMemcached::get( CacheMemcached::RES_ZONE_MERGE_LIST);
		}
		return $zoneMergeList;
	}

	// 获取道具列表
	// 2016-7-1 16:17:53
	static public function getItemList(){
		if(CacheMemcached::get( CacheMemcached::RES_ITEM_LIST) === false){
			$itemList = Db::connect(UEA)->select("select * from `item` where `iid` < 10000 order by `iid` asc");
			CacheMemcached::set( CacheMemcached::RES_ITEM_LIST, $itemList, Consts::DAY_SEC * 10);
		}else{
			$itemList = CacheMemcached::get( CacheMemcached::RES_ITEM_LIST);
		}
		return $itemList;
	}

	// 获取装备列表
	// 2016-10-21 10:40:08
	static public function getEquipList(){
		if(CacheMemcached::get( CacheMemcached::RES_EQUIP_LIST) === false){
			$equipList = Db::connect(UEA)->select("select * from `item` where `iid` > 10000 order by `iid` asc");
			CacheMemcached::set( CacheMemcached::RES_EQUIP_LIST, $equipList, Consts::DAY_SEC * 10);
		}else{
			$equipList = CacheMemcached::get( CacheMemcached::RES_EQUIP_LIST);
		}
		return $equipList;
	}

	// 获取任务列表
	// 2016-10-21 10:27:23
	static public function getTaskList(){
		if(CacheMemcached::get( CacheMemcached::RES_TASK_LIST) === false){
			$taskList = Db::connect(UEA)->select( "select * from `task`");
			CacheMemcached::set( CacheMemcached::RES_TASK_LIST, $taskList, Consts::DAY_SEC * 10);
		}else{
			$taskList = CacheMemcached::get( CacheMemcached::RES_TASK_LIST);
		}
		return $taskList;
	}

	// 获取区服服务器信息
	// 2016-8-3 10:31:56
	static public function getServerInfo( $zid = 0){
		$serverInfo = ['serverip'=>'0','serverport'=>0];
		$zoneRow = Db::connect(UER)->selectRow( "select `serverip`,`serverport` from `zone` where `zid` = '{$zid}'");
		if(isset($zoneRow['serverip']) && $zoneRow['serverip'] && $zoneRow['serverport']){
			$portList = array_filter(explode( ',', $zoneRow['serverport']));
			$port = $portList[rand(0, count($portList) - 1)];
			$serverInfo = ['serverip'=>$zoneRow['serverip'], 'serverport'=>$port];
		}
		return $serverInfo;
	}

	// shell
    // 2016-10-9 11:54:32
    static public function shell( $sh){
        return trim(shell_exec( $sh));
    }

    // 获取指定区服玩家信息
    // 2016-10-9 15:12:00
    static public function getChatDataRow( $zid, $keyword){
        self::setDBConnect( $zid);
        return Db::connect(MAIN)->selectRow("select * from `chardata` where `charid` = '{$keyword}' or `name` = '{$keyword}'");
    }

    // 判断区服列表
    // 2017-3-6 11:27:09
    static public function getZidList($zid, $useType = 's'){
    	if('s' == $useType){
    		$zidList = -1 == $zid? array_unique(array_column(Functions::getZoneList(), 'zid')): [$zid];
    	}else{
    		if(-1 == $zid){
    			$zidList = array_column(Functions::getZoneList('all'), 'zid');
    		}else{
    			$whereLst = [
    				"`zone` like '%,{$zid}'",
    				"`zone` like '{$zid},%'",
    				"`zone` like '%,{$zid},%'",
    				"`zone` = '{$zid}'"
    			];
    			$where = implode( ' or ', $whereLst);
    			$zoneMergeRow = Db::connect(UER)->selectRow("select * from `zone_merge` where {$where}");
    			$zidList = $zoneMergeRow? explode( ',', $zoneMergeRow['zone']): [$zid];
    		}
    	}
    	return $zidList;
    }
}
