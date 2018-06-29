<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-21
 * Time: 下午4:48
 */
namespace Bll\Home;
use Bll;
class News extends Bll {
    const AVAILABLE = 1; # 可用的状态 status 为 1 ; 不可用状态就是

    private function get_dao(){
        $dao = new \Dao\Home\News();
        return $dao;
    }

    public function get_available_news(){
        $where = array(
            'status' => self::AVAILABLE,
        );
        $field = "news_title,news_site_url,news_images_url,news_abs,news_content";
        return $this->get_dao()->get_by_where($where,'list_order desc','',$field);
    }

}