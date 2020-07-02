<?php
namespace Yurun\Crawler\Process;

use Imi\Process\Annotation\Process;

/**
 * 采集队列消费进程
 * 
 * @Process(name="CrawlerQueueConsumer", co=false)
 */
class QueueConsumerProcess extends \Imi\Queue\Process\QueueConsumerProcess
{

}
