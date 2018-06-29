<?php
/**
 * A job demo for get news
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-20
 * Time: 上午10:05
 */

class Bin_Home_GetNews extends \Bin_Abstract {

    public function run($argv, $argc) {
        // 演示在脚本中两种方法获取数据库中相应的新闻数据

        // 1、直接通过sql语句的方法
//        $dao_home_news = new Dao_FromTable('kirk', 'tb_home_news', 'news_id');
//        $field = "news_title,news_site_url,news_images_url,news_abs,news_content";
//        $home_news_data = $dao_home_news->exeSQL("select $field from tb_home_news where status=1");

        // 2、通过调用bll的方法
        $bll_home_news = new \Bll\Home\News();
        $home_news_data = $bll_home_news->get_available_news();

        // 拿到新闻数据后，根据具体的业务情况再进行下一步操作，demo演示直接dump
        var_dump($home_news_data);
    }
}