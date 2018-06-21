<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-11
 * Time: 下午4:04
 */
kirk_require_ctrl('Ctrl');
class ActionCtrl extends Ctrl{
    public function run() {
        $result = $this->router_action();
        if (is_array($result)){
            $response = KIRK::get_instance()->get_response();
            $response->header("Content-Type","application/json; charset=utf-8");
            echo json_encode($result);
        } else {
            return $result;
        }
    }

    public function error($status = 1,$msg = "请求失败！"){
        $result = array(
            'status' => $status,
            'message' => $msg,
            'data' => [],
        );
        return $result;
    }

    public function success($data = [],$msg = '请求成功！'){
        $result = array(
            'status' => 0,
            'message' => $msg,
            'data' => $data
        );
        return $result;
    }
}