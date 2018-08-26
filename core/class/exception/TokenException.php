<?php
namespace CoreExcept;
/**
 * token验证失败时抛出此异常
 * Class TokenException
 * @package Core\Exception
 */
class TokenExceptionCtrl extends BaseExceptionCtrl{
    public $code =401;
    public $msg = 'Token已经过期或无效';
    public $errorCode = 10001;

}