<?php
namespace Core\Exception;

/**
 * 创建成功（如果不需要返回任何消息）
 * 201 创建成功，202 需要一个异步的处理才能完成请求
 * Class SuccessMessage
 * @package Core\Exception
 */
class SuccessMessage extends BaseException{
    public $code = 201;
    public $msg = 'ok';
    public $errorCode = 0;
}