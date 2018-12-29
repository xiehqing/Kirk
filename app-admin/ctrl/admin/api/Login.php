<?php
namespace Admin\Api;
use KIRK;
class LoginCtrl extends BaseCtrl{
    /**
     * @param $params
     * @param $request
     * @return bool
     */
    public function Login($params,$request){
        $params = $this->filterParams($params);
        $username = $params['username'];

        if ($username == 'admin' && !in_array($this->admin_ip,$this->instance->get_config('admin_ip','common')) ){
            return $this->error(1, 'admin账号登陆受限');
        }

        $password = $params['password'];
        $bllUser = new \Bll\Kirk\AdminUser();
        $user = $bllUser->getUserByName($username);
        if (!$user){
            return $this->error(1,'account error');
        }else{
            $salt = $user['salt'];
            $ever = $params['ever'];
            if (md5($password.$salt) == $user['password']){
                if (!$ever){
                    $t=0;
                }else{
                    $t = time() + 30 * 24 * 3600;
                }
                $this->response->set_cookie('admin_id',$user['id'],$t,'/');
                $this->response->set_cookie('admin_name',$user['username'],$t,'/');
                $this->response->set_cookie('admin_token',\GlobalFun::sign($user['id']),$t,'/');
                // 记录日志
                $bllLog = new \Bll\Kirk\AdminUserLog();
                $bllLog->addLogs($user['id'],"用户id：{$user['id']}，用户名：{$username}，登陆成功！", $bllLog::TYPE_LOGIN);
                return $this->success(\GlobalFun::sign($user['id']));
            } else{
                // 记录日志
//                $bllLog = new \Bll\Kirk\AdminUserLog();
//                $bllLog->addLogs($user['id'],"用户id：{$user['id']}，用户名：{$username}，密码错误！");
                return $this->error(1,'password error');
            }
        }
    }

    /**
     * @param $params
     * @param \AdminRequest $request
     * @return array
     */
    public function logout($params,$request){
        $this->response->set_cookie('admin_id','');
        $this->response->set_cookie('admin_name','');
        $this->response->set_cookie('admin_token','');
        return $this->success();
    }
}