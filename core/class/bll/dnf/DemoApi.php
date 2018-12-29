<?php
namespace Bll\Dnf;
use Bll;
use KIRK;
class DemoApi extends Bll{
    const APP_TAG = '!J@c#r$0';                    // appTag参数的值
    const KEY = '1!d@n#f$!d@n#f$0';       // 接口测试环境的key
    //const KEY = '2*d&n^f%d$n#f@20';     // 接口线上环境的key

    /**
     * @param array $params 是一个数组，类似['status'=>'','message'=>'']
     * @param string $api_name (接口名)
     * @return mixed
     */
    public function build_params($params,$api_name){
        $params['timestamp'] =  time();
        $params['appTag'] = self::APP_TAG;
        $params['sequenceNumber'] = $this->build_sequenceNumber($api_name);

        //拼接签名
        ksort($params);
        $params_str = '';
        // value需要经过urlencode后再进行拼接
        foreach ($params as $key => $value){
            $params_str .= $key.'='.urlencode($value).'&';
        }
        $params_str = substr($params_str,0,-1);
        $sign = strtoupper(md5(self::KEY.$params_str.self::KEY));

        $params['sign'] = $sign;
        return $params;
    }

    /**
     * 生成sequenceNumber的方法
     *     sequenceNumber 序列号，由调用方生成，长度不超过32，需保证5分钟内不重复
     *     redis 里面记录一个数字,作为 sequenceNumber 的值
     * @param $api_name
     * @return string
     */
    public function build_sequenceNumber($api_name){
        $redis = KIRK::get_instance()->get_redis();
        # 因为只要5分钟内不重复，可以调用time方法的后5位
        $now_time = time();
        $falg = substr($now_time,-5,5);
        $sequenceNumber = $api_name."_".$falg;
        $redis->incr($sequenceNumber);
        return $sequenceNumber;
    }
}