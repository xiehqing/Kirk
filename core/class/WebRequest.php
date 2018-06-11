<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-11
 * Time: 下午3:32
 */
class WebRequest extends Request{
    public function get_url(){
        return 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    }

    public function is_mobile() {
        $ua = $this->get_user_agent();
        $pattern1 = '/Profile\/MIDP-\d/i';
        $pattern2 = '/Mozilla\/.*(SymbianOS|iPhone|iTouch|IEMobile|Android|Windows\sCE)/i';
        $isMobile = preg_match($pattern1, $ua) || preg_match($pattern2, $ua);
        if($isMobile) {
            return true;
        } else {
            return false;
        }
    }
    public function is_iphone(){
        $agent = strtolower($this->get_user_agent());
        $iphone = (strpos($agent, 'iphone')) ? true : false;
        return $iphone;
    }
    public function is_android(){
        $agent = strtolower($this->get_user_agent());
        $iphone = (strpos($agent, 'iphone')) ? true : false;
        $android = (strpos($agent, 'android')) ? true : false;
        return $android;
    }

    public function is_weixin() {
        if (strpos($this->get_user_agent(), 'MicroMessenger') !== false) {
            return true;
        } return false;
    }
    public function is_ipad(){
        $ua = $this->get_user_agent();
        if(strpos($ua,'iPad')!==false) {
            return true;
        } else {
            return false;
        }
    }
}