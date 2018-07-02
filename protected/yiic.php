<?php

// func
$func=dirname(__FILE__).'/../func.php';

// change the following paths if necessary
$yiic=dirname(__FILE__).'/../core/framework/yiic.php';
$config=dirname(__FILE__).'/config/console.php';

// web root
defined('WEB_NAME') or define('WEB_NAME', 'BACKEND');
defined('WEB_ROOT') or define('WEB_ROOT', dirname(__FILE__) . '/..');

// go program directory
defined('GO_CMD') or define('GO_CMD', dirname(__FILE__) . '/assets/exec/GMCmd');
defined('GO_SCENE') or define('GO_SCENE', dirname(__FILE__) . '/assets/exec/Scene');

// UEA、UER、MAIN OR LOG
defined('UEA') or define('UEA', 'uea');
defined('UER') or define('UER', 'uer');
defined('MAIN') or define('MAIN', 'main');
defined('LOG') or define('LOG', 'log');

require_once($func);
require_once($yiic);
Yii::createConsoleApplication($config)->run();
