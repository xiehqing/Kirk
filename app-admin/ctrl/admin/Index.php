<?php
namespace Admin;

class IndexCtrl extends AbstractCtrl {
    public function run_child() {
        return $this->auto_router();
    }

    /**
     * @param $params
     * @param \AdminRequest $request
     * @return string
     */
    public function index($params,$request){
        # 初始化左侧菜单栏
        $this->initLeftMenu($params,$request);
        return 'Admin\Index';
    }

    function get_left_uri(){
        return '0_1';
    }

    function get_show_menu(){
        return false;
    }

    function level_promise(){
        // TODO: Implement level_promise() method.
    }

    /**
     * @param $params
     * @param \AdminRequest $request
     * @return array
     */
    public function getRandomData($params,$request){
        $bllAdminLog = new \Bll\Kirk\AdminUserLog();
        $lastSevenDays = [
            0 => date("Y-m-d",strtotime("-1 day")),
            1 => date("Y-m-d",strtotime("-2 day")),
            2 => date("Y-m-d",strtotime("-3 day")),
            3 => date("Y-m-d",strtotime("-4 day")),
            4 => date("Y-m-d",strtotime("-5 day")),
            5 => date("Y-m-d",strtotime("-6 day")),
            6 => date("Y-m-d",strtotime("-7 day")),
        ];
        $logData = $bllAdminLog->getAllLoginLogByUserID($this->admin_id);
        $data = [];
        foreach ($logData as $key => $value){
            $data[$key]['login_time'] = $logData[$key]['create_time'];
            $data[$key]['IP'] = $logData[$key]['ip'];
            $data[$key]['count'] = $this;

        }
//        $data=[
//            ['login_time'=> '2018-12-17', 'IP'=> '127.0.0.1', 'count'=> 10],
//            ['login_time'=> '2018-12-18', 'IP'=> '127.0.0.1', 'count'=> 101],
//            ['login_time'=> '2018-12-19', 'IP'=> '127.0.0.1', 'count'=> 120],
//            ['login_time'=> '2018-12-20', 'IP'=> '127.0.0.1', 'count'=> 0],
//            ['login_time'=> '2018-12-21', 'IP'=> '127.0.0.1', 'count'=> 110],
//            ['login_time'=> '2018-12-22', 'IP'=> '127.0.0.1', 'count'=> 3],
//            ['login_time'=> '2018-12-23', 'IP'=> '127.0.0.1', 'count'=> 8],
//            ['login_time'=> '2018-12-24', 'IP'=> '127.0.0.1', 'count'=> 20],
//            ['login_time'=> '2018-12-25', 'IP'=> '127.0.0.1', 'count'=> 220],
//            ['login_time'=> '2018-12-26', 'IP'=> '127.0.0.1', 'count'=> 11]
//        ];
//        $data = [
//            'email'=>[0, 132, 101, 134, 90, 230, 210],
//            'legends'=>[220, 182, 191, 234, 290, 330, 310],
//            'videos'=>[150, 232, 201, 154, 190, 330, 410],
//            'attach'=>[320, 332, 301, 334, 390, 330, 320],
//            'search'=>[820, 932, 901, 934, 1290, 1330, 1320],
//        ];
        return $this->success($data);
    }

    private function countLoginTimes(){
        $bllAdminLog = new \Bll\Kirk\AdminUser();
        $loginTimes = $bllAdminLog->countLoginTimesByUserIdWithLast7Days($this->admin_id);
    }

}
