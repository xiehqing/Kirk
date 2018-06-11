<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-11
 * Time: 下午6:30
 */

error_reporting(E_ALL & ~E_NOTICE);
define(ROOT_PATH,dirname(dirname(__FILE__)).'/');
define(SYS_PATH,ROOT_PATH.'system');
define(CUR_PATH,ROOT_PATH.'app-job');
require_once(SYS_PATH.'/functions.php');

$INCLUDE_PATH = array(
    CUR_PATH,
    ROOT_PATH.'app-job',
    ROOT_PATH.'app-core'
);
$CONFIG_PATH = array(
    CUR_PATH.'/config',
    ROOT_PATH.'app-core/config',
    ROOT_PATH.'config',
);
kirk_require_class('KIRK');
KIRK::get_instance()->debug = false; //防止溢出
$job_path = $argv[1];
if($job_path) {
    kirk_require_class($job_path);
    $job = new $job_path();
    $new_argv = array();
    $new_argv[] = $argv[0];
    for($i=2;$i<count($argv);$i++) {
        $new_argv[] = $argv[$i];
    }
    $job->run($new_argv,$argc);
} else {
    echo '输入你的job类名';echo PHP_EOL;
}
