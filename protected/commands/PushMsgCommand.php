<?php
class PushMsgCommand extends CConsoleCommand
{  
    public function run($args) {
        set_time_limit(0);
        // 初始化环境
        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', Yii::getPathOfAlias('webroot') . '/../assets/key/ck.pem');
        stream_context_set_option($ctx, 'ssl', 'passphrase', '123456789');
        // 建立APNS连接
        $fp = stream_socket_client( 'ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
        if(!$fp){
            Console::error( 'IOS推送', "未能连接APNS服务器 {$err}, {$errstr}");
            return;
        }
        while(1){
            $tokenMsg = unserialize( CacheRedis::connect()->rpop('iosPushMsg'));
            if($tokenMsg){
                $sTime = microtime(true);
                
                $deviceToken = $tokenMsg['token'];

                $message = $tokenMsg['msg'];

                // 构建消息体,json编码
                $payload = json_encode( array( 'aps'=>array('alert' => $message, 'sound' => 'default')));

                // 转换二进制
                $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

                // 发送消息
                $result = fwrite($fp, $msg, strlen($msg));

                if (!$result){
                    Console::warn( 'IOS推送', "消息推送失败,CHARID: {$tokenMsg['charid']}");
                } else{
                    $time = round( microtime(true)-$sTime, 3);
                    Console::log( 'IOS推送', "消息推送成功,CHARID: {$tokenMsg['charid']},耗时: {$time}秒");
                }
            }else{
                break;
            }
        }
        fclose($fp);
    }
}  