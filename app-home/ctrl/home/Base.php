<?php
/**
 * Created by PhpStorm.
 * User: kuan
 * Date: 18-9-12
 * Time: 下午6:24
 */

namespace Home;
use KIRK;
use ActionCtrl;
class BaseCtrl extends ActionCtrl {
//    public $start_time;
//    public $end_time;
//    public $input_params;
//    public $output_params;
//
//    public $api_log_bll;
    /**
     * 构造函数
     * BaseCtrl constructor.
     */
//    public function __construct() {
//        $this->api_log_bll = new Bll_Home_ApiLog();
//        $this->start_time = round(microtime(true) *1000);
//        $this->input_params = KIRK::get_instance()->get_request()->get_params();
//    }
    /**
     * 析构函数
     * BaseCtrl destructor
     */
//    public function __destruct() {
//        if (isset($this->input_params['action'])){
//            $this->api_log();
//        }
//    }
//    private function api_log(){
//        $this->end_time = round(microtime(true) * 1000);
//        $this->api_log_bll->api_log($this->input_params,$this->output_params,$this->end_time,$this->start_time);
//    }
    public function success($data = [], $msg = '请求成功！') {
        $data = $this->format_value($data);
        return array(
            'status' => 0,
            'message' => $msg,
            'data' => $data,
        );
//        return parent::success($data, $msg);
    }
    public function error($status = 1, $msg = '',$data = []) {
//        $data = $this->format_value($data);
        return array(
            'status' => $status,
            'message' => $msg,
            'data' => $data,
        );
//        return parent::error($status, $msg);
    }
    public function format_value(&$arr) {
        if (empty($arr)) {
            $arr = array();
        }
        foreach($arr as $key => &$val) {
            if (is_null($val) || strtolower($val) == 'null') {
                $val = '';
            }
            if ($val === true) {
                $val = '1';
            }
            if ($val === false) {
                $val = '0';
            }
            if (is_array($val)) {
                $this->format_value($val); //递归调用
            }
        }
        return $arr;
    }
    private function get_status_message($status) {
        $code_message_list = array(
            0 => '请求成功',
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
