<?php
$common_conf = include('./Conf/include.php');

$conf = array(
    'DEFAULT_FILTER' => 'htmlspecialchars,trim',
);

return array_merge($common_conf, $conf);
