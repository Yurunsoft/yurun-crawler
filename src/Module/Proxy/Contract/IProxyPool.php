<?php
namespace Yurun\Crawler\Module\Proxy\Contract;

use Yurun\Crawler\Module\Proxy\Model\Proxy;

/**
 * 代理 IP 池
 */
interface IProxyPool
{
    /**
     * 获取下一个代理 IP
     *
     * @return \Yurun\Crawler\Module\Proxy\Model\Proxy
     */
    public function getNextProxy(): Proxy;

    /**
     * 获取随机代理 IP
     *
     * @return \Yurun\Crawler\Module\Proxy\Model\Proxy
     */
    public function getRandomProxy(): Proxy;

    /**
     * 获取所有代理 IP
     *
     * @return array
     */
    public function getProxys(): array;

    /**
     * 获取代理 IP 数量
     *
     * @return integer
     */
    public function getCount(): int;

    /**
     * 增加代理 IP
     *
     * @param \Yurun\Crawler\Module\Proxy\Model\Proxy $proxy
     * @return void
     */
    public function add(Proxy $proxy);

    /**
     * 移除代理 IP
     *
     * @param \Yurun\Crawler\Module\Proxy\Model\Proxy $proxy
     * @return void
     */
    public function remove(Proxy $proxy);

}
