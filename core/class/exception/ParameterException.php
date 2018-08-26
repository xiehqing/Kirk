<?php
namespace CoreExcept;

/**
 * 通用参数类异常错误
 * Class ParameterException
 * @package Core\Exception
 */
class ParameterExceptionCtrl extends BaseExceptionCtrl{
    public $code = 400;
    public $errorCode = 10000;
    public $msg = "invalid parameters";
}