<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-20
 * Time: 上午10:06
 */
set_time_limit(0);
abstract class Bin_Abstract {
    public $max_page_num = 500;
    abstract public function run($argv,$argc);
    public function walk_table($dao,$where,$action){
        if (!$where){
            $where = ' 1=1 ';
        }
        $pk = $dao->get_pk_id();
        $table = $dao->get_table_name();
        // 获取最大值
        $sql = "select {$pk} from `{$where}` where {$where} order by {$pk} desc limit 1";
        $this->log($sql);
        $max = $dao->exeSql($sql);
        if(!$max){
            return false;
        }
        $max_id = $max[0][$pk]+1;
        while(true) {
            $sql = "select * from `{$table}` where {$where} and
             $pk<$max_id order by {$pk} desc limit ".$this->max_page_num;
            $this->log($sql);
            $result = $dao->exeSql($sql);
            foreach($result as $k=>$v) {
                $this->$action($v);
            }
            if(count($result)<$this->max_page_num) {
                break;
            } else {
                $min = array_pop($result);
                $max_id = $min[$pk];
            }
        }
    }

    public function walk_table_list($dao,$where,$action) {
        if(!$where) {
            $where = ' 1=1 ';
        }
        $pk = $dao->get_pk_id();
        $table = $dao->get_table_name();
        //获取最大值
        $sql = "select {$pk} from `{$table}` where {$where} order by {$pk} desc limit 1";
        $this->log($sql);
        $max = $dao->exeSql($sql);
        if(!$max) {
            return false;
        }
        $max_id = $max[0][$pk]+1;
        while(true) {
            $sql = "select * from `{$table}` where {$where} and
             $pk<$max_id order by {$pk} desc limit ".$this->max_page_num;
            $this->log($sql);
            $result = $dao->exeSql($sql);
            $this->$action($result);
            if(count($result)<$this->max_page_num) {
                break;
            } else {
                $min = array_pop($result);
                $max_id = $min[$pk];
            }
        }
    }

    public function walk_table_order($dao,$where,$action,$order) {
        if(!$where) {
            $where = ' 1=1 ';
        }
        $pk = $dao->get_pk_id();
        $table = $dao->get_table_name();
        //获取最大值
        $sql = "select {$pk} from `{$table}` where {$where} order by {$pk} desc limit 1";
        $this->log($sql);
        $max = $dao->exeSql($sql);
        if(!$max) {
            return false;
        }
        $max_id = $max[0][$pk]+1;
        while(true) {
            $sql = "select * from `{$table}` where {$where} and
             $pk<$max_id order by {$order} desc limit ".$this->max_page_num;
            $this->log($sql);
            $result = $dao->exeSql($sql);
            foreach($result as $k=>$v) {
                $this->$action($v);
            }
            if(count($result)<$this->max_page_num) {
                break;
            } else {
                $min = array_pop($result);
                $max_id = $min[$pk];
            }
        }
    }



    public function log($str) {
        echo "[".date("Y-m-d H:i:s")."] ";
        if(is_string($str)){
            echo $str;
        } else {
            print_r($str);
        }
        echo PHP_EOL;
    }

    public function walk_row_file($path,$fun) {
        $fp = fopen($path,'r');
        while (!feof($fp)){
            $line = fgets($fp);
            $fun($line);
        }
        fclose($fp);
    }
}