<?php
namespace Home;
use HomeFrameView;
use KIRK;
class AboutView extends HomeFrameView {

    public function get_content(){
		$data = KIRK::get_instance()->get_request()->get_attributes();
		foreach($data as $k=>$v) {
			$this->set_data($k, $v);
		}
		return 'Home\About';
	}
	public static function get_css_list() {
		return array_merge(parent::get_css_list(),
		array(
			'Home\About'
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

	public static function get_js_list() {
		return array_merge(
		parent::get_js_list(),
		array(
			'Home\About'
		));
	}

    public function get_title() {
        return '测试';
    }
}
