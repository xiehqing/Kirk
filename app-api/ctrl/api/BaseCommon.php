<?php
namespace Api;
use ActionCtrl;

/**
 * 所有接口的基础方法
 * Class BaseCommonCtrl
 * @package Api
 */
class BaseCommonCtrl extends ActionCtrl{

    public function run() {
        return parent::run();
    }

    /**
     * 参数数组过滤器
     * @param $params
     * @return mixed
     */
    public function filterParams($params){
        foreach($params as &$v){
            $v = htmlspecialchars(trim($v));
        }
        return $params;
    }

    /**
     * 把传过来的两个字符串转换成数组，数组长度相同就返回true
     * @param $a_str
     * @param $b_str
     * @return bool
     */
    public function isSameLength($a_str,$b_str){
        $arr1 = explode(",",$a_str);
        $arr1 = array_filter($arr1);
        $arr2 = explode(",",$b_str);
        if (count($arr1) == count($arr2)){
            return true;
        }else{
            return false;
        }
    }
}