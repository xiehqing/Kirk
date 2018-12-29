<?php
namespace Admin;
use KIRK;
class UrlHandle{
    /**
     * 跳转到404页面
     */
    public static function page_not_found(){
        KIRK::get_instance()->get_response()->not_found();
        KIRK::get_instance()->get_response()->redirect('/page-not-find');
        exit();
    }
}