<?php
kirk_require_class('View');
kirk_require_class('UrlBuilder');
kirk_require_plugin('Admin\LeftMenu');
kirk_require_plugin('Admin\TopHeader');
kirk_require_plugin('Admin\PopFrame');
abstract class AdminFrameView extends View{

    public function get_container() {
        return 'AdminFrame';
    }

    /**
     * 获取外部静态css
     * @return array
     */
    public static function get_static_css_list()
    {
        return array_merge(parent::get_static_css_list(),
        array(
            'vendor/bootstrap/css/bootstrap.min.css',
            'vendor/metisMenu/metisMenu.min.css',
            'dist/css/sb-admin-2.css',
            'vendor/morrisjs/morris.css',
            'vendor/font-awesome/css/font-awesome.min.css'
        ));
    }

    /**
     * 获取自定义的css
     * @return array
     */
    public static function get_css_list() {
        return array(
            'AdminFrame',
        );
    }

    /**
     * 获取外部静态js
     * @return array
     */
    public static function get_static_js_list()
    {
        return array_merge(parent::get_static_js_list(),
        array(
            'vendor/jquery/jquery.min.js',
            'vendor/bootstrap/js/bootstrap.min.js',
            'vendor/metisMenu/metisMenu.min.js',
            'vendor/raphael/raphael.min.js',
            'vendor/morrisjs/morris.min.js',
//            'data/morris-data.js',
            'dist/js/sb-admin-2.js'
        ));
    }

    /**
     * 获取自定义的js
     * @return array
     */
    public static function get_js_list() {
        return array_merge(
            parent::get_js_list(),array(
            'Commonjs_WindowsBase',
            'AdminFrame'
        ));
    }

    /**
     * 加了这个方法才能加载到插件里的js等等
     * @return array
     */
    public static function get_plugin() {
        return array(
            'Admin\LeftMenu',
            'Admin\TopHeader',
//            'Admin\PopFrame'
        );
    }

    public function get_main_section() {
        return "index";
    }

    public function get_author(){
        return 'Kirk';
    }

}