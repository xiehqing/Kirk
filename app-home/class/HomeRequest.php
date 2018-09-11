<?php
/**
 * Created by PhpStorm.
 * User: kuan
 * Date: 18-9-10
 * Time: 下午2:59
 */

class HomeRequest extends WebRequest {
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