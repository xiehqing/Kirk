<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-5-22
 * Time: 下午7:12
 */
/**
 * p方法，输出对应的变量或者数组
 * @param $var
 */
function p($var){
    if (is_bool($var)) {
        var_dump($var);
    } elseif (is_null($var)) {
        var_dump(NULL);
    } else {
        echo "<pre style='position:relative;z-index:1000;padding:10px;border-radius:5px;background:#F5F5F5;border:1px solid #aaa;font-size:14px;line-height:18px;opacity:0.9;'>". print_r($var,true) . "</pre>";
    }
}


?>