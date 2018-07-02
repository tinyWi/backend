<?php
// 主配置文件
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>' | 游曳联运平台',
	// auto load class
	'import'=>array(
		'application.models.*',
		'application.components.*'
	),
	// components
	'components'=>array(
 		'session'=>array(
 			'timeout'=>604800,
 		),
		'user'=>array(
			'allowAutoLogin'=>true,
		),
		'request' => array(
            'enableCsrfValidation' => false,
            'enableCookieValidation' => true,
        ),
		// backend database
		'UEA'=>array(
			'class' => 'CDbConnection',
			'connectionString' => 'mysql:host=127.0.0.1;dbname=uea',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'root',
			'charset' => 'utf8',
			'tablePrefix'=>''
		),
		// backend database
		'UER'=>array(
			'class' => 'CDbConnection',
			'connectionString' => 'mysql:host=127.0.0.1;dbname=uer',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'root',
			'charset' => 'utf8',
			'tablePrefix'=>''
		)
	),
	// timezone
	'timeZone'=>'Asia/ShangHai'
);