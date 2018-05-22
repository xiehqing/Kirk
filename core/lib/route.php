<?php
namespace core\lib;
use core\lib\conf;
class route
{
        public $ctrl;
        public $action;
        public function __construct()
        {
                // xxx.com/index/index
                // xxx.com/index.php/index/index
                /**
                 * 1.隐藏index.php(根据web服务器不同的反向代理服务进行配置)
                 * 2.获取到URL 的参数部分(通过打印$_server查看REQUEST_URI是否存在)
                 * 3.返回对应控制器和方法
                 */
                // p($_SERVER['REQUEST_URI']);
                if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != '/') {
                        # 解析 /index/index
                        $path = $_SERVER['REQUEST_URI'];
                        $patharr =  explode('/', trim($path,'/'));
                        // 打印分割好的控制器和方法
                        // p($patharr);
                        // 还需处理一种情况，如果url中只输入控制器，没有输入方法
                        if (isset($patharr[0])) {
                                $this->ctrl = $patharr[0];
                                // 卸载掉该参数，为后面获取get参数做准备
                                unset($patharr[0]);
                        }
                        if (isset($patharr[1])) {
                                $this->action = $patharr[1];
                                // 卸载掉该参数，为后面获取get参数做准备
                                unset($patharr[1]);
                        } else {
                                // $this->action = conf::$conf;
                            $this->action = conf::get('ACTION','route');
                        }
                        // 把url中的多余部分转换成get参数
                        // index/index/id/1/...
                        // p($patharr);
                        // 先判断$patharr数组当中有多少位
                        $count = count($patharr);
                        $i = 2;
                        while ($i < $count+2) {
                                if (isset($patharr[$i + 1])) {
                                        $_GET[$patharr[$i]] = $patharr[$i+1];
                                }
                                $i = $i + 2;
                        }
                        // p($_GET);
                } else {
                        // 默认情况下，我们的控制器和方法都是index
                        $this->ctrl = conf::get('CTRL','route');
                        $this->action = conf::get('ACTION','route');

                }
	}

}