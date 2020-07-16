<?php
namespace Yurun\Crawler\Module\Crawler\Contract;

use Psr\Http\Message\ResponseInterface;
use Yurun\Crawler\Module\Crawler\Annotation\Parser;
use Yurun\Crawler\Module\Crawler\Contract\ICrawler;
use Yurun\Crawler\Module\Parser\Model\ParserParams;
use Yurun\Crawler\Module\Crawler\Annotation\Processor;
use Yurun\Crawler\Module\Crawler\Annotation\ProxyPool;
use Yurun\Crawler\Module\Crawler\Annotation\Downloader;
use Yurun\Crawler\Module\DataModel\Contract\IDataModel;
use Yurun\Crawler\Module\Crawler\Annotation\CrawlerItem;
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

    /**
     * 获取采集项目注解列表
     *
     * @return \Yurun\Crawler\Module\Crawler\Annotation\CrawlerItem
     */
    public function getCrawlerItemAnnotation(): CrawlerItem;

    /**
     * 获取下载器注解
     *
     * @return \Yurun\Crawler\Module\Crawler\Annotation\Downloader
     */
    public function getDownloaderAnnotation(): Downloader;

    /**
     * 获取代理 IP 池注解
     *
     * @return \Yurun\Crawler\Module\Crawler\Annotation\ProxyPool|null
     */
    public function getProxyPoolAnnotation(): ?ProxyPool;

    /**
     * 获取解析器注解
     *
     * @return \Yurun\Crawler\Module\Crawler\Annotation\Parser
     */
    public function getParserAnnotation(): Parser;

    /**
     * 获取处理器注解
     *
     * @return \Yurun\Crawler\Module\Crawler\Annotation\Processor
     */
    public function getProcessorAnnotation(): Processor;

    /**
     * 获取爬虫项名称
     *
     * @return string
     */
    public function getName(): string;

}
