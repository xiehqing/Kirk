<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-20
 * Time: 上午10:06
 */
set_time_limit(0);
abstract class Bin_Abstract {

    public $max_page_num = 500;
    abstract public function run($argv,$argc);

}