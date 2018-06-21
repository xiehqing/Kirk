<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-21
 * Time: 下午2:44
 */

interface CacheInterface {
    /**
     * @param string $key
     * @param array $value,string $value
     * @param int $t
     * @return mixed
     * 用来存储array
     */
    public function set_array($key,$value,$t=86400);

    /**
     * @param string $key
     * @return array
     * 返回一个array
     */
    public function get_array($key);
    public function set($key,$value,$t=86400);
    public function get($key);
    public function delete($key);
}