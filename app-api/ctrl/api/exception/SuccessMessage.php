<?php
/**
 * Created by PhpStorm.
 * User: kuan
 * Date: 18-8-26
 * Time: 下午5:11
 */
namespace Api\Exception;
/**
 * 创建成功（如果不需要返回任何消息）
 * 201 创建成功，202 需要一个异步的处理才能完成请求
 * Class SuccessMessage
 * @package Api\Exception
 */
class SuccessMessage extends BaseException{
    public $code = 201;
    public $msg = 'success!';
    public $errorCode = 0;
}