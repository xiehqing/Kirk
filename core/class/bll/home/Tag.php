<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-21
 * Time: 下午4:44
 */
namespace Bll\Home;
use Bll;
class Tag extends Bll {
    const AVAILABLE = 1; # 可用的状态 status 为 1 ; 不可用状态就是

    private function get_dao(){
        $dao = new \Dao\Home\Tag();
        return $dao;
    }

    public function get_available_tags(){
        $where = array(
            'status' => self::AVAILABLE,
        );
        return $this->get_dao()->get_by_where($where,'list_order desc');
    }

}