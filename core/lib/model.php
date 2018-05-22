<?php
namespace core\lib;
use core\lib\conf;
//class model extends \PDO {
//	public function __construct(){
//		// $dsn = 'mysql:host=localhost;dbname=pydb';
//		// $username = 'root';
//		// $passwd = 'root';
//		$database = conf::all('database');
//		// p($database);
//		try{
//			parent::__construct($database['DSN'],$database['USERNAME'],$database['PASSWD']);
//		} catch(\PDOException $e){
//			p($e->getMessage());
//
//		}
//
//	}
//}
//改为继承medoo
class model extends \Medoo\Medoo {

    public function __construct() {
        $option = conf::all('database');
        // var_dump($option);die();
        parent::__construct($option);
    }
}