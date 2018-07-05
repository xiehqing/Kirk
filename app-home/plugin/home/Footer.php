<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-11
 * Time: 下午4:59
 */

kirk_require_plugin('Plugin');

class Home_FooterPlugin extends Plugin {
    public function get_content() {

        // 获取底部联系方式
        $contact_data = $this->get_contact_data();

        $this->set_data('contact_data',$contact_data);
        return 'Home\Footer';
    }

    public static function get_css_list() {
        return array(
            'Home\Footer'
        );
    }

    public static function get_js_list(){
        return array(
            'Home\Footer'
        );
    }

    public function get_contact_data(){
        $bll_home_contact = new \Bll\Home\Contact();
        $result = $bll_home_contact->get_available_contact_info();
        return $result;
    }
}