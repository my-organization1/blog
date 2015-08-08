<?php
function now()
{
    return TimeHelper::now();
}

/**
 * //还原正则路由,要在模板里使用，所以没有写到类里
 * @method RestoreRouter
 * @param  string        $rule 正则路由
 * @return  string       还原以后的链接
 */
function RestoreRule($rule)
{
    $rule = ltrim(trim($rule, '$/'), '/^');
    $rule = stripslashes($rule);

    return $rule;
}

//返回图片绝对路径
function realImgPath($path)
{
    return __ROOT__.ltrim($path,'.');
}
//清除html,空格,换行
function strip_html($str)
{
    $str = trim($str);
    $str = strip_tags($str, "");
    $str = ereg_replace("\t", "", $str);
    $str = ereg_replace("\r\n", "", $str);
    $str = ereg_replace("\r", "", $str);
    $str = ereg_replace("\n", "", $str);
    $str = ereg_replace(" ", " ", $str);
    return trim($str);
}

//兼容低版本array_column函数
if (!function_exists('array_column')) {
    function array_column(array $array, $columnKey, $indexKey = null)
    {
        $result = array();
        foreach ($array as $subArray) {
            if (!is_array($subArray)) {
                continue;
            } elseif (is_null($indexKey) && array_key_exists($columnKey, $subArray)) {
                $result[] = $subArray[$columnKey];
            } elseif (array_key_exists($indexKey, $subArray)) {
                if (is_null($columnKey)) {
                    $result[$subArray[$indexKey]] = $subArray;
                } elseif (array_key_exists($columnKey, $subArray)) {
                    $result[$subArray[$indexKey]] = $subArray[$columnKey];
                }
            }
        }
        return $result;
    }
}

/**
 * 字符串截取，支持中文和其他编码
 * @static
 * @access public
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * @return string
 */
function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = true)
{
    if (function_exists("mb_substr")) {
        $slice = mb_substr($str, $start, $length, $charset);
    } elseif (function_exists('iconv_substr')) {
        $slice = iconv_substr($str, $start, $length, $charset);
        if (false === $slice) {
            $slice = '';
        }
    } else {
        $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("", array_slice($match[0], $start, $length));
    }
    return $suffix ? $slice . '...' : $slice;
}
