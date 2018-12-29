<?php
namespace Admin\Api;
use KIRK;
use ActionCtrl;
/**
 * 所有接口的基础方法
 * Class BaseCommonCtrl
 * @package Api
 */
class BaseCtrl extends ActionCtrl{
    public $instance;
    public $response;
    public $request;
    public $admin_ip;

    public function run(){
        $this->instance = KIRK::get_instance();
        $this->response = $this->instance->get_response();
        $this->request = $this->instance->get_request();
        $this->admin_ip = $this->request->get_client_ip();

        $this->response->header("Content-Type","application/json; charset=utf-8");

        $params = $this->request->get_params();
        $action = $params['action'];


        // 校验接口是否存在
        if (!method_exists($this, $action)){
            $result = [
                'status' =>1,
                'message' => '接口不存在'
            ];
            echo json_encode($result);
            return false;
        }

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