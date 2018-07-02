<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-11
 * Time: 下午3:38
 */

# 首页路由
$config['router']['Home\Index'] = array('^\/*$');

# 搜索路由 需要搜索的内容（文章、新闻、页面）
$config['router']['Home\Search'] = array('^\/search$');

$config['router']['Home\Api\ApiBase'] = array(
    '^\/home\/api$'
);
