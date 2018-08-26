<?php
/**
 * Created by PhpStorm.
 * User: kuan
 * Date: 18-8-26
 * Time: 下午5:05
 */
namespace Api\Exception;

/**
 * token验证失败时，抛出此异常
 * Class ForbiddenException
 * @package Api\Exception
 */
class ForbiddenException extends BaseException{
    public $code = 403;
    public $msg = '权限不够';
    public $errorCode = 10001;
}