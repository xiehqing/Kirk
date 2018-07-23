<?php
namespace Home;
use KIRK;
class IndexCtrl extends HomeBaseCtrl {
    const PAGE_MUM = 8;
    /**
     * @param $params
     * @param \HomeRequest $request
     * @return string
     */
    public function index($params,$request) {

        $page = $params['page']?$params['page']:1;
        $limit = (($page-1)*self::PAGE_MUM).','.self::PAGE_MUM;

        $nav_data = $this->get_menu_for_nav();
        $header_data = $this->get_notice_for_header();
        $footer_data = $this->get_friends_link_for_footer();
        $bll_photo = new \Bll\Home\Photo();
        $photo_info = $bll_photo->get_photo_info_by_status(\Bll\Home\Photo::STATUS_PASSED,$limit);
        $photo_count = $bll_photo->get_photo_count_by_status(\Bll\Home\Photo::STATUS_PASSED);

        # page_create
        $page_create = new \PageCreater();
        $page_create->set_baseurl('/');
        $page_create->set_page($page);
        $page_create->set_page_num(self::PAGE_MUM);
        $page_create->set_total_num($photo_count);
        $pages = $page_create->get_pages();

        $request->set_attribute("photo_info",$photo_info);
        $request->set_attribute("pages",$pages);
        $request->set_attribute("nav_data",$nav_data);
        $request->set_attribute("header_data",$header_data);
        $request->set_attribute("footer_data",$footer_data);

        return 'Home\Index';
    }

    public function get_page_value(){
        return "Home";
    }
}
