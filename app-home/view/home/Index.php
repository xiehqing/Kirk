<?php
namespace Home;
use HomeFrameView;
use KIRK;
class IndexView extends HomeFrameView {

    public function get_content(){
        $data = KIRK::get_instance()->get_request()->get_attributes();
        foreach($data as $k=>$v) {
            $this->set_data($k, $v);
        }
        return 'Home\Index';
    }

    /**
     * 获取静态css资源
     * @return array
     */
    public static function get_static_css_list(){
        return array_merge(
            parent::get_static_css_list(), array(
            'home/css/font-awesome.min.css',
            'home/css/magnific-popup.css',
            'home/css/templatemo_style.css',
        ));
    }

    /**
     * 获取自定义的css
     * @return array
     */
    public static function get_css_list() {
        return array_merge(parent::get_css_list(),
            array(
                'Home\Index'
            ));
    }

    /**
     * 获取静态js资源
     * @return array
     */
    public static function get_static_js_list() {
        return array_merge(
            parent::get_static_js_list(), array(
            'home/js/jquery-1.11.1.min.js',
            'home/js/jquery.easing.1.3.js',
            'home/js/modernizr.2.5.3.min.js',
            'home/js/jquery.magnific-popup.min.js',
            'home/js/templatemo_script.js'
        ));
    }

    /**
     * 获取自定义的js
     * @return array
     */
    public static function get_js_list() {
        return array_merge(
            parent::get_js_list(),
            array(
                'Home\Index'
            ));
    }



    public function get_title() {
        return 'Kirk - A Distributed Framework for PHP';
    }
}