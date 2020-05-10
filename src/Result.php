<?php
namespace Hgg\HttpManager;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use function GuzzleHttp\Psr7\str;

class Result
{
    private $response;

    private $request;

    private $startTime;

    private $endTime;

    /**
     * @return mixed
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param mixed $startTime
     */
    public function setStartTime($startTime): void
    {
        $this->startTime = $startTime;
    }

    /**
     * @return mixed
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @param mixed $endTime
     */
    public function setEndTime($endTime): void
    {
        $this->endTime = $endTime;
    }

    /**
     * @return mixed
     */
    public function getResponse() : ResponseInterface
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     */
    public function setResponse(ResponseInterface $response): void
    {
        $this->response = $response;
    }

    /**
     * @return mixed
     */
    public function getRequest() : RequestInterface
    {
        return $this->request;
    }

    /**
     * @param mixed $request
     */
    public function setRequest(RequestInterface $request): void
    {
        $this->request = $request;
    }

    public function __toString()
    {
        return json_encode([
            (string)$this->getRequest()->getBody(),
            (string)$this->getResponse()->getBody(),
            ($this->getEndTime() - $this->getStartTime())
        ], JSON_UNESCAPED_UNICODE);
    }

}
