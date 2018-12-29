<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-12
 * Time: 下午2:11
 */
kirk_require_class('Url_Album');
kirk_require_class('Url_Singer');

class UrlBuilder{
    private static $user_info;

    public static function build_static($path){
        if (preg_match('/^https*\:\/\/i',$path)){
            return $path;
        }
        $static = KIRK::get_instance()->get_config('static');
        return $static . '/' . $path;
    }

    public static function build_image_url_with_logo($key,$width=230,$height=230,$ext="jpg",$q=""){
        if (!$key){
            return '';
        }
        $static = KIRK::get_instance()->get_config('file_url');
        if (!$q){
            return $static.'/imglogo/'.$key."/{$width}x{$height}.{$ext}";
        }else{
            return $static.'/imglogo/'.$key."/{$width}x{$height}.{$ext}?q={$q}";
        }
    }

    public static function build_image_url_compatible($key,$width=230,$height=230,$ext="jpg",$q=""){
        $domain = KIRK::get_instance()->get_config('shuidi_pc_domain');
        if(strpos($domain,'test')!==false) {
            return "http://{$domain}/kaptcha/compress?path={$key}&width=$width&height=$height";
        } else {
            return self::build_image_url($key,$width,$height,$ext,$q);
        }
    }

    public static function build_image_url($key,$width=230,$height=230,$ext="jpg",$q="",$token=false){
        if(!$key) {
            return '';
        }
        if($token) {
            $static = KIRK::get_instance()->get_config('file_url_without_cdn');
        } else {
            $static = KIRK::get_instance()->get_config('file_url');
        }

        if(!$q) {
            $image_url =  $static.'/img/'.$key."/{$width}x{$height}.{$ext}";
        } else {
            $image_url =  $static.'/img/'.$key."/{$width}x{$height}.{$ext}?q={$q}";
        }

        if($token) {
            $t = time();
            $sign = GlobalFun::sign($key.$t);
            $token = "t={$t}&sign={$sign}";

            if(strstr($image_url,'?')) {
                $image_url.='?'.$token;
            } else {
                $image_url .='&'.$token;
            }
        }

        return $image_url;
    }

    /**
     * 生成移动端的url（包括二维码等等）
     * @param $key
     * @param bool $with_domain
     * @return string
     */
    public static function build_mobile_url_by_key($key,$with_domain=false){
        if (!$with_domain){
            return "/mobile/dnf?key={$key}";
        }else{
            return 'http://'.KIRK::get_instance()->get_config('domain')."/mobile/dnf?key={$key}";
        }
    }
}