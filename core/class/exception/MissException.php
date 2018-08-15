<?php
namespace Core\Exception;

/**
 * 404时抛出此异常
 * Class MissException
 * @package Core\Exception
 */
class MissException extends BaseException{
    public $code = 404;
    public $msg = 'global:your required resource are not found';
    public $errorCode = 10001;
}