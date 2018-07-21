<?php

namespace Bll\Home;
use Bll;

class Photo extends Bll {
    const STATUS_WAIT = 1;      # status为1表示待审核
    const STATUS_PASSED = 2;    # status为2表示审核通过
    const STATUS_NO_PASS = 3;   # status为3表示审核未通过

    private function get_dao() {
        $dao = new \Dao\Home\Photo();
        return $dao;
    }

    /**
     * 通过status获取数据
     * @param string $status
     * @param $limit
     * @return array
     */
    public function get_photo_info_by_status($status="",$limit){
        $fields = "id,title,path,abs,content,status";
        $where = [];
        if ($status){
            $where['status'] = $status;
        }
        $order = "sort asc";
        return $this->get_dao()->get_by_where($where,$order,$limit,$fields);
    }

    /**
     * 通过status获取数据的条数
     * @param string $status
     * @return mixed
     */
    public function get_photo_count_by_status($status=""){
        $where =array();
        if ($status){
            $where['status'] = $status;
        }
        return $this->get_dao()->get_count_by_where($where);
    }


}