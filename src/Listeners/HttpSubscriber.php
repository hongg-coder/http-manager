<?php

namespace Hgg\HttpManager\Listeners;

use Hgg\HttpManager\Cache;
use Hgg\HttpManager\Container;
use Hgg\HttpManager\Events\HttpExceptionEvent;
use Hgg\HttpManager\Events\HttpLockEvent;
use Hgg\HttpManager\Events\HttpResponseEvent;
use Hgg\HttpManager\Exceptions\LockException;
use Hgg\HttpManager\Result;
use Hgg\HttpManager\Tools\UrlTools;
use Hgg\HttpManager\UrlManage;
use Hgg\HttpManager\UrlRule;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class HttpSubscriber implements EventSubscriberInterface
{
    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            HttpResponseEvent::class => [
                ["httpResponseLog", 3],
                ["httpResponseTimeout", 2],
                ["httpResponseError", 1],
                ["rewindResponseBody", 1]
            ],
            HttpExceptionEvent::class => [
                ["httpException", 1]
            ],
            HttpLockEvent::class => [
                ["httpLock", 1]
            ]
        ];
    }

    /**
     * 保存日志
     * @param HttpResponseEvent $httpResponse
     */
    public function httpResponseLog(HttpResponseEvent $httpResponse)
    {
        //保存日志
        if (Container::$isSetLogger) {
            Container::getLogger()->info($httpResponse->getResult());
        }
    }

    /**
     * 判断是否超时
     * @param HttpResponseEvent $httpResponse
     */
    public function httpResponseTimeout(HttpResponseEvent $httpResponse)
    {
        $url = (string)$httpResponse->getResult()->getRequest()->getUri();

        $isRegister = Container::isRegisterUrl($url);

        if (!$isRegister) {
            return true;
        }

        $urlRule = Container::getUrlRule($url);

        $isOverTimeout = $this->responseIsOverTimeout($httpResponse->getResult(), $urlRule);

        if (!$isOverTimeout) {
            return true;
        }

        return (new UrlManage($urlRule))->overTimeoutHandler();
    }

    /**
     * 判断是否请求失败
     * @param HttpResponseEvent $httpResponseEvent
     */
    public function httpResponseError(HttpResponseEvent $httpResponseEvent)
    {
        $url = (string)$httpResponseEvent->getResult()->getRequest()->getUri();

        $isRegister = Container::isRegisterUrl($url);
        if (!$isRegister) {
            return true;
        }

        $urlRule = Container::getUrlRule($url);

        if ($this->getResponseIsSuccess($httpResponseEvent->getResult(), $urlRule)) {
            return true;
        }

        return (new UrlManage($urlRule))->responseErrorHandle();

    }

    /**
     * 每次调用完response 需要rewind 数据 否则下一次拿数据 拿不到数据
     * @param HttpResponseEvent $httpResponseEvent
     * @return mixed
     */
    public function rewindResponseBody(HttpResponseEvent $httpResponseEvent)
    {
        return $httpResponseEvent->getResult()->getResponse()->getBody()->rewind();
    }

    private function responseIsOverTimeout(Result $result, UrlRule $urlRule)
    {
        $diff = round(($result->getEndTime() - $result->getStartTime()), 2);

        return ($diff >= $urlRule->getTimeoutLimit()) ? true : false;
    }

    /**
     * 判断http响应返回是否成功
     * @param Result $result
     * @param UrlRule $
     */
    private function getResponseIsSuccess(Result $result, UrlRule $urlRule)
    {
        $responseStatusCode = (int)$result->getResponse()->getStatusCode();

        if ($responseStatusCode < 400) {
            return true;
        }

        if (in_array($responseStatusCode, $urlRule->getWhiteResponseCodeList())) {
            return true;
        }

        return false;
    }

    /**
     * @param HttpExceptionEvent $httpException
     */
    public function httpException(HttpExceptionEvent $httpException)
    {
        $url = UrlTools::getUrlPath(
            (string)$httpException->getRequestException()->getRequest()->getUri()
        );

        if (Container::$isSetLogger) {
            Container::getLogger()->error($httpException->getRequestException());
        }

        if (!Container::$isSetMonit) {
            return;
        }

        if (!Container::$isSetCache) {
            Container::getMonit()->requestExceptionReport($httpException->getRequestException());
            return;
        }

        if (empty(Cache::getResponseExceptionIsNotice($url))) {
            Container::getMonit()->requestExceptionReport($httpException->getRequestException());
            Cache::setResponseExceptionIsNotice($url, 10);
        }
    }

    /**
     * @param HttpLockEvent $httpLockEvent
     * @throws LockException
     */
    public function httpLock(HttpLockEvent $httpLockEvent)
    {

    }


}
