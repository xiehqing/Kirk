<?php

namespace Bll\Kirk;
use Bll;

class AdminUser extends Bll {


    private function get_dao() {
        $dao = new \Dao\Kirk\AdminUser();
        return $dao;
    }

    public function getUserByName($name){
        $where = [
            'username' => $name
        ];
        return $this->get_dao()->get_single_by_where($where);
    }

    /**
     * 检测是否篡改cookie中的user_id和username
     * @param $id
     * @param $username
     * @return bool
     */
    public function checkUserByUidAndUname($id,$username){
        $data = $this->get_dao()->get_by_id($id);
        if ($username == $data['username']){
            return true;
        }else{
            return false;
        }
    }
}