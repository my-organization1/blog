<?php
//核心配置文件目录
defined('PUBLIC_CONF_PATH') or define('PUBLIC_CONF_PATH', dirname(__FILE__));

//加载Conf文件文件列表
$fileList = scandir(PUBLIC_CONF_PATH);
$fileList = array_filter($fileList, function($v){
    $in = array('.','..',basename(__FILE__));
    if(in_array($v,$in)){
        return false;
    }
    return true;
});

//加载配置文件
$conf = array();
if (!empty($fileList)) {
    foreach($fileList as $_k=>$_v){
        $path = PUBLIC_CONF_PATH.'/'.$_v;
        $conf = array_merge($conf,require_once($path));
    }
}

return $conf;
