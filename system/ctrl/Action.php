<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-11
 * Time: 下午4:04
 */

kirk_require_ctrl('Ctrl');
class ActionCtrl extends Ctrl {

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

    public function error($status = 1, $msg = ""){

        $result = [
            'status' => $status,
            'data' => [],
        ];

        if ($msg){
            $result['message'] = $msg;
        }else{
            $result['message'] = $this->getErrorMessageByStatus($status);
        }

        return $result;
    }

    public function success($token = '',$data = [],$msg = '请求成功！'){
        $result = array(
            'status' => 0,
            'message' => $msg,
            'data' => $data,
            'token' => $token
        );
        return $result;
    }

    private function getErrorMessageByStatus($status) {
        $code_message_list = array(
            1 => '请求失败',
            2 => '参数不完整',
            3 => '无结果',
            4 => '参数不合法',
        );
        if (isset($code_message_list[$status])) {
            return $code_message_list[$status];
        } else {
            return $code_message_list[1];
        }
    }


}