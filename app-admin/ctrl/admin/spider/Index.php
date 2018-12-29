<?php
namespace Admin\Spider;
class IndexCtrl extends BaseCtrl {
    public function run_child(){
        return $this->auto_router();
    }
    function get_left_uri(){
        return '1_1';
    }
    function get_show_menu(){
        return 'spider';
    }
    function level_promise(){
        // TODO: Implement level_promise() method.
    }

    /**
     * @param $params
     * @param \AdminRequest $request
     * @return string
     */
    public function index($params,$request){
        # 初始化左侧菜单栏
        $this->initLeftMenu($params,$request);
        return 'Admin\Spider\Index';
    }
}
