<?php
namespace Admin\Demo;
use KIRK;
class TablesView extends \DemoFrameView {

    public function get_content(){
		$data = KIRK::get_instance()->get_request()->get_attributes();
		foreach($data as $k=>$v) {
			$this->set_data($k, $v);
		}
		return 'Admin\Demo\Tables';
	}
	public static function get_css_list() {
		return array_merge(parent::get_css_list(),
		array(
			'Admin\Demo\Tables'
		));
	}
	public static function get_js_list() {
		return array_merge(
		parent::get_js_list(),
		array(
			'Admin\Demo\Tables'
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
                'vendor/datatables-plugins/dataTables.bootstrap.css',
                'vendor/datatables-responsive/dataTables.responsive.css',
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
                'vendor/datatables/js/jquery.dataTables.min.js',
                'vendor/datatables-plugins/dataTables.bootstrap.min.js',
                'vendor/datatables-responsive/dataTables.responsive.js',
                'dist/js/sb-admin-2.js'
            ));
    }

    public function get_title() {
        return 'Demo - Tables';
    }

    public function get_keywords()
    {
        return 'Just a Demo!';
    }
}
