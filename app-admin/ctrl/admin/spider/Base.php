<?php
namespace Admin\Spider;
use Admin\AbstractCtrl;
class BaseCtrl extends AbstractCtrl {
    public function run_child(){
        return $this->auto_router();
    }

}