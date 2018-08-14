<?php
/**
 * Created by PhpStorm.
 * User: kuan
 * Date: 2018/8/13
 * Time: 19:55
 */
namespace Api;

/**
 * 接口路由类
 * Class ApiRouterCtrl
 * @package Api
 */
class ApiRouterCtrl {

    /**
     * 定义几种请求方式
     * 只要$_SERVER['REQUEST_METHOD']在这之外的
     * 都不考虑，直接return false
     */
    const API_METHOD = [
        'POST' =>'', 'GET' =>'', 'PUT' =>'', 'PATCH' =>'', 'DELETE' =>'',
        'COPY' =>'', 'HEAD' =>'', 'OPTIONS' =>'', 'LINK' =>'', 'UNLINK' =>'',
        'PURGE' =>'', 'LOCK' =>'', 'UNLOCK' =>'', 'PROPFIND' =>'', 'VIEW' => ''
    ];

    /**
     * 校验请求方式
     * 后期完善为统一路由校验
     * @param String $get   必填参数 数据请求的方式
     * @param String $need  可选参数 该参数存在就会校验请求方式是否符合
     * @return bool
     */
    public static function checkMethod($get,$need=''){
        // 先判断是否在协议中
        if (array_key_exists($get, self::API_METHOD)){
            // 如果要求了提交方式，则判断提交方式
            if ($need){
                if ($get == $need){
                    return true;
                }else{
                    return false;
                }
            }else{ //不要求请求方式就直接返回true
                return true;
            }
        }else{ // 不在协议中的直接返回false
            return false;
        }
    }
}