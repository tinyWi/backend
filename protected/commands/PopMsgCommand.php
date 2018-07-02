<?php
class PopMsgCommand extends CConsoleCommand
{  
    public function run($args) {
        set_time_limit(0);
        while(1){
            $num = CacheRedis::connect()->llen('iosPushMsg');
            if($num){
                shell_exec('/usr/bin/php /var/www/html/uea/protected/yiic.php PushMsg');
                shell_exec('/usr/bin/php /var/www/html/uea/protected/yiic.php PushMsg');
                shell_exec('/usr/bin/php /var/www/html/uea/protected/yiic.php PushMsg');
                shell_exec('/usr/bin/php /var/www/html/uea/protected/yiic.php PushMsg');
                shell_exec('/usr/bin/php /var/www/html/uea/protected/yiic.php PushMsg');
                shell_exec('/usr/bin/php /var/www/html/uea/protected/yiic.php PushMsg');
                shell_exec('/usr/bin/php /var/www/html/uea/protected/yiic.php PushMsg');
                shell_exec('/usr/bin/php /var/www/html/uea/protected/yiic.php PushMsg');
                shell_exec('/usr/bin/php /var/www/html/uea/protected/yiic.php PushMsg');
                shell_exec('/usr/bin/php /var/www/html/uea/protected/yiic.php PushMsg');
            }else{
                sleep(3);
            }
        }
    }
}  