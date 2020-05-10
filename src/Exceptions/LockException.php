<?php

namespace Hgg\HttpManager\Exceptions;

use Throwable;

class LockException extends \Exception
{
    private $url;

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    public function __construct($url)
    {
        $this->url = $url;
        parent::__construct("{$url}接口被锁定,目前无法访问", 9990);
    }
}
