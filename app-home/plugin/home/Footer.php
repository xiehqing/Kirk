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
        return 'Home\Footer';
    }

    public static function get_css_list() {
        return array(
            'Home\Footer'
        );
    }

    public static function get_js_list() {
        return array(
            'Home\Footer'
        );
    }
}