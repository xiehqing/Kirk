<?php

# 加载资源的路由
$config['router']['Resource'] = array(
    '^\/([a-z]+)\/resource\/([a-z]+)\/(.+)\.(css|js)$',
);
# 缓存的路由
$config['router']['Cache'] = array(
    '^\/cache$'
);

$config['router']['Browser'] = array(
    '^\/browser$'
);
$config['router']['CrossDomainJs'] = array(
    '^\/crossdomainjs'
);
# 验证码路由
$config['router']['Code'] = array(
    '^\/checkcode'
);
$config['router']['Beta'] = array(
    '^\/beta'
);
