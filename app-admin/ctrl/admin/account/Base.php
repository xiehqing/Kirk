<?php
namespace Admin\Account;
use Admin\AbstractCtrl;
class BaseCtrl extends AbstractCtrl{

    public function run_child(){
        return $this->auto_router();
    }


}