<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-7-21
 * Time: 上午11:53
 */
class PageCreater{
    private $data = array();
    public $is_static_uri = false;

    /**
     * 设置pages的基础url
     * @param String $url
     */
    public function set_baseurl($url){
        $this->data['base_url'] = $url;
    }

    /**
     * 设置当前分页
     * @param String $page
     */
    public function set_page($page){
        $this->data['page'] = $page;
    }

    /**
     * 设置总数量
     * @param Integer $num
     */
    public function set_total_num($num){
        $this->data['total_num'] = $num;
    }

    /**
     * 设置每页的个数
     * @param Integer $num
     */
    public function set_page_num($num){
        if (!$num){
            trigger_error('每页个数必须大于0',E_USER_WARNING);
            return;
        }
        $this->data['page_size'] = $num;
    }

    /**
     * 获取pages
     * @return array
     */
    public function get_pages(){
        $this->data['is_static_url'] = $this->is_static_uri;
        return $this->data;
    }
}