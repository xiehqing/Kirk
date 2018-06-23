<?php
//kirk_require_plugin('Plugin');
namespace Home;
class VueDevPlugin extends \Plugin {
    public function get_content() {
        return 'Home\VueDev';
    }

    public static function get_js_list() {
        return array(
            'Home\VueDev'
        );
    }
}