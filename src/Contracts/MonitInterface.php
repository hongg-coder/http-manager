<?php

namespace Hgg\HttpManager\Contracts;

use Hgg\HttpManager\UrlRule;
use GuzzleHttp\Exception\RequestException;

interface MonitInterface
{
    public function requestExceptionReport(RequestException $requestException);

    public function curlErrorReport(UrlRule $urlRule);

    public function lockReport(UrlRule $urlRule);
}
