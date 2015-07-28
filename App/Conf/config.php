<?php
$common_conf = include('./Conf/include.php');

$conf = array(
    'DEFAULT_FILTER' => 'htmlspecialchars,trim',
    'ROUTER_TABLE' => 'router',
    'TMPL_PATH' => TMPL_PATH.$common_conf['APP_DEFAULT_THEME'],
);

return array_merge($common_conf, $conf);
