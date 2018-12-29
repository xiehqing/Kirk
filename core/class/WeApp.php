<?php

namespace core\common;
define("TOKEN", '公众号token');
define("APPID", '公众号APPID');
define("APPSECRET", '公众号APPSECRET');
define("INDEXURL","公众号INDEXURL");
class WeApp{
    //--------------------
    // 微信公众号授权相关的轮子
    //--------------------
    public function Auth(){
        if (!session('openid')) {
            //如果$_SESSION中没有openid，说明用户刚刚登陆，就执行getCode、getOpenId、getUserInfo获取他的信息
            $code = getCode();
            $access_token = getOpenId($code);
            $userInfo = getUserInfo($access_token);
            $wxid = $userInfo['openid'];
            $nickname = $userInfo['nickname'];
            $avatar = $userInfo['headimgurl'];
            $user = Db::name('system_users')->where("openid",  $wxid )->find();//获取用户信息
            if($user){
                session('openid',$wxid);
            }else{
                $data['openid'] =$wxid;
                $data['uname'] =$nickname;
                $data['avatar'] = $avatar;
                Db::name('system_users')->insert($data);
            }
        }
    }

    /**
     * @explain
     * 获取code,用于获取openid和access_token
     * @remark
     * code只能使用一次，当获取到之后code失效,再次获取需要重新进入
     * 不会弹出授权页面，适用于关注公众号后自定义菜单跳转等，如果不关注，那么只能获取openid
     **/
    public function getCode(){
        if (isset($_GET["code"])) {
            return $_GET["code"];
        } else {
            $str = "location: https://open.weixin.qq.com/connect/oauth2/authorize?appid=".APPID."&redirect_uri=" .INDEXURL. "&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
            // var_dump($str);die();
            header($str);
            // die();
            exit;
        }
    }
    /**
     * @explain
     * 用于获取access_token,返回的$access_token_array中也包含有用户的openid信息。

     **/
    public function getOpenId($code)
    {
        $access_token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" .APPID. "&secret=" . APPSECRET . "&code=" . $code . "&grant_type=authorization_code";
        $access_token_json = https_request($access_token_url);
        $access_token_array = json_decode($access_token_json, TRUE);
        return $access_token_array;
    }
    /**
     * @explain
     * 获取到用户的openid之后可以判断用户是否有数据，可以直接跳过获取access_token,也可以继续获取access_token
     **/
    public function getUserInfo($access_token)
    {
        $userinfo_url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token['access_token'] ."&openid=" . $access_token['openid']."&lang=zh_CN";
        $userinfo_json = https_request($userinfo_url);
        $userinfo_array = json_decode($userinfo_json, TRUE);
        return $userinfo_array;
    }

    /**
     * @explain
     * 发送http请求，并返回数据
     **/
    public function https_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
}