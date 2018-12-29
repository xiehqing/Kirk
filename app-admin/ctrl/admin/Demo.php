<?php
namespace Admin;

class DemoCtrl extends AbstractCtrl {
    public function run_child() {
        return $this->auto_router();
    }

    /**
     * @param $params
     * @param \AdminRequest $request
     * @return string
     */
    public function index($params,$request){
        return 'Admin\Demo';
    }
}
