<?php
kirk_require_class('Admin_Abstract');
class Admin_Monitor_HomeCtrl extends Admin_AbstractCtrl {

    public function run_child(){
        return $this->auto_route();
    }

    public function index(){
        return 'Admin\Monitor\Home';
    }

    public function get_speed_data($params,$request){
        $data_list = array(
            array('key' => 'home_solr_api_speed','title'=>'solr关键词查询速度'),
	        array('key' => 'home_index_speed','title'=>'主页访问速度'),
	        array('key' => 'home_detail_speed','title'=>'文章详情页访问速度')
	    );
	    return $this->get_js_data($data_list,'speed');
    }
    public function get_count_data(){
	    $data_list = array(
	        array('key' => 'home_error_pv','title' => '50x错误统计'),
	        array('key' => 'solr_count', 'title' => 'solr查询量统计'),
            array('key' => 'home_pc_pv', 'title' => '主页pc请求'),
            array('key' => 'home_404_error_pv', 'title' => '404统计')
        );
	    return $this->get_js_data($data_list, 'count');
    }
    public function get_js_data($data_list, $data_key){
        $redis = KIRK::get_instance()->get_redis();
        $js_data_list = array();

        foreach ($data_list as $data){
            $current_hour = intval(date('H'));
            $data_length = $current_hour+24;
            $recent_two_days_list = $redis->lRange($data['key'],$data_length*-1,-1);


            // 计算几天的
            $recent_two_days_list_assoc = array();
            foreach ($recent_two_days_list as $k => $v){
                $data_array = json_decode($v,true);
                $recent_two_days_list_assoc[$data_array['time_index']] = $data_array;
            }

            $toady_date_index = date('Ymd');
            $toady_data = array();
            for($i=0;$i<24;$i++) {

                $hour = sprintf('%02d',$i);
                $current_time_index = $toady_date_index.$hour;

                if($current_data = $recent_two_days_list_assoc[$current_time_index]) {
                    $toady_data[] = $current_data;
                } else {
                    $toady_data[] = array(
                        'time_index'=>$current_time_index,
                        $data_key=>0
                    );
                }
            }

            $yestoady_date_index =  date('Ymd',strtotime('-1days'));
            $yestoady_data = array();
            for($i=0;$i<24;$i++) {
                $hour = sprintf('%02d',$i);
                $current_time_index = $yestoady_date_index.$hour;
                if($current_data = $recent_two_days_list_assoc[$current_time_index]) {
                    $yestoady_data[] = $current_data;
                } else {
                    $yestoady_data[] = array(
                        'time_index'=>$current_time_index,
                        $data_key=>0
                    );
                }
            }

            foreach($recent_two_days_list as $k=>$v) {
                $recent_two_days_list[$k] = json_decode($v,true);
            }
            $js_data_list[] = array(
                'title'=>$data['title'],
                'data'=>$toady_data,
                'yestoady'=>$yestoady_data
            );
        }
        return $js_data_list;
    }

    public function get_minute_data($params,$request){
        $key = $params['key'];
        $redis = KIRK::get_instance()->get_redis();
        $data = $redis->lRange($key,6*60*-1,-1);
        $js_data = array();



        foreach($data as $k=>$v) {
            $v_obj = json_decode($v,true);
            $js_data[] = array(
                'name'=>$v_obj['time_index'],
                'value'=>array(
                    $v_obj['time_index'],
                    $v_obj['speed']
                )
            );
        }

        return $js_data;

    }
}
