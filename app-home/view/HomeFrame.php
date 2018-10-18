<?php
/**
 * Created by PhpStorm.
 * User: kuan
 * Date: 18-9-10
 * Time: 下午2:49
 */
kirk_require_view("View");
kirk_require_plugin('Home\Footer');
kirk_require_plugin('Home\Header');
kirk_require_plugin('Home\Vue');
kirk_require_class('UrlBuilder');
kirk_require_class('Home_UrlBuilder');
abstract class HomeFrameView extends View {

    public function get_container() {
        return 'HomeFrame';
    }
    // 获取css
    public static function get_css_list() {
        return array(
            'HomeFrame'
        );
    }
    // 获取js
    public static function get_js_list() {
        return array_merge(
            parent::get_js_list(), array(
            'HomeFrame'
        ));
    }
    public static function get_static_js_list() {
        return array_merge(
            parent::get_static_js_list(), array(
            'js/jquery-1.7.1.min.js',
        ));
    }
    // 获取插件
    public static function get_plugin() {
        return array(
            'Home\Vue',
            'Home\Header',
            'Home\Footer'

        );
    }


    public function get_main_section() {
        return "HomeFrame";
    }
}