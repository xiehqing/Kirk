<?php
namespace core;
use KIRK;
use Overtrue\EasySms\EasySms;
class EasySmsCls {

    /**
     * 集成一套万能的短信发送服务
     * @throws \Overtrue\EasySms\Exceptions\InvalidArgumentException
     * @throws \Overtrue\EasySms\Exceptions\NoGatewayAvailableException
     */
    public function easy_sms($to,$data){
//        $data的结构
//        $data = [
//            'content' => '您的验证码为：1111',
//            'template' => 'SMS_001',
//            'data' => [
//                'code' => 1111
//            ],
//        ];
        $easySms = new EasySms(KIRK::get_instance()->get_config('easy_sms'));
        $easySms->send($to,$data);
//        demo
//        $easySms->send(13188888888, [
//            'content'  => '您的验证码为: 6379',
//            'template' => 'SMS_001',
//            'data' => [
//                'code' => 6379
//            ],
//        ]);


    }
}