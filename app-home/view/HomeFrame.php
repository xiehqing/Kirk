<?php
/**
 * Created by PhpStorm.
 * User: kuan
 * Date: 18-9-10
 * Time: 下午2:49
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
            'HomeFrame'
        );
    }
    public static function get_js_list() {
        return array_merge(
            parent::get_js_list(), array(
            'HomeFrame'
        ));
    }


    public function get_main_section() {
        return "HomeFrame";
    }
}