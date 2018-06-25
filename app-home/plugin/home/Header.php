<?php
kirk_require_plugin('Plugin');

class Home_HeaderPlugin extends Plugin {
    public function get_content() {
        return 'Home\Header';
    }

    public static function get_css_list() {
        return array(
            'Home\Header'
        );
    }

    public static function get_js_list() {
        return array(
            'Home\Header'
        );
    }
}