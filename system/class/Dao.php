<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-21
 * Time: 下午2:26
 */

abstract class Dao {
    abstract public function get_table_name ();
    abstract public function get_pk_id();
    abstract public function get_db_name();
    private $slave_pdo;
    private $master_pdo;
    public $force_master = false;
    private $db_config;
    public function force_from_master() {
        $this->force_master = true;
    }
    public function __construct() {
        $db_config = KIRK::get_instance()->get_config('db','database');
        $this->db_config = $db_config[$this->get_db_name()];
        if(!$this->db_config){
            trigger_error("没有找到".$this->get_db_name()."的master配置信息",E_ERROR);
        }
    }

    private function get_master_pdo() {
        if(!$this->master_pdo) {
            $this->master_pdo = KIRK::get_instance()->get_pdo($this->db_config['master']);
        }
        return $this->master_pdo;
    }

    private function get_slave_pdo() {
        if($this->force_master) {
            return $this->get_master_pdo();
        }
        if(!$this->slave_pdo) {
            $this->slave_pdo = KIRK::get_instance()->get_pdo($this->db_config['slave']);
        }
        return $this->slave_pdo;
    }

    public function get_by_ids($ids,$order='',$fields="*") {
        $where = array(
            $this->get_pk_id().' in'=>$ids
        );
        return $this->get_by_where($where,$order,'0,2000',$fields);
    }

    /**
     * @desc 没查到就得 返回false
     * @param $id
     * @param string $fields
     * @return bool | array
     */
    public function get_by_id($id,$fields = "*") {
        $sql = "select {$fields} from `".$this->get_table_name()."` where `".$this->get_pk_id()."`=?";
        KIRK::get_instance()->debug($sql,'sql');
        $stmt = $this->get_slave_pdo()->prepare($sql);
        $stmt->execute(array($id));
        $result =  $stmt->fetch(PDO::FETCH_ASSOC);

        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function my_implode($data) {
        $result = '';
        if(!$data) {
            return $result;
        }
        foreach($data as $v) {
            $result .= "'$v',";
        }
        return substr($result, 0,-1);
    }

    public function build_where($where) {
        $sql = " where ";
        if(!$where) {
            return array(
                'where'=>' ',
                'data'=>array()
            );
        }

        $data = array();
        $is_first = true;
        foreach($where as $k=>$v) {
            $wh = explode(" ", $k);
            $mod = $wh[1];
            if($wh[1]=='') {
                $mod = '=';
            } else if($wh[1]=='in'){
                $v = ' ('.$this->my_implode($v).')';
                $mod = 'in'.$v;
                $key = $wh[0];
                $sql.= (!$is_first?' and ':' ')."`{$key}` {$mod}";
                $is_first = FALSE;
                continue;
            } else if($wh[1]=='notin') {
                $v = ' ('.$this->my_implode($v).')';
                $mod = 'not in'.$v;
                $key = $wh[0];
                $sql.= (!$is_first?' and ':' ')."`{$key}` {$mod}";
                $is_first = FALSE;
                continue;
            }
            $key = $wh[0];
            $sql.= (!$is_first?' and ':' ')."`{$key}` {$mod} ?";
            $data[] = $v;
            $is_first = FALSE;
        }
        $result = array(
            'where'=>$sql,
            'data'=>$data
        );
        return $result;
    }

    public function get_count_by_where($where) {
        $sql = "select count(*) as num from `" .$this->get_table_name(). "` ";
        $where_data = $this->build_where($where);
        $sql.=$where_data['where'];
        $data = $where_data['data'];

        $stmt = $this->get_slave_pdo()->prepare($sql);
        $result = array();
        $st = microtime(1);
        if($stmt->execute($data)) {
            $row =  $stmt->fetch(PDO::FETCH_ASSOC);
        }
        $spend = microtime(1)-$st;
        KIRK::get_instance()->debug($sql.' Time taked:'.$spend,'sql');
        return $row['num'];
    }

    public function get_single_by_where($where,$order='',$fields='*') {
        $info = $this->get_by_where($where,$order,'0,1',$fields);
        return $info[0];
    }

    public function get_by_where($where,$order='',$limit='0,2000',$fileds = '*') {
        $sql = "select {$fileds} from `".$this->get_table_name()."` ";

        $where_data = $this->build_where($where);
        $sql.=$where_data['where'];
        $data = $where_data['data'];
        if($order) {
            $order = 'order by '.$order;
        }
        if($limit) {
            $limit = 'limit '.$limit;
        }
        $sql .= " {$order} {$limit}";


        $stmt = $this->get_slave_pdo()->prepare($sql);
        $result = array();

        //echo $sql;exit();
        $st = microtime(1);
        if($stmt->execute($data)) {
            while($row =  $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result[] = $row;
            }
        }
        $spend = microtime(1)-$st;
        KIRK::get_instance()->debug($sql.' Time taked:'.$spend,'sql');
        return $result;
    }

    /**
     * @param $where
     * @param string $group
     * @param string $limit
     * @param string $fileds
     * @return array
     * @deprecated
     */
    public function get_by_where_group_by($where,$group='',$limit='0,2000',$fileds = '*') {
        $sql = "select {$fileds} from `".$this->get_table_name()."` ";

        $where_data = $this->build_where($where);
        $sql.=$where_data['where'];
        $data = $where_data['data'];
        if($group) {
            $group = 'group by '.$group;
        }
        if($limit) {
            $limit = 'limit '.$limit;
        }
        $sql .= " {$group} {$limit}";


        $stmt = $this->get_slave_pdo()->prepare($sql);
        $result = array();

        //echo $sql;exit();
        $st = microtime(1);
        if($stmt->execute($data)) {
            while($row =  $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result[] = $row;
            }
        }
        $spend = microtime(1)-$st;
        KIRK::get_instance()->debug($sql.' Time taked:'.$spend,'sql');
        return $result;
    }
    public function get_by_where_for_update($where) {
        $sql = "select * from `".$this->get_table_name()."` ";

        $where_data = $this->build_where($where);
        $sql.=$where_data['where'];
        $data = $where_data['data'];
        $sql .= " for update";


        $stmt = $this->get_master_pdo()->prepare($sql);
        $result = array();

        //echo $sql;exit();
        $st = microtime(1);
        if($stmt->execute($data)) {
            while($row =  $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result[] = $row;
            }
        }
        $spend = microtime(1)-$st;
        KIRK::get_instance()->debug($sql.' Time taked:'.$spend,'sql');
        return $result;
    }
    public function update_by_id($id,$data) {
        if(!is_array($data)) {
            trigger_error('$data必须是个数组');
            return;
        }

        $set_datas = array();
        if($data) {
            $set_string = ' set ';
            foreach($data as $k=>$v) {
                $set_datas[] = $v;
                $ks = explode(' ',$k);

                if(count($ks)==1) {
                    $k = $ks[0];
                    $set_string .= "`{$k}`=?,";
                } else {
                    $k = $ks[0];
                    $operate = $ks[1];
                    $set_string .= "`{$k}`=`{$k}`{$operate}?,";
                }
            }
            $set_string = substr($set_string, 0,-1);
        } else {
            return false;
        }
        $sql = "update `".$this->get_table_name()."` {$set_string}   where `".$this->get_pk_id()."`=?";
        KIRK::get_instance()->debug($sql,'sql');
        $stmt = $this->get_master_pdo()->prepare($sql);
        $set_datas = array_merge($set_datas,array($id));
        return $stmt->execute($set_datas);
    }
    public function update_by_where($where,$data) {
        $set_datas = array();
        if($data) {
            $set_string = ' set ';
            foreach($data as $k=>$v) {
                $set_datas[] = $v;
                $set_string.="`{$k}`=?,";
            }
            $set_string = substr($set_string, 0,-1);
        } else {
            return false;
        }

        $sql = "update `".$this->get_table_name()."` {$set_string} ";
        $to_data = array();
        $where = $this->build_where($where);
        $sql .= $where['where'];
        $to_data  = $where['data'];

        KIRK::get_instance()->debug($sql,'sql');
        $stmt = $this->get_master_pdo()->prepare($sql);
        return $stmt->execute(array_merge($set_datas,$to_data));
    }
    public function insert($data) {
        $d_string = '';
        $insert_data = array();
        if($data) {
            $set_string = '';
            foreach($data as $k=>$v) {
                $set_string.="`{$k}`,";
                $d_string.="?,";
                $insert_data[] = $v;
            }
            $set_string = substr($set_string, 0,-1);
            $d_string = substr($d_string, 0,-1);
        } else {
            return false;
        }
        $sql = "insert into `".$this->get_table_name()."`({$set_string}) values($d_string)";
        //echo $sql;exit();
        KIRK::get_instance()->debug($sql,'sql');
        $stmt = $this->get_master_pdo()->prepare($sql);
        if(!$stmt->execute($insert_data)){
            $error = $stmt->errorInfo();
            throw new Exception('SQL ERROR:'.$sql.';INFO:'.$error[2]);
            return false;
        }
        return $this->get_master_pdo()->lastInsertId();
    }

    public function exeSQL($sql) {
        KIRK::get_instance()->debug($sql);

        $stmt = $this->get_slave_pdo()->prepare($sql);
        $result = array();
        if($stmt->execute()) {
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result[] = $row;
            }
        }
        return $result;
    }

    public function del_by_id($id) {
        $sql = "delete from `".$this->get_table_name()."` where `".$this->get_pk_id()."`=?";
        KIRK::get_instance()->debug($sql,'sql');
        $stmt = $this->get_master_pdo()->prepare($sql);
        return $stmt->execute(array($id));
    }


    public function del_by_where($where) {
        $sql = "delete from `".$this->get_table_name()."` where 1=1 ";
        $data = array();
        foreach($where as $k=>$v) {
            $wh = explode(" ", $k);
            $mod = $wh[1]==''?'=':$wh[1];
            $key = $wh[0];
            $sql.=" and `{$key}`{$mod}?";
            $data[] = $v;
        }
        KIRK::get_instance()->debug($sql,'sql');
        $stmt = $this->get_master_pdo()->prepare($sql);
        return $stmt->execute($data);
    }


    /**
     * 开启事务
     */
    public function begin() {
        $this->get_master_pdo()->beginTransaction();
    }

    /**
     * 提交
     * @return mixed
     */
    public function commit() {
        $this->get_master_pdo()->commit();
    }

    /**
     * 回滚
     * @return mixed
     */
    public function roll_back() {
        $this->get_master_pdo()->rollBack();
    }

    /**
     * 锁表
     * @return mixed
     */
    public function lock_table() {
        return $this->exeSQL("LOCK TABLE {$this->get_table_name()} WRITE");
    }

    /**
     * 解锁表
     * @return mixed
     */
    public function unlock_table() {
        return $this->exeSQL("UNLOCK TABLE");
    }
}
