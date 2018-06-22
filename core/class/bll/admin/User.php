<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-22
 * Time: 下午2:21
 */
namespace Bll\Admin;
use Bll;
class User extends Bll {
    const AVAILABLE = 1; # 可用的状态 status 为 1 ;

    private function get_dao(){
        $dao = new \Dao\Admin\User();
        return $dao;
    }

    public function get_user_by_id($uid){
        $user = $this->get_dao()->get_by_id($uid);
        $user['owner_permission'] = json_decode($user['owner_permission'],true);
        return $user;
    }

    public function get_available_users() {
        $where = array(
            'status' => self::AVAILABLE,
        );
        return $this->get_dao()->get_by_where($where,'create_time desc');
    }
}