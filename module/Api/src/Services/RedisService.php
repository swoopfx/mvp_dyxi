<?php
namespace Api\Services;

use Predis\Client;

class RedisService
{
    private $client;

    private $redisObject;

    public function setRedisObject($redisObject)
    {
        $this->redisObject = $redisObject;
        return $this;
    }
}
