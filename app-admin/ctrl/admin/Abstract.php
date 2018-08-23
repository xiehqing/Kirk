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

/**
 * Class AbstractCtrl
 * @package Admin
 */
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

    /**
     * 检验是否是一个手机号
     * @param $phone
     * @return bool
     */
    public function check_is_phone($phone){
        if (!preg_match('/^1[34578]{1}\d{9}$/',$phone)) {
            return false;
        }
        return true;
    }

    /**检验密码是否符合规则
     * @param $pwd
     * @return bool
     */
    public function check_pwd($pwd){
        if(preg_match('/^[_0-9a-z]{6,16}$/i',$pwd)){
            return true;
        }
        return false;
    }

    /**检验图形验证码
     * @param $verify_code
     * @param string $type
     * @return bool
     */
    public function check_img_code($img_code,$type){
        $key = \GlobalFun::build_user_key($type);
        $mem = KIRK::get_instance()->get_cache();
        $mem_code = $mem->get($key);
        $mem->set($key, '');
        if($img_code=='8888'){//通用图形验证码
            return true;
        }
        if(strtolower($img_code)!=strtolower($mem_code)){
            return false;
        }
        return true;
    }

    /**直接使用user_id登陆
     * @param $user_id
     * @return bool
     */
    public function login_with_user_id($user_id){
        $response = KIRK::get_instance()->get_response();
        $response->set_cookie('user_id',$user_id,time()+3600*24*7,'/');
        $response->set_cookie('suqian_uid_token',\GlobalFun::sign($user_id),time()+3600*24*7,'/');
        return true;
    }
}
