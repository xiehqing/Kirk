<?php

namespace Bll\Home;
use Bll;

class Notice extends Bll {
    const STATUS_WAIT = 1;      # status为1表示待审核
    const STATUS_PASSED = 2;    # status为2表示审核通过
    const STATUS_NO_PASS = 3;   # status为3表示审核未通过

    private function get_dao() {
        $dao = new \Dao\Home\Notice();
        return $dao;
    }

    public function get_last_passed_notice(){
        $fields = "id,title,url,abs,content,status";
        $where = array(
            'status' => self::STATUS_PASSED,
        );
        $order = "last_update_time";
        return $this->get_dao()->get_single_by_where($where,$order,$fields);
    }
}