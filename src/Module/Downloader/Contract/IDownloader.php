<?php
namespace Yurun\Crawler\Module\Downloader\Contract;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * 下载器接口
 */
interface IDownloader
{
    /**
     * 下载内容
     *
     * @param \Psr\Http\Message\RequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function download(RequestInterface $request): ResponseInterface;

}
