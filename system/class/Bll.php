<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-21
 * Time: 下午3:09
 */
class Bll {

    public function assoc_data($arr,$key) {
        if(!is_array($arr)){
            return array();
        }
        $result = array();
        foreach($arr as $v) {
            $result[$v[$key]] = $v;
        }
        return $result;
    }

    public function merge_data($arr1,$arr2,$assoc_key) {
        foreach($arr1 as $k1=>$v1) {
            foreach($arr2[$v1[$assoc_key]] as $k2=>$v2) {
                $arr1[$k1][$k2] = $v2;
            }
        }
        return $arr1;
    }
    public static function map_array_by_property_value($arr,$property){
        if(!is_array($arr)){
            return array();
        }
        $result = array();
        foreach($arr as $v) {
            $result[$v->$property] = $v;
        }
        return $result;
    }

    public static function map_array_by_key_value($arr,$key){
        if(!is_array($arr)){
            return array();
        }
        $result = array();
        foreach($arr as $v) {
            $result[$v[$key]] = $v;
        }
        return $result;
    }

    public static function get_array_by_key($array,$key) {
        $result = array();
        foreach($array as $v) {
            $result[] = $v[$key];
        }
        return $result;
    }


    public function get_ids($array,$key) {
        $result = array();
        foreach($array as $v) {
            $result[] = $v[$key];
        }
        return $result;
    }

    public function key_list($key,$list) {
        $result = array();
        foreach($list as $v) {
            $result[$v[$key]][] = $v;
        }
        return $result;
    }

    public function key_list_count($key,$list) {
        $result = array();
        foreach($list as $v) {
            isset($result[$v[$key]]) or $result[$v[$key]] = 0;
            $result[$v[$key]] ++;
        }
        return $result;
    }


    /**
     * @param $one_dao
     * @param $more_dao
     * @param $assoc_key
     * @param $des_key
     * @param $where
     * @param string $order
     * @param string $limit
     * @return mixed
     */
    public function one_to_more($one_dao,$more_dao,$assoc_key,$des_key,$where,$order='id asc',$limit='') {

        $basic_data = $one_dao->get_by_where($where,$order,$limit);
        $assoc_ids = array();
        $assoc_ids[] = $this->get_ids($basic_data,$assoc_key);
        $more_list = $more_dao->get_by_where(array(
            $assoc_key=>$assoc_ids
        ));

        $more_assoc_list = array();
        foreach($more_list as $v) {
            $more_assoc_list[$v[$assoc_key]] = $v;
        }
        foreach($basic_data as $k=>$v) {
            $basic_data[$k][$des_key] = $more_assoc_list[$v[$assoc_key]];
        }
        return $basic_data;
    }


    public function key_array_to_key_count($key_array) {
        $key_count = [];
        foreach($key_array as $k=>$v) {
            $key_count[$k] = count($v);
        }
        return $key_count;
    }
}
