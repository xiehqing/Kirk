<?php

kirk_require_plugin('Plugin');

class Home_VuePlugin extends \Plugin {

    public function get_content() {
        return 'Home\Vue';
    }

    public static function get_js_list() {
        return array(
            'Home\Vue'
        );
    }
}