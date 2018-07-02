<?php

// func
$func=dirname(__FILE__).'/func.php';

// change the following paths if necessary
$yii=dirname(__FILE__).'/core/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

if(isset($_GET['debug']) && 'true' == $_GET['debug']){
    // open debug in production mode
    defined('YII_DEBUG') or define('YII_DEBUG',true);

    // specify how many levels of call stack should be shown in each log message
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
}else{
    // default close the debug in production mode
    defined('YII_DEBUG') or define('YII_DEBUG',false);

}

// web root
defined('WEB_NAME') or define('WEB_NAME', 'BACKEND');
defined('WEB_ROOT') or define('WEB_ROOT', dirname(__FILE__));

// go program directory
defined('GO_CMD') or define('GO_CMD', dirname(__FILE__) . '/assets/exec/GMCmd');
defined('GO_SCENE') or define('GO_SCENE', dirname(__FILE__) . '/assets/exec/Scene');

// UEA、UER、MAIN OR LOG
defined('UEA') or define('UEA', 'uea');
defined('UER') or define('UER', 'uer');
defined('MAIN') or define('MAIN', 'main');
defined('LOG') or define('LOG', 'log');
defined('PLATFORM') or define('PLATFORM', 'platform');

require_once($func);
require_once($yii);
Yii::createWebApplication($config)->run();
