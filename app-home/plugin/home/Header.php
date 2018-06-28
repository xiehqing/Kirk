<?php
kirk_require_plugin('Plugin');

class Home_HeaderPlugin extends Plugin {
    /**
     * 获取相关数据
     * @return string
     */
    public function get_content() {
        $request = KIRK::get_instance()->get_request();

        $is_index = $request->get_attribute('is_index');
        $this->set_data('is_index',$is_index?:'');
        // 获取顶部左侧菜单栏
        $left_menu_data = $this->get_menu_data(\Bll\Home\Menu::HEADER_MENU_LEFT,$limit='0,5');
        $this->set_data('left_menu_data',$left_menu_data);
        // 获取顶部右侧菜单栏按钮
        $right_menu_data = $this->get_menu_data(\Bll\Home\Menu::HEADER_MENU_RIGHT,$limit="0,3");
        $this->set_data('right_menu_data',$right_menu_data);

        return 'Home\Header';
    }

    /**
     * 获取Header.css
     * @return array
     */
    public static function get_css_list() {
        return array(
            'Home\Header'
        );
    }

    /**
     * 获取Header.js
     * @return array
     */
    public static function get_js_list() {
        return array(
            'Home\Header'
        );
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