<?php
namespace Admin\Demo;
kirk_require_plugin('Plugin');
use Plugin;
class TopHeaderPlugin extends Plugin{
    public function get_content() {
        $data = $this->get_construct_datas();
        foreach ($data as $k=>$v){
            $this->set_data($k,$v);
        }
        return 'Admin\Demo\TopHeader';
    }

    public static function get_css_list()
    {
        return array(
            'Admin\Demo\TopHeader'
        );
    }

    public static function get_js_list() {
        return array(
            'Admin\Demo\TopHeader'
        );
    }
}