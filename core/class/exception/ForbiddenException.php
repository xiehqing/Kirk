<?php
namespace Core\Exception;

/**
 * token验证失败事抛出此异常
 * Class ForbiddenException
 * @package exception
 */
class ForbiddenException extends BaseException{
    public $code = 403;
    public $msg = '权限不够';
    public $errorCode = 10001;
}