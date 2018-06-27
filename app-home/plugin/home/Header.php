<?php
kirk_require_plugin('Plugin');

class Home_HeaderPlugin extends Plugin {
    /**
     * 获取相关数据
     * @return string
     */
    public function get_content() {
        $request = KIRK::get_instance()->get_request();
        $user_id = $request->get_uid();
        if ($user_id){
            $bll_home_user = new \Bll\Home\User();
            $user_info = $bll_home_user->get_info_by_user_id($user_id);
            $this->set_data('user_name',$user_info['user_name']);
        }
        $is_index = $request->get_attribute('is_index');
        $this->set_data('is_index',$is_index?:'');

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