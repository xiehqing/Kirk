<?php
namespace Api\V1;
use Api\ApiAbstractCtrl;
use KIRK;

/**
 * API的基类，从这里转发到其它的接口
 * Class DemoBaseCtrl
 * @package Api\V1
 */
class ApiBaseCtrl extends ApiAbstractCtrl {

    /**
     * 获取api的通用配置
     * @return mixed
     */
    public function get_api_config(){
        return KIRK::get_instance()->get_config('api');
    }

    public function run(){
        $request = KIRK::get_instance()->get_request();
        $params = $request->get_params();
        if (!$params['action']){
            echo json_encode($this->error(1,'没有方法函数！'));
            return false;
        }
        $action = $params['action'];
        if(method_exists($this,$action)){
            $result = $this->$action($params,$request);
        }else{
            $fstr = stripos($action,'_');
            if (!$fstr){
                echo json_encode($this->error(1,'该方法不存在！'));
                return false;
            }
            $class = 'Api\\v1\\'.ucwords(substr($action,0,$fstr)).'Ctrl';
            $action = substr($action,$fstr+1,(strlen($action)-$fstr-1));
            $result = array();
            $class_obj = new $class();
            if(method_exists($class_obj, $action)) {
                $result = $class_obj->$action($params,$request);
            }else{
                return false;
            }
        }
        if(is_array($result)) {
            $response = KIRK::get_instance()->get_response();
            $response->header("Content-Type","application/json; charset=utf-8");
            echo json_encode($result);
        } else {
            return $result;
        }
    }
}
