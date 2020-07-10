<?php
namespace Yurun\Crawler\Module\Downloader\Listener;

use Imi\App;
use Imi\RateLimit\RateLimiter;
use Imi\Bean\Annotation\Listener;
use Imi\Config;
use Imi\Queue\Event\Param\ConsumerBeforeConsumeParam;
use Imi\Queue\Event\Listener\IConsumerBeforeConsumeListener;
use Yurun\Crawler\Module\Crawler\Contract\BaseCrawlerQueueMessage;

/**
 * 下载器限流
 * @Listener("IMI.QUEUE.CONSUMER.BEFORE_CONSUME")
 */
class DownloaderRateLimitListener implements IConsumerBeforeConsumeListener
{
    /**
     * 事件处理方法
     * @param ConsumerBeforeConsumeParam $e
     * @return void
     */
    public function handle(ConsumerBeforeConsumeParam $e)
    {
        $message = new BaseCrawlerQueueMessage;
        $message->loadFromJsonString($e->message->getMessage());
        if($message->crawler && $message->crawlerItem)
        {
            /** @var \Yurun\Crawler\Module\Crawler\Contract\BaseCrawlerItem $crawlerItem */
            $crawlerItem = App::getBean($message->crawlerItem);
            $downloaderAnnotation = $crawlerItem->getDownloaderAnnotation();
            if($downloaderAnnotation->limit <= 0)
            {
                return;
            }
            $limit = $downloaderAnnotation->limit;
            RateLimiter::limitBlock(Config::get('@app.ratelimitPrefix') . $e->queue->getName(), $limit, null, $downloaderAnnotation->limitWait, $limit, $downloaderAnnotation->limitUnit);
        }
    }

}