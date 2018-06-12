<?php
define("ROOT_PATH",dirname(dirname(dirname((__FILE__)))) . '/');
//===============================V1.0 版本===========已废弃============
//return array(
//	'DRIVE' => 'file',
//	'OPTION' => array(
//		'PATH'=>KIRK.'/log/'
//	)
//);
//===============================V1.0 版本===========已废弃============

# log日志相关的配置信息
$config['log'] = array(
    'DRIVE' => 'file',
	'OPTION' => array(
	    'PATH'=>ROOT_PATH.'log/'
    )
);