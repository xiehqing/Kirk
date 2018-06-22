<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-22
 * Time: 下午3:49
 */

namespace Admin;

class DefaultCtrl extends AbstractCtrl {
    public function run_child() {
        return $this->auto_router();
    }
    public function index(){
        return 'Admin\Default';
    }
//    public function company_name_notice($params, $request) {
//        $company_name = $params['company_name'];
//        if (empty(trim($company_name))) {
//            $this->error(2);
//        }
//        $solr = new Bll_Shuidi_Solr();
//        $res = $solr->search($company_name, 1, 6);
//        if ($res) {
//            $company_list = array();
//            foreach ($res['list'] as $val) {
//                $company_list[] = array('company_name' => $val['company_name'], 'digest' => $val['company_name_digest']);
//            }
//            return $this->success(array('company_list' => $company_list));
//        } else {
//            return $this->error(3);
//        }
//    }

//    public function get_company_classification_list($params, $request){
//        $name = $params['name'];
//        $bll = new Bll_Shuidi_CompanyType();
//        $limit = '0,10';
//        $classification_list = $bll->get_info_by_level(4,$name,$limit);
//        if($classification_list){
//            $list = array();
//            foreach($classification_list as $k=>$v){
//                $list[] = ['id'=>$v['id'],'name'=>$v['name']];
//            }
//            return $this->success(['list'=>$list]);
//        }else{
//            return $this->error(3);
//        }
//
//    }
    protected function error($status = 1, $message = '', $data = []) {
        //$data = $this->format_value($data);
        return array(
            'status' => $status,
            'message' => $message ? $message : $this->get_status_message($status),
            'data' => $data,
        );
    }
    private function get_status_message($status) {
        $code_message_list = array(
            0 => '请求成功',
            1 => '请求失败',
            2 => '参数不完整',
            3 => '无结果',
            4 => '参数不合法'
        );
        if (isset($code_message_list[$status])) {
            return $code_message_list[$status];
        } else {
            return $code_message_list[1];
        }
    }
    protected function success($data = [], $msg = '请求成功!') {
        $data = $this->format_value($data);
        return array(
            'status' => 0,
            'message' => $msg,
            'data' => $data,
        );
    }
    private function format_value(&$arr) {
        if (empty($arr)) {
            // 防止空数组变成空串
            $arr = array();
        }
        foreach ($arr as $key => &$val) {
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
                $this->format_value($val); // 递归调用
            }
        }
        return $arr;
    }
}
