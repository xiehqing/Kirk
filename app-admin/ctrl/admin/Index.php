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
    public function getLastSevenData($params,$request){
        $bllAdminLog = new \Bll\Kirk\AdminUserLog();
        # 获取最近七天的全部数据
        $lastSevenData = $bllAdminLog->getLastSevenLoginLogByUid($this->admin_id);
        # 生成数组：日期=》登录次数
        $countTimeStamp = [];
        foreach ($lastSevenData as $v){
            $countTimeStamp[date('Y-m-d',strtotime($v['create_time']))] +=1;
        }

        # 生成y轴，近七天的日期
        $timeStamp = [];
        foreach ($countTimeStamp as $key => $val){
            $timeStamp[] = $key;
        }

        # 生成最终的数据
        $data = [];
        foreach ($timeStamp as $key => $value){
            $data[$key]['login_time'] = $value;
            $data[$key]['count'] = $countTimeStamp[$value];
        }

        return $this->success($data);
    }


}
