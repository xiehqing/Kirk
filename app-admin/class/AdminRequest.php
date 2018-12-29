<?php
class AdminRequest extends Request{
    private $permission = 0;
    public $admin_id;
    public $user_name;

    public function set_adminid($admin_id){
        $this->admin_id = $admin_id;
    }

    public function get_adminid(){
        return $this->admin_id;
    }

    public function set_username($user_name){
        $this->user_name = $user_name;
    }

    public function get_username(){
        return $this->user_name;
    }

    public function set_permission($permission){
        $this->permission = $permission;
    }

    public function get_permission(){
        $permission_list = explode(",",$this->permission);

        $permission_list_assoc = array();

        foreach ($permission_list as $key => $value){
            $permission_list_assoc[$value] = 1;
        }

        return $permission_list_assoc;
    }

}