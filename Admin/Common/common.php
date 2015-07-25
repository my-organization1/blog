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
function RestoreRouter($rule)
{
    $rule = ltrim(trim($rule, '$/'), '/^');
    $rule = stripslashes($rule);

    return $rule;
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
