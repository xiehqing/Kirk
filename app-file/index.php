<?php
/**
 * Created by PhpStorm.
 * User: kuan
 * Date: 2018/7/12
 * Time: 09:00
 */
error_reporting(E_ALL & ~E_NOTICE);


define("ROOT_PATH",dirname(dirname(__FILE__)) . '/');
define("SYS_PATH",'../system');
define("CUR_PATH", ROOT_PATH . 'app-file');

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
kirk_require_class('FileRequest');
kirk_require_class('FileResponse');
KIRK::get_instance()->setRequest(new FileRequest());
KIRK::get_instance()->setResponse(new FileResponse());
KIRK::get_instance()->run();
