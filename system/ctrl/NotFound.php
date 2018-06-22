<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-22
 * Time: 下午4:45
 */

kirk_require_ctrl("Ctrl");
class NotFoundCtrl extends Ctrl {
    public function run() {
        return KIRK::get_instance()->response->not_found();
    }
}