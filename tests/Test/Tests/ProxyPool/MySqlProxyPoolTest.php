<?php
namespace Yurun\Crawler\Test\Tests\Processor;

use Imi\App;
use Yurun\Crawler\Module\Proxy\Contract\IProxyPool;

class MySqlProxyPoolTest extends BaseProxyPoolTest
{
    /**
     * 获取连接池对象
     *
     * @return \Yurun\Crawler\Module\Proxy\Contract\IProxyPool
     */
    public function getProxyPoolInstance(): IProxyPool
    {
        return App::getBean('MySqlProxyPool', 'maindb', 'tb_proxy_test');
    }

}
