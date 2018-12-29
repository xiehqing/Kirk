<?php
namespace Admin\Spider;
class AnalysisCtrl extends BaseCtrl {
    public function run_child(){
        return $this->auto_router();
    }

    function get_left_uri(){
        return '1_2';
    }
    function get_show_menu(){
        return 'spider';
    }
    function level_promise(){
        // TODO: Implement level_promise() method.
    }

    /**
     * @param $params
     * @param $request
     * @return string
     */
    public function index($params,$request){
        # 初始化左侧菜单栏
        $this->initLeftMenu($params,$request);
        return 'Admin\Spider\Analysis';
    }

    /**
     * @param $params
     * @param \AdminRequest $request
     * @return array
     */
    public function getRandomData($params,$request){
        $data = [
            'email'=>[0, 132, 101, 134, 90, 230, 210],
            'legends'=>[220, 182, 191, 234, 290, 330, 310],
            'videos'=>[150, 232, 201, 154, 190, 330, 410],
            'attach'=>[320, 332, 301, 334, 390, 330, 320],
            'search'=>[820, 932, 901, 934, 1290, 1330, 1320],
        ];
        return $this->success($data);
    }
}
