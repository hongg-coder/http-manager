<?php
namespace Hgg\HttpManager\Events;

use GuzzleHttp\Exception\RequestException;
use Symfony\Contracts\EventDispatcher\Event;

class HttpExceptionEvent extends Event
{
    private $requestException;

    /**
     * @return RequestException
     */
    public function getRequestException(): RequestException
    {
        return $this->requestException;
    }

    public function __construct(RequestException $requestException)
    {
        $this->requestException = $requestException;
    }
}