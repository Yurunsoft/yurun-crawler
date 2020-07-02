<?php
namespace Yurun\Crawler\Module\Processor\Consumer;

use Imi\Bean\Annotation\Bean;
use Imi\Queue\Contract\IMessage;
use Imi\Queue\Driver\IQueueDriver;
use Imi\Queue\Service\BaseQueueConsumer;

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

    }

}
