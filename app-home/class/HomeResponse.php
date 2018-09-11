<?php
/**
 * Created by PhpStorm.
 * User: kuan
 * Date: 18-9-10
 * Time: 下午2:59
 */

class HomeResponse extends WebResponse {
    public function not_found() {
        parent::not_found();
        echo '这个页面还没建好呢！';
        return false;
    }
}