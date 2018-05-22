# Kirk
自己琢磨的一套框架。

## 框架运行流程：
1. 入口文件
2. 定义常量（框架所带的目录或者是函数库、第三方类库所带的目录）
3. 引入函数库
4. 自动加载类（自动加载一些文件）
5. 启动框架
6. 路由解析（路由类，解析url）
7. 加载控制器（通过路由解析的url找到所需加载的控制器和方法）
8. 返回结果（通过运算，返回需要的结果）

## 公共模块

### 公共函数function.php
* p方法，输出对应的变量或者数组,p($var)
* 二分查找,bin_sch($array,$low,$high,$k)
* 顺序查找（数组里查找某个元素）,seq_sch($array, $n,  $k)
* 线性表的删除（数组中实现） ,delete_array_element($array , $i)
* 冒泡排序（数组排序）,bubble_sort($array)
* 快速排序（数组排序）,quick_sort($array)

#### PHP内置字符串函数实现  
* 字符串长度 ,strlen ($str)
* 截取子串,substr($str, $start, $length=NULL)  
* 字符串翻转,strrev($str)
* 字符串比较,strcmp($s1,  $s2)  
* 查找字符串,strstr($str, $substr)
* 字符串替换,str_replace($substr , $newsubstr, $str)  

#### 自实现字符串处理函数 
* 插入一段字符串, str_insert($str, $i , $substr)  
* 删除一段字符串, str_delete($str , $i, $j)  
* 复制字符串, strcpy($s1, $s2 ) 
* 连接字符串, strcat($s1 , $s2) 
* 简单编码函数（与php_decode函数对应）, php_encode($str)
* 简单解码函数（与php_encode函数对应）, php_decode($str)
* 简单加密函数（与php_decrypt函数对应）, php_encrypt($str)  
* 简单解密函数（与php_encrypt函数对应）, php_decrypt($str) 

#### 微信公众号授权相关的轮子
* 先填入公众号的token、appid、appsecret、indexurl，然后在需要授权的地方调用授权函数Auth()即可。

### 短链接生成算法short_url.php
```
//测试  
$url = "http://huangkuankuan.cn/projects/";
$short = new \core\common\short_url::short($url);
print_r($short);
```
