<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-22
 * Time: 上午11:37
 */

kirk_require_class('Response');
kirk_require_class('UrlBuilder');
class AdminResponse extends Response{
    public function not_found() {
        parent::not_found();
        echo '这个页面还没建好呢！';
        return false;
    }
}