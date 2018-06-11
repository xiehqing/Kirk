<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-11
 * Time: 下午4:58
 */
kirk_require_plugin('Plugin');

class Home_HeaderPlugin extends Plugin {
    public function get_content() {
        $request = KIRK::get_instance()->get_request();
//        $user_id = $request->get_uid();
//        if($user_id){
//            $bll = new \Bll\Suqian\User();
//            $user_info = $bll->get_info_by_user_id($user_id);
//            $this->set_data('user_name',$user_info['user_name']);
//        }
        $is_index = $request->get_attribute('is_index');
        $this->set_data('is_index',$is_index?:'');



        return 'Kirk_Header';
    }

    public static function get_css_list() {
        return array(
            'Kirk_Header'
        );
    }

    public static function get_js_list() {
        return array(
            'Kirk_Header'
        );
    }
}