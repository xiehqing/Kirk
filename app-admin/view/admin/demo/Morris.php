<?php
namespace Admin\Demo;
use KIRK;
class MorrisView extends \DemoFrameView {

    public function get_content(){
		$data = KIRK::get_instance()->get_request()->get_attributes();
		foreach($data as $k=>$v) {
			$this->set_data($k, $v);
		}
		return 'Admin\Demo\Morris';
	}
	public static function get_css_list() {
		return array_merge(parent::get_css_list(),
		array(
			'Admin\Demo\Morris'
		));
	}
	public static function get_js_list() {
		return array_merge(
		parent::get_js_list(),
		array(
			'Admin\Demo\Morris'
		));
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
                'data/morris-data.js',
                'dist/js/sb-admin-2.js'
            ));
    }

    public function get_title() {
        return 'Demo - Morris';
    }

    public function get_keywords()
    {
        return 'Just a Demo!';
    }
}
