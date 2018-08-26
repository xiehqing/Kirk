<?php
/**
 * Created by PhpStorm.
 * User: kuan
 * Date: 18-8-26
 * Time: 下午5:09
 */
namespace Api\Exception;
/**
 * 通用参数类异常错误
 * Class ParameterException
 * @package Api\Exception
 */
class ParameterException extends BaseException{
    public $code = 400;
    public $errorCode = 10000;
    public $msg = "invalid parameters";
}