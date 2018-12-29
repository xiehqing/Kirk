<?php
kirk_require_class('View');
kirk_require_class('UrlBuilder');
kirk_require_plugin('Admin\Demo\LeftMenu');
kirk_require_plugin('Admin\Demo\TopHeader');
abstract class DemoFrameView extends \View{

    public function get_container() {
        return 'DemoFrame';
    }

    public static function get_css_list() {
        return array(
            'DemoFrame',
        );
    }

    public static function get_js_list() {
        return array_merge(
            parent::get_js_list(),array(
            'DemoFrame'
        ));
    }

    /**
     * 加了这个方法才能加载到插件里的js等等
     * @return array
     */
    public static function get_plugin() {
        return array(
            'Admin\Demo\LeftMenu',
            'Admin\Demo\TopHeader'
        );
    }

    public function get_author(){
        return 'Kirk';
    }

}