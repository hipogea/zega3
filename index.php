<?php

// change the following paths if necessary

if(strpos(dirname(__FILE__).'','dev')>0)
        $cad='/../framework/yii.php';
    else  $cad='/framework/yii.php';
$yii=dirname(__FILE__).$cad;
$config=dirname(__FILE__).'/protected/config/main.php';
//echo $yii; die();
// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
date_default_timezone_set('Africa/Lusaka');
Yii::createWebApplication($config)->run();   
