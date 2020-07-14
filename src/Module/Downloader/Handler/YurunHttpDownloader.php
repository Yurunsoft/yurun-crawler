<?php
namespace Yurun\Crawler\Module\Downloader\Handler;

use Yurun\Util\YurunHttp;
use Yurun\Util\YurunHttp\Attributes;
use Psr\Http\Message\ResponseInterface;
use Yurun\Crawler\Module\Proxy\Model\Proxy;
use Psr\Http\Message\ServerRequestInterface;
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
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Yurun\Crawler\Module\Proxy\Model\Proxy $proxy
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function download(ICrawlerItem $crawlerItem, ServerRequestInterface $request, ?Proxy $proxy = null): ResponseInterface
    {
        if($proxy)
        {
            $request = $request->withAttribute(Attributes::PROXY_TYPE, $proxy->type)
                               ->withAttribute(Attributes::PROXY_SERVER, $proxy->host)
                               ->withAttribute(Attributes::PROXY_PORT, $proxy->port)
                               ->withAttribute(Attributes::PROXY_USERNAME, $proxy->username)
                               ->withAttribute(Attributes::PROXY_PASSWORD, $proxy->password);
        }
        return YurunHttp::send($request);
    }

}
