<?php
//===============================V1.0 版本===========已废弃============
//return array(
//	'DSN' => 'mysql:host=localhost;dbname=dbname',
//	'USERNAME' => '',
//	'PASSWD' => ''
//);

//# 改为medoo的配置
//return array(
//    'database_type' => '',
//    'database_name' => '',
//    'server' => '',
//    'username' => '',
//    'password' => ''
//);
//===============================V1.0 版本===========已废弃============


# 数据库相关的配置信息
$config['mongodb'][''] = array(
    'dbname' => '',
    'uri' => ''
);

$config['db']['']['master'] = array(
    'host' => '',
    'port' => '',
    'user' => '',
    'pass' => '',
    'db' => ''
);

$config['db']['']['slave'] = array(
    'host' => '',
    'port' => '',
    'user' => '',
    'pass' => '',
    'db' => ''
);