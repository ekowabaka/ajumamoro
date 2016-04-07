<?php

namespace ajumamoro;

use ajumamoro\Config;

class Queue
{
    public function add(Job $job)
    {
        $store = Broker::getInstance();
        $jobClass = new \ReflectionClass($job);
        $path = $jobClass->getFileName();
        $object = serialize($job);
        return $store->put(['path' => $path, 'object' => $object]);
    }
    
    public static function connectBroker($parameters)
    {
        Config::set('broker', $parameters);
        return new Queue();
    }
    
    public function getJobStatus($query)
    {
        return Broker::getInstance()->getStatus($query);
    }
}