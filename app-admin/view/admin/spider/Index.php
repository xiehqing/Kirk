<?php
namespace Admin\Spider;
use KIRK;
class IndexView extends \AdminFrameView {

    public function get_content(){
		$data = KIRK::get_instance()->get_request()->get_attributes();
		foreach($data as $k=>$v) {
			$this->set_data($k, $v);
		}
		return 'Admin\Spider\Index';
	}
	public static function get_css_list() {
		return array_merge(parent::get_css_list(),
		array(
			'Admin\Spider\Index'
		));
	}
	public static function get_js_list() {
		return array_merge(
		parent::get_js_list(),
		array(
			'Admin\Spider\Index'
		));
	}
    public function get_title() {
        return '爬虫管理';
    }
}
