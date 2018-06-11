<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-11
 * Time: 下午2:42
 */
class Response {

    final public function __construct() {
        $this->set_debug();
    }

    final private function set_debug() {
        $params = KIRK::get_instance()->request->get_params();
        if($params['debug']) {
            $this->set_cookie('debug',1);
        } else if(isset($params['debug'])){
            $this->set_cookie('debug', 0, time()-1);
        }
    }

    public function not_found() {
        Header("HTTP/1.1 404 Not Found");
        return false;
    }
    public function status_500() {
        Header("HTTP/1.1 500 Invalid Params");
        echo '<h1>非法参数</h1>';
    }
    public function set_cookie($key,$v,$t=0,$path='/',$domain='',$httponly=false) {
        if($t===0) {
            $t = time()+7*86400;
        }
        if(!$httponly) {
            setcookie($key,$v,$t,$path,$domain);
        } else {
            setcookie($key,$v,$t,$path,$domain,null,true);
        }
    }
    public function header($key,$value) {
        Header("$key:$value");
    }
    public function redirect($location,$is_301=false) {
        if($is_301) {
            Header("HTTP/1.1 301 Moved Permanently");
        }
        $this->header("Location", $location);
    }
    public function is_https() {
        if($_SERVER['HTTPS']=='on') {
            return true;
        } else {
            return false;
        }
    }
}
