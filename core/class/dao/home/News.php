<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-21
 * Time: 下午4:49
 */
namespace Dao\Home;
use Dao_CacheDao;
class News extends Dao_CacheDao {
    public function get_db_name() {
        return 'kirk';
    }

    public function get_table_name() {
        return 'tb_home_news';
    }

    public function get_pk_id() {
        return 'news_id';
    }
}