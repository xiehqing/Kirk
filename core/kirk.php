<?php

namespace core;
class kirk{
	// 出于性能考虑，如果引入过$class，就不再重复引入，建一个临时变量进行储存已经加再好的类，临时的静态属性
	public static $classMap = array();
	public $assign;
	static public function run(){
		// 启动日志
		\core\lib\log::init();
		\core\lib\log::log($_SERVER,'server');

		// 加载路由
		$route = new \core\lib\route();
		// 加载控制器
		$ctrlClass = $route->ctrl;
		// 加载方法
		$action = $route->action;

		$ctrlfile = APP.'/ctrl/'.$ctrlClass.'Ctrl.php';
		$cltrlClass = '\\'.MODULE . '\ctrl\\'.$ctrlClass.'Ctrl';
		// p($ctrlfile);exit();
		if (is_file($ctrlfile)) {
			include $ctrlfile;
			// new \app\ctrl\indexCtrl;
			// new MODULE.'/ctrl/'.$ctrlClass();
			$ctrl = new $cltrlClass();
			$ctrl->$action();
			\core\lib\log::log('ctrl:'.$ctrlClass.'      '.'action:'.$action);
		} else {
			throw new \Exception('找不到控制器'.$ctrlClass);
		}

	}

	// 自动加载功能
	static public function load($class){
		// 自动加载类库
		// new \core\route();
		// $class = '\core\route';
		// KIRK.'/core/route.php';
		// 目的：把$class = '\core\route';转化为KIRK.'/core/route.php';
		//在引入一个类时，先在$classMap中判断是否已经引入了这个类
		if (isset($classMap[$class])) {
			return true;
		} else{
			$class = str_replace('\\', '/', $class);
			$file = KIRK .'/'. $class . '.php';
			if (is_file($file)) {
				include $file;
				// 加载成功，把$class类放入$classMap数组中，因为是一个静态的属性,所以我们要用self来引入
				self::$classMap[$class] = $class;
			} else {
				return false;
			}
		}
	}

	public function assign($name,$value){
		$this->assign[$name] = $value;

	}

	public function display($file){
		$file = APP.'/views/'.$file;
		if (is_file($file)) {
			// p($this->assign);exit();
			extract($this->assign);
			include $file;
		}
	}
}
