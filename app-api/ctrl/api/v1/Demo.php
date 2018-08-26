<?php
/**
 * Created by PhpStorm.
 * User: kuan
 * Date: 2018/8/13
 * Time: 16:57
 */
namespace Api\V1;
use Api\Exception\TokenExceptionCtrl;
use KIRK;
use Api\ApiBaseCtrl;
use Api\ApiRouterCtrl as ApiRoute;
use Api\Exception\TokenExceptionCtrl as TokenException;
//use CoreExcept\TokenExceptionCtrl as TokenException;
/**
 * 获取Demo相关信息的接口
 * Class DemoCtrl
 * @package Api\V1
 */
class DemoCtrl extends ApiBaseCtrl {

    public function get_api_config(){}

    const MUST_METHOD_GET = 'GET';
    const MUST_METHOD_POST = 'POST';

    /**
     * 获取demo的接口配置
     * @return mixed
     */
    public function getDemoApiConfig(){
        return KIRK::get_instance()->get_config('demo_api');
    }

    /**
     * 测试接口
     * @url /v1/demo?action=referer
     * @return array
     * @throws TokenException
     */
    public function referer(){
//        $test = new TokenException(['msg' => 'ceshierror!']);
//
//        var_dump($test);
//        die;
        if (ApiRoute::checkMethod($_SERVER['REQUEST_METHOD'],self::MUST_METHOD_GET)) {
            $data = [];
            $data['test'] = '测试1';
            $data['api'] = '接口';
            return $this->success($data);
        }else{
            throw new TokenException([
                'msg' => '测试异常！',
            ]);
        }
    }

    /**
     * 测试接口
     * @url /v1/demo?action=demo_testReferer
     * @return array
     */
    public function testReferer(){
        if (ApiRoute::checkMethod($_SERVER['REQUEST_METHOD'])){
            $data = [];
            $data['test'] = '测试';
            $data['api'] = 'test_referer';
            return $this->success($data);
        }else{
            return $this->error(1,'something error!');
        }
    }


}