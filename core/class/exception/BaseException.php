<?php
namespace CoreExcept;
use MyException;
//kirk_require_class('MyException');

/**
 * 异常类的基类
 * 封装了该类之后，以后的异常情况可以直接归纳在该类下面，作为子类进行处理
 * Class BaseException
 */
class BaseExceptionCtrl extends MyException{
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