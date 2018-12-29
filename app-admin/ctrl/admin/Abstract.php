<?php
namespace Admin;
use Ctrl;
use KIRK;

/**
 * Class AbstractCtrl
 * @package Admin
 */
abstract class AbstractCtrl extends Ctrl{

    abstract public function run_child();
//    abstract function level_promise();
//    abstract function get_left_uri();
//    abstract function get_show_menu();

    public $instance;
    public $request;
    public $response;

    public $admin_id = 0;
    public $admin_name;
    public $admin_token;
    public $admin_ip;

    public function run(){

        $this->instance = KIRK::get_instance();
        $this->request = $this->instance->get_request();
        $this->response = $this->instance->get_response();

        $this->admin_id = $this->request->get_cookie('admin_id');
        $this->admin_name = $this->request->get_cookie('admin_name');
        $this->admin_token = $this->request->get_cookie('admin_token');
        $this->admin_ip = $this->request->get_client_ip();

        if(!$this->admin_id) {
            if(!$this->is_api) {
                $this->response->redirect('/login/');
                return false;
            } else {
                echo '{"error"=>101,"message":"你还没有登录！"}';
                return false;
            }
        } else {
            // 拦截器
            if ($this->intercept()){
                echo  '{"error"=>101,"message":"道高一尺，魔高一丈啊小老弟！"}';
                return false;
            }
            // 初始化顶部header数据
            $this->initTopHeader();
            return $this->run_child();
        }

    }

    /**
     * 初始化左侧菜单栏的数据
     * @param $params
     * @param \AdminRequest $request
     */
    public function initLeftMenu($params,$request){
        $result_data = array();
        $left_uri = trim($params['left_uri']);
        $result_data['left_uri'] = $this->get_left_uri();
        if ($left_uri){
            $result_data['left_uri'] = $left_uri;
        }

        $show_menu = trim($params['show_menu']);
        $result_data['show_menu'] = $this->get_show_menu();
        if ($show_menu){
            $result_data['show_menu'] = $show_menu;
        }
        $request->set_attribute('left_menu_data',$result_data);
    }

    /**
     * 初始化顶部header栏
     */
    public function initTopHeader(){
        $result_data = array();
//        $bllUserProfile = new \Bll\Kirk\AdminUserProfile();
//        $userProfile = $bllUserProfile->getInfoByAdminID($this->admin_id);
//        $nick_name = $userProfile['nick_name'];
//        $avatar = \UrlBuilder::build_image_url($userProfile['avatar'],230,0);
//        $slogan = $userProfile['slogan'];
        $result_data['nick_name'] = $this->admin_name;
        $result_data['avatar'] = $avatar ? $avatar : \UrlBuilder::build_static('admin/imgs/logo.png');
        $result_data['slogan'] = $slogan ? $slogan : "辣鸡版本（前端练手）。";

        $this->request->set_attribute('top_header_data',$result_data);
    }

    /**
     * 拦截器
     * 防篡改cookie，防越权...
     * @return bool
     */
    private function intercept(){
//        $level = $this->level_promise();
//        if ($this->get_vip()<$level){
//            UrlHandle::page_not_found();
//        }

        // 防止篡改cookie里的信息，进行伪造数据登录
        if ($this->admin_token != \GlobalFun::sign($this->admin_id)){
            return true;
        }
        // admin的登录权限是限制了ip的
        if ($this->admin_name = 'admin' && !in_array($this->admin_ip,$this->instance->get_config('admin_ip','common'))){
            return true;
        }
    }

    public function error($status = 1, $msg = ""){

        $result = [
            'status' => $status,
            'data' => [],
        ];

        if ($msg){
            $result['message'] = $msg;
        }else{
            $result['message'] = $this->getErrorMessageByStatus($status);
        }

        return $result;
    }

    public function success($data = [],$msg = '请求成功！'){
        $result = array(
            'status' => 0,
            'message' => $msg,
            'data' => $data,
        );
        return $result;
    }

    private function getErrorMessageByStatus($status) {
        $code_message_list = array(
            1 => '请求失败',
            2 => '参数不完整',
            3 => '无结果',
            4 => '参数不合法',
        );
        if (isset($code_message_list[$status])) {
            return $code_message_list[$status];
        } else {
            return $code_message_list[1];
        }
    }
}