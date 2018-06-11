<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-11
 * Time: 上午11:03
 */
error_reporting(E_ALL & ~E_NOTICE);


define("ROOT_PATH",dirname(dirname((__FILE__))) . '/');
define("SYS_PATH",'../system');
define("CUR_PATH", ROOT_PATH . 'app-home');

require_once (SYS_PATH . '/functions.php');

$INCLUDE_PATH = array(
    CUR_PATH,
    ROOT_PATH . 'core'
);

$CONFIG_PATH = array(
    ROOT_PATH . 'core/config',
    CUR_PATH . '/config',
    ROOT_PATH . 'config',
);

# 设置页面超时时间
set_time_limit(KIRK::get_instance()->get_config(['time_out']));

kirk_require_class('KIRK');
kirk_require_class('HomeRequest');
kirk_require_class('HomeResponse');
KIRK::get_instance()->setRequest(new HomeRequest());
KIRK::get_instance()->setResponse(new HomeResponse());
KIRK::get_instance()->run();

