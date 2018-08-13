<?php
/**
 * Created by PhpStorm.
 * User: kuan
 * Date: 2018/8/13
 * Time: 16:57
 */
namespace Api\V1;
use ActionCtrl;
use KIRK;
// 获取文章相关信息的接口
class ArticleCtrl extends ActionCtrl{

    # 访问方式：
    #   http://kirk.com/api/v1?action=article_referer
    public function referer(){
        KIRK::get_instance()->get_response()->redirect('http://kirk.com/home/api?action=article_test_referer');
        exit();
    }

    # 访问方式：
    #   http://kirk.com/api/v1?action=article_test_referer
    public function test_referer(){
        $data = [];
        $data['test'] = '测试1';
        $data['api'] = '接口';
        return $this->success($data);
    }


}