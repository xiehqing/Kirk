<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-11
 * Time: 下午3:39
 */

# 开发环境使用，线上环境需要删除该文件
# 使用方法：
#   如建立app-home目录下的index控制器和视图文件，php Tool.php create-page app-home Home\\Index HomeFrameView

error_reporting(E_ALL & ~E_NOTICE);

$action = $argv[1];

function get_namespace($class) {
    $class_names = explode('\\',$class);
    $namespaces = array_slice($class_names,0,-1);
    $namespace = implode('\\',$namespaces);
    return array(
        'namespace' => $namespace,
        'classname' => $class_names[count($class_names)-1],
        'dir' => strtolower(implode('/',$namespaces)),
        'classes' => $class_names
    );
}


if($action=='create-dao') {
    $dao_name = $argv[2];

    if($dao_name=='-h') {
        echo 'php run.php create-dao dao_name table_name db pk'.PHP_EOL;
        return;
    }

    $table_name = $argv[3];
    $db = $argv[4]?:'ucs';
    $pk = $argv[5]?:'id';
    $class_names = explode('\\',$dao_name);
    $namespaces = array_slice($class_names,0,-1);
    $namespace = implode('\\',$namespaces);
    $dao_name = $class_names[count($class_names)-1];
    $dao_content = <<<EOL
<?php
namespace {$namespace};
use Dao_CacheDao;
class {$dao_name} extends Dao_CacheDao {

    public function get_db_name() {
        return '{$db}';
    }

    public function get_table_name() {
        return '{$table_name}';
    }

    public function get_pk_id() {
        return '{$pk}';
    }
}
EOL;
    $dir = './app-core/class/'.implode('/',$namespaces);
    $dir  = strtolower($dir);

    if(!file_exists($dir)) {
        mkdir($dir, 0755, true);
    }
    $path = $dir.'/'.$dao_name.'.php';

    file_put_contents($path,$dao_content);
    echo 'success';
} else if($action=='create-bll') {
    $classname = $argv[2];
    $dao_name = $argv[3];
    $class_names = explode('\\',$classname);
    $namespaces = array_slice($class_names,0,-1);
    $namespace = implode('\\',$namespaces);
    $bll_name = $class_names[count($class_names)-1];

    $bll_content = <<<EOL
<?php

namespace {$namespace};
use Bll;

class {$bll_name} extends Bll {


    private function get_dao() {
        \$dao = new \\{$dao_name}();
        return \$dao;
    }
}
EOL;
    $dir = './app-core/class/'.implode('/',$namespaces);
    $dir  = strtolower($dir);
    if(!file_exists($dir)) {
        mkdir($dir, 0755, true);
    }
    $path = $dir.'/'.$bll_name.'.php';
    file_put_contents($path,$bll_content);
    echo 'success';
} else if($action=='create-page') {
    $app_dir = $argv[2];
    $ctrl = $argv[3];
    $frame = $argv[4];


    $class_info  = get_namespace($ctrl);

    $ctrl_template = <<<EOL
<?php
namespace {$class_info['namespace']};

class {$class_info['classname']}Ctrl extends \Ctrl {

    public function run(){


        return '{$ctrl}';
    }
}

EOL;

    $des_dir = './'.$app_dir.'/ctrl/'.$class_info['dir'];

    if(!file_exists($des_dir)) {
        mkdir($des_dir, 0755, true);
    }

    $path = $des_dir.'/'.$class_info['classname'].'.php';
    file_put_contents($path,$ctrl_template);


    $view_template = <<<EOL
<?php
namespace {$class_info['namespace']};
use KIRK;
class {$class_info['classname']}View extends \\{$frame}View {

    public function get_content(){
		\$data = KIRK::get_instance()->get_request()->get_attributes();
		foreach(\$data as \$k=>\$v) {
			\$this->set_data(\$k, \$v);
		}
		return '{$ctrl}';
	}
	public static function get_css_list() {
		return array_merge(parent::get_css_list(),
		array(
			'{$ctrl}'
		));
	}
	public static function get_js_list() {
		return array_merge(
		parent::get_js_list(),
		array(
			'{$ctrl}'
		));
	}
    public function get_title() {
        return '测试';
    }
}

EOL;

    $view_dir = './'.$app_dir.'/view/'.$class_info['dir'];

    if(!file_exists($view_dir)) {
        mkdir($view_dir, 0755, true);
    }

    $view_path = $view_dir.'/'.$class_info['classname'].'.php';
    file_put_contents($view_path,$view_template);

    //css
    $css_path = $view_dir.'/'.$class_info['classname'].'.css';
    file_put_contents($css_path,'/*css*/');


    $js_class = implode('.',$class_info['classes']);

    $js_templace = <<<EOL
KIRK.regist("{$js_class}");
{$js_class} =  function(){

};

{$js_class}.prototype = {
    'init':function(){

    }
};
EOL;


    //js
    $js_path = $view_dir.'/'.$class_info['classname'].'.js';
    file_put_contents($js_path,$js_templace);

    $html_path = $view_dir.'/'.$class_info['classname'].'.phtml';
    $jsInstance = implode('',$class_info['classes']);

    $html_templace = <<<EOL
hello world
<?php \$this->begain_script_block(); ?>
<script>
	var {$jsInstance} = new {$js_class}();
    {$jsInstance}.init();
</script>
<?php \$this->end_script_block(); ?>
EOL;
    file_put_contents($html_path,$html_templace);


    //router
    $router = strtolower($class_info['classname']);
    $rounter_template = <<<EOL

\$config['router']['{$ctrl}'] = array(
    '^\/{$router}$'
);
EOL;

    $view_dir = './'.$app_dir.'/config/router.php';

    $fp = fopen($view_dir,'a');
    fwrite($fp,$rounter_template);
    fclose($fp);
} else if($action=='create-plugin') {
    $app_dir = $argv[2];
    $controller = $argv[3];
    $frame = $argv[4];


    $class_info  = get_namespace($controller);


    $plugin_template = <<<EOL
<?php
namespace {$class_info['namespace']};
use KIRK;
class {$class_info['classname']}Plugin extends Plugin {

    public static function get_css_list() {
        return array(
            '{$controller}'
        );
    }

    public static function get_js_list() {
        return array(
            '{$controller}'
        );
    }

    public function get_content() {
        \$data = \$this->get_construct_datas();
        foreach(\$data as \$k=>\$v) {
            \$this->set_data(\$k, \$v);
        }
        return '{$controller}';
    }
}

EOL;
    $plugin_dir = './'.$app_dir.'/plugin/'.$class_info['dir'];

    if(!file_exists($plugin_dir)) {
        mkdir($plugin_dir, 0755, true);
    }

    $plugin_path = $plugin_dir.'/'.$class_info['classname'].'.php';
    file_put_contents($plugin_path,$plugin_template);

    //css
    $css_path = $plugin_dir.'/'.$class_info['classname'].'.css';
    file_put_contents($css_path,'/*css*/');

    $js_class = implode('.',$class_info['classes']);
    $js_templace = <<<EOL
KIRK.regist("{$js_class}");
{$js_class} =  function(){

};

{$js_class}.prototype = {
    'init':function(){

    }
};
EOL;

    //js
    $js_path = $plugin_dir.'/'.$class_info['classname'].'.js';
    file_put_contents($js_path,$js_templace);

    $html_path = $plugin_dir.'/'.$class_info['classname'].'.phtml';
    $jsInstance = implode('',$class_info['classes']);

    $html_templace = <<<EOL
hello world
<?php \$this->begain_script_block(); ?>
<script>
	var {$jsInstance} = new {$js_class}();
    {$jsInstance}.init();
</script>
<?php \$this->end_script_block(); ?>
EOL;
    file_put_contents($html_path,$html_templace);
}