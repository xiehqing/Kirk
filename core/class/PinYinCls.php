<?php
/**
 * Created by PhpStorm.
 * User: kuan
 * Date: 18-9-26
 * Time: 下午6:56
 */
namespace core;
use Overtrue\Pinyin\Pinyin;
class PinYinCls {
    const LITTLE_MEM_TYPE = 1;      // 小内存型: 将字典分片载入内存
    const MEM_TYPE = 2;             // 内存型: 将所有字典预先载入内存
    const IO_TYPE = 3;              // I/O型: 不载入内存，将字典使用文件流打开逐行遍历并运用php5.5生成器(yield)特性分配单行内存

    const PINYIN_DEFAULT = 1;       // 不带音标，默认
    const PINYIN_TONE = 2;          // 带音标
    const PINYIN_ASCII_TONE = 3;    // 带数字表示的音标

    const PINYIN_KEEP_NUMBER = 1;   // 保持数字
    const PINYIN_KEEP_ENGLISH = 2;  // 保持英文

    /**
     * 根据loaderName选择类型进行实例化
     * @param $loaderName
     * @return Pinyin
     */
    public function choseLoaderName($loaderName){
        // 选择需要实例化的类型($loaderName)
        if ($loaderName == self::MEM_TYPE){
            // 内存型
            $pinyin = new Pinyin('Overtrue\Pinyin\MemoryFileDictLoader');
        }
        else if ($loaderName == self::IO_TYPE){
            // I/O型
            $pinyin = new Pinyin('Overtrue\Pinyin\GeneratorFileDictLoader');
        }else{
            // 小内存型
            $pinyin = new Pinyin(); // 默认
        }
        return $pinyin;
    }

    /**
     * 将中文字符串转化为拼音数组
     * @param $loaderName
     * @param $option
     * @param $chinese
     * @return array
     */
    public function pinyinArray($loaderName,$option,$chinese){
        // 选择需要实例化的类型($loaderName)
        $pinyin = $this->choseLoaderName($loaderName);

        // 选择解码出来的类型 $option
        if ($option == self::PINYIN_TONE){
//            $result = $pinyin->convert('带着希望去旅行，比到达终点更美好', PINYIN_TONE);
            $result = $pinyin->convert($chinese, PINYIN_TONE);
            // ["dài","zhe","xī","wàng","qù","lǚ","xíng","bǐ","dào","dá","zhōng","diǎn","gèng","měi","hǎo"]
        }
        elseif ($option == self::PINYIN_ASCII_TONE){
//            $result = $pinyin->convert('带着希望去旅行，比到达终点更美好', PINYIN_ASCII_TONE);
            $result = $pinyin->convert($chinese, PINYIN_ASCII_TONE);
            //["dai4","zhe","xi1","wang4","qu4","lyu3","xing2","bi3","dao4","da2","zhong1","dian3","geng4","mei3","hao3"]
        }else{
//            $result = $pinyin->convert('带着希望去旅行，比到达终点更美好');
            $result = $pinyin->convert($chinese);
            // ["dai", "zhe", "xi", "wang", "qu", "lyu", "xing", "bi", "dao", "da", "zhong", "dian", "geng", "mei", "hao"]
        }
        return $result;
    }

    /**
     * 生成用于链接的拼音字符串
     * @param $loaderName
     * @param string $delimiter
     * @param $chinese
     * @return string
     */
    public function pinyinStringLinked($loaderName,$delimiter="",$chinese){
        // 选择需要实例化的类型($loaderName)
        $pinyin = $this->choseLoaderName($loaderName);

        // 选择解码出来的类型 $option
        if ($delimiter){
            $result = $pinyin->permalink($chinese, '.'); // dai.zhe.xi.wang.qu.lyu.xing
//            $result = $pinyin->permalink('带着希望去旅行', '.'); // dai.zhe.xi.wang.qu.lyu.xing
        }else{
            $result = $pinyin->permalink($chinese); // dai-zhe-xi-wang-qu-lyu-xing
//        $result = $pinyin->permalink('带着希望去旅行'); // dai-zhe-xi-wang-qu-lyu-xing

        }

        return $result;
    }

    /**
     * 获取首字符字符串
     * @param $loaderName
     * @param string $delimiter
     * @param $chinese
     * @return string
     */
    public function pinyinFirstChar($loaderName,$delimiter="",$chinese){
        // 选择需要实例化的类型($loaderName)
        $pinyin = $this->choseLoaderName($loaderName);

        if ($delimiter){
            if ($delimiter == self::PINYIN_KEEP_NUMBER){
                // 有数字
                $result = $pinyin->abbr($chinese, PINYIN_KEEP_NUMBER); // nh2018
//                $result = $pinyin->abbr('你好2018！', PINYIN_KEEP_NUMBER); // nh2018
            }
            elseif ($delimiter == self::PINYIN_KEEP_ENGLISH){
                // 有英文
                $result = $pinyin->abbr($chinese, PINYIN_KEEP_ENGLISH); // HNY2018
//                $result = $pinyin->abbr('Happy New Year! 2018！', PINYIN_KEEP_ENGLISH); // HNY2018
            }
            else{
                // 默认分割符-
                $result = $pinyin->abbr($chinese, '-'); // d-z-x-w-q-l-x
//                $result = $pinyin->abbr('带着希望去旅行', '-'); // d-z-x-w-q-l-x
            }
        }
        else{
            // 没有分割符
            $result = $pinyin->abbr($chinese); // dzxwqlx
//            $result = $pinyin->abbr('带着希望去旅行'); // dzxwqlx
        }
        return $result;
    }

    /**
     * 翻译整段文字为拼音(将会保留中文字符：，。 ！ ？ ： “ ” ‘ ’ 并替换为对应的英文符号。)
     * @param $loaderName
     * @param $option
     * @param $chinese
     * @return string
     */
    public function pinyinPaper($loaderName,$option,$chinese){
        // 选择需要实例化的类型($loaderName)
        $pinyin = $this->choseLoaderName($loaderName);

        // 选择解码出来的类型 $option
        if ($option == self::PINYIN_TONE){
//            $result = $pinyin->sentence('带着希望去旅行，比到达终点更美好', PINYIN_TONE);
            $result = $pinyin->sentence($chinese, PINYIN_TONE);
            // dài zhe xī wàng qù lǚ xíng, bǐ dào dá zhōng diǎn gèng měi hǎo!
        }
        elseif ($option == self::PINYIN_ASCII_TONE){
//            $result = $pinyin->sentence('带着希望去旅行，比到达终点更美好', PINYIN_ASCII_TONE);
            $result = $pinyin->sentence($chinese, PINYIN_ASCII_TONE);
            //dai4 zhe xi1 wang4 qu4 lyu3 xing2 bi3 dao4 da2 zhong1 dian3 geng4 mei3 hao3!
        }else{
//            $result = $pinyin->sentence('带着希望去旅行，比到达终点更美好!');
            $result = $pinyin->sentence($chinese);
            // dai zhe xi wang qu lyu xing, bi dao da zhong dian geng mei hao!
        }
        return $result;
    }

    /**
     * 翻译姓名(姓名的姓的读音有些与普通字不一样，比如 ‘单’ 常见的音为 dan，而作为姓的时候读 shan。)
     * @param $loaderName
     * @param $option
     * @param $chinese
     * @return array
     */
    public function pinyinName($loaderName,$option,$chinese){
        // 选择需要实例化的类型($loaderName)
        $pinyin = $this->choseLoaderName($loaderName);

        // 选择解码出来的类型 $option
        if ($option == self::PINYIN_TONE){
//            $result = $pinyin->name('单某某', PINYIN_TONE); // ["shàn","mǒu","mǒu"]
            $result = $pinyin->name($chinese, PINYIN_TONE);
        }
        elseif ($option == self::PINYIN_ASCII_TONE){
//            $result = $pinyin->name('单某某', PINYIN_ASCII_TONE); // ["shan4","mou3","mou3"]
            $result = $pinyin->name($chinese, PINYIN_ASCII_TONE);
        }else{
//            $result = $pinyin->name('单某某'); // ['shan', 'mou', 'mou']
            $result = $pinyin->name($chinese);
        }
        return $result;

    }


}