<?php
namespace Yurun\Crawler\Module\Crawler\Contract;

use Psr\Http\Message\ResponseInterface;
use Yurun\Crawler\Module\Crawler\Annotation\ProxyPool;
use Yurun\Crawler\Module\Crawler\Annotation\Downloader;
use Yurun\Crawler\Module\DataModel\Contract\IDataModel;

/**
 * 爬虫对象接口
 */
interface ICrawler
{
    /**
     * 开始爬取
     *
     * @return void
     */
    public function start();

    /**
     * 运行爬取任务
     *
     * @return void
     */
    public function run();

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
     * 获取爬虫项集合
     *
     * @return array
     */
    public function getCrawlerItemNames(): array;
    
    /**
     * 上一次运行的爬取任务是否执行完成
     *
     * @return boolean
     */
    public function isLastTaskCompleted(): bool;
    
    /**
     * 获取爬虫名称
     *
     * @return string
     */
    public function getName(): string;
    
    /**
     * 推送下载任务消息
     *
     * @param string $crawlerItem
     * @param string $url
     * @param string $method
     * @param string $body
     * @param array $headers
     * @param array $data
     * @return string
     */
    public function pushDownloadMessage(string $crawlerItem, string $url, string $method = 'GET', string $body = '', array $headers = [], array $data = []): string;

    /**
     * 推送解析器消息
     *
     * @param string $crawlerItem
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param array $data
     * @return void
     */
    public function pushParserMessage(string $crawlerItem, ResponseInterface $response, array $data = []);

    /**
     * 推送处理器消息
     *
     * @param string $crawlerItem
     * @param \Yurun\Crawler\Module\DataModel\Contract\IDataModel $dataModel
     * @param array $data
     * @return void
     */
    public function pushProcessorMessage(string $crawlerItem, IDataModel $dataModel, array $data = []);

}
