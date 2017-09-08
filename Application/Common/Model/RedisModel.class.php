<?php
namespace Common\Model;

class RedisModel{
    public static $instance;

    private function __construct()
    {
    }

    public static function getInstance(){
        if(empty(self::$instance)){
            self::$instance = new \Redis();
            self::$instance->connect('127.0.0.1', '6379');
        }
        return self::$instance;
    }

}