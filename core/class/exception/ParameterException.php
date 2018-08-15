<?php
namespace Core\Exception;

/**
 * 通用参数类异常错误
 * Class ParameterException
 * @package Core\Exception
 */
class ParameterException extends BaseException{
    public $code = 400;
    public $errorCode = 10000;
    public $msg = "invalid parameters";
}