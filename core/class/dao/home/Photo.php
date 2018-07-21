<?php
namespace Dao\Home;
use Dao_CacheDao;
class Photo extends Dao_CacheDao {

    public function get_db_name() {
        return 'kirk';
    }

    public function get_table_name() {
        return 'tb_home_photo';
    }

    public function get_pk_id() {
        return 'id';
    }
}