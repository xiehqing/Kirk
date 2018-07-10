<?php
namespace admin\home;
use KIRK;
class UserVipView extends \AdminFrameView {

    public function get_content(){
		$data = KIRK::get_instance()->get_request()->get_attributes();
		foreach($data as $k=>$v) {
			$this->set_data($k, $v);
		}
		return 'admin\home\UserVip';
	}
	public static function get_css_list() {
		return array_merge(parent::get_css_list(),
		array(
			'admin\home\UserVip'
		));
	}
	public static function get_js_list() {
		return array_merge(
		parent::get_js_list(),
		array(
			'admin\home\UserVip'
		));
	}
    public function get_title() {
        return '测试';
    }
}
