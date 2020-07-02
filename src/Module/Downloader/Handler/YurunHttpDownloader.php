<?php
namespace Yurun\Crawler\Module\Downloader\Handler;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Yurun\Crawler\Module\Downloader\Contract\BaseDownloader;
use Yurun\Util\YurunHttp;

/**
 * 基于 YurunHttp 的下载器
 */
class YurunHttpDownloader extends BaseDownloader
{
    /**
     * 下载内容
     *
     * @param \Psr\Http\Message\RequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function __download(RequestInterface $request): ResponseInterface
    {
        return YurunHttp::send($request);
    }

}
