<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-22
 * Time: 下午2:18
 */
namespace Dao\Admin;
use Dao_CacheDao;
class User extends Dao_CacheDao {
    public function get_db_name() {
        return 'kirk';
    }

    public function get_table_name() {
        return 'tb_admin_user';
    }

    public function get_pk_id() {
        return 'user_id';
    }
}