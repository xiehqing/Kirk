<?php
namespace Bll\Kirk;
use Bll;
use KIRK;
class AdminUserLog extends Bll {

    # 状态 status 字段
    const STATUS_USEFUL = 1;        # 有效状态
    const STATUS_NOT_USEFUL = 2;    # 无效状态

    # 操作类型 action_type 字段
    const TYPE_LOGIN = 1;           # 登录类型

    private function get_dao() {
        $dao = new \Dao\Kirk\AdminUserLog();
        return $dao;
    }

    /**
     * 添加日志信息
     * @param $user_id
     * @param $action
     * @param $action_type
     * @return bool
     */
    public function addLogs($user_id,$action,$action_type){
        $data = [
            'user_id' => $user_id,
            'action' => $action,
            'action_type' =>$action_type,
            'ip' => KIRK::get_instance()->get_request()->get_client_ip(),
            'status' => self::STATUS_USEFUL,
            'create_time' => date('Y-m-d H:i:s',time())
        ];
        return $this->get_dao()->insert($data);
    }

    public function getAllLoginLogByUserID($user_id){
        $where = [
            'user_id' => $user_id,
            'action_type' => self::TYPE_LOGIN
        ];
        return $this->get_dao()->get_by_where($where);
    }

    /**
     * 获取最近七天的数据
     * @param $user_id
     * @return array
     */
    public function getLastSevenLoginLogByUid($user_id){
        $where = [
            'user_id' => $user_id,
            'action_type' => self::TYPE_LOGIN,
            'status' => self::STATUS_USEFUL,
            'create_time >=' => date("Y-m-d",strtotime("-7 day"))
        ];
        return $this->get_dao()->get_by_where($where);
    }

}