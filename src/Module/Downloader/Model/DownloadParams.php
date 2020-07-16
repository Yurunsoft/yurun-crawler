<?php
namespace Yurun\Crawler\Module\Downloader\Model;

/**
 * 下载参数
 */
class DownloadParams
{
    /**
     * 请求对象
     *
     * @var \Psr\Http\Message\ServerRequestInterface
     */
    public $request;

    /**
     * 代理 IP
     *
     * @var \Yurun\Crawler\Module\Proxy\Model\Proxy
     */
    public $proxy;

    /**
     * 数据
     *
     * @var array
     */
    public $data;

}
