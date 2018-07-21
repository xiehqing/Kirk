<?php
/**
 * Created by PhpStorm.
 * User: kuan
 * Date: 2018/7/21
 * Time: 14:22
 */
namespace Home;
use KIRK;
abstract class HomeBaseCtrl extends BaseCtrl{

    //    获取页面打点
    abstract public function get_page_value();

    public function get_menu_for_nav(){
        $bll_home_menu = new \Bll\Home\Menu();
        $result['menu'] = $bll_home_menu->get_passed_menu('',"0,5");
        $result['page_dot'] = $this->get_page_value();
        return $result;
    }

    public function get_notice_for_header(){
        $bll_home_notice = new \Bll\Home\Notice();
        $result['notice'] = $bll_home_notice->get_last_passed_notice();
        return $result;
    }
}