<?php
namespace app\ctrl;
use core\lib\model;
use core\common\Globalfun;
/**
* 
*/
class indexCtrl extends \core\kirk{
    //集成medoo
    public function index(){
        $model = new model();
//        dump($model);
        //medoo 查询select（表名，字段名，查询条件）
        // $data = $model->select("testtable","*");

        // medoo 插入insert（table，data）
        $data = array(
        	'name'=>'ceshi',
        	'url'=> 'huangkuankuan.cn'
        );

        $ret = $model->insert("tb_test",$data);
        if ($ret){
            $message = array(
                "status" => 0,
                "message" => "提交数据成功！"
            );
        dump($message);
        }

    }

	public function test(){
		 p('it is model test');
		$model = new \core\lib\model();
		$sql = "select * from testtable";
		$ret = $model->query($sql);
		p($ret);
		p($ret->fetchAll());
	}
}