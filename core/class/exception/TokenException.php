<?php
namespace Core\Exception;

/**
 * token验证失败时抛出此异常
 * Class TokenException
 * @package Core\Exception
 */
class TokenException extends BaseException{
    public $code =401;
    public $msg = 'Token已经过期或无效Token';
    public $errorCode = 10001;

}