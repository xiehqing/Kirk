<?php
namespace Admin;
use KIRK;
class LoginView extends \AdminBlankFrameView {

    public function get_content(){
		$data = KIRK::get_instance()->get_request()->get_attributes();
		foreach($data as $k=>$v) {
			$this->set_data($k, $v);
		}
		return 'Admin\Login';
	}

	public static function get_css_list() {
		return array_merge(parent::get_css_list(),
		    array(
			    'Admin\Login',
		    )
        );
	}

    //	外部的静态css资源
	public static function get_static_css_list()
    {
        return array_merge(
            parent::get_static_css_list(),
            array(
                'vendor/bootstrap/css/bootstrap.min.css',
                'vendor/metisMenu/metisMenu.min.css',
                'dist/css/sb-admin-2.css',
                'vendor/font-awesome/css/font-awesome.min.css'
            ));
    }


    public static function get_js_list() {
		return array_merge(
		    parent::get_js_list(),
		    array(
			    'Admin\Login',
		    )
        );
	}

    //  外部的js资源
	public static function get_static_js_list() {
        return array_merge(
            parent::get_static_js_list(),
            array(
                'vendor/jquery/jquery.min.js',
                'vendor/bootstrap/js/bootstrap.min.js',
                'vendor/metisMenu/metisMenu.min.js',
                'dist/js/sb-admin-2.js'
            )
        );
    }

    public function get_title() {
        return '登录';
    }

}
