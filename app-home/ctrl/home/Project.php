<?php
namespace Home;

class ProjectCtrl extends HomeBaseCtrl {

    /**
     * @param $params
     * @param \HomeRequest $request
     * @return string
     */
    public function index($params,$request){

        $nav_data = $this->get_menu_for_nav();
        $header_data = $this->get_notice_for_header();
        $footer_data = $this->get_friends_link_for_footer();


        $request->set_attribute("nav_data",$nav_data);
        $request->set_attribute("header_data",$header_data);
        $request->set_attribute("footer_data",$footer_data);

        return 'Home\Project';
    }
    public function get_page_value(){
        return "Project";
    }
}
