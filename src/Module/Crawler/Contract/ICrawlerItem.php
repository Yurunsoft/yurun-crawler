<?php
namespace Yurun\Crawler\Module\Crawler\Contract;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Yurun\Crawler\Module\Crawler\Contract\ICrawler;
use Yurun\Crawler\Module\DataModel\Contract\IDataModel;

/**
 * 采集项目接口
 */
interface ICrawlerItem
{
    /**
     * 下载
     *
     * @param \Psr\Http\Message\RequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function download(RequestInterface $request): ResponseInterface;

    /**
     * 解析
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return \Yurun\Crawler\Module\DataModel\Contract\IDataModel
     */
    public function parse(ResponseInterface $response): IDataModel;

    /**
     * 处理
     *
     * @param \Yurun\Crawler\Module\DataModel\Contract\IDataModel $data
     * @return void
     */
    public function process(IDataModel $data);

    /**
     * 获取爬虫对象
     *
     * @return ICrawler
     */
    public function getCrawler(): ICrawler;

}
