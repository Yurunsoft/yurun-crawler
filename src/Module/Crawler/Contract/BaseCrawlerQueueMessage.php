<?php
namespace Yurun\Crawler\Module\Crawler\Contract;

use Yurun\Crawler\Contract\BaseQueueMessage;

class BaseCrawlerQueueMessage extends BaseQueueMessage
{
    /**
     * 消息类型
     *
     * @var string
     */
    public $messageType;

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

}
