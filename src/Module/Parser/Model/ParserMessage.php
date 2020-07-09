<?php
namespace Yurun\Crawler\Module\Parser\Model;

use Psr\Http\Message\ResponseInterface;
use Yurun\Crawler\Contract\BaseQueueMessage;

/**
 * 解析器消息
 */
class ParserMessage extends BaseQueueMessage
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
     * 响应主体内容
     *
     * @var string
     */
    public $body;

    /**
     * 响应头
     *
     * @var array
     */
    public $headers;

    /**
     * 状态码
     *
     * @var int
     */
    public $statusCode;

    /**
     * 其它数据
     *
     * @var array|null
     */
    public $data;

    public function __construct(string $crawler = null, string $crawlerItem = null, string $body = null, array $headers = [], int $statusCode = 200, array $data = [])
    {
        $this->crawler = $crawler;
        $this->crawlerItem = $crawlerItem;
        $this->body = $body;
        $this->headers = $headers;
        $this->statusCode = $statusCode;
        $this->data = $data;
    }

    /**
     * 从响应体创建
     *
     * @param string $crawler
     * @param string $crawlerItem
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param array $data
     * @return static
     */
    public static function createFromResponse(string $crawler, string $crawlerItem, ResponseInterface $response, array $data = [])
    {
        $headers = [];
        foreach($response->getHeaders() as $name => $item)
        {
            $headers[] = implode(', ', $item);
        }
        return new static($crawler, $crawlerItem, $response->getBody(), $headers, $response->getStatusCode(), $data);
    }

}
