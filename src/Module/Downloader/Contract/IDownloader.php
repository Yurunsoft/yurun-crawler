<?php
namespace Yurun\Crawler\Module\Downloader\Contract;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
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
     * @param \Psr\Http\Message\RequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function download(ICrawlerItem $crawlerItem, RequestInterface $request): ResponseInterface;

}
