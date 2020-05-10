<?php

namespace Hgg\HttpManager\Contracts;

use Hgg\HttpManager\Result;
use GuzzleHttp\Exception\RequestException;

interface LoggerInterface
{
    public function info(Result $result);

    public function error(RequestException $exception);
}
