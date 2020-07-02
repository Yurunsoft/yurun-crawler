<?php
namespace Yurun\Crawler\Module\Downloader\Contract;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * 下载器基类
 */
abstract class BaseDownloader implements IDownloader
{
    /**
     * 下载内容
     *
     * @param \Psr\Http\Message\RequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function download(RequestInterface $request): ResponseInterface
    {
        $response = $this->beforeDownload($request);
        if($response)
        {
            return $response;
        }
        $response = $this->__download($request);
        return $this->afterDownload($request, $response);
    }

    /**
     * 下载内容
     *
     * @param \Psr\Http\Message\RequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    abstract protected function __download(RequestInterface $request): ResponseInterface;

    /**
     * 下载内容前触发
     *
     * @param \Psr\Http\Message\RequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface|null
     */
    protected function beforeDownload(RequestInterface &$request): ?ResponseInterface
    {
        return null;
    }

    /**
     * 下载内容后触发
     *
     * @param \Psr\Http\Message\RequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function afterDownload(RequestInterface &$request, ResponseInterface $response): ResponseInterface
    {
        return $response;
    }

}
