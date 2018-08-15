<?php
/**
 * Created by PhpStorm.
 * User: kuan
 * Date: 2018/8/15
 * Time: 09:16
 */

class MyException extends \Exception{
    protected $data = [];

    final protected function setData($label, array $data){
        $this->data[$label] = $data;
    }

    final public function getData(){
        return $this->data;
    }
}