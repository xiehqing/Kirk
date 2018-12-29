<?php
# 数据库相关的配置信息
$config['mongodb'][''] = array(
    'dbname' => '',
    'uri' => ''
);

$config['db']['kirk']['master'] = array(
    'host' => '127.0.0.1',
    'port' => '3306',
    'user' => 'root',
    'pass' => '',
    'db' => 'kirk'
);

$config['db']['kirk']['slave'] = array(
    'host' => '127.0.0.1',
    'port' => '3306',
    'user' => 'root',
    'pass' => '',
    'db' => 'kirk'
);
