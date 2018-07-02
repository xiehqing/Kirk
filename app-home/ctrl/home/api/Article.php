<?php
/**
 * Created by PhpStorm.
 * User: kuan
 * Date: 2018/7/2
 * Time: 09:24
 */
namespace Home\Api;
use ActionCtrl;
use KIRK;

// 获取文章相关信息的接口
class ArticleCtrl extends ActionCtrl{

    # 访问方式：
    #   http://kirk.com/home/api?action=article_referer
    public function referer(){
        KIRK::get_instance()->get_response()->redirect('http://kirk.com/home/api?action=article_test_referer');
        exit();
    }

    # 访问方式：
    #   http://kirk.com/home/api?action=article_test_referer
    public function test_referer(){
        print_r($_SERVER);
        exit();
    }


}