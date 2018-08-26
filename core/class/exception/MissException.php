<?php
namespace CoreExcept;
/**
 * 404时抛出此异常
 * Class MissException
 * @package Core\Exception
 */
class MissExceptionCtrl extends BaseExceptionCtrl{
    public $code = 404;
    public $msg = 'global:your required resource are not found';
    public $errorCode = 10001;
}