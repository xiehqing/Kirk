<?php
kirk_require_class('Dao_CacheDao');
class Dao_FromTable extends Dao_CacheDao {
    public $create_db = '';
    public $create_table_name = '';
    public $create_pk_id = '';
    public function get_db_name() {
        return $this->create_db;
    }
    public function get_table_name(){
        return $this->create_table_name;
    }
    public function get_pk_id() {
        return $this->create_pk_id;
    }

    /**
     * Dao_FromTable constructor.
     * @param $db
     * @param $table_name
     * @param string $pk_id
     */
    public function __construct($db,$table_name,$pk_id='id') {
        $this->create_db = $db;
        $this->create_table_name = $table_name;
        $this->create_pk_id = $pk_id;
        parent::__construct();
    }
}