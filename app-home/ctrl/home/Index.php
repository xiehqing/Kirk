<?php
namespace Home;
use KIRK;
class IndexCtrl extends BaseCtrl {
    const PAGE_MUM = 8;
    /**
     * @param $params
     * @param \HomeRequest $request
     * @return string
     */
    public function index($params,$request) {

        $page = $params['page']?$params['page']:1;
        $limit = (($page-1)*self::PAGE_MUM).','.self::PAGE_MUM;
        $bll_photo = new \Bll\Home\Photo();
        $photo_info = $bll_photo->get_photo_info_by_ststus($ststus,$limit);
        $photo_count = $bll_photo->get_photo_count_by_status($ststus);

        # page_create
        $page_creater = new \PageCreater();
        $page_creater->set_baseurl('/');
        $page_creater->set_page($page);
        $page_creater->set_page_num(self::PAGE_MUM);
        $page_creater->set_total_num($count);

        $request->set_attribute("top",$top);
        $request->set_attribute("side",$side);
        $request->set_attribute("main",$main);

        return 'Home\Index';
    }
}
