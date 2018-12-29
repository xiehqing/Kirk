<?php
namespace Admin\Demo;
kirk_require_plugin('Plugin');
use Plugin;
class LeftMenuPlugin extends Plugin {
    public function get_content() {
        $data = $this->get_construct_datas();
        foreach ($data as $k=>$v){
            $this->set_data($k,$v);
        }
        return 'Admin\Demo\LeftMenu';
    }

    public static function get_css_list(){
        return array('Admin\Demo\LeftMenu');
    }

    public static function get_js_list() {
        return array(
            'Admin\Demo\LeftMenu'
        );
    }

    public static function get_plugin()
    {
        return parent::get_plugin();
    }
}
