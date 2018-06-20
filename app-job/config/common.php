<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-20
 * Time: 上午9:41
 */

$config['location'] = '/job';

$config['logQueueOpen'] = 1; //1-代表开启日志记录；０－代表关闭日志记录

$config['release_email'] = array(
    // 此处只做示例（非真实配置信息），请自行修改相应配置信息
    'mail_host' => 'smtphm.qiye.163.com',
    'mail_user' => 'noreply@kirk.com',
    'mail_pass' => 'kirk',
    'sender' => 'noreply@kirk.com',
    'sender_name' => 'kirk',
    'receivers' => 'kuan@kirk.com',
);