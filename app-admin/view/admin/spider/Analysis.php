<?php
namespace Admin\Spider;
use KIRK;
class AnalysisView extends \AdminFrameView {

    public function get_content(){
		$data = KIRK::get_instance()->get_request()->get_attributes();
		foreach($data as $k=>$v) {
			$this->set_data($k, $v);
		}
		return 'Admin\Spider\Analysis';
	}
	public static function get_css_list() {
		return array_merge(parent::get_css_list(),
		array(
			'Admin\Spider\Analysis'
		));
	}
	public static function get_js_list() {
		return array_merge(
		parent::get_js_list(),
		array(
			'Admin\Spider\Analysis'
		));
	}

	public static function get_static_js_list() {
        return array_merge(
            parent::get_static_js_list(),array(
            'js/echarts.min.js',
            'js/china.js',
            'js/echart/extension/bmap.js',
        ));
    }

    public function get_title() {
        return '数据分析';
    }
}
