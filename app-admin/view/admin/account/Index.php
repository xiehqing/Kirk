<?php
namespace Admin\Account;
use KIRK;
class IndexView extends \AdminFrameView {

    public function get_content(){
		$data = KIRK::get_instance()->get_request()->get_attributes();
		foreach($data as $k=>$v) {
			$this->set_data($k, $v);
		}
		return 'Admin\Account\Index';
	}
	public static function get_css_list() {
		return array_merge(parent::get_css_list(),
		array(
			'Admin\Account\Index'
		));
	}
	public static function get_js_list() {
		return array_merge(
		parent::get_js_list(),
		array(
			'Admin\Account\Index'
		));
	}
    public function get_title() {
        return '个人资料';
    }
}
