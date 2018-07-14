<?php

kirk_require_ctrl("Ctrl");

class ResourceCtrl extends Ctrl {
    private $code_logo = '//                            _ooOoo_    
//                           o8888888o    
//                           88" . "88    
//                           (| -_- |)    
//                            O\ = /O    
//                        ____/`---\'\____    
//                      .   \' \\| |// `.    
//                       / \\||| : |||// \    
//                     / _||||| -:- |||||- \    
//                       | | \\\ - /// | |    
//                     | \_| \'\'\---/\'\' | |    
//                      \ .-\__ `-` ___/-. /    
//                   ___`. .\' /--.--\ `. . __    
//                ."" \'< `.___\_<|>_/___.\' >\'"".    
//               | | : `- \`.;`\ _ /`;.`/ - ` : | |    
//                 \ \ `-. \_ __\ /__ _/ .-` / /    
//         ======`-.____`-.___\_____/___.-`____.-\'======    
//                            `=---=\'    
//    
//         .............................................    
//                  佛祖保佑             永无BUG';
    public function run() {
        $request = KIRK::get_instance()->get_request();
        //强制关掉debug,防止出错
        $request->is_debug = false;
        $response = KIRK::get_instance() -> get_response();
        $matchs = KIRK::get_instance() -> get_request() -> get_matchs();
        $location = $matchs[1];
        $type = $matchs[2];
        $class = $matchs[3];

        if(strpos($class,'/')!==false) {
            $class = str_replace('/','\\',$class);
        }


        $content_type = $type == 'css' ? 'text/css' : 'application/x-javascript';
        KIRK::get_instance() -> get_response() -> header('Content-Type', $content_type. '; charset=utf-8');
        kirk_require_view($class);
        $class_name = $class . 'View';

        if(!class_exists($class_name)) {
            return false;
        }

        $view = new $class_name();
        if ($type == 'css') {
            $head = $view->get_css_header();
            $etag = $head['etag'];
            $last_mod = $head['last_mod'];
            $response->header('ETag', $etag);


            if(!KIRK::get_instance()->get_config('cache')) {
                $response->header('Cache-Control', 'no-cache');
            }


            $response->header('Last-Modified', gmdate('D, d M Y H:i:s', $last_mod) . ' GMT');
            if ((isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $last_mod)
                || (isset($_SERVER['HTTP_IF_UNMODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_UNMODIFIED_SINCE']) < $last_mod)
                || (isset($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] == $etag)) {
                header("HTTP/1.1 304 Not Modified");
                exit(0);
            } else {
                echo "/*\n\n";
                echo $this->code_logo;
                echo "\n\n\n*/";
                echo $view->get_css_content($head,$request->get_domain());
            }
        } else if ($type == 'js') {
            $head = $view -> get_js_content_header();
            $etag = $head['etag'];
            $last_mod = $head['last_mod'];
            $response->header('ETag', $etag);

            if(!KIRK::get_instance()->get_config('cache')) {
                $response->header('Cache-Control', 'no-cache');
            }
            $response->header('Last-Modified', gmdate('D, d M Y H:i:s', $last_mod) . ' GMT');
            if ((isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $last_mod)
                || (isset($_SERVER['HTTP_IF_UNMODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_UNMODIFIED_SINCE']) < $last_mod)
                || (isset($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] == $etag)) {
                header("HTTP/1.1 304 Not Modified");
                exit(0);
            } else {
                echo "/*\n\n";
                echo $this->code_logo;
                echo "\n\n\n*/";
                echo $view -> get_js_content($head,$request->get_domain());
            }
        }
    }

}
