<?php
/**
 * Created by PhpStorm.
 * User: kuan
 * Date: 2018/8/13
 * Time: 16:46
 */
namespace Api;
use ActionCtrl;

abstract class ApiBaseCtrl extends ActionCtrl{

    /**
     * 获取api的通用配置
     * @return mixed
     */
    abstract public function get_api_config();
}