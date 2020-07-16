<?php
namespace Yurun\Crawler\Module\Processor\Consumer;

use Imi\App;
use Imi\Bean\Annotation\Bean;
use Imi\Queue\Contract\IMessage;
use Imi\Queue\Driver\IQueueDriver;
use Imi\Queue\Service\BaseQueueConsumer;
use Yurun\Crawler\Module\Processor\Model\ProcessorParams;
use Yurun\Crawler\Module\Processor\Model\ProcessorMessage;

/**
 * 处理器消费者
 * 
 * @Bean("ProcessorConsumer")
 */
class ProcessorConsumer extends BaseQueueConsumer
{
    /**
     * 处理消费
     * 
     * @param \Imi\Queue\Contract\IMessage $message
     * @param \Imi\Queue\Driver\IQueueDriver $queue
     * @return void
     */
    protected function consume(IMessage $message, IQueueDriver $queue)
    {
        // 处理器消息处理
        $processorMessage = new ProcessorMessage;
        $processorMessage->loadFromJsonString($message->getMessage());
        /** @var \Yurun\Crawler\Module\Crawler\Contract\BaseCrawler $crawler */
        // $crawler = App::getBean($processorMessage->crawler);
        $processorParams = new ProcessorParams;
        $processorParams->dataModel = $processorMessage->dataModel;
        $processorParams->data = $processorMessage->data;
        /** @var \Yurun\Crawler\Module\Crawler\Contract\BaseCrawlerItem $crawlerItem */
        $crawlerItem = App::getBean($processorMessage->crawlerItem);
        // 处理
        $crawlerItem->process($processorParams);
        $queue->success($message);
    }

}
