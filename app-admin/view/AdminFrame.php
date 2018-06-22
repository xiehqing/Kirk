<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-22
 * Time: 下午4:38
 */

kirk_require_view('View');
kirk_require_class('UrlBuilder');
kirk_require_plugin('Admin_Header');
kirk_require_plugin('Admin_Nav');
kirk_require_plugin('Admin_Footer');
kirk_require_plugin('Admin_Pages');
abstract class AdminFrameView extends View {
    public static function get_css_list() {
        return array(
            'AdminFrame',
            'Bootstrap_Bootstrap.min',
            'Bootstrap_Bootstrap-responsive.min'
        );
    }

    public static function get_js_list() {
        return array_merge(
            parent::get_js_list(),array(
            'Jquery.json-2.4.min',
            'jquery.dragsort-0.5.1.min',
            'Bootstrap_Bootstrap.min',
            'Admin_Common',
            'Util',
            'AdminFrame'
        ));
    }

    public static function get_static_js_list() {
        return array_merge(
            parent::get_static_js_list(),array(
            'js/jquery-1.7.1.min.js',
        ));
    }

    public static function get_plugin() {
        return array(
            'Admin_Header',
            'Admin_Nav'
        );
    }
    public function get_permit_nav_list($list) {
        $permission = new Admin_Permission(KIRK::get_instance()->get_request());
        $list =  $permission->filter_permission($list);
        if(!$list) {
            die('permission denied!!!');
        }
        return $list;
    }
    public static function get_name()
    {
        return '主页';
    }

    public function get_container()
    {
        return 'AdminFrame';
    }

    public function get_main_path() {
        return '';
    }
}