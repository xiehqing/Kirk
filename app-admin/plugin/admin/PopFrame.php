<?php
namespace Admin;
kirk_require_plugin('Plugin');
use Plugin;
class PopFramePlugin extends Plugin {

    public function get_content() {
        return 'Admin\PopFrame';
    }

    public static function get_css_list(){
        return array('Admin\PopFrame');
    }

    public static function get_js_list() {
        return array(
            'Admin\PopFrame'
        );
    }

    public static function get_plugin()
    {
        return parent::get_plugin();
    }
}
