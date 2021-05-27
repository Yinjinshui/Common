<?php

declare(strict_types=1);

namespace App\Common\Cache;

use Hyperf\Utils\ApplicationContext;

/**
 * redis二次封装
 */
class Redis
{
    private $redis;

    public function __construct()
    {
        $container = ApplicationContext::getContainer();
        $this->redis = $container->get(\Hyperf\Redis\Redis::class);
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->redis, $name], $arguments);
    }

    /**
     * 获取缓存
     * @param string $key
     * @return string|null
     */
    public function getArr(string $key)
    {
        $value = $this->redis->get($key);
        if ($value) {
            $value = unserialize($value);
        }
        return $value;
    }

    /**
     * 设置缓存
     * @param string $key
     * @param string $value
     * @return bool
     */
    public function setArr(string $key, array $value, $expire = 0)
    {
        $value = serialize($value);
        $expire = intval($expire);
        if ($expire === 0) {
            $res = $this->redis->set($key, $value);
        } else {
            $res = $this->redis->set($key, $value, $expire);
        }
        return $res;
    }

    /**
     * @param $key
     * @param $value
     * @return string
     */
    public function test($key, $value)
    {
        return "测试".$key."value".$value;
    }

    /**
     * @param $key
     * @param $value
     * @return string
     */
    public function testdev($key, $value)
    {
        return "测试".$key."value".$value;
    }
}