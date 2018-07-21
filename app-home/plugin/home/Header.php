<?php
kirk_require_plugin('Plugin');

class Home_HeaderPlugin extends Plugin {

    public function get_content() {
        $data = KIRK::get_instance()->get_request()->get_attributes();
        foreach($data as $k=>$v) {
            $this->set_data($k, $v);
        }
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