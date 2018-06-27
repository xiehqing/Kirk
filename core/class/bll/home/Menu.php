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
    const FIRST_MENU = 0;           # 顶级菜单父节点p_menu_id字段 为 0
    const UNAVAILABLE = 0;          # 不可用的菜单 status 为 0
    const HEADER_MENU_LEFT = 1;     # 顶部左边菜单栏 status 为 1
    const HEADER_MENU_RIGHT = 2;    # 顶部右边菜单栏 status 为 2

    private function get_dao(){
        $dao = new \Dao\Home\Menu();
        return $dao;
    }

    /**
     * 通过传入的$status，获取特定的菜单
     * @param int $status   为0表示不可用的menu、为1表示header左侧、为2表示header右侧
     * @param string $limit
     * @return array
     */
    public function get_menu_by_status($status=1,$limit){
            $where = array(
                'status' => $status,
            );
        return $this->get_dao()->get_by_where($where,'list_order',$limit,'menu_id,p_menu_id,menu_name,menu_url');
    }

    /**
     * 通过传入的$pid，获取特定的菜单
     * @param int $pid      为0表示无父级菜单，即顶级menu ，传入相应的pid即查找该pid的子菜单
     * @return array
     */
    public function get_menu_by_pid($pid){
        $where = array(
            'p_menu_id' => $pid,
        );
        return $this->get_dao()->get_by_where($where,'list_order','','menu_id,p_menu_id,menu_name,menu_url');
    }

    /**
     * 通过传入的$status，获取特定的顶级菜单
     * @param int $status   为0表示不可用的menu、为1表示header左侧、为2表示header右侧
     * @param string $limit
     * @return array
     */
    public function get_first_menu_by_status($status=1,$limit){
        $where = array(
            'status' => $status,
            'p_menu_id' => self::FIRST_MENU,
        );
        return $this->get_dao()->get_by_where($where,'list_order',$limit,'menu_id,p_menu_id,menu_name,menu_url');
    }

}