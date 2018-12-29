<?php
namespace Api\Dnf;
use KIRK;
use Api\BaseCommonCtrl;
/**
 * DNF的基础接口类
 * 先判定接口是否存在，再校验签名，继承该类的其他类只需要校验业务逻辑即可
 * Class BaseCtrl
 * @package Api\Dnf
 */
class BaseCtrl extends BaseCommonCtrl{

    # DNF 接口的安全密钥
    const KEY = '1!d@n#f$!d@n#f$0';       // 接口测试环境的key
    //const KEY = '2*d&n^f%d$n#f@20';     // 接口线上环境的key

    public function run(){
        $response = KIRK::get_instance()->get_response();
        $response->header("Content-Type","application/json; charset=utf-8");
        $request = KIRK::get_instance()->get_request();
        $params = $request->get_params();
        $action = $params['action'];
        $timestamp = $params['timestamp'];
        $sign = $params['sign'];
        unset($params['sign']);

        // 校验接口是否存在
        if (!method_exists($this, $action)){
            $result = [
                'status' =>1,
                'message' => '接口不存在'
            ];
            echo json_encode($result);
            return false;
        }

        // 校验过期时间 时间戳误差在正负5分钟内
        $now_time = time();
        $before = strtotime($now_time,'-5 minute');
        $later = strtotime($now_time,'+5 minute');
        if (!($before<=$timestamp && $later>= $timestamp)){
            return $this->error(1,'时间失效');
        }

        // 校验签名
        ksort($params);
        $params_str = '';
        foreach($params as $key=>$value){
            $params_str .= $key.'='.$value.'&';
        }
        $params_str = substr($params_str,0,-1);
        # 将key拼接到首部和尾部，md5之后再转换为大写
        $sing_str = strtoupper(md5(self::KEY.$params_str.self::KEY));
        if($sing_str!=$sign){
            $result = [
                'status'=>2,
                'message'=>'签名校验失败'
            ];
            echo json_encode($result);
            return false;
        }

        return parent::run();
    }

}