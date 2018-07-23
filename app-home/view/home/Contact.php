<?php
namespace Home;
use KIRK;
class ContactView extends \HomeFrameView {

    public function get_content(){
		$data = KIRK::get_instance()->get_request()->get_attributes();
		foreach($data as $k=>$v) {
			$this->set_data($k, $v);
		}
		return 'Home\Contact';
	}
	public static function get_css_list() {
		return array_merge(parent::get_css_list(),
		array(
			'Home\Contact'
		));
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
     * 获取静态js资源
     * @return array
     */
    public static function get_static_js_list() {
        return array_merge(
            parent::get_static_js_list(), array(
            'home/js/templatemo_script.js'
        ));
    }

	public static function get_js_list() {
		return array_merge(
		parent::get_js_list(),
		array(
			'Home\Contact'
		));
	}
    public function get_title() {
        return 'Contact - Kirk';
    }
}
