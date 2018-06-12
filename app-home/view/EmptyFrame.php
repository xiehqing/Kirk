<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-12
 * Time: 上午8:50
 */

kirk_require_view("View");
kirk_require_class('UrlBuilder');

abstract class EmptyFrameView extends View {

    public function get_container() {
        return 'EmptyFrame';
    }

    public static function get_css_list() {
        return array(
            'EmptyFrame'
        );
    }

    public static function get_js_list() {
        return array_merge(
            parent::get_js_list(), array(
            'EmptyFrame',
        ));
    }

    public static function get_static_js_list() {
        return array_merge(
            parent::get_static_js_list(), array(
            'js/jquery-1.7.1.min.js',
        ));
    }

    public static function get_plugin() {
        return array();
    }
}