<?php
namespace Dao\Dnf;
use Dao_CacheDao;
class Form extends Dao_CacheDao {

    public function get_db_name() {
        return 'kirk';
    }

    public function get_table_name() {
        return 'tb_dnf_form';
    }

    public function get_pk_id() {
        return 'id';
    }
}