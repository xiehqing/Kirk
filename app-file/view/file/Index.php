<?php
namespace File;
use DefaultFrameView;
use KIRK;
class IndexView extends DefaultFrameView {

    public function get_content(){
		$data = KIRK::get_instance()->get_request()->get_attributes();
		foreach($data as $k=>$v) {
			$this->set_data($k, $v);
		}
		return 'file\Index';
	}
	public static function get_css_list() {
		return array_merge(parent::get_css_list(),
		array(
			'file\Index'
		));
	}
	public static function get_js_list() {
		return array_merge(
		parent::get_js_list(),
		array(
			'file\Index'
		));
	}
    public function get_title() {
        return '测试';
    }
}
