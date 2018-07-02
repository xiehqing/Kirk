<?php
/**
 * Created by PhpStorm.
 * User: kuan
 * Date: 2018/7/2
 * Time: 10:08
 */
namespace api;
use ActionCtrl;

abstract class ApiBaseCtrl extends ActionCtrl{
    abstract public function get_api_config();

}