<?php
/**
 * A job demo for get news
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-20
 * Time: 上午10:05
 */

class Bin_Home_GetNews extends \Bin_Abstract {

    public function run($argv, $argc) {
        // 此处调用各平台api获取新闻
        echo "job demo";
    }
}