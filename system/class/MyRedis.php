<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-7-29
 * Time: 下午4:47
 */

kirk_require_class("CacheInterface");
kirk_require_class('Redis');

class MyRedis implements CacheInterface {

    private static $master;
    private static $slave;

    /**
     * @param string $type
     * @return mixed
     */
    private function get_redis_config($type = 'master') {
        $redis_config = KIRK::get_instance()->get_config('redis', 'common');
        return $redis_config[$type];
    }

    /**
     * @param string $type
     * @return Redis
     */
    private function get_redis($type = 'master') {
        if (!self::$$type) {
            self::$$type = new Redis();
            $redis_config = $this->get_redis_config($type);
            self::$$type->pconnect($redis_config['host'], $redis_config['port']);
            if ($redis_config['password']) {
                self::$$type->auth($redis_config['password']);
            }
        }
        return self::$$type;
    }

    private function get_master_redis() {
        return $this->get_redis('master');
    }

    private function get_slave_redis() {
        return $this->get_redis('slave');
    }

    /**
     * @param string $key
     * @param array $value
     * @param int $t
     * @return bool|mixed
     * 用来存储array
     */
    public function set_array($key, $value, $t = 86400) {
        if (is_array($value)) {
            $string = serialize($value);
        } else {
            $string = $value;
        }

        if ($t != 0) {
            $res = $this->set($key, $string, $t);
        } else {
            $res = $this->set($key, $string);
        }

        KIRK::get_instance()->debug($res, 'redis');
        return $res;
    }

    /**
     * @param string $key
     * @return array
     * 返回一个array
     */
    public function get_array($key) {
        $res = $this->get($key);
        KIRK::get_instance()->debug($res, 'redis');
        return unserialize($res);
    }

    public function set($key, $value, $t = 0) {
        if ($t != 0) {
            $res = $this->get_master_redis()->set($key, $value, $t);
        } else {
            $res = $this->get_master_redis()->set($key, $value);
        }
        KIRK::get_instance()->debug($res, 'redis');
        return $res;
    }

    public function get($key) {
        $res = $this->get_slave_redis()->get($key);
        KIRK::get_instance()->debug($res, 'redis');
        return $res;
    }
    public function getMultiple($keys) {
        return $this->get_slave_redis()->getMultiple($keys);
    }


    public function expire($key, $ttl = 60) {
        $res = $this->get_master_redis()->expire($key, $ttl);
        KIRK::get_instance()->debug($res, 'redis');
        return $res;
    }

    public function incr($key) {
        $res = $this->get_master_redis()->incr($key);
        KIRK::get_instance()->debug($res, 'redis');
        return $res;
    }

    public function decr($key) {
        $res = $this->get_master_redis()->decr($key);
        KIRK::get_instance()->debug($res, 'redis');
        return $res;
    }

    public function incrby($key, $num = 1) {
        $res = $this->get_master_redis()->incrBy($key, $num);
        KIRK::get_instance()->debug($res, 'redis');
        return $res;

    }

    public function sadd($key, $value) {
        $res = $this->get_master_redis()->sAdd($key, $value);
        KIRK::get_instance()->debug($res, 'redis');
        return $res;
    }

    public function scard($key) {
        $res = $this->get_master_redis()->sCard($key);
        KIRK::get_instance()->debug($res, 'redis');
        return $res;
    }

    public function sPop($key){
        $this->get_master_redis()->sPop($key);
    }

    public function sRandMember($key, $count){
        $res = $this->get_slave_redis()->sRandMember($key, $count);
        KIRK::get_instance()->debug($res, 'redis');
        return $res;
    }


    public function decrby($key, $num = 1) {
        $res = $this->get_master_redis()->decrBy($key, $num);
        KIRK::get_instance()->debug($res, 'redis');
        return $res;
    }

    public function lpush($key, $value) {
        $res = $this->get_master_redis()->lPush($key, $value);
        KIRK::get_instance()->debug($res, 'redis');
        return $res;
    }

    public function rpush($key, $value) {
        $res =  $this->get_master_redis()->rPush($key, $value);
        KIRK::get_instance()->debug($res, 'redis');
        return $res;
    }

    public function lpop($key) {
        $res = $this->get_master_redis()->lPop($key);
        KIRK::get_instance()->debug($res, 'redis');
        return $res;
    }

    public function rpop($key) {
        $res = $this->get_master_redis()->rPop($key);
        KIRK::get_instance()->debug($res, 'redis');
        return $res;
    }

    public function zIncrBy($key,$value=1,$member) {
        return $this->get_master_redis()->zIncrBy($key,$value,$member);
    }

    public function hIncrBy($key, $hashKey, $value) {
        return $this->get_master_redis()->hIncrBy($key, $hashKey, $value);
    }

    public function delete($key) {
        return $this->get_master_redis()->delete($key);
    }

    public function hGet($key, $hashKey) {
        return $this->get_slave_redis()->hGet($key, $hashKey);
    }
    public function zRange($key,$start,$end,$withscores) {
        return $this->get_slave_redis()->zRange($key,$start,$end,$withscores);
    }
    public function zScore($key,$member) {
        return $this->get_slave_redis()->zScore($key,$member);
    }

    /**
     * @param $key
     * @param $start
     * @param $end
     * @return array
     */
    public function lRange($key,$start,$end) {
        return $this->get_slave_redis()->lRange($key,$start,$end);
    }
    public function publish($channel,$message) {
        return $this->get_master_redis()->publish($channel,$message);
    }
    public function sIsMember($key,$value){
        return $this->get_slave_redis()->sIsMember($key,$value);
    }
    public function sMembers($key) {
        return $this->get_slave_redis()->sMembers($key);
    }

}
