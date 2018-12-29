<?php
kirk_require_class('View');
kirk_require_class('UrlBuilder');
abstract class DefaultFrameView extends View{

    public function get_container() {
        return 'DefaultFrame';
    }

    public static function get_css_list() {
        return array(
            'DefaultFrame'
        );
    }

    public static function get_static_js_list() {
        return array_merge(
            parent::get_static_js_list(),array(
//            'js/jquery-1.7.1.min.js',
        ));
    }

    public static function get_js_list() {
        return array_merge(
            parent::get_js_list(),array(
            'DefaultFrame'
        ));
    }

    public static function get_plugin() {
        return array(
        );
    }
}