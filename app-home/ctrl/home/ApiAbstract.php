<?php
/**
 * Created by PhpStorm.
 * User: kuan
 * Date: 2018/7/2
 * Time: 08:52
 */
namespace Home;
use ActionCtrl;

abstract class ApiAbstractCtrl extends ActionCtrl{
    abstract public function get_api_config();

}