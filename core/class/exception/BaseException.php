<?php
namespace Core\Exception;
use MyException;

/**
 * 异常类的基类
 * Class BaseException
 */
class BaseException extends MyException{
    public $code = 400;
    public $msg = 'invalid parameters!';
    public $errorCode = 999;

    public $shouldToClient = true;

    public function __construct($params =[]){
        if(!is_array($params)){
            return;
        }
        if(array_key_exists('code',$params)){
            $this->code = $params['code'];
        }
        if(array_key_exists('msg',$params)){
            $this->msg = $params['msg'];
        }
        if(array_key_exists('errorCode',$params)){
            $this->errorCode = $params['errorCode'];
        }
    }
}