<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-11
 * Time: 下午1:43
 */

kirk_require_class('Request');
kirk_require_class('Response');

class KIRK{
    public $request;
    private $debug_list = array();
    public $debug = true;

    public function __construct(){
        set_error_handler("kirk_error_handler");
        $this->debug('kirk loaded');
    }

    public static $my;

    public static function get_instance(){
        if (!self::$my){
            self::$my = new KIRK();
        }
        return self::$my;
    }

    public function run(){
        KIRK::get_instance()->debug($_SERVER,'server');
        KIRK::get_instance()->debug($_REQUEST,'request');

        $time_start = microtime(1);

        $this->debug("request");
        if(!$this->request){
            $this->request = new Request();
        }
        $this->debug("response");
        if(!$this->response){
            $this->response = new Response();
        }

        $this->debug("get router");
        $uri = $this->request->get_uri_path();
        $this->debug($uri);
        $this->debug("get ctrl");
        $ctrl = $this->get_ctrl($uri);

        // 开始执行拦截器，为嘛在这？因为要在ctrl之前，而且需要用到request、response
        // 第一种，默认的拦截器，所有的类都要，但不能在except里
        $interceptor_config = $this->get_config('interceptor','interceptor');
        $default_interceptor = $interceptor_config['default'];
        if ($default_interceptor){
            foreach ($default_interceptor as $interceptor){
                if ($exceptions = $interceptor_config['exception'][$interceptor]){
                    if (in_array($ctrl,$exceptions)){
                        continue;
                    }
                }
                kirk_require_interceptor($interceptor);
                $interceptor = $interceptor.'Interceptor';
                if (class_exists($interceptor)){
                    $this->debug("run interceptor:".$interceptor);
                    $inter_obj = new $interceptor();
                    if ($inter_obj->go_next()){
                        continue;
                    }else{
                        $inter_obj->broken();
                        exit();
                    }
                }else{
                    continue;
                }
            }
        }

        //指定的拦截器
        $specialed_interceptor = $interceptor_config['specified'];
        if($intercepts = $specialed_interceptor[$ctrl]){
            foreach ($intercepts as $interceptor){
                kirk_require_interceptor($interceptor);
                if (class_exists($interceptor)) {
                    $this->debug("run interceptor:".$interceptor);
                    $inter_obj = new $interceptor();
                    if(!$inter_obj->go_next()){
                        $inter_obj->broken();
                    }else{
                        continue;
                    }
                }else{
                    continue;
                }
            }
        }


        $this->debug($ctrl);
        kirk_require_ctrl($ctrl);
        $ctrl .= 'Ctrl';
        $ctrls = new $ctrl();
        $this->debug("ctrl run");
        $c_s = microtime(1);
        $view = $ctrls->run();

        $this->debug('Ctrl time taked:'.(microtime(1)-$c_s).'s');
        if ($view){
            kirk_require_view($view);
            $view_name = $view.'View';
            $view = new $view_name;
            $this->debug('build html');
            $view->build_container();
        }
        $this->debug('All_time taked:'.(microtime(1)-$time_start).'s');
        $this->show_debug_message();
    }

    public function setRequest($request){
        $this->request = $request;
    }

    private function get_ctrl($uri) {
        $router = $this->get_config('router','router');

        foreach($router as $k=>$v) {
            foreach($v as $reg) {
                $reg = '/'.$reg.'/';
                if(preg_match_all($reg, $uri,$result)) {
                    $matchs = array();
                    foreach($result as $m) {
                        foreach($m as $ma) {
                            $matchs[] = $ma;
                        }
                    }
                    $this->request->set_matchs($matchs);
                    return $k;
                }

            }
        }
        return 'NotFound';
    }

    public function get_config($key,$file='common') {
        global $CONFIG_PATH;
        foreach($CONFIG_PATH as $k=>$v) {
            $config_path = $v.'/'.$file.'.php';
            if(file_exists($config_path)) {
                require $config_path;//局部变量，不能require_once噢
            }
        }
        return $config[$key];
    }
    public function setResponse($response) {
        $this->response = $response;
    }
    public function debug($str,$title='system') {
        if($this->debug) {
            $this->debug_list[] = array($str, $title);
        }
    }

    public function show_debug_message() {
        if($this->request->is_debug) {
            $t_head = '<table border=1 style="font-size:12px; margin-top:20px; width:400px; margin:30px;">';
            $t_head.='<tr><td style="border:1px solid black" colspan=2>RSF Debug Message:</td></tr>';


            foreach($this->debug_list as $data) {
                $str = $data[0];
                if(is_array($str)||is_object($str)) {
                    $str = '<pre>'.print_r($str,TRUE).'</pre>';
                }
                $title = $data[1];
                $t_head .= '<tr><td style="border:1px solid black;padding:0 5px 0 5px;">'.$title.'</td><td style="border:1px solid black"  >'.$str.'</td></tr>';
            }
            $t_end = '</table>';
            $t_head.=$t_end;
            echo $t_head;
        }
    }
    private $pdo_list = array();
    /**
     * 获取一个pdo实例
     * @param $config array
     * @return Object Pdo
     * */
    public function get_pdo($config) {
        $key = md5($config['db'].$config['host'].$config['port'].$config['user']);

        if($this->pdo_list[$key]) {
            return $this->pdo_list[$key];
        } else {
            $db_string = 'mysql:host='.$config['host'].';port='.$config['port'].';dbname='.$config['db'];
            $this->debug($db_string);
            try {
                $pdo  =  new PDO($db_string, $config['user'], $config['pass']);
            } catch  (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            $pdo->exec("SET CHARACTER SET utf8");
            $this->pdo_list[$key] = $pdo;
            return $pdo;
        }
    }
    /**
     * @desc 获取request对象
     * @return Request
     * */
    public function get_request() {
        return $this->request;
    }

    /**
     * @desc 获取request对象
     * @return Response
     * */
    public function get_response() {
        return $this->response;
    }

    private $memcache = null;
    /**
     * 获取memcache
     * @return MyMemcache
     * */
    public function get_memcache() {
        rsf_require_class('MyMemcache');
        if(!$this->memcache) {
            $this->memcache = new MyMemcache();
            $domain = $this->get_config('memcache');
            $domains = explode(':',$domain);
            $this->memcache->addServer($domains[0],intval($domains[1]));
        }
        return $this->memcache;
    }

    private $redis = null;
    /**
     * 获取memcache
     * @return MyRedis
     * */
    public function get_redis() {
        rsf_require_class('MyRedis');
        if(!$this->redis) {
            $this->redis = new MyRedis();
            //$domain = $this->get_config('redis');
            //$domains = explode(':',$domain);
            //$this->redis->connect($domains[0],intval($domains[1]));
            //if($domains[2]) {
            //    $this->redis->auth($domains[2]);
            //}
        }
        return $this->redis;

    }

    const CACHE_TYPE_REDIS = 1;
    const CACHE_TYPE_MEMCACHE = 2;
    const CACHE_TYPE_REDIS_CLUSTER = 3;


    public $cache_redis;
    public $cache_redis_cluster;
    /**
     * @return CacheInterface
     */
    public function get_cache(){
        $cache_type = $this->get_config("cache_type");
        if($cache_type==self::CACHE_TYPE_REDIS) {
            rsf_require_class('RedisCache');
            if(!$this->cache_redis) {
                $this->cache_redis = new RedisCache();
            }
            return $this->cache_redis;
        } elseif($cache_type==self::CACHE_TYPE_MEMCACHE) {
            return $this->get_memcache();
        } elseif($cache_type==self::CACHE_TYPE_REDIS_CLUSTER) {
            if(!$this->cache_redis_cluster) {
                $this->cache_redis_cluster = new RedisClusterCache();
            }
            return $this->cache_redis_cluster;
        }
    }

    private $redis_cluster;
    public function get_redis_cluster() {
        if(!$this->redis_cluster) {
            $this->redis_cluster = new RedisCluster(NULL, KIRK::get_instance()->get_config('redis_cluster'));
        }
        return $this->redis_cluster;
    }

    /**
     * @param array solr_config
     * @return SolrClient
     */
    public function get_solr($config) {
        $params = array(
            'hostname'=>$config['hostname'],
            'port'=>$config['port']);
        if($config['timeout']){
            $params['timeout'] = $config['timeout'];
        }
        $solr_client = new SolrClient($params);
        $solr_client->setServlet(SolrClient::SEARCH_SERVLET_TYPE,$config['db'].'/select');
        return $solr_client;
    }

    private $mongo_client_list = array();
    /**
     * @param string $uri mongodb://[username:password@]host1[:port1][,host2[:port2:],...]/db
     * @return MongoDB\Driver\Manager
     */
    public function get_mongo($uri) {
        if(!$this->mongo_client_list[$uri]) {
            $this->mongo_client_list[$uri]  = new MongoDB\Driver\Manager($uri,array(
                'readPreference'=>'secondary'
            ));
        }
        return $this->mongo_client_list[$uri];
    }
}