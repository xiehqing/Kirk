<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-11
 * Time: 上午11:15
 */

require_once ROOT_PATH .'vendor/autoload.php';

spl_autoload_register(function ($classname){
    if (substr($classname,-4,strlen($classname))=='Ctrl'){
        if ($classname=='Ctrl'){
            kirk_require_ctrl($classname);
        } else{
            kirk_require_ctrl(substr($classname,0,-4));
        }
    } else if (substr($classname,-4,strlen($classname))=='View'){
        if ($classname=='View'){
            kirk_require_view($classname);
        } else{
            kirk_require_view(substr($classname,0,-4));
        }
    } else if (substr($classname,-6,strlen($classname))=='Plugin'){
        if ($classname=='Plugin'){
            kirk_require_view($classname);
        } else{
            kirk_require_view(substr($classname,0,-6));
        }
    } else{
        kirk_require_class($classname);
    }
});

function get_real_class_name($class,$type){
    if(strtolower($class)==$type){
        $class = '';
    }
    if($type){
        $class_true_name = $class.strtoupper(substr($type,0,1)).substr($type,1);
    }else{
        $class_true_name = $class;
    }
    return $class_true_name;
}

function kirk_require($class_name,$type='',$extend='php'){
    global $INCLUDE_PATH;
    $folder = $type==''?'class':$type;
    $build_path = kirk_build_path($class_name,$folder);

    $real_path = SYS_PATH.$build_path.'.'.$extend;

    $class_true_name = get_real_class_name($class_name,$type);

    if (file_exists($real_path)){
        if (!class_exists($class_true_name)){
            require_once $real_path;
        }
        return;
    }

    foreach($INCLUDE_PATH AS $v){
        $real_path = $v.$build_path.'.'.$extend;
        if(file_exists($real_path)){

            if (!class_exists($class_true_name)) {
                require_once $real_path;
            }
            return;
        }
    }
}

function kirk_require_class($class_name){
    kirk_require($class_name);
}

function kirk_require_ctrl($class_name){
    kirk_require($class_name,'ctrl');
}

function kirk_require_view($class_name){
    kirk_require($class_name,'view');
}

function kirk_require_template($class_name){
    kirk_require($class_name,'ctrl','phtml');
}

function kirk_require_plugin($class_name){
    kirk_require($class_name,'plugin');
}

function kirk_require_interceptor($class_name){
    kirk_require($class_name,'interceptor');
}

function kirk_build_path($class,$type){
    if(strpos($class,'\\')!==false){
        $arr = explode('\\',$class);
    }else{
        $arr = explode('_',$class);
    }
    $name = array_pop($arr);
    $path = '';
    foreach($arr as $v){
        $path.='/'.strtolower($v);
    }
    return '/'.$type.$path.'/'.$name;
}

function kirk_error_handler($error_no){
    if($error_no!=8){
        //debug_print_backtrace();
    }
}

?>
