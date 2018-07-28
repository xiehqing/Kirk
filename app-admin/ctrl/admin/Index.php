<?php
kirk_require_ctrl('Admin_Abstract');
class Admin_IndexCtrl extends Admin_AbstractCtrl {
    public function run_child(){
        return 'Admin\Index';
    }
}
