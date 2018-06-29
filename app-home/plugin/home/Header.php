<?php
kirk_require_plugin('Plugin');

class Home_HeaderPlugin extends Plugin {
    /**
     * 获取相关数据
     * @return string
     */
    public function get_content() {

        $data = $this->get_construct_datas();
        $this->set_data('data', $data);

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