<?php
/**
 * Created by PhpStorm.
 * User: kuan
 * Date: 2018/7/21
 * Time: 13:21
 */
kirk_require_plugin('Plugin');

class Home_NavPlugin extends Plugin {
    public function get_content() {
        $data = KIRK::get_instance()->get_request()->get_attributes();
        foreach($data as $k=>$v) {
            $this->set_data($k, $v);
        }
        return 'Home\Nav';
    }

    public static function get_css_list() {
        return array(
            'Home\Nav'
        );
    }

    public static function get_js_list(){
        return array(
            'Home\Nav'
        );
    }
}