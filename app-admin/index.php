<?php
error_reporting(E_ALL & ~E_NOTICE);
define(ROOT_PATH,dirname(dirname(__FILE__)).'/');
define(SYS_PATH,'../system');
define(CUR_PATH,ROOT_PATH.'app-admin');

require_once(SYS_PATH.'/functions.php');

$INCLUDE_PATH = array(
    CUR_PATH,
    ROOT_PATH.'app-admin',
    ROOT_PATH.'app-dnf',
    ROOT_PATH.'core'
);
$CONFIG_PATH = array(
    CUR_PATH.'/config',
    ROOT_PATH.'core/config',
    ROOT_PATH.'config',
);

kirk_require_class('KIRK');
kirk_require_class('AdminRequest');
kirk_require_class('AdminResponse');
KIRK::get_instance()->setRequest(new AdminRequest());
KIRK::get_instance()->setResponse(new AdminResponse());
KIRK::get_instance()->run();
