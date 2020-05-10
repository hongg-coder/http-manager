<?php

namespace Hgg\HttpManager\Contracts;

interface CacheInterface
{
    public function get($key);

    public function set($key, $value, $ttl = 0);

    public function incr($key, $step = 1);

    public function del($key);
}
