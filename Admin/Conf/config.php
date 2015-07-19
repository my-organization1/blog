<?php
$common_conf = include('./Conf/include.php');

$conf = array(
    'DEFAULT_FILTER' => 'htmlspecialchars,trim',
    '__PUBLIC__' => __ROOT__.'/Public',
    'ADMIN_TITLE' => '博客系统后台登录模板',
    'APP_AUTOLOAD_PATH' =>'ORG',
    'DEFAULT_THEME' => ''
);

return array_merge($common_conf, $conf);
