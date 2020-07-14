<?php
namespace Yurun\Crawler\Module\Downloader\Contract;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Yurun\Crawler\Module\Proxy\Model\Proxy;
use Yurun\Crawler\Module\Crawler\Contract\ICrawlerItem;

/**
 * 下载器接口
 */
interface IDownloader
{
    /**
     * 下载内容
     *
     * @param \Yurun\Crawler\Module\Crawler\Contract\ICrawlerItem $crawlerItem
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Yurun\Crawler\Module\Proxy\Model\Proxy $proxy
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function download(ICrawlerItem $crawlerItem, ServerRequestInterface $request, ?Proxy $proxy = null): ResponseInterface;

}
