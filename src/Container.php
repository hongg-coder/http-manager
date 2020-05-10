<?php

/**
 * 容器类
 */

namespace Hgg\HttpManager;

use Hgg\HttpManager\Contracts\CacheInterface;
use Hgg\HttpManager\Contracts\LoggerInterface;
use Hgg\HttpManager\Contracts\MonitInterface;
use Hgg\HttpManager\Events\HttpLockEvent;
use Hgg\HttpManager\Exceptions\LockException;
use Hgg\HttpManager\Listeners\HttpSubscriber;
use Hgg\HttpManager\Tools\UrlTools;
use Symfony\Contracts\EventDispatcher\Event;

class Container
{

    public static $isSetLogger = false;

    public static $isSetCache = false;

    public static $isSetMonit = false;

    private static $monit;

    private static $logger;

    private static $cache;

    private static $ruleContainer = [];

    protected static $isInitEvent = false;

    public static function enableEvent()
    {
        //初始化dispatcher
        Events::initDispatcher();
        //增加订阅者
        Events::addSubscriber(new HttpSubscriber());
        self::$isInitEvent = true;
    }

    public static function getLogger(): LoggerInterface
    {
        return self::$logger;
    }

    public static function setLogger(LoggerInterface $logger)
    {
        self::$logger = $logger;

        self::$isSetLogger = true;
    }

    public static function setCache(CacheInterface $cache)
    {
        self::$cache = $cache;

        self::$isSetCache = true;
    }

    public static function getCache(): CacheInterface
    {
        return self::$cache;
    }

    public static function setMoint(MonitInterface $monit)
    {
        self::$monit = $monit;

        self::$isSetMonit = true;
    }

    public static function getMonit(): MonitInterface
    {
        return self::$monit;
    }

    public static function registerUrl(UrlRule $urlRule)
    {
        self::$ruleContainer[UrlTools::getUrlPath($urlRule->getUri())] = $urlRule;
    }

    public static function isRegisterUrl(string $url): bool
    {
        return array_key_exists(UrlTools::getUrlPath($url), self::$ruleContainer);
    }

    public static function getUrlRule(string $url): ?UrlRule
    {
        return self::isRegisterUrl($url) ? self::$ruleContainer[UrlTools::getUrlPath($url)] : null;
    }
}