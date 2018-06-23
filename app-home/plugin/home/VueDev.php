<?php
kirk_require_plugin('Plugin');
class Home_VueDevPlugin extends \Plugin {
    public function get_content() {
        return 'Home\VueDev';
    }

    public static function get_js_list() {
        return array(
            'Home\VueDev'
        );
    }
}