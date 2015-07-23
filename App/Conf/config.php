<?php
$common_conf = include('./Conf/include.php');

$conf = array(
    'DEFAULT_FILTER' => 'htmlspecialchars,trim',
    'ROUTER_TABLE' => 'router',
);

return array_merge($common_conf, $conf);
