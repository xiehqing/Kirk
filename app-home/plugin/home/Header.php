<?php
kirk_require_plugin('Plugin');

class Home_HeaderPlugin extends Plugin {
    /**
     * 获取相关数据
     * @return string
     */
    public function get_content() {
//        $request = KIRK::get_instance()->get_request();
//
//        $is_index = $request->get_attribute('is_index');
//        $this->set_data('is_index',$is_index?:'');
//        // 获取顶部左侧菜单栏
//        $left_menu_data = $this->get_menu_data(\Bll\Home\Menu::HEADER_MENU_LEFT,$limit='0,5');
//        $this->set_data('left_menu_data',$left_menu_data);
//        // 获取顶部右侧菜单栏按钮
//        $right_menu_data = $this->get_menu_data(\Bll\Home\Menu::HEADER_MENU_RIGHT,$limit="0,3");
//        $this->set_data('right_menu_data',$right_menu_data);
        $data = $this->get_construct_datas();
//        foreach($data as $k=>$v) {
//            $
//            $this->set_data($k, $v);
//        }
        $this->set_data('data', $data);
//        var_dump($data);
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
}