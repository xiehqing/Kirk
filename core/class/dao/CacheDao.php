<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-21
 * Time: 下午2:24
 */

kirk_require_class('Dao');
abstract class Dao_CacheDao extends Dao {
    public $is_cache = true;
    private $cache_time = 0;
    const CACHE_TIME_ONE_DAY = 86400;
    const CACHE_TIME_ONE_HOUR = 3600;
    const CACHE_TIME_ONE_MINIUTE = 60;
    const CACHE_TIME_ONE_WEEK = 604800;

    public function set_cache_time($cache_time){
        $this->cache_time = $cache_time;
    }

    public function disable_cache() {
        $this->is_cache = false;
    }
    public function get_pre_key() {
        return $this->get_db_name().'_'.$this->get_table_name().'_';
    }
    public function exeSQL($sql) {
        $this->set_update();
        return parent::exeSQL($sql);
    }
    public function get_count_by_where($where) {
        if(!$this->is_cache) {
            return parent::get_count_by_where($where);
        }

        $s = microtime(TRUE);
        $uncached = false;
        //首先按照键值排序
        ksort($where); //缓存更加能命中
        //找到in的情况
        foreach($where as $k=>$v) {
            $wh = explode(" ", $k);
            if($wh[1]=='in') {
                if(is_array($v)) {
                    $v = array_keys(array_flip($v));
                    $where[$k]  = $v;
                }
            }
        }
        $mem = KIRK::get_instance()->get_cache();
        //改成这样是怕出现别的表里带有_count字样
        $key = $this->get_pre_key().'_table_&*&^_count_'.md5(serialize($where));

        if($this->is_update($mem->get($key.'_save_time'))) {
            $uncached = true;
        } else {
            $num = $mem->get($key);
            if($num===false) {
                $uncached = true;
            }
        }
        if($uncached) {
            $num = parent::get_count_by_where($where);
            $mem->set($key,$num,$this->cache_time);
            $mem->set($key.'_save_time',time(),$this->cache_time);
        } else {
            KIRK::get_instance()->debug($key.'get_num from cache','from cache');
        }
        return $num;
    }

    /**
     * 为了增加缓存的命正率,第二个参数 最好不要加
     * @param $id
     * @param string $fields
     * @return array|bool
     */
    public function get_by_id($id,$fields = '*') {
        //强制
        $fields = '*';

        if(!$id) {
            return array();
        }
        if(!$this->is_cache) {
            return parent::get_by_id($id,$fields);
        }
        $mem = KIRK::get_instance()->get_cache();
        $key = $this->build_row_key($id,$fields);
        $result = $mem->get_array($key);
        KIRK::get_instance()->debug($result,'检测到,行缓存内容'.$key);



        //如果是空数组,进入判断是否有效逻辑
        if(is_array($result) && empty($result)) {

            $cache_time = $mem->get($key."_cache_time");
            KIRK::get_instance()->debug($cache_time,'行缓存时间检查');

            if (!$this->is_update($cache_time)) {
                KIRK::get_instance()->debug($cache_time, '行缓存时间大于最后表更新时间,直接取数据');
                if (is_array($result)) {
                    if (empty($result)) {
                        KIRK::get_instance()->debug('空数组直接返回false', '行缓存');
                        return false;
                    }
                    return $result;
                }
            } else {
                KIRK::get_instance()->debug("表缓存时间>行缓存,走下边的逻辑", '时间超时');
                //如果是空数据组,那么就是因为没有结果被故意设置的
                $result = false;
            }
        }

        KIRK::get_instance()->debug('判断行缓存有效性','行缓存');
        //得到的结果不是数据,说明没有,或者被清空了
        if(!is_array($result)) {

            KIRK::get_instance()->debug($cache_time,'缓存无效');

            $result = parent::get_by_id($id,$fields);
            $mem_store = $result;
            if($result===false) {
                $mem_store = array();  //这是只是为了判断,是查到就是为空,还是缓存就为空,所以才设置成这样
            }

            $mem->set_array($key,$mem_store,$this->cache_time);
            //缓存时间
            $mem->set($key."_cache_time",time(),$this->cache_time);
        } else {
            KIRK::get_instance()->debug($key,'行缓存命中啦!');
        }
        return $result;
    }
    public function build_row_key($id,$fields='*') {
        if($id!='') {
            return $this->get_pre_key().$id.$fields;
        } else {
            return $this->get_pre_key().'0'.$fields;
        }
    }

    /**
     * @desc 判断缓存的缓存事件是否超过表的最后更新时间
     * @param integer $t 缓存的缓存时间
     * @return bool
     */
    public function is_update($t) {

        KIRK::get_instance()->debug("检测表更新","缓存");
        //如果$t没有,直接判断缓存数据为空
        if(!$t) {
            return true;
        }
        $mem = KIRK::get_instance()->get_cache();
        $is_update = $mem->get($this->get_pre_key());


        KIRK::get_instance()->debug($is_update,"缓存-表时间");
        KIRK::get_instance()->debug($t,"缓存-查询时间");
        if(!$is_update) {
            //$this->set_update();
            return false;
        }

        if($t>$is_update) {
            return false;
        } else {
            return true;
        }
    }
    public function set_update() {
        $mem = KIRK::get_instance()->get_cache();
        $mem->set($this->get_pre_key(),time(),$this->cache_time);
    }
    public function get_by_where($where,$order='',$limit='0,2000',$fields = '*') {

        if(!$this->is_cache) {
            return parent::get_by_where($where,$order,$limit, $fields);
        }

        $s = microtime(TRUE);
        $uncached = false;

        //首先按照键值排序
        ksort($where); //缓存更加能命中
        //找到in的情况
        foreach($where as $k=>$v) {
            $wh = explode(" ", $k);
            if($wh[1]=='in') {
                if(is_array($v)) {
                    $v = array_keys(array_flip($v));
                    $where[$k]  = $v;
                }
            }
        }
        $mem = KIRK::get_instance()->get_cache();
        $key = $this->get_pre_key().md5(serialize($where).$order.$limit.$fields);

        if($this->is_update($mem->get($key.'_save_time'))) {
            KIRK::get_instance()->debug('更新时间小与表的更新时间 ','更新时间');
            $uncached = true;
        }


        if(!$uncached) {
            $result = $mem->get_array($key.'_data');
            if(!is_array($result)){
                $result = $mem->get_array($key.'_data');
                $ids = $mem->get_array($key);
                if(!$ids) {
                    $uncached = true;
                } else {
                    $result = array();
                    foreach($ids as $id) {
                        if(!$id) {
                            $uncached = true;
                            break;
                        }
                        $rowkey = $this->build_row_key($id,$fields);
                        $row = $mem->get_array($rowkey);
                        if(!is_array($row)) {
                            $uncached = true;
                            break;
                        }else {
                            $result[] = $row;
                        }
                    }
                }
            } else {
                KIRK::get_instance()->debug('get direct result ','from Cache');
            }
        }
        if($uncached) {
            $result = parent::get_by_where($where,$order,$limit,$fields);
            $primary_keys = array();
            foreach($result as $row) {
                $primary_keys[] = $row[$this->get_pk_id()];
                $row_key = $this->build_row_key($row[$this->get_pk_id()],$fields);
                $mem->set_array($row_key,$row,$this->cache_time);
            }
            $mem->set_array($key,$primary_keys,$this->cache_time);
            $mem->set($key.'_save_time',time(),$this->cache_time);
            $mem->set_array($key.'_data',$result,$this->cache_time);
        } else {
            KIRK::get_instance()->debug($key.'  time taked:'.(microtime(true)-$s),'from cache');
        }
        return $result;
    }


    public function get_single_by_where($where,$order='',$fields = '*') {
        $result = $this->get_by_where($where,$order,1,$fields);
        return $result[0];
    }

    /**
     * @param $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return mixed
     * @deprecated
     */
    public function get_one_by_where($where,$order='',$limit='1',$fields = '*') {
        $result = $this->get_by_where($where,$order,$limit,$fields);
        return $result[0];
    }

    public function get_by_ids($ids,$order='',$fields='*') {
        $mem = KIRK::get_instance()->get_cache();
        $cached_available  = true;

        if(!$this->is_cache) {
            return parent::get_by_ids($ids,$order,$fields);
        }


        $key = $this->get_pre_key().md5(serialize($ids).$order.$fields.'_get_ids');

        if($this->is_update($mem->get($key.'_save_time'))) {
            if($order) { //不缓存了
                $cached_available = false;
            } else {
                $result = array();
                foreach($ids as $id) {
                    $rowkey = $this->build_row_key($id,$fields);
                    $row = $mem->get_array($rowkey);
                    if(!is_array($row)) {
                        $cached_available = FALSE;
                        break;
                    } else {
                        $result[] = $row;
                        KIRK::get_instance()->debug($rowkey,'get_by_ids_row_cache');
                    }
                }

                if($cached_available) {
                    $mem->set($key.'_save_time',time(),$this->cache_time);
                    $mem->set_array($key.'_data',$result,$this->cache_time);
                }
            }

        } else {
            $result = $mem->get_array($key.'_data');

            if(!$result) {
                if($order) { //不缓存了
                    $cached_available = false;
                } else {
                    $result = array();
                    foreach($ids as $id) {
                        $rowkey = $this->build_row_key($id,$fields);
                        $row = $mem->get_array($rowkey);
                        if(!is_array($row)) {
                            $cached_available = FALSE;
                            break;
                        } else {
                            $result[] = $row;
                            KIRK::get_instance()->debug($rowkey,'get_by_ids_row_cache');
                        }
                    }
                }
            } else {
                KIRK::get_instance()->debug($key,'get_by_ids_direct_cache');
            }
        }

        if(!$cached_available) {
            $result =  parent::get_by_ids($ids,$order,$fields);
            foreach($result as $row) {
                $mem->set_array($this->build_row_key($row[$this->get_pre_key()],$fields),$row,$this->cache_time);
            }
            $mem->set($key.'_save_time',time(),$this->cache_time);
            $mem->set_array($key.'_data',$result,$this->cache_time);
        } else {
            KIRK::get_instance()->debug($key,'from cache get ids');
        }
        return $result;
    }


    public function update_by_id($id,$data) {
        //清缓存
        $this->clear_row_cache($id);
        return parent::update_by_id($id,$data);
    }
    public function clear_row_cache($id) {
        $this->set_update();
        $mem = KIRK::get_instance()->get_cache();
        $key = $this->build_row_key($id);
        KIRK::get_instance()->debug($key,'删除rowkey');
        $mem->delete($key);
    }

    public function update_by_where($where,$data,$time_no_delay = false) {

        //可能出现延迟的问题,更新必须走master
        if($time_no_delay) {
            $tmp = $this->force_master;
            $this->force_master = true;
            $result = parent::get_by_where($where);
            $this->force_master = $tmp;
        } else {
            $result = $this->get_by_where($where);
        }
        foreach($result as $k=>$v) {
            $this->update_by_id($v[$this->get_pk_id()], $data);
        }
        $this->set_update();
    }

    public function insert($data) {
        $this->set_update();
        return parent::insert($data);
    }

    public function del_by_id($id) {
        $this->clear_row_cache($id);
        return parent::del_by_id($id);
    }

    public function del_by_where($where) {
        $result = $this->get_by_where($where);
        foreach($result as $k=>$v) {
            $this->del_by_id($v[$this->get_pk_id()]);
        }
        return true;
    }

}
