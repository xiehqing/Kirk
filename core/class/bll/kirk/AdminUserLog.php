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
     * 统计最近七天每天的登录次数
     * @param $day
     * @param $user_id
     * @param $action_type
     * @return mixed
     */
    public function count_data_for_admin($day,$user_id,$action_type){
        if ($day>1){
            $dateFrom = date("Y-m-d",strtotime("-{$day} day"));
            $dateTo = date('Y-m-d',strtotime("-{$day} day"));
            $where['create_time >='] = $dateFrom;
            $where['create_time <='] = $dateTo;
        }


        if ($digest){
            $where['company_name_digest'] = $digest;
        }
        if ($status){
            $where['status'] = $status;
        }
        return $this->get_dao()->get_count_by_where($where);
    }
}