<?php
namespace Yurun\Crawler\Module\Downloader\Model;

use Yurun\Crawler\Contract\BaseQueueMessage;

/**
 * 下载消息
 */
class DownloadMessage extends BaseQueueMessage
{
    /**
     * 爬虫名称
     *
     * @var string
     */
    public $crawler;

    /**
     * 爬虫项名称
     *
     * @var string
     */
    public $crawlerItem;

    /**
     * 请求方法
     *
     * @var string
     */
    public $method;

    /**
     * 请求地址
     *
     * @var string
     */
    public $url;

    /**
     * 请求主体内容
     *
     * @var string
     */
    public $body;

    /**
     * 请求头
     *
     * @var array
     */
    public $headers;

    /**
     * 其它数据
     *
     * @var array|null
     */
    public $data;

    public function __construct(string $crawler = null, string $crawlerItem = null, string $url = null, string $method = null, string $body = null, array $headers = [], array $data = [])
    {
        $this->crawler = $crawler;
        $this->crawlerItem = $crawlerItem;
        $this->method = $method;
        $this->body = $body;
        $this->headers = $headers;
        $this->url = $url;
        $this->data = $data;
    }

}
