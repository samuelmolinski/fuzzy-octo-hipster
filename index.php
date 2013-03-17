<?php
require_once('m_toolbox/m_toolbox.php');
require_once('combination/Performance.php');
require_once('combination/CombinationGenerator.php');
require_once('combination/CombinationList.php');
require_once('combination/LF_Combination.php');
require_once('combination/LF_Restrictions.php');
require_once('combination/LF_CombinationGenerator.php');

if((FALSE === stripos(hostURI(), 'nissen'))) {
	//use on local host
	// change the following paths if necessary
	$yii=dirname(__FILE__).'/../yii/framework/yii.php';
} else {	
	$yii=dirname(__FILE__).'/../../yii/framework/yii.php';
}

$config=dirname(__FILE__).'/protected/config/main.php';
// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
