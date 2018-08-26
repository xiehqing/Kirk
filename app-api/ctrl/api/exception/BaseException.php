<?php
/**
 * Created by PhpStorm.
 * User: kuan
 * Date: 18-8-26
 * Time: 下午4:55
 */
namespace Api\Exception;
use MyException;

/**
 * 异常类的基类
 * Class BaseException
 * @package Api\Exception
 */
class BaseExceptionCtrl extends MyException{
    public $code = 400;
    public $msg = 'invalid parameters!';
    public $errorCode = 999;

    public $shouldToClient = true;

    public function __construct($params = []){
        if (!is_array($params)){
            return ;
        }
        if (array_key_exists('code',$params['code'])){
            $this->code = $params['code'];
        }
        if (array_key_exists('msg',$params['msg'])){
            $this->msg = $params['msg'];
        }
        if (array_key_exists('errorCode', $params['errorCode'])){
            $this->errorCode = $params['errorCode'];
        }

    }
}