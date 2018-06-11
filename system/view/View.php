<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-11
 * Time: 下午4:14
 */
kirk_require_class('GlobalFun');
abstract class View{
    public function get_title() {
        $kirk = KIRK::get_instance();
        return $kirk->get_config('name').$kirk->get_config('version');
    }
    public function get_keywords() {
        //return 'PHP,Frame,框架，好用';
    }

    public function get_description() {
        //return '世界上最好用的php框架';
    }
    public function get_metals(){
        //return [['name'=>'hah','haha','hehe'],['name'=>'hah','haha','hehe']]
    }
    public function build_container() {
        KIRK::get_instance()->debug('build_html_container:'.$this->get_container());
        $this->include_template($this->get_container());
    }

    public function build_content() {
        KIRK::get_instance()->debug('build_html_content');
        $this->include_template($this->get_content());
    }

    abstract public function get_content();

    public function get_container(){

    }

    public function include_template($name,$view='view',$type='phtml') {
        extract($this->data);
        KIRK::get_instance()->debug($name);
        $path = self::get_real_path($name,$view,$type);
        if($path) {
            require $path;
        } else {
            KIRK::get_instance()->debug("Not Found Template,Name:{$name},View:{$view},Type:{$type}","KIRK ERROR");
        }
    }
    /**
     * 获取真正的路径
     * */
    public static function get_real_path($name,$view='view',$type='phtml') {
        $path  = kirk_build_path($name,$view);
        $path = CUR_PATH.$path.'.'.$type;
        if(file_exists($path)) {
            return $path;
        }

        $path  = kirk_build_path($name,$view);
        $path = SYS_PATH.$path.'.'.$type;
        if(file_exists($path)) {
            return $path;
        }
        global $INCLUDE_PATH;
        if($INCLUDE_PATH) {
            foreach($INCLUDE_PATH as $path_root) {
                $path  = kirk_build_path($name,$view);
                $path = $path_root.$path.'.'.$type;
                if(file_exists($path)) {
                    return $path;
                }
            }
        }
        return false;
    }
    public $data = array();
    public function set_data($key,$value) {
        $this->data[$key] = $value;
    }
    public function get_class_name() {
        $called = get_called_class();
        return substr($called, 0, -4);
    }
    public function build_css_url() {

        $source_url = KIRK::get_instance()->get_config("source");


        $location = KIRK::get_instance()->get_config("location");

        $class_name = $this->get_class_name();

        if(strpos($class_name,'\\')!==false) {
            $class_name = str_replace('\\','/',$class_name);
        }
        $real_url = $source_url.$location.'/resource/css/'.$class_name.'.css';

        $request = KIRK::get_instance()->get_request();
        //防止 cdn将https和http缓存成同一个请求
        return $real_url.'?v='.VERSION.'&'.($request->is_https()?'https':'');
    }

    public function build_js_url() {


        $source_url = KIRK::get_instance()->get_config("source");


        $location = KIRK::get_instance()->get_config("location");

        $class_name = $this->get_class_name();

        if(strpos($class_name,'\\')!==false) {
            $class_name = str_replace('\\','/',$class_name);
        }

        $real_url = $source_url.$location.'/resource/js/'.$class_name.'.js';
        $request = KIRK::get_instance()->get_request();
        //防止 cdn将https和http缓存成同一个请求
        return $real_url.'?v='.VERSION.'&'.($request->is_https()?'https':'');
    }
    public static function get_css_list() {
        return array();
    }
    public static function get_js_list() {
        return array(
            'KIRK'
        );
    }

    public static function get_static_js_list() {
        return array(

        );
    }
    public static function get_plugin() {
        return array();
    }

    public function get_css_header(){
        $called = get_called_class();
        $css_list = $called::get_css_list();
        $tag = '';
        $last_mod = 0;
        foreach($css_list as $v) {
            $real_path = self::get_real_path($v,'view','css');
            $last_mod_time = filemtime($real_path);
            $tag .= $v.$last_mod_time.'view';
            $last_mod = max($last_mod,$last_mod_time);
        }
        //插件内的css
        $called = get_called_class();
        $plugin_list = $called::get_plugin();
        foreach ($plugin_list as $key => $plugin) {
            $real_name = $plugin.'Plugin';
            $css_list = $real_name::get_css_list();

            foreach($css_list as $v) {
                $real_path = self::get_real_path($v,'plugin','css');
                $last_mod_time = filemtime($real_path);
                $tag .= $v.$last_mod_time.'view';
                $last_mod = max($last_mod,$last_mod_time);
            }
        }
        $tag .= serialize(KIRK::get_instance()->get_request()->get_params());
        $request = KIRK::get_instance()->get_request();

        $matchs = KIRK::get_instance() -> get_request() -> get_matchs();
        $location = $matchs[1];
        $tag .= $location;


        $tag  = md5(($request->is_https()?'https':'').$tag.VERSION.'css');


        $header = array('etag'=>$tag,'last_mod'=>$last_mod);
        return $header;
    }

    public static function get_real_px($px,$screen_width,$psd_width){

        if( $px == '1') {
            return $px;
        }

        $psd_width = $psd_width ?$psd_width:720;
        return  round($screen_width/$psd_width*$px);
    }

    /**
     * @desc 自动进行尺寸处理
     * @param $content
     * @param $screen_width
     * @param $psd_width
     * @return mixed
     */
    public function auto_make_css_size($content,$screen_width,$psd_width) {
        return preg_replace_callback('/\/\*real\{([\-\d]+)\}\*\//',function($matches) use($screen_width,$psd_width) {
            return $this->get_real_px($matches[1],$screen_width,$psd_width).'px';
        },$content);
    }

    public function get_css_content($header,$host='') {
        $mem_key = $host.$header['etag'];

        $content = '';
        if(KIRK::get_instance()->get_config("cache")) {
            $cache = KIRK::get_instance()->get_cache();
            $cache_content = $cache->get($mem_key);
            if ($cache_content) {
                KIRK::get_instance()->get_response()->header('from_mem', 1);
                $content =  $cache_content;
                echo $content;
            }
        }
        if(!$content) {
            $called = get_called_class();
            $css_list = $called::get_css_list();
            foreach ($css_list as $v) {
                $this->begain_script_block();
                $this->include_template($v, 'view', 'css');
                $this->end_script_block();
            }
            //插件内的css
            $called = get_called_class();
            $plugin_list = $called::get_plugin();
            foreach ($plugin_list as $key => $plugin) {
                $real_name = $plugin . 'Plugin';
                $css_list = $real_name::get_css_list();
                foreach ($css_list as $v) {
                    $this->begain_script_block();
                    $this->include_template($v, 'plugin', 'css');
                    $this->end_script_block();
                }
            }
            $content = implode('', $this->script_blocks);


            $screen_width = KIRK::get_instance()->get_request()->get_param('sw');
            if($screen_width) {
                $psd_width = KIRK::get_instance()->get_request()->get_param('psw',720);
                $content = $this->auto_make_css_size($content, $screen_width, $psd_width);
            }


            if (KIRK::get_instance()->get_config('compress_css')) {
                $url = KIRK::get_instance()->get_config('compress_server');
                $post_data = array('css' => $content);
                $query = http_build_query([
                    'key'=>$mem_key
                ]);
                $c = GlobalFun::post($url.'?'.$query, $post_data);
                if($c) {
                    $content = $c;
                }

            }

            if(KIRK::get_instance()->get_config("cache")) {
                $cache = KIRK::get_instance()->get_cache();
                $cache->set($mem_key, $content, 0);
            }
            echo $content;
        }
    }

    public function get_js_content_header() {
        $called = get_called_class();
        $common_js_list = $called::get_js_list();
        //插件内的js
        $called = get_called_class();
        $plugin_list = $called::get_plugin();
        $plugin_js_list = array();
        foreach ($plugin_list as $key => $plugin) {
            $real_name = $plugin.'Plugin';
            $js_list = $real_name::get_js_list();
            foreach($js_list as $v) {
                $plugin_js_list[] = $v;
            }
        }
        $key = '';
        $last_mod = 0;
        $last_time_list = [];
        foreach($common_js_list as $v) {
            $real_path = self::get_real_path($v,'view','js');
            $last_mod_time = filemtime($real_path);
            $last_time_list[] = $last_mod_time;
            $key .= $v.$last_mod_time.'view';
            $last_mod = max($last_mod,$last_mod_time);
        }
        KIRK::get_instance()->get_response()->header('js_list',implode(',',$common_js_list));
        KIRK::get_instance()->get_response()->header('time_list',implode(',',$last_time_list));

        foreach($plugin_js_list as $v) {
            $real_path = self::get_real_path($v,'plugin','js');
            $last_mod_time = filemtime($real_path);
            $key .= $v.$last_mod_time.'plugin';
            $last_mod = max($last_mod,$last_mod_time);
        }


        $request = KIRK::get_instance()->get_request();

        $matchs = $request -> get_matchs();
        $location = $matchs[1];
        $key .= $location;


        $key  = md5(($request->is_https()?'https':'').$key.VERSION.'js');

        return array('etag'=>$key,'last_mod'=>$last_mod);
    }
    public function get_js_content($head,$host='') {
        $tag  = $host.$head['etag'];
        $content = '';
        if(KIRK::get_instance()->get_config("cache")) {
            $cache = KIRK::get_instance()->get_cache();
            $result = $cache->get($tag);
            if ($result) {
                KIRK::get_instance()->get_response()->header('from_mem', 1);
                $content =  $result;
                echo $content;
            }
        }
        if(!$content){
            $called = get_called_class();
            $common_js_list = $called::get_js_list();
            //插件内的js
            $called = get_called_class();
            $plugin_list = $called::get_plugin();
            $plugin_js_list = array();
            foreach ($plugin_list as $key => $plugin) {
                $real_name = $plugin.'Plugin';
                $js_list = $real_name::get_js_list();
                foreach($js_list as $v) {
                    $plugin_js_list[] = $v;
                }
            }
            $this->begain_script_block();
            foreach($common_js_list as $v) {
                $this->include_template($v,'view','js');
                echo ';';echo PHP_EOL;
            }
            foreach($plugin_js_list as $v) {
                $this->include_template($v,'plugin','js');
                echo ';';echo PHP_EOL;
            }
            $this->end_script_block();
            $content = implode('', $this->script_blocks);
            if (KIRK::get_instance()->get_config('compress_js')) {
                $url = KIRK::get_instance()->get_config('compress_server');
                $post_data = array('js' => $content);
                $query = http_build_query([
                    'key'=>$tag
                ]);
                $c = GlobalFun::post($url.'?'.$query, $post_data);
                if($c) {
                    $content = $c;
                }
            }
            if(KIRK::get_instance()->get_config("cache")) {
                $cache = KIRK::get_instance()->get_cache();
                $cache->set($tag, $content, 0);
            }
            echo $content;
        }

    }
    private $dependence_js_list = array();

    public function require_js($js){
        if(!$this->dependence_js_list[$js]) {
            echo PHP_EOL.'//dependence:' . $js . PHP_EOL;
            $this->include_template($js, 'view', 'js');
            $this->dependence_js_list[$js] = 1;
        } else {
            echo PHP_EOL.'//repeat_dependence:' . $js . PHP_EOL;
        }
    }


    private $dependence_css_list = array();
    public function require_css($css){
        if(!$this->dependence_css_list[$css]) {
            echo PHP_EOL.'//dependence:' . $css . PHP_EOL;
            $this->include_template($css, 'view', 'css');
            $this->dependence_css_list[$css] = 1;
        } else {
            echo PHP_EOL.'//repeat_dependence:' . $css . PHP_EOL;
        }
    }


    //为了把script的执行代码全部放在最后，so
    public function begain_script_block() {
        ob_start();
    }
    public function end_script_block() {
        $this->add_script_blocks(ob_get_contents());
        ob_end_clean();
    }
    private $script_blocks = array();
    public function add_script_blocks($str) {
        $this->script_blocks[] = $str;
    }
    public function write_script_blocks() {
        foreach($this->script_blocks as $v) {
            echo $v;
        }
    }

    public function write_script_blocks_with_out_script_tag() {
        foreach($this->script_blocks as $v) {
            echo strip_tags($v);
        }
    }

    public static function render_template($path,$data){
        $template_content = file_get_contents( $path);
        return  preg_replace_callback('/\{\$([^}]+)\}/',function($matches) use($data) {
            return $data[$matches[1]];
        },$template_content);
    }
}