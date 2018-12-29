<?php
kirk_require_class('View');
kirk_require_class('UrlBuilder');
abstract class AdminBlankFrameView extends \View{

    public function get_container() {
        return 'AdminBlankFrame';
    }

    public static function get_css_list() {
        return array(
            'AdminBlankFrame',
        );
    }

    public static function get_js_list() {
        return array_merge(
            parent::get_js_list(),array(
                'Commonjs_WindowsBase',
                'AdminBlankFrame'
        ));
    }

    public function get_author(){
        return 'Kirk';
    }

}