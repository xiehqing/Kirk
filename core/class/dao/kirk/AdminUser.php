<?php
namespace Dao\Kirk;
use Dao_CacheDao;
class AdminUser extends Dao_CacheDao {

    public function get_db_name() {
        return 'kirk';
    }

    public function get_table_name() {
        return 'tb_admin_user';
    }

    public function get_pk_id() {
        return 'id';
    }
}