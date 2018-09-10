<?php
/**
 * Created by PhpStorm.
 * User: kuan
 * Date: 18-9-10
 * Time: 下午2:57
 */

error_reporting(E_ALL & ~E_NOTICE);
define("ROOT_PATH",dirname(dirname((__FILE__))) . '/');
define("SYS_PATH",'../system');
define("CUR_PATH",ROOT_PATH.'app-home');

require_once(SYS_PATH.'/functions.php');


$INCLUDE_PATH = array(
    CUR_PATH,
    ROOT_PATH . 'core'
);

$CONFIG_PATH = array(
    CUR_PATH . '/config',
    ROOT_PATH . 'core/config',
    ROOT_PATH . 'config',
);

kirk_require_class('KIRK');
kirk_require_class('HomeRequest');
kirk_require_class('HomeResponse');
KIRK::get_instance()->setRequest(new HomeRequest());
KIRK::get_instance()->setResponse(new HomeResponse());
KIRK::get_instance()->run();