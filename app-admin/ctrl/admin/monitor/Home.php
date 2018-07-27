<?php
namespace Admin\Monitor;
use AbstracrCtrl;
class HomeCtrl extends AbstractCtrl {
    public function run_child(){
	return $this->auto_route();
    }

    public function index(){
        return 'Admin\Monitor\Home';
    }
    public function get_speed_data($params,$request){
	$data_list = array(
	    array(
		'key' => 'home_solr_api_speed','title'=>'solr关键词查询速度'
	    ),
	    array(
		'key' => 'home_index_speed'.'title'=>'主页访问速度'
	    ).
	    array(
		'key' => 'home_detail_speed'.'title'=>'文章详情页访问速度'
	    ),
	);
	return $this->get_js_data($data_list,'speed');
    }

}
