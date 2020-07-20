<?php
namespace Yurun\Crawler\Module\Crawler\Contract;

use Imi\App;
use Imi\Log\Log;
use Imi\Bean\BeanFactory;
use Imi\Queue\Facade\Queue;
use Imi\Queue\Model\Message;
use Imi\Aop\Annotation\Inject;
use Imi\Cron\Consts\CronTaskType;
use Psr\Http\Message\ResponseInterface;
use Imi\Bean\Annotation\AnnotationManager;
use Yurun\Crawler\Module\Crawler\Annotation\Crawler;
use Yurun\Crawler\Module\Parser\Model\ParserMessage;
use Yurun\Crawler\Module\Crawler\Cron\CrawlerCronTask;
use Yurun\Crawler\Module\Crawler\Annotation\Downloader;
use Yurun\Crawler\Module\DataModel\Contract\IDataModel;
use Yurun\Crawler\Module\Crawler\Annotation\CrawlerCron;
use Yurun\Crawler\Module\Downloader\Model\DownloadMessage;
use Yurun\Crawler\Module\Processor\Model\ProcessorMessage;
use Yurun\Crawler\Module\Crawler\Annotation\Parser\CrawlerItemParser;
use Yurun\Crawler\Module\Crawler\Annotation\ProxyPool;

/**
 * 爬虫基类
 */
abstract class BaseCrawler implements ICrawler
{
    /**
     * 本对象真实的类名
     *
     * @var string
     */
    protected $realClassName;

    /**
     * 爬虫名称
     *
     * @var string
     */
    protected $name;

    /**
     * @Inject("CronManager")
     *
     * @var \Imi\Cron\CronManager
     */
    protected $cronManager;

    public function __construct()
    {
        $this->realClassName = $className = BeanFactory::getObjectClass($this);
        /** @var \Imi\Bean\Annotation\Bean $bean */
        $bean = AnnotationManager::getClassAnnotations($className, \Imi\Bean\Annotation\Bean::class)[0];
        if($bean)
        {
            $this->name = $bean->name;
        }
        else
        {
            $this->name = $className;
        }
    }

    /**
     * 开始爬取
     *
     * @return void
     */
    public function start()
    {
        $this->parseCron();
        $this->__start();
    }

    /**
     * 开始操作，一般做一些初始化操作
     * 
     * 子类中覆盖实现
     *
     * @return void
     */
    protected abstract function __start();

    /**
     * 运行爬取任务
     *
     * @return void
     */
    public function run()
    {
        /** @var Crawler $crawlerAnnotation */
        $crawlerAnnotation = AnnotationManager::getClassAnnotations($this->realClassName, Crawler::class)[0] ?? null;
        if(!$crawlerAnnotation)
        {
            return;
        }
        if($crawlerAnnotation->waitComplete && !$this->isLastTaskCompleted())
        {
            Log::info(sprintf('The crawler task that was run last time has not been completed yet, skip'));
            return;
        }
        $this->__run();
    }

    /**
     * 运行爬取任务
     * 
     * 子类中覆盖实现
     *
     * @return void
     */
    protected abstract function __run();

    /**
     * 获取下载器注解
     *
     * @return \Yurun\Crawler\Module\Crawler\Annotation\Downloader
     */
    public function getDownloaderAnnotation(): Downloader
    {
        $downloader = AnnotationManager::getClassAnnotations($this->realClassName, Downloader::class)[0] ?? null;
        if(null === $downloader)
        {
            $downloader = new Downloader;
        }
        return $downloader;
    }

    /**
     * 获取代理 IP 池注解
     *
     * @return \Yurun\Crawler\Module\Crawler\Annotation\ProxyPool|null
     */
    public function getProxyPoolAnnotation(): ?ProxyPool
    {
        return AnnotationManager::getClassAnnotations($this->realClassName, ProxyPool::class)[0] ?? null;
    }

    /**
     * 处理定时任务
     *
     * @return void
     */
    protected function parseCron()
    {
        /** @var CrawlerCron $tmpCrawlerCron */
        $tmpCrawlerCron = AnnotationManager::getClassAnnotations($this->realClassName, CrawlerCron::class)[0] ?? null;
        if(!$tmpCrawlerCron)
        {
            return;
        }
        $crawlerCron = clone $tmpCrawlerCron;
        $crawlerCron->id = $this->name;
        if(!$crawlerCron->type)
        {
            $crawlerCron->type = CronTaskType::PROCESS;
        }
        $this->cronManager->addCronByAnnotation($crawlerCron, CrawlerCronTask::class);
    }

    /**
     * 获取爬虫项集合
     *
     * @return array
     */
    public function getCrawlerItemNames(): array
    {
        $data = CrawlerItemParser::getInstance()->getData();
        $result = [];
        foreach(array_merge($data[$this->realClassName] ?? [], $data[$this->name] ?? []) as $item)
        {
            $result[] = $item['className'];
        }
        return $result;
    }

    /**
     * 上一次运行的爬取任务是否执行完成
     *
     * @return boolean
     */
    public function isLastTaskCompleted(): bool
    {
        foreach($this->getCrawlerItemNames() as $itemName)
        {
            /** @var \Yurun\Crawler\Module\Crawler\Contract\BaseCrawlerItem $crawlerItem */
            $crawlerItem = App::getBean($itemName);
            foreach([
                $crawlerItem->getDownloaderAnnotation()->queue,
                $crawlerItem->getParserAnnotation()->queue,
                $crawlerItem->getProcessorAnnotation()->queue,
            ] as $queue)
            {
                $status = Queue::getQueue($queue)->status();
                if($status->getReady() > 0 || $status->getWorking() > 0 || $status->getDelay() > 0)
                {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * 获取爬虫名称
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

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
    public function pushDownloadMessage(string $crawlerItem, string $url, string $method = 'GET', string $body = '', array $headers = [], array $data = []): string
    {
        $downloadMessage = new DownloadMessage($this->name, $crawlerItem, $url, $method, $body, $headers, $data);
        /** @var \Yurun\Crawler\Module\Crawler\Contract\BaseCrawlerItem $crawlerItemInstance */
        $crawlerItemInstance = App::getBean($crawlerItem);
        $downloaderAnnotation = $crawlerItemInstance->getDownloaderAnnotation();
        $message = new Message;
        $message->setMessage($downloadMessage);
        if($downloaderAnnotation->timeout > 0)
        {
            $message->setWorkingTimeout($downloaderAnnotation->timeout);
        }
        return Queue::getQueue($downloaderAnnotation->queue)->push($message);
    }

    /**
     * 推送解析器消息
     *
     * @param string $crawlerItem
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param array $data
     * @return void
     */
    public function pushParserMessage(string $crawlerItem, ResponseInterface $response, array $data = [])
    {
        $parserMessage = ParserMessage::createFromResponse($this->name, $crawlerItem, $response, $data);
        /** @var \Yurun\Crawler\Module\Crawler\Contract\BaseCrawlerItem $crawlerItemInstance */
        $crawlerItemInstance = App::getBean($crawlerItem);
        $parserAnnotation = $crawlerItemInstance->getParserAnnotation();
        $message = new Message;
        $message->setMessage($parserMessage);
        if($parserAnnotation->timeout > 0)
        {
            $message->setWorkingTimeout($parserAnnotation->timeout);
        }
        return Queue::getQueue($parserAnnotation->queue)->push($message);
    }

    /**
     * 推送处理器消息
     *
     * @param string $crawlerItem
     * @param \Yurun\Crawler\Module\DataModel\Contract\IDataModel $dataModel
     * @param array $data
     * @return void
     */
    public function pushProcessorMessage(string $crawlerItem, IDataModel $dataModel, array $data = [])
    {
        $processorMessage = new ProcessorMessage($this->name, $crawlerItem, $dataModel, $data);
        /** @var \Yurun\Crawler\Module\Crawler\Contract\BaseCrawlerItem $crawlerItemInstance */
        $crawlerItemInstance = App::getBean($crawlerItem);
        $processorAnnotation = $crawlerItemInstance->getProcessorAnnotation();
        $message = new Message;
        $message->setMessage($processorMessage);
        if($processorAnnotation->timeout > 0)
        {
            $message->setWorkingTimeout($processorAnnotation->timeout);
        }
        return Queue::getQueue($processorAnnotation->queue)->push($message);
    }

}
