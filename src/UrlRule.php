<?php

namespace Hgg\HttpManager;
class UrlRule
{
    //对应的url 全路径
    protected $uri = '';

    //是否需要熔断
    protected $isNeedLock = false;

    //超时限制 超过该值代表 错误请求
    protected $timeoutLimit = 10;

    //规定时间内超时的次数
    protected $timeoutErrorLimit = 2;

    //规定时间那超过超时的次数
    protected $timeoutInterval = 60;

    //规定时间的错误次数限制
    protected $errorLimit = 2;

    //错误时间间隔 60s
    protected $errorInterval = 60;

    //锁住接口时间
    protected $lockTime = 5;

    // 响应返回错误吗白名单列表 如果response >= 400 但是在白名单那 认为接口没有出错
    protected $whiteResponseCodeList = [

    ];

    /**
     * @return int
     */
    public function getTimeoutErrorLimit(): int
    {
        return $this->timeoutErrorLimit;
    }

    /**
     * @return int
     */
    public function getTimeoutInterval(): int
    {
        return $this->timeoutInterval;
    }

    /**
     * @return array
     */
    public function getWhiteResponseCodeList(): array
    {
        return $this->whiteResponseCodeList;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**j
     * @param string $uri
     */
    public function setUri(string $uri): void
    {
        $this->uri = $uri;
    }

    /**
     * @return bool
     */
    public function isNeedLock(): bool
    {
        return $this->isNeedLock;
    }

    /**
     * @param bool $isNeedLock
     */
    public function setIsNeedLock(bool $isNeedLock): void
    {
        $this->isNeedLock = $isNeedLock;
    }

    /**
     * @return int
     */
    public function getTimeoutLimit(): float
    {
        return $this->timeoutLimit;
    }

    /**
     * @param int $timeoutLimit
     */
    public function setTimeoutLimit(float $timeoutLimit): void
    {
        $this->timeoutLimit = $timeoutLimit;
    }

    /**
     * @return int
     */
    public function getErrorLimit(): int
    {
        return $this->errorLimit;
    }

    /**
     * @param int $errorLimit
     */
    public function setErrorLimit(int $errorLimit): void
    {
        $this->errorLimit = $errorLimit;
    }

    /**
     * @return int
     */
    public function getErrorInterval(): int
    {
        return $this->errorInterval;
    }

    /**
     * @param int $errorInterval
     */
    public function setErrorInterval(int $errorInterval): void
    {
        $this->errorInterval = $errorInterval;
    }

    /**
     * @return int
     */
    public function getLockTime(): int
    {
        return $this->lockTime;
    }

    /**
     * @param int $lockTime
     */
    public function setLockTime(int $lockTime): void
    {
        $this->lockTime = $lockTime;
    }


}