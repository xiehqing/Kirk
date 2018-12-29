<?php
namespace Core;
use KIRK;
/**
 * 短链接方法（此处用的redis加mysql进行存储）
 * Class ShortUrl
 */
class ShortUrl{
    public function __construct(){
        $this->redis = KIRK::get_instance()->get_redis();
    }

    public function dao(){
        return new \Dao\Home\ShortUrl();
    }

    /**
     * 通过短链接后面的key获取完整的长链接url
     * @param $short_key
     * @return mixed
     */
    public function get_url($short_key){
        $info = $this->dao()->get_single_by_where(array('key'=>$short_key));
        return $info['url'];
    }

    /**
     * 通过key值，统计自增
     * @param $short_key
     */
    public function incr($short_key){
        $update_data = array(
            'pv' => "pv+1"
        );

        $where = array(
            'key' => $short_key
        );
        $this->dao()->update_by_where($where, $update_data);
    }

    /**
     * 通过索引，生成key的方法
     * @param $index
     * @return mixed|string
     */
    public function get_key_from_index($index){
        $char_list = [
            '0','1','2','3','4','5','6','7','8','9',
            'a','b','c','d','e','f','g','h','i','j',
            'k','l','m','n','o','p','q','r','s','t',
            'u','v','w','x','y','z',
            'A','B','C','D','E','F','G','H','I','J',
            'K','L','M','N','O','P','Q','R','S','T',
            'U','V','W','X','Y','Z'];
//        if ($index==0){
//            return 0;
//        }
        if ($index<=count($char_list)){
            return $char_list[$index];
        }
        $result = '';
        while(true){
            $remain = $index%62;
            $result = $this->get_key_from_index($remain).$result;

            $index = intval($index/62);
            if ($index<62){
                $result = $this->get_key_from_index($index).$result;
                break;
            }
        }
        return $result;
    }

    /**
     * 向redis中塞入一个 short_url_index 并返回索引index，
     * 通过索引 index 去生成对应的key
     * @return mixed|string
     */
    public function get_one_key(){
        $redis = KIRK::get_instance()->get_redis();
        $index = $redis->incr('short_url_index');
        $s = $this->get_key_from_index($index);
        return $s;
    }

    /**
     * 该url存在，就返回短链接，
     * 不存在，就在数据库中生成相应的记录，再返回短链接
     * @param $type
     * @param $url
     * @return string
     */
    public function set_url($type, $url){
        $short_domain = KIRK::get_instance()->get_config('short_domain');

        $where = array(
            'url' => $url
        );
        $exist = $this->dao()->get_single_by_where($where);
        if ($exist){
            $short_url = "http://{$short_domain}/{$exist['key']}";
            return $short_url;
        }

        $short_key = $this->get_one_key();

        $data = array(
            'key' => $short_key,
            'type' => $type,
            'url' => $url
        );
        $this->dao()->insert($data);

        $short_url = "http://{$short_domain}/{$short_key}";
        return $short_url;
    }

    /**
     * 通过url列表，获取所有短链接表中的信息
     * @param $urls
     * @return array
     */
    public function get_info_by_urls($urls){
        $where = array(
            'url in ' =>$urls
        );
        return $this->dao()->get_by_where($where);
    }

    /**
     * 拼接短信模板的链接，只要返回url后面的key就可以，其他方法请不要调用！！！！！
     * @param $type
     * @param $url
     * @return string
     * @author kuan
     */
    public function set_url_return_key($type,$url){
        //检测是否已经存在
        $where = array(
            'url'=>$url
        );
        $exist = $this->dao()->get_single_by_where($where);
        if($exist) {
            return $exist['key'];
        }
        $short_key = $this->get_one_key();
        $data = array(
            'key' => $short_key,
            'type' => $type,
            'url' => $url,
        );
        $this->dao()->insert($data);
        // 只要返回key
        return $short_key;
    }
}