<?php
namespace Home;
use KIRK;
class ProjectView extends \HomeFrameView {

    public function get_content(){
		$data = KIRK::get_instance()->get_request()->get_attributes();
		foreach($data as $k=>$v) {
			$this->set_data($k, $v);
		}
		return 'Home\Project';
	}
	public static function get_css_list() {
		return array_merge(parent::get_css_list(),
		array(
			'Home\Project'
		));
	}
	public static function get_js_list() {
		return array_merge(
		parent::get_js_list(),
		array(
			'Home\Project'
		));
	}
    public function get_title() {
        return '测试';
    }
}
