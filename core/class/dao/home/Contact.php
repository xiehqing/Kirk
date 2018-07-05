<?php
/**
 * Created by PhpStorm.
 * User: kuan
 * Date: 2018/7/4
 * Time: 17:14
 */
namespace Dao\Home;
use Dao_CacheDao;
class Contact extends Dao_CacheDao{

    public function get_db_name() {
        return 'kirk';
    }

    public function get_table_name() {
        return 'tb_home_contact';
    }

    public function get_pk_id() {
        return 'contact_id';
    }


}