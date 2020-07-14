<?php
namespace Yurun\Crawler\Test\Tests\Processor;

use PHPUnit\Framework\TestCase;
use Yurun\Crawler\Module\Proxy\Contract\IProxyPool;
use Yurun\Crawler\Module\Proxy\Model\Proxy;

abstract class BaseProxyPoolTest extends TestCase
{
    /**
     * 获取连接池对象
     *
     * @return \Yurun\Crawler\Module\Proxy\Contract\IProxyPool
     */
    public abstract function getProxyPoolInstance(): IProxyPool;

    protected $proxys = [
        ['host' => '127.0.0.1', 'port' => 80, 'username' => null, 'password' => null, 'type' => 'http'],
        ['host' => '127.0.0.2', 'port' => 81, 'username' => null, 'password' => null, 'type' => 'http'],
        ['host' => '127.0.0.3', 'port' => 82, 'username' => null, 'password' => null, 'type' => 'http'],
        ['host' => '127.0.0.4', 'port' => 83, 'username' => null, 'password' => null, 'type' => 'http'],
        ['host' => '127.0.0.5', 'port' => 84, 'username' => null, 'password' => null, 'type' => 'http'],
    ];

    public function testManage()
    {
        $proxyPool = $this->getProxyPoolInstance();
        
        $proxyPool->add(new Proxy('127.0.0.5', 84));
        $this->assertEquals(1, $proxyPool->getCount());
        $proxyPool->remove(new Proxy('127.0.0.5', 84));
        $this->assertEquals(0, $proxyPool->getCount());
        $proxyPool->add(new Proxy('127.0.0.5', 84));
        $this->assertEquals(1, $proxyPool->getCount());
        $this->assertEquals([['host' => '127.0.0.5', 'port' => 84, 'username' => null, 'password' => null, 'type' => 'http']], json_decode(json_encode($proxyPool->getProxys()), true));
        $proxyPool->clear();
        $this->assertEquals(0, $proxyPool->getCount());

        foreach($this->proxys as $item)
        {
            $proxyPool->add(Proxy::createFromArray($item));
        }
        $this->assertEquals(5, $proxyPool->getCount());
    }

    public function testGetNextProxy()
    {
        $proxyPool = $this->getProxyPoolInstance();
        foreach($this->proxys as $item)
        {
            $this->assertEquals($item, json_decode(json_encode($proxyPool->getNextProxy()), true));
        }
        $this->assertEquals($this->proxys[0], json_decode(json_encode($proxyPool->getNextProxy()), true));
    }

    public function testGetRandomProxy()
    {
        $proxyPool = $this->getProxyPoolInstance();
        for($i = 0; $i < 5; ++$i)
        {
            $this->assertTrue(in_array(json_decode(json_encode($proxyPool->getNextProxy()), true), $this->proxys));
        }
    }

}
