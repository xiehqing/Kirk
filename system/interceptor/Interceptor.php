<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-20
 * Time: 上午11:04
 */
abstract class Interceptor {
    public function __construct() {

    }
    abstract public function go_next();
    public function broken() {
        KIRK::get_instance()->get_response()->status_500();
        exit();
    }
}