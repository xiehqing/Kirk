<?php
/**
 * Created by PhpStorm.
 * User: kuan
 * Date: 2018/11/13
 * Time: 下午3:58
 */
error_reporting(E_ALL & ~E_NOTICE);
define("ROOT_PATH", dirname(dirname(__FILE__)) . '/');
define("SYS_PATH", '../system');
define("CUR_PATH", ROOT_PATH . 'app-api');

require_once (SYS_PATH . '/functions.php');

$INCLUDE_PATH = [
    CUR_PATH,
    ROOT_PATH . 'core'
];

$CONFIG_PATH = [
    ROOT_PATH . 'app-core/config',
    CUR_PATH . '/config',
    ROOT_PATH . 'config',
];

kirk_require_class('KIRK');
kirk_require_class('ApiRequest');
KIRK::get_instance()->setRequest(new ApiRequest());
KIRK::get_instance()->run();