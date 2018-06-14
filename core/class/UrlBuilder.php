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

    }
}