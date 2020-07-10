<?php
namespace Yurun\Crawler\Module\Downloader\Handler;

use Yurun\Util\YurunHttp;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Yurun\Crawler\Module\Crawler\Contract\ICrawlerItem;
use Yurun\Crawler\Module\Downloader\Contract\BaseDownloader;

/**
 * 基于 YurunHttp 的下载器
 */
class YurunHttpDownloader extends BaseDownloader
{
    /**
     * 下载内容
     *
     * @param \Yurun\Crawler\Module\Crawler\Contract\ICrawlerItem $crawlerItem
     * @param \Psr\Http\Message\RequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function download(ICrawlerItem $crawlerItem, RequestInterface $request): ResponseInterface
    {
        return YurunHttp::send($request);
    }

}
