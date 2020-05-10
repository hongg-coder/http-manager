<?php
namespace Hgg\HttpManager;

class CacheKeyList
{
    public static function getUrlIsLockKey($url)
    {
        return vsprintf(
            "%s-lock-key",
            [$url]
        );
    }

    public static function getUrlTimeoutErrorCountKey($url)
    {
        return vsprintf(
            "%s-timeout-count",
            [$url]
        );
    }

    public static function getUrlResponseErrorCountKey($url)
    {
        return vsprintf(
            "%s-response-count",
            [$url]
        );
    }

    public static function getUrlTimeoutIsMonitKey($url)
    {
        return vsprintf(
            "%s-timeout-is-monit-key",
            [$url]
        );
    }

    public static function getUrlResponseErrorIsMonitKey($url)
    {
        return vsprintf(
            "%s-response-is-monit-key",
            [$url]
        );
    }

    public static function getUrlExceptionIsMonitKey($url)
    {
        return vsprintf(
            "%s-exception-is-monit-key",
            [$url]
        );
    }
}
