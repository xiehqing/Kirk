<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-7-5
 * Time: 下午7:36
 */
namespace Bin;
use Bin_Abstract;
class InitLittleTableCache extends Bin_Abstract{
    /**
     * @var \Dao\LittleTableCacheDao
     */
    private $cache_dao;
    public function run($argv, $argc) {
        $cache_dao_name = $argv[1];
        $this->cache_dao = new $cache_dao_name();
        $this->walk_table($this->cache_dao,'','row');
    }
    public function row(){
        $cache = $this->cache_dao->get_cache();
        $cache->set($this->cache_dao->get_little_search_key_pre().$data[$this->cache_dao->get_main_search_key()],'1');
    }
}