<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-11
 * Time: 下午4:06
 */
abstract class Ctrl{
    abstract public function run();

    /**
     * @desc 自动action 进行反射到对应的方法，对结果不处理
     * @param string $handle router的参数
     * @return mixed
     */
    public function router_action($handle='action'){
        $request = KIRK::get_instance()->get_request();
        $params = $request->get_params();
        $action = $params[$handle];
        $action = $action?$action:'index';
        if(method_exists($this, $action)) {
            $result = $this->$action($params,$request);
        }
        return $result;
    }

    /**
     * @desc 自动对action进行处理，若返回数组，那么认为是ajax请求
     * @param string $handle
     * @return bool
     */
    public function auto_router($handle='action'){
        $result = $this->router_action($handle);
        if(is_array($result)) {
            echo json_encode($result);
            return false;
        } else {
            return $result;
        }
    }
}