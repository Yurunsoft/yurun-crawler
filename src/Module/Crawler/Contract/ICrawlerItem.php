<?php
namespace Yurun\Crawler\Module\Crawler\Contract;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Yurun\Crawler\Module\Crawler\Contract\ICrawler;
use Yurun\Crawler\Module\Parser\Model\ParserParams;
use Yurun\Crawler\Module\DataModel\Contract\IDataModel;
use Yurun\Crawler\Module\Downloader\Model\DownloadParams;
use Yurun\Crawler\Module\Processor\Model\ProcessorParams;

/**
 * 采集项目接口
 */
interface ICrawlerItem
{
    /**
     * 下载
     *
     * @param \Yurun\Crawler\Module\Downloader\Model\DownloadParams $params
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function download(DownloadParams $params): ResponseInterface;

    /**
     * 解析
     *
     * @param \Yurun\Crawler\Module\Parser\Model\ParserParams $params
     * @return \Yurun\Crawler\Module\DataModel\Contract\IDataModel
     */
    public function parse(ParserParams $params): IDataModel;

    /**
     * 处理
     *
     * @param \Yurun\Crawler\Module\Processor\Model\ProcessorParams $params
     * @return void
     */
    public function process(ProcessorParams $params);

    /**
     * 获取爬虫对象
     *
     * @return ICrawler
     */
    public function getCrawler(): ICrawler;

}
