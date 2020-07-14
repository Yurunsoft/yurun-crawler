<?php
namespace Yurun\Crawler\Test\Tests\Processor;

use Imi\App;
use Yurun\Crawler\Module\Proxy\Contract\IProxyPool;

class RedisProxyPoolTest extends BaseProxyPoolTest
{
    /**
     * 获取连接池对象
     *
     * @return \Yurun\Crawler\Module\Proxy\Contract\IProxyPool
     */
    public function getProxyPoolInstance(): IProxyPool
    {
        return App::getBean('RedisProxyPool', 'redis', 'yurun:crawler:proxyPool:test');
    }

}
