<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-22
 * Time: 上午11:36
 */

class AdminRequest extends Request {
    private $permission = 0;
    public function set_adminid($admin_id) {
        $this->admin_id = $admin_id;
    }
    public function get_adminid() {
        return $this->admin_id;
    }
    public function get_username() {
        return $this->user_name;
    }
    public function set_username($user_name) {
        $this->user_name = $user_name;
    }
    public function set_permission($permission){

        $this->permission = $permission;
    }
    public function get_permission(){
        $permission_list =  explode(",",$this->permission);

        $permission_list_assoc = array();

        foreach($permission_list as $k=>$v) {
            $permission_list_assoc[$v] = 1;
        }

        return $permission_list_assoc;
    }
}
