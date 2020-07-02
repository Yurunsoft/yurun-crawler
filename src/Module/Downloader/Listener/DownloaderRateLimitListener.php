<?php
namespace Yurun\Crawler\Module\Downloader\Listener;

use Imi\Bean\Annotation\Listener;
use Imi\Queue\Event\Param\ConsumerBeforePopParam;
use Imi\Queue\Event\Listener\IConsumerBeforePopListener;

/**
 * 下载器限流
 * @Listener("IMI.QUEUE.CONSUMER.BEFORE_POP")
 */
class DownloaderRateLimitListener implements IConsumerBeforePopListener
{
    /**
     * 事件处理方法
     * @param ConsumerBeforePopParam $e
     * @return void
     */
    public function handle(ConsumerBeforePopParam $e)
    {
        // TODO:
    }

}