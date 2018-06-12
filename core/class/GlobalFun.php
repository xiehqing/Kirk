<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-11
 * Time: 下午5:53
 */

class GlobalFun{

    /**
     * 获取拼音信息
     * @access public
     * @param string $str 字符串
     * @param int $ishead 是否为字母
     * @return string
     */
    public static function pinyin($str, $ishead = 0){
        $str = iconv('utf-8','gb18030',$str);
        $pinyins = array();
        $restr = '';
        $str = trim($str);
        $slen = strlen($str);
        if($slen < 2){
            return $str;
        }
        if (count($pinyins) == 0) {
            $list_str = KIRK::get_instance()->get_config('pinyin', 'pinyin');
            $list_pinyin = explode("\n", $list_str);
            foreach ($list_pinyin as $line) {
                $line = iconv('utf-8', 'gb18030', $line);
                $pinyins[$line[0] . $line[1]] = substr($line, 3, strlen($line) - 3);
            }
        }
        for ($i = 0; $i < $slen; $i++) {
            if (ord($str[$i]) > 0x80) {
                $c = $str[$i] . $str[$i + 1];
                $i++;
                if (isset($pinyins[$c])) {
                    if ($ishead == 0) {
                        $restr .= $pinyins[$c];
                    } else {
                        $restr .= $pinyins[$c][0];
                    }
                } else {
                    $restr .= "_";
                }
            } else if (preg_match("/[a-z0-9]/i", $str[$i])) {
                $restr .= $str[$i];
            } else {
                $restr .= "_";
            }
        }
        return $restr;
    }

    /**
     * 截取字符串
     * @param String $str
     * @param Integer $len
     * @param $ext String
     * @return String
     * */
    public static function cut_string($str, $len, $ext = '') {
        return mb_substr($str, 0, $len, 'utf-8') . $ext;
    }

    /**
     * 签名函数
     * @param $str
     * @return string
     */
    public static function sign($str) {
        $signature = KIRK::get_instance()->get_config('signature');
        return md5($str . $signature);
    }

    /**
     * 生成一个关于用户的key
     * @param $type String
     * @return String
     * */
    public static function build_user_key($type) {
        $guid = KIRK::get_instance()->get_request()->get_guid();
        return md5($type . $guid);
    }

    /**
     * 隐藏身份证,手机号
     * @param $content
     * @return null|string|string[]
     */
    public static function hide_card_phone($content) {
        $content = preg_replace_callback('/\d{17,17}[xX\d]/i', function () {
            return '**************';
        }, $content);

        $content = preg_replace_callback('/\d{15,15}/i', function () {
            return '**************';
        }, $content);

        $content = preg_replace_callback('/1(3|4|5|7|8)\d{9}/', function () {
            return '**************';
        }, $content);

        return $content;
    }

    /**
     * 支持富文本的过滤防xss函数
     * @param $html_string
     * @return mixed|null|string|string[]
     */
    public static function no_xss($html_string) {
        //第一步过滤script标签
        $reg1 = "/<\/*script[^>]*>/i";
        //忽略大小写
        while (preg_match($reg1, $html_string)) {
            $html_string = preg_replace($reg1, '', $html_string);
        }
        //第二步过滤 expression
        $reg2 = "/expression/i";
        while (preg_match($reg2, $html_string)) {
            $html_string = preg_replace($reg2, '', $html_string);
        }
        //第三步 过滤属性 onerror onload
        $reg3 = "/ (on[a-zA-Z]+)/i";
        while (preg_match($reg3, $html_string)) {
            $html_string = preg_replace($reg3, ' ', $html_string);
        }
        //第四步 过滤协议类型 src=jav scr="" href="" href=
        $reg4 = "/(href|src) *\= *('|\"){0,1}([^>^ ^\"^']+)('|\"){0,1}/i";
        preg_match_all($reg4, $html_string, $result);
        $url_list = $result[3];
        foreach ($url_list as $v) {
            if (!preg_match("/^http\:\/\//i", $v)) {
                $html_string = str_replace($v, '', $html_string);
            }
        }
        //第五步 过滤 link标签
        $reg5 = "/<\/*link[^>]*>/i";
        //忽略大小写
        while (preg_match($reg5, $html_string)) {
            $html_string = preg_replace($reg5, '', $html_string);
        }
        //第六步 过滤iframe 标签
        $reg6 = "/<\/*iframe[^>]*>/i";
        //忽略大小写
        while (preg_match($reg6, $html_string)) {
            $html_string = preg_replace($reg6, '', $html_string);
        }
        return $html_string;
    }

    public static function post_str($url, $str, $header = array()) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $str);
        if($header){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        if(DIRECTORY_SEPARATOR=='\\'){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143');
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public static function get($url,$header=array(),$time_out=-1,$connect_out=-1) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, false);
        if($header){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        if($time_out>-1) {
            curl_setopt($ch, CURLOPT_TIMEOUT,$time_out);
        }
        if($connect_out>-1) {
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,$connect_out);
        }
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143');
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public static function post($url, $datas,$time_out=-1,$connect_out=-1) {
        $c = http_build_query($datas);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $c);
        if($time_out>-1) {
            curl_setopt($ch, CURLOPT_TIMEOUT,$time_out);
        }
        if($connect_out>-1) {
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,$connect_out);
        }
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143');
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
    /**
     * @param $image_path
     * @param $url
     * @return array
     */
    public static function post_file($image_path, $url) {
        $ch = curl_init();
        $data = array('file' => new CURLFile($image_path));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }

    /**
     * @desc 获取一个随机字符串
     * @return bool|string
     */
    public static function get_salt() {
        return substr(md5(microtime()), rand(1, 30), 6);
    }

    /**
     * @desc 密码签名
     * @param $password
     * @param $salt
     * @return string
     */
    public static function sign_password($password, $salt) {
        return md5($password . $salt);
    }

    /**
     * @desc 检查邮箱格式
     * @param $email
     * @return bool
     */
    public static function check_email($email) {
        if (preg_match('/^[0-9a-z][a-z0-9\._-]{1,}@[a-z0-9-]{1,}[a-z0-9]\.[a-z\.]{1,}[a-z]$/i', $email)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 检查手机号码
     * @param $phone
     * @return bool
     */
    public static function check_phone($phone) {
        if (preg_match('/^(\+86)|(86)?(\d{11})$/', $phone)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 上传base64文件
     * @param $data
     * @return mixed|string
     */
    public static function upload_base64_file($data) {
        if(empty($data)) return '';
        $data = str_replace('data:image/png;base64,','',$data);
        $url = KIRK::get_instance()->get_config('uploadbase64');
        return self::post($url,array('file_data'=>$data));
    }

    /**
     * 通过url上传文件
     * @param $url
     * @param int $time_out
     * @param int $connect_out
     * @return mixed|string
     */
    public static function upload_url($url,$time_out=-1,$connect_out=-1) {
        if(empty($url)) return '';
        $upload_domain = KIRK::get_instance()->get_config('uploadurl');
        $data = '?url='.$url;
        $url = $upload_domain.$data;
        return self::get($url,array(),$time_out,$connect_out);
    }

    /**
     * 二维数组的快排(可指定key名)
     * @param $arr
     * @param $key_name
     * @return bool
     */
    public static function quick_sort_by_key($arr, $key_name, $sequence = 'asc') {
        if (!is_array($arr)) {
            return false;
        }
        $length = count($arr);
        if ($length <= 1) {
            return $arr;
        }

        $base_num = $arr[0];

        if (!isset($base_num[$key_name])) {
            return false;
        }

        $left_arr = array();
        $right_arr = array();

        for ($i = 1; $i < $length; $i++) {
            if ($sequence == 'asc') {
                if ($base_num[$key_name] > $arr[$i][$key_name]) {
                    $left_arr[] = $arr[$i];
                } else {
                    $right_arr[] = $arr[$i];
                }
            } else {
                if ($base_num[$key_name] < $arr[$i][$key_name]) {
                    $left_arr[] = $arr[$i];
                } else {
                    $right_arr[] = $arr[$i];
                }
            }
        }

        $left_arr = self::quick_sort_by_key($left_arr, $key_name, $sequence);
        $right_arr = self::quick_sort_by_key($right_arr, $key_name, $sequence);

        return array_merge($left_arr, array($base_num), $right_arr);
    }
    public static function quick_sort_by_property($arr, $key_name, $sequence = 'asc') {
        if (!is_array($arr)) {
            return false;
        }
        $length = count($arr);
        if ($length <= 1) {
            return $arr;
        }

        $base_num = $arr[0];

        if (!isset($base_num->$key_name)) {
            return false;
        }

        $left_arr = array();
        $right_arr = array();

        for ($i = 1; $i < $length; $i++) {
            if ($sequence == 'asc') {
                if ($base_num->$key_name > $arr[$i]->$key_name) {
                    $left_arr[] = $arr[$i];
                } else {
                    $right_arr[] = $arr[$i];
                }
            } else {
                if ($base_num->$key_name < $arr[$i]->$key_name) {
                    $left_arr[] = $arr[$i];
                } else {
                    $right_arr[] = $arr[$i];
                }
            }
        }

        $left_arr = self::quick_sort_by_property($left_arr, $key_name, $sequence);
        $right_arr = self::quick_sort_by_property($right_arr, $key_name, $sequence);

        return array_merge($left_arr, array($base_num), $right_arr);
    }

    /**对象转数组
     * @param  object $array 要转化的object
     * @return array 转化后的array
     */
    public static function object_array($array) {
        if (is_a($array, 'MongoDB\BSON\UTCDateTime')) {
            $date = $array->toDateTime()->getTimestamp();
            $array = date('Y-m-d', $date);
        }
        if (is_object($array)) {
            $array = (array)$array;
        }
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $array[$key] = self::object_array($value);
            }
        }
        return $array;
    }

    public static function time_ago($time) {
        $t = time() - $time;
        $f = array(
            '31536000' => '年',
            '2592000' => '个月',
            '604800' => '星期',
            '86400' => '天',
            '3600' => '小时',
            '60' => '分钟',
            '1' => '秒'
        );
        foreach ($f as $k => $v) {
            if (0 != $c = floor($t / (int)$k)) {
                return $c . $v . '前';
            }
        }
    }

    public static function get_random_string($length) {
        $alphabet = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
        $max_num = count($alphabet) - 1;
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $random_num = mt_rand(0, $max_num);
            $str .= $alphabet[$random_num];
        }
        return $str;
    }

    public static function get_random_num($length) {
        $num_list = range(0, 9);
        $max_num = count($num_list) - 1;
        $res = '';
        for ($i = 0; $i < $length; $i++) {
            $random_key = mt_rand(0, $max_num);
            $res .= $num_list[$random_key];
        }
        return $res;
    }

    /**
     * @param $capital
     * @param string $encoding
     * @return mixed
     */
    public static function mongo_capital_format($capital,$encoding='utf8'){
        $capital = preg_replace_callback('/[\d\.]+/', function ($matches) use ($capital) {
            return round($matches[0], 2);
        }, $capital);
        return $capital;
    }

    /**
     * base64转换
     */
    public static function debase64_url($base, $key = ''){
        $base = base64_decode($base);
        if($base){
            parse_str($base, $arr_base);
            if($key){
                return $arr_base[$key];
            }
            return $arr_base;
        }
        if($key){
            return '';
        }
        return array();
    }
    /**
     * @param $num
     * @return int
     */
    public static function intval32($num) {
        $num = $num & 0xffffffff;//消掉高32位

        $p = $num>>31; //取第一位 判断是正数还是负数
        if($p==1) { //负数
            $num = $num-1;
            $num = ~$num; //取反 会当成64位取反,算出来的数就去了,所以取反之后 要消掉 高32位
            $num = $num & 0xffffffff;
            return $num * -1;
        } else {
            return $num;
        }
    }
    public static function get_string_hash_code($str) {
        $h = 0;
        $off = 0;
        $len = strlen($str);
        for ($i = 0; $i < $len; $i++) {
            $h = self::intval32(self::intval32(31 * $h) + ord($str[$off++]));
        }
        return $h;
    }
    /**
     * 验证姓名是否为百家姓
     * @param  $user_name
     * @return boolean
     */
    public static function check_person_name($user_name)
    {
        if(2>mb_strlen($user_name)||mb_strlen($user_name)>5){
            return FALSE;
        }

        $surnames = KIRK::get_instance()->get_config('surname','surname');
        foreach($surnames as $surname){
            if(preg_match('/^'.$surname.'/',$user_name)){
                return TRUE;
            }
        }
        return FALSE;
    }

    public static function getMoneyRealYuanNumber($moneyStr) {
        $currency = 1;
        if(strpos($moneyStr,'美元')!==false) {
            $currency = 6.8;
        }

        preg_match_all('/^[^\d]*([\d\,\.\ ]+)(万)*/i', $moneyStr, $result);

        $money = $result[1][0];
        $money = str_replace(',','',$money);

        $danwei = $result[2][0];
        if (!($result[0][0])) {
            if ($moneyStr != '' && $moneyStr != 'None') {
            }
        } else {

        }
        if (trim($money)) {
            return $money * $currency*($danwei?10000:1);
        } else {
            return 0;
        }
    }

    public static function filter_html($str){
        $str = strip_tags($str);
        $str = str_replace(array("&nbsp;","&amp;nbsp;","\t","\r\n","\r","\n"),array("","","","","",""),$str);
        return $str;
    }

    /**
     * 验证身份证是否有效
     * @param string $IDCard 身份证号
     * @return bool
     */
    public static function validateIDCard($IDCard) {
        if (strlen($IDCard) == 18) {
            return self::check18IDCard($IDCard);
        } elseif ((strlen($IDCard) == 15)) {
            $IDCard = self::convertIDCard15to18($IDCard);
            return self::check18IDCard($IDCard);
        } else {
            return false;
        }
    }

    /**
     * 计算身份证的最后一位验证码,根据国家标准GB 11643-1999
     * @param $IDCardBody
     * @return bool|mixed
     */
    private static function calcIDCardCode($IDCardBody) {
        if (strlen($IDCardBody) != 17) {
            return false;
        }

        //加权因子
        $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
        //校验码对应值
        $code = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
        $checksum = 0;

        for ($i = 0; $i < strlen($IDCardBody); $i++) {
            $checksum += substr($IDCardBody, $i, 1) * $factor[$i];
        }

        return $code[$checksum % 11];
    }

    /**
     * 将15位身份证升级到18位
     * @param $IDCard
     * @return bool|string
     */
    private static function convertIDCard15to18($IDCard) {
        if (strlen($IDCard) != 15) {
            return false;
        } else {
            // 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码
            if (array_search(substr($IDCard, 12, 3), array('996', '997', '998', '999')) !== false) {
                $IDCard = substr($IDCard, 0, 6) . '18' . substr($IDCard, 6, 9);
            } else {
                $IDCard = substr($IDCard, 0, 6) . '19' . substr($IDCard, 6, 9);
            }
        }
        $IDCard = $IDCard . self::calcIDCardCode($IDCard);
        return $IDCard;
    }

    /**
     * 18位身份证校验码有效性检查
     * @param $IDCard
     * @return bool
     */
    private static function check18IDCard($IDCard) {
        if (strlen($IDCard) != 18) {
            return false;
        }

        $IDCardBody = substr($IDCard, 0, 17); //身份证主体
        $IDCardCode = strtoupper(substr($IDCard, 17, 1)); //身份证最后一位的验证码

        if (self::calcIDCardCode($IDCardBody) != $IDCardCode) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param array $arr 二维数组
     * @param string $keys 要排序的key
     * @param string $type 升序ASC 降序 DESC
     * @return array 返回排序后的数组
     */
    public static function array_sort($arr, $keys, $type = 'DESC')
    {
        $key_value = $new_array = array();
        foreach ($arr as $k => $v) {
            $key_value[$k] = $v[$keys];
        }
        if ($type == 'ASC') {
            asort($key_value);
        } else {
            arsort($key_value);
        }
        reset($key_value);
        foreach ($key_value as $k => $v) {
            $new_array[$k] = $arr[$k];
        }
        return $new_array;
    }
    /**
     * @param $xml_file 文件路径
     * @return mixed
     * xml文件转数组
     * 说明: 参数可以传文件路径,也可以传xml字符串,一定要符合xml标准格式,CDATA可有可无
     */
    public static function xml2Array($xml_file)
    {
        if (file_exists($xml_file)) {
            libxml_disable_entity_loader(false);
            $xml_string = simplexml_load_file($xml_file, 'SimpleXMLElement', LIBXML_NOCDATA);
        } else {
            libxml_disable_entity_loader(true);
            $xml_string = simplexml_load_string($xml_file, 'SimpleXMLElement', LIBXML_NOCDATA);
        }
        $arr = json_decode(json_encode($xml_string), true);
        return $arr;
    }
    /**
     * 判断终端类型
     * 0 - ios, 1 - android, 2 - other
     */
    public static function client_system()
    {
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
            return 0;
        }else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
            return 1;
        }else{
            return 2;
        }
    }

    /**
     * 获取客户端真实IP
     * @return string
     */
    public static function getClientIp() {
        // 先初始化ip
        $ip = 'unknow';
        // 几种可能存在的情况（代理，反向代理等等）
        $condition = array(
            'HTTP_CLIENT_IP',               //代理端的（有可能存在，可伪造）
            'HTTP_X_FORWARDED_FOR',         //用户是在哪个IP使用的代理（有可能存在，也可以伪造）
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'                   //访问端（有可能是用户，有可能是代理的）IP
        );
        foreach ($condition as $key) {
            // 如果在$_SERVER中存在$condition的key
            if (array_key_exists($key, $_SERVER)) {
                // 如果用的代理，就会存在多段用逗号隔开IP字符串，所以通过逗号分割成数组
                foreach (explode(',', $_SERVER[$key]) as $ip_tmp) {
                    //会过滤掉保留地址和私有地址段的IP，例如 127.0.0.1、内网负载均衡等IP都会被过滤，也为了安全（防注入,过滤掉构造的注入语句）
                    if ((bool) filter_var($ip_tmp, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                        $ip = $ip_tmp;
                        return $ip;
                    }
                }
            }
        }
        return $ip;
    }

    /**
     * p方法，输出对应的变量或者数组
     * @param $var
     */
    public static function p($var){
        if (is_bool($var)) {
            var_dump($var);
        } elseif (is_null($var)) {
            var_dump(NULL);
        } else {
            echo "<pre style='position:relative;z-index:1000;padding:10px;border-radius:5px;background:#F5F5F5;border:1px solid #aaa;font-size:14px;line-height:18px;opacity:0.9;'>". print_r($var,true) . "</pre>";
        }
    }



}