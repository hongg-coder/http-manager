<?php

namespace Hgg\HttpManager;

class Cache
{

    public static function getUrlIsLock($url)
    {
        return Container::getCache()->get(CacheKeyList::getUrlIsLockKey($url));
    }

    public static function setUrlIsLock($url, $ttl)
    {
        return Container::getCache()->set(CacheKeyList::getUrlIsLockKey($url), 1, $ttl);
    }

    public static function getUrlTimeoutCount($url)
    {
        return Container::getCache()->get(CacheKeyList::getUrlTimeoutErrorCountKey($url));
    }

    public static function incrUrlTimeoutCount($url)
    {
        return Container::getCache()->incr(CacheKeyList::getUrlTimeoutErrorCountKey($url));
    }

    public static function setUrlTimeoutCount($url, $count, $ttl)
    {
        return Container::getCache()->set(
            CacheKeyList::getUrlTimeoutErrorCountKey($url),
            $count,
            $ttl
        );
    }

    public static function getUrlResponseErrorCount($url)
    {
        return Container::getCache()->get(CacheKeyList::getUrlResponseErrorCountKey($url));
    }

    public static function incrUrlResponseErrorCount($url)
    {
        return Container::getCache()->incr(CacheKeyList::getUrlResponseErrorCountKey($url));
    }

    public static function setUrlResponseErrorCount($url, $count, $ttl)
    {
        return Container::getCache()->set(
            CacheKeyList::getUrlResponseErrorCountKey($url),
            $count,
            $ttl
        );
    }

    public static function getResponseErrorIsNotice($url)
    {
        return Container::getCache()->get(CacheKeyList::getUrlResponseErrorIsMonitKey($url));
    }

    public static function setResponseErrorIsNotice($url, $ttl)
    {
        return Container::getCache()->set(CacheKeyList::getUrlResponseErrorIsMonitKey($url), 1, $ttl);
    }

    public static function getResponseTimeoutIsNotice($url)
    {
        return Container::getCache()->get(CacheKeyList::getUrlTimeoutIsMonitKey($url));
    }

    public static function setResponseTimeoutIsNotice($url, $ttl)
    {
        return Container::getCache()->set(CacheKeyList::getUrlTimeoutIsMonitKey($url), 1, $ttl);
    }

    public static function getResponseExceptionIsNotice($url)
    {
        return Container::getCache()->get(CacheKeyList::getUrlExceptionIsMonitKey($url));
    }

    public static function setResponseExceptionIsNotice($url, $ttl)
    {
        return Container::getCache()->set(CacheKeyList::getUrlExceptionIsMonitKey($url), 1, $ttl);
    }

}