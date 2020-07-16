<?php
namespace Yurun\Crawler\Module\Parser\Consumer;

use Imi\App;
use Imi\Bean\Annotation\Bean;
use Imi\Queue\Contract\IMessage;
use Imi\Queue\Driver\IQueueDriver;
use Imi\Queue\Service\BaseQueueConsumer;
use Yurun\Util\YurunHttp\Http\Psr7\Response;
use Yurun\Crawler\Module\Parser\Model\ParserParams;
use Yurun\Crawler\Module\Parser\Model\ParserMessage;

/**
 * 解析器消费者
 * 
 * @Bean("ParserConsumer")
 */
class ParserConsumer extends BaseQueueConsumer
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
        // 解析器消息处理
        $parserMessage = new ParserMessage;
        $parserMessage->loadFromJsonString($message->getMessage());
        /** @var \Yurun\Crawler\Module\Crawler\Contract\BaseCrawler $crawler */
        $crawler = App::getBean($parserMessage->crawler);
        /** @var \Yurun\Crawler\Module\Crawler\Contract\BaseCrawlerItem $crawlerItem */
        $crawlerItem = App::getBean($parserMessage->crawlerItem);
        $parserParams = new ParserParams;
        $parserParams->data = $parserMessage->data;
        // 构建响应对象
        $response = new Response($parserMessage->body, $parserMessage->statusCode);
        foreach($parserMessage->headers as $k => $v)
        {
            $response = $response->withHeader($k, $v);
        }
        $parserParams->response = $response;
        // 解析为模型
        $dataModel = $crawlerItem->parse($parserParams);
        // 推送处理器消息
        $crawler->pushProcessorMessage($parserMessage->crawlerItem, $dataModel, $parserParams->data);
        $queue->success($message);
    }

}
