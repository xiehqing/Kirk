<?php
namespace Home;
use KIRK;
class IndexCtrl extends BaseCtrl {

    /**
     * @param $params
     * @param \HomeRequest $request
     * @return string
     */
    public function index($params,$request){

        # 顶部导航栏菜单
        $bll_menu = new \Bll\Home\Menu();
//        $top['menu'] = $bll_menu->get_menu();
//
//        # 顶部banner图
//        $bll_banner = new \Bll\Home\Banner();
//        $top['banner'] = $bll_banner->get_available_banners();
//
//        # 侧边标签
//        $bll_tag = new \Bll\Home\Tag();
//        $side['tag'] = $bll_tag->get_available_tags();
//
//        # 侧边分类
//        $bll_category = new \Bll\Home\Category();
//        $side['category'] = $bll_category->get_available_categories();
//
//        # 文章
//        $bll_article = new \Bll\Home\Article();
//        $main['article'] = $bll_article->get_available_articles();
//
//        # 新闻动态
//        $bll_news = new \Bll\Home\News();
//        $main['news'] = $bll_news->get_available_news();

        $request->set_attribute("top",$top);
//        $request->set_attribute("side",$side);
//        $request->set_attribute("main",$main);


        return 'Home\Index';
    }
}
