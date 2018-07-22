<?php

namespace Bll\Home;
use Bll;

class Friends extends Bll {
    const STATUS_WAIT = 1;      # status为1表示待审核
    const STATUS_PASSED = 2;    # status为2表示审核通过
    const STATUS_NO_PASS = 3;   # status为3表示审核未通过

    private function get_dao() {
        $dao = new \Dao\Home\Friends();
        return $dao;
    }

    public function get_friends_link($status="",$limit){
        $fields = "title,url,abs";
        $where = array();
        if ($status){
            $where['status'] = $status;
        }
        $order = "sort";
        return $this->get_dao()->get_by_where($where,$order,$limit,$fields);
    }
}