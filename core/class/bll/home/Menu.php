<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-21
 * Time: 下午3:07
 */
namespace Bll\Home;
use Bll;
class Menu extends Bll {
    const FIRST_MENU = 0;       # 顶级菜单父节点p_menu_id字段 为 0
    const STATUS_WAIT = 1;      # status为1表示待审核
    const STATUS_PASSED = 2;    # status为2表示审核通过
    const STATUS_NO_PASS = 3;   # status为3表示审核未通过

    private function get_dao(){
        $dao = new \Dao\Home\Menu();
        return $dao;
    }

    /**
     * 通过传入的$status，获取特定的顶级菜单 $status为0表示不可用的menu、为1表示header左侧、为2表示header右侧
     * @param $status
     * @param $pid
     * @param string $limit
     * @return array
     */
    public function get_first_menu_by_status($status="",$pid="",$limit){
        $where = [];
        if ($pid != ""){
            $where['p_id'] = $pid;
        }
        if ($status){
            $where['status'] = $status;
        }
        return $this->get_dao()->get_by_where($where,'sort',$limit,'id,p_id,name,url,sort,status');
    }

    /**
     * 获取通过审核的菜单menu
     * @param string $pid
     * @param $limit
     * @return array
     */
    public function get_passed_menu($pid="",$limit){
        $where = array(
            'status' => self::STATUS_PASSED,
        );
        if ($pid != ""){
            $where['p_id'] = $pid;
        }
        return $this->get_dao()->get_by_where($where,'sort',$limit,'id,p_id,name,url,sort,status');
    }

}