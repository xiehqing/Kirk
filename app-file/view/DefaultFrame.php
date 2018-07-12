<?php

kirk_require_class('View');
kirk_require_class('UrlBuilder');
class DefaultFrameView extends View {

    public function get_content(){
		$data = KIRK::get_instance()->get_request()->get_attributes();
		foreach($data as $k=>$v) {
			$this->set_data($k, $v);
		}
		return 'DefaultFrame';
	}
	public static function get_css_list() {
		return array_merge(parent::get_css_list(),
		array(
			'DefaultFrame'
		));
	}
	public static function get_js_list() {
		return array_merge(
		parent::get_js_list(),
		array(
			'DefaultFrame'
		));
	}
    public function get_title() {
        return '测试';
    }
}
