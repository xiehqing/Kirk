<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-11
 * Time: 下午2:37
 */
kirk_require_class('WebRequest');

class HomeRequest extends WebRequest{
    // 初始化用户uid
    private $user_id = 0;
    // 初始化管理员uid
    private $admin_user_id = 0;
    /**
     * 设置用户uid
     * @param $user_id
     */
    public function set_uid($user_id){
        $this->user_id->$user_id;
    }

    /**
     * 获取用户uid
     * @return int
     */
    public function get_uid(){
        return $this->user_id;
    }

    /**
     * 设置管理员uid
     * @param $admin_user_id
     */
    public function set_admin_uid($admin_user_id){
        $this->admin_user_id = $admin_user_id;
    }

    /**
     * 获取管理员uid
     * @return int
     */
    public function get_admin_uid(){
        return $this->admin_user_id;
    }

    /**
     * 验证黑名单IP
     * @param bool $exit
     * @return bool
     */
    public function check_ip_black($exit = true){
        $ip = $this->get_client_ip();
        $user_agent = $this->get_user_agent();
        // 验证ＩＰ是否在白名单中
        if ($this->is_white_ip($ip)){
            return false;
        }
    }

    /**
     * 获取子域名
     * @return bool
     */
    public function get_child_domain(){
        $domain = $this->get_domain();
        $config_domain = KIRK::get_instance()->get_config("domain");
        if ($domain == $config_domain) {
            return false;
        } else {
            $ds = explode('.',$domain);
            return $ds[0];
        }
    }

    /**
     * 验证是否是白名单中的ＩＰ或ＩＰ段
     * @param string $ip
     * @return bool|void
     */
    public function is_white_ip($ip = ""){
        // 如果没有传$ip，就调用获取客户端ＩＰ的方法
        if (!$ip){
            $ip = $this->get_client_ip();
        }
        //读取配置 white_ip_list（配置文件中将IP或IP段构造为数组的key，因为复杂度array_key_exists比in_array是1比n）
        $white_ip_list = KIRK::get_instance()->get_config("white_ip_list");
        // 如果是指定ＩＰ而不是ＩＰ段
        if (array_key_exists($ip,$white_ip_list)){
            return true;
        }

        // 如果是符合ＩＰ段的ＩＰ，先通过“.”符号截取ＩＰ的前三组数据
        $ip_pre = explode(".",$ip);
        array_pop($ip_pre);
        $ip_pre = implode(".",$ip_pre);
        // 判断IP前缀是否在IP段内
        if (array_key_exists($ip_pre,$white_ip_list)){
            return true;
        }

        return ;
    }

    /**
     * 获取客户端IP
     * @return mixed
     */
    public function get_client_ip() {
        return $_SERVER['REMOTE_ADDR'];
    }

}