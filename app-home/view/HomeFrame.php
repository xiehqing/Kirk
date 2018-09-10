<?php
/**
 * Created by PhpStorm.
 * User: kuan
 * Date: 18-9-10
 * Time: 下午2:49
 */
kirk_require_view('View');
kirk_require_class('UrlBuilder');
abstract class HomeFrameView extends View {
    public static function get_css_list() {
        return array(
            'HomeFrame'
        );
    }

    public static function get_js_list() {
        return array_merge(
            parent::get_js_list(),array(
            'HomeFrame'
        ));
    }

    public static function get_static_js_list() {
        return array_merge(
            parent::get_static_js_list(),array(
            '',
        ));
    }

    public static function get_plugin() {
        return array(
            ''
        );
    }
    public function get_permit_nav_list($list) {
        $permission = new Home_Permission(KIRK::get_instance()->get_request());
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
        return 'HomeFrame';
    }

    public function get_main_path() {
        return '';
    }
}