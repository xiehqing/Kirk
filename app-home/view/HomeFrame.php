<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-11
 * Time: 下午4:10
 */

kirk_require_view("View");
kirk_require_plugin('Home_Footer');
kirk_require_plugin('Home_Header');
kirk_require_plugin('Home_Nav');
kirk_require_plugin('Home\VueDev');
kirk_require_class('UrlBuilder');
kirk_require_class('Home_UrlBuilder');

abstract class HomeFrameView extends View {

    public function get_container() {
        $request = KIRK::get_instance()->get_request();

        $is_index = $request->get_attribute('is_index');
        $this->set_data('is_index',$is_index?:'');
        // 获取顶部左侧菜单栏
        $menu_data["left"] = $this->get_menu_data(\Bll\Home\Menu::HEADER_MENU_LEFT,$limit='0,5');

        // 获取顶部右侧菜单栏按钮
        $menu_data["right"] = $this->get_menu_data(\Bll\Home\Menu::HEADER_MENU_RIGHT,$limit="0,3");

        $this->set_data('menu_data',$menu_data);

        return 'HomeFrame';
    }

    public static function get_css_list() {
        return array(
            'HomeFrame',
        );
    }

    public static function get_static_css_list(){
        return array_merge(
            parent::get_static_css_list(), array(
            'css/bootstrap.min.css',
            'css/bootstrap-theme.min.css',
        ));
    }

    public static function get_js_list() {
        return array_merge(
            parent::get_js_list(), array(
            'HomeFrame',
            'Util',
            'Options',
        ));
    }

    public static function get_static_js_list() {
        return array_merge(
            parent::get_static_js_list(), array(
                'js/jquery-3.3.1.min.js',
                'js/bootstrap.min.js',
        ));
    }

    public static function get_plugin() {
        return array(
            'Home_Footer',
            'Home_Header'
        );
    }

    public function get_main_section() {
        return "index";
    }


    /**
     * 获取两层结构的Menu
     * @param int $side 表示status的值（0不可用，1左侧，2右侧）
     * @param string $limit 获取的条数"0,100"
     * @return array
     */
    public function get_menu_data($side,$limit){
        $bll_home_menu = new \Bll\Home\Menu();
        $first_menu = $bll_home_menu->get_first_menu_by_status($side,$limit);
        $result = [];
        foreach($first_menu as $key => $value){
            $result[$key]["have_child"] = false; // 初始化是否有子节点（默认为无）
            $result[$key]["menu_name"] = $value["menu_name"];
            $result[$key]["menu_url"] = $value["menu_url"];
            $check_have_child = $bll_home_menu->get_menu_by_pid($value["menu_id"]);
            if ($check_have_child){
                $result[$key]["have_child"] = true;
                foreach($check_have_child as $child_key => $child_value){
                    $result[$key]["child_menu"][$child_key]["menu_name"] = $child_value["menu_name"];
                    $result[$key]["child_menu"][$child_key]["menu_url"] = $child_value["menu_url"];
                }
            }
        }
        return $result;
    }

}