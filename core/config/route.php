<?php
//===============================V1.0 版本===========已废弃============
//return array(
//	'CTRL'=>'index',
//	'ACTION'=>'index'
//);
//===============================V1.0 版本===========已废弃============

$config['router']['Resource'] = array(
    '^\/([a-z]+)\/resource\/([a-z]+)\/(.+)\.(css|js)$',
);

$config['router']['Cache'] = array(
    '^\/cache$'
);

$config['router']['Browser'] = array(
    '^\/browser$'
);
$config['router']['CrossDomainJs'] = array(
    '^\/crossdomainjs'
);
$config['router']['Code'] = array(
    '^\/checkcode'
);
$config['router']['Beta'] = array(
    '^\/beta'
);
