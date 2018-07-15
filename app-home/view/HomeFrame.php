<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-11
 * Time: 下午4:10
 */

kirk_require_view("View");
kirk_require_plugin('Home_Footer');
kirk_require_plugin('Home_Header');
kirk_require_plugin('Home_Nav');
kirk_require_plugin('Home\VueDev');
kirk_require_class('UrlBuilder');
kirk_require_class('Home_UrlBuilder');

abstract class HomeFrameView extends View {

    public function get_container() {
        return 'HomeFrame';
    }

    public static function get_css_list() {
        return array(
            'HomeFrame',
        );
    }

    public static function get_static_css_list(){
        return array_merge(
            parent::get_static_css_list(), array(
            'home/css/bootstrap.min.css',
            'home/css/bootstrap-theme.min.css',
        ));
    }

    public static function get_js_list() {
        return array_merge(
            parent::get_js_list(), array(
            'HomeFrame',
            'Util',
            'Options',
        ));
    }

    public static function get_static_js_list() {
        return array_merge(
            parent::get_static_js_list(), array(
                'home/js/jquery-3.3.1.min.js',
                'home/js/bootstrap.min.js',
        ));
    }

    public static function get_plugin() {
        return array(
            'Home_Footer',
            'Home_Header'
        );
    }

    public function get_main_section() {
        return "index";
    }


}