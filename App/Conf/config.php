<?php
$common_conf = include('./Conf/include.php');

$conf = array(
    'URL_MODEL' => 2,
    'DEFAULT_FILTER' => 'htmlspecialchars,trim',
    'ROUTER_TABLE' => 'router',
    'APP_AUTOLOAD_PATH' =>'ORG',
    'TMPL_PATH' => __ROOT__.'/'.TMPL_PATH.$common_conf['APP_DEFAULT_THEME'],
);

return array_merge($common_conf, $conf);
