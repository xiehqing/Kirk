<?php
/**
 * 入口文件
 * 1.定义常量
 * 2.加载函数库
 * 3.启动框架
 */

// 获取当前框架所在目录
define('KIRK', realpath('./'));
// 获取框架核心文件所处目录
define('CORE', KIRK.'/core');
// 获取项目文件所处目录
define('APP', KIRK.'/app');
define('MODULE', 'app');
// 开启调试模式
define('DEBUG', true);

//引入composer之前先引入相关的composer类
include "vendor/autoload.php";

if (DEBUG) {
//    引入composer安装的whoops错误提示类
    $whoops = new \Whoops\Run;
//    自定义错误title
    $errorTitle = '框架出错了';
    $option = new \Whoops\Handler\PrettyPageHandler();
    $option->setPageTitle($errorTitle);
    $whoops->pushHandler($option);
//    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
	ini_set('display_error', 'On');
}else{
	ini_set('display_error', 'Off');
}

// 加载函数库
include CORE.'/common/Globalfun.php';
// 加载核心文件kirk.php
include CORE.'/kirk.php';
// 当我们new一个类的时候，如果该类不存在，则触发kirk::load方法,把不存在的类引入
spl_autoload_register('\core\kirk::load');
// 启动框架
\CORE\kirk::run();