<?php
namespace Yurun\Crawler\Module\Proxy\Handler;

use Imi\App;
use Imi\Bean\Annotation\Bean;
use Imi\Redis\RedisManager;
use Yurun\Crawler\Module\Proxy\Model\Proxy;
use Yurun\Crawler\Module\Proxy\Contract\IProxyPool;
use Yurun\Crawler\Module\Proxy\Exception\EmptyProxyPoolException;

/**
 * Redis 代理 IP 池
 * @Bean("RedisProxyPool")
 */
class RedisProxyPool implements IProxyPool
{
    /**
     * 连接池名
     *
     * @var string
     */
    protected $poolName;

    /**
     * 键名
     *
     * @var string
     */
    protected $key;

    /**
     * 格式化编码方式
     *
     * @var string
     */
    protected $format;

    /**
     * 格式化编码对象
     *
     * @var \Imi\Util\Format\IFormat
     */
    protected $formatInstance;

    /**
     * 当前序号
     *
     * @var integer
     */
    protected $index = 0;

    public function __construct(string $poolName = null, string $key = null, string $format = \Imi\Util\Format\Json::class)
    {
        $this->poolName = $poolName;
        $this->key = $key;
        $this->format = $format;
    }
 
    public function __init()
    {
        if($this->format)
        {
            $this->formatInstance = App::getBean($this->format);
        }
    }

    /**
     * 获取下一个代理 IP
     *
     * @return \Yurun\Crawler\Module\Proxy\Model\Proxy
     */
    public function getNextProxy(): Proxy
    {
        $result = RedisManager::getInstance($this->poolName)->lindex($this->key, $this->index++);
        if(false === $result)
        {
            $result = RedisManager::getInstance($this->poolName)->lindex($this->key, $this->index = 0);
        }
        $formatInstance = $this->formatInstance;
        return Proxy::createFromArray($formatInstance ? $formatInstance->decode($result) : $result);
    }

    /**
     * 获取随机代理 IP
     *
     * @return \Yurun\Crawler\Module\Proxy\Model\Proxy
     */
    public function getRandomProxy(): Proxy
    {
        $result = RedisManager::getInstance($this->poolName)->evalEx(<<<LUA
local length = redis.call('llen', KEYS[1]);
local num = math.random(0, length - 1);
return redis.call('lindex', num);
LUA
        , [$this->key], 1);
        if(!$result)
        {
            throw new EmptyProxyPoolException;
        }
        $formatInstance = $this->formatInstance;
        return Proxy::createFromArray($formatInstance ? $formatInstance->decode($result) : $result);
    }

    /**
     * 获取所有代理 IP
     *
     * @return array
     */
    public function getProxys(): array
    {
        $list = [];
        $formatInstance = $this->formatInstance;
        foreach(RedisManager::getInstance($this->poolName)->lrange($this->key, 0, -1) as $item)
        {
            $list[] = Proxy::createFromArray($formatInstance ? $formatInstance->decode($item) : $item);
        }
        return $list;
    }

    /**
     * 获取代理 IP 数量
     *
     * @return integer
     */
    public function getCount(): int
    {
        return RedisManager::getInstance($this->poolName)->lLen($this->key);
    }

    /**
     * 增加代理 IP
     *
     * @param \Yurun\Crawler\Module\Proxy\Model\Proxy $proxy
     * @return void
     */
    public function add(Proxy $proxy)
    {
        if($this->formatInstance)
        {
            $data = $this->formatInstance->encode($proxy);
        }
        else
        {
            $data = $proxy;
        }
        RedisManager::getInstance($this->poolName)->rPush($this->key, $data);
    }

    /**
     * 移除代理 IP
     *
     * @param \Yurun\Crawler\Module\Proxy\Model\Proxy $proxy
     * @return void
     */
    public function remove(Proxy $proxy)
    {
        if($this->formatInstance)
        {
            $data = $this->formatInstance->encode($proxy);
        }
        else
        {
            $data = $proxy;
        }
        RedisManager::getInstance($this->poolName)->lrem($this->key, $data, 1);
    }

    /**
     * 清空代理 IP 池
     *
     * @return void
     */
    public function clear()
    {
        RedisManager::getInstance($this->poolName)->del($this->key);
    }

}
