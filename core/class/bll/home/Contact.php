<?php
/**
 * Created by PhpStorm.
 * User: kuan
 * Date: 2018/7/4
 * Time: 17:19
 */
namespace Bll\Home;
use Bll;
class Contact extends Bll{
    const AVAILABLE = 1; # 可用的状态 status 为 1 ; 不可用状态

    private function get_dao(){
        $dao = new \Dao\Home\Contact();
        return $dao;
    }

    public function get_available_contact_info(){
        $where = array(
            'status' => self::AVAILABLE,
        );
        return $this->get_dao()->get_by_where($where);
    }
}