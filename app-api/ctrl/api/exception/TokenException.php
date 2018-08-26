<?php
/**
 * Created by PhpStorm.
 * User: kuan
 * Date: 18-8-26
 * Time: 下午5:13
 */
namespace Api\Exception;
/**
 * Token验证失败时抛出此异常
 * Class TokenException
 * @package Api\Exception
 */
class TokenExceptionCtrl extends BaseExceptionCtrl{
    public $code =401;
    public $msg = 'Token已经过期或无效';
    public $errorCode = 10001;
}