<?php

namespace Hgg\HttpManager\Tools;

class UrlTools
{
    /**
     * 去掉参数判断
     * @param string $url
     * @return string
     */
    public static function getUrlPath(string $url)
    {
        $ret = parse_url($url);

        //如果没有带有http or https 认为不是标准url 则直接返回
        if (!array_key_exists("scheme", $ret)) {
            return $url;
        }

        $path = $ret['path'] ?? "";
        return $ret['scheme'] . '://' . $ret['host'] . $path;
    }

    /**
     * key=value&key=value -> array
     * @param $string
     */
    public static function urlEncodeParamsToArray($string)
    {
        $string = urldecode($string);
        $array = explode("&", $string);

        $list = [];

        foreach ($array as $key => $value) {
            list($k, $v) = explode("=", $value);

            $list[$k] = $v;
        }

        return $list;
    }

}