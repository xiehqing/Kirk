<?php
kirk_require_class("CacheInterface");
kirk_require_class('Redis');

class RedisCache implements CacheInterface {

    private static $master;
    private static $slave;

    /**
     * @param string $type
     * @return mixed
     */
    private function get_redis_config($type = 'master') {
        $redis_config = KIRK::get_instance()->get_config('redis_cache');
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
     * 用来存储array
     */
    public function set_array($key, $value, $t = 86400) {
        $cache = KIRK::get_instance()->get_config('cache');
        if(!$cache) {
            return false;
        }
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
        $cache = KIRK::get_instance()->get_config('cache');
        if(!$cache) {
            return false;
        }
        $res = $this->get($key);
        KIRK::get_instance()->debug($res, 'redis');
        return unserialize($res);
    }

    public function set($key, $value, $t = 0) {
        $cache = KIRK::get_instance()->get_config('cache');
        if(!$cache) {
            return false;
        }
        if ($t != 0) {
            $res = $this->get_master_redis()->set($key, $value, $t);
        } else {
            $res = $this->get_master_redis()->set($key, $value);
        }
        KIRK::get_instance()->debug($res, 'redis');
        return $res;
    }
    public function delete($key){
        $res = $this->get_master_redis()->delete($key);
        return $res;
    }
    public function get($key) {

        $cache = KIRK::get_instance()->get_config('cache');
        if(!$cache) {
            return false;
        }

        $res = $this->get_slave_redis()->get($key);
        KIRK::get_instance()->debug($res, 'redis');
        return $res;
    }
}
