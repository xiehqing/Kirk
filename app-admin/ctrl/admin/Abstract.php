<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-22
 * Time: 下午3:48
 */
namespace Admin;
use Ctrl;
use KIRK;
abstract class AbstractCtrl extends Ctrl {

    abstract public function run_child();
    public $admin_id = 0;
    public function run() {
        $this->admin_id = KIRK::get_instance()->get_request()->get_adminid();
        $response = KIRK::get_instance()->get_response();
        if(!$this->admin_id) {
            if(!$this->is_ajax) {
                $response->redirect('/login/');
                return false;
            } else {
                echo '{"error"=>101,"message":"你还没有登录！"}';
                return false;
            }
        } else {
            return $this->run_child();
        }
    }
    protected function set_baseurl($params,$base){
        unset($params['page']);
        foreach ($params as $k=>$v){
            $base .= "$k=$v&";
        }
        return $base;
    }
}
