<?php
namespace Dao;

/**
 * 用来解决表里数据过少,但是又要持续缓存过多的问题
 * 切记切记只能用来放小表,建议数据不超过5000
 * Class MiniTableCacheDao
 * @package Dao
 * @deprecated 你确定是个小表吗?确定继续用,不确定不要用
 */
abstract class MiniTableCacheDao extends \Dao_CacheDao {

    public $total_data;
    public $map = [];
    /**
     * 关键词key,
     * @return string
     */
    abstract public function get_main_search_key();
    /**
     * 有效性查询
     * @return array
     */
    abstract public function get_available_condition();

    public function __construct() {
        parent::__construct();
        //获取全部数据
        $this->total_data = parent::get_by_where($this->get_available_condition(),'','',$this->get_main_search_key());
        foreach($this->total_data as $v) {
            $this->map[$v[$this->get_main_search_key()]] = 1;
        }

    }
    public function get_by_where($where,$order='',$limit='0,2000',$fileds = '*'){
        if($key_value = $where[$this->get_main_search_key()]) {
            \KIRK::get_instance()->debug('命中查询key','minitablecache');
            if($this->map[$key_value]) {
                return parent::get_by_where($where,$order,$limit,$fileds);
            } else {
                \KIRK::get_instance()->debug('不可能有内容','minitablecache');
                return [];
            }
        } else {
            return parent::get_by_where($where,$order,$limit,$fileds);
        }
    }
    public function get_single_by_where($where, $order = '', $fields = '*') {
        if($key_value = $where[$this->get_main_search_key()]) {
            \KIRK::get_instance()->debug('命中查询key','minitablecache');
            if($this->map[$key_value]) {
                return parent::get_single_by_where($where, $order, $fields);
            } else {
                \KIRK::get_instance()->debug('不可能有内容','minitablecache');
                return false;
            }
        } else {
            return parent::get_single_by_where($where, $order, $fields);
        }
    }

}
