<?php
/**
 * Created by PhpStorm.
 * User: kuan
 * Date: 18-8-26
 * Time: 下午5:08
 */
namespace Api\Exception;
/**
 * 404时抛出此异常
 * Class MissException
 * @package Api\Exception
 */
class MissException extends BaseException{
    public $code = 404;
    public $msg = 'global:your required resource are not found';
    public $errorCode = 10001;
}