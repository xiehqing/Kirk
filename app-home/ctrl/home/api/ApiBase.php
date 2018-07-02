<?php
/**
 * Created by PhpStorm.
 * User: kuan
 * Date: 2018/7/2
 * Time: 09:15
 */
namespace Home\Api;
use Home\ApiAbstractCtrl;
use KIRK;

class ApiBaseCtrl extends ApiAbstractCtrl{

    # 获取home的API配置
    public function get_api_config() {
        return KIRK::get_instance()->get_config('home_api');
    }

    public function run(){
        $request = KIRK::get_instance()->get_request();
        $params = $request->get_params();
        $action = $request->get_param('action');
        if(method_exists($this,$action)){
            $result = $this->$action($params,$request);
        }else{
            $fstr = stripos($action,'_');
            $class = 'Home\Api\\'.ucwords(substr($action,0,$fstr)).'Ctrl';
            $action = substr($action,$fstr+1,(strlen($action)-$fstr-1));

            $result = array();
            $class_obj = new $class();
            if(method_exists($class_obj, $action)) {
                $result = $class_obj->$action($params,$request);
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