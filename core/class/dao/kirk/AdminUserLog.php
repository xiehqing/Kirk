<?php
namespace Dao\Kirk;
use Dao_CacheDao;
class AdminUserLog extends Dao_CacheDao {

    public function get_db_name() {
        return 'kirk';
    }

    public function get_table_name() {
        return 'tb_admin_user_log';
    }

    public function get_pk_id() {
        return 'id';
    }
}