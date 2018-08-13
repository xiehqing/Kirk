<?php
/**
 * Created by PhpStorm.
 * User: kuan
 * Date: 2018/8/13
 * Time: 16:46
 */
namespace Api;
use ActionCtrl;
abstract class ApiAbstractCtrl extends ActionCtrl{
    abstract public function get_api_config();
}