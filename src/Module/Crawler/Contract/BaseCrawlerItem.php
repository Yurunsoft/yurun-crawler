<?php
namespace Yurun\Crawler\Module\Crawler\Contract;

use Imi\App;
use Imi\Bean\BeanFactory;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Imi\Bean\Annotation\AnnotationManager;
use Imi\Util\Http\Consts\RequestHeader;
use Yurun\Crawler\Module\Proxy\Model\Proxy;
use Psr\Http\Message\ServerRequestInterface;
use Yurun\Crawler\Module\Crawler\Annotation\Parser;
use Yurun\Crawler\Module\Parser\Model\ParserParams;
use Yurun\Crawler\Module\Crawler\Annotation\Processor;
use Yurun\Crawler\Module\Crawler\Annotation\ProxyPool;
use Yurun\Crawler\Module\Crawler\Annotation\Downloader;
use Yurun\Crawler\Module\DataModel\Contract\IDataModel;
use Yurun\Crawler\Module\Crawler\Annotation\CrawlerItem;
use Yurun\Crawler\Module\Crawler\Annotation\RandomUA;
use Yurun\Crawler\Module\Downloader\Model\DownloadParams;
use Yurun\Crawler\Module\Processor\Model\ProcessorParams;

/**
 * 采集项目基类
 */
abstract class BaseCrawlerItem implements ICrawlerItem
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
     * 下载
     *
     * @param \Yurun\Crawler\Module\Downloader\Model\DownloadParams $params
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function download(DownloadParams $params): ResponseInterface
    {
        $response = $this->beforeDownload($params);
        if($response)
        {
            return $response;
        }
        if(!$params->proxy && $proxyPoolAnnotation = $this->getProxyPoolAnnotation())
        {
            // 处理代理 IP
            /** @var \Yurun\Crawler\Module\Proxy\Contract\IProxyPool $proxyPool */
            $proxyPool = App::getBean($proxyPoolAnnotation->class, ...$proxyPoolAnnotation->args);
            $params->proxy = $proxyPool->{'get' . $proxyPoolAnnotation->method . 'Proxy'}();
        }
        // UserAgent
        /** @var RandomUA $randomUA */
        $randomUA = $this->autoGetAnnotation(RandomUA::class);
        if($randomUA && $randomUA->enable)
        {
            /** @var \Yurun\Crawler\Module\Downloader\Util\UserAgentManager $userAgentManager */
            $userAgentManager = App::getBean('UserAgentManager');
            $userAgent = $userAgentManager->getRandom();
            if($userAgent)
            {
                $params->request = $params->request->withHeader(RequestHeader::USER_AGENT, $userAgent);
            }
        }
        $downloaderAnnotation = $this->getDownloaderAnnotation();
        /** @var \Yurun\Crawler\Module\Downloader\Contract\IDownloader $downloader */
        $downloader = App::getBean($downloaderAnnotation->class);
        $response = $downloader->download($this, $params->request, $params->proxy);
        return $this->afterDownload($params, $response);
    }

    /**
     * 下载内容前置操作
     *
     * @param \Yurun\Crawler\Module\Downloader\Model\DownloadParams $params
     * @return \Psr\Http\Message\ResponseInterface|null
     */
    protected function beforeDownload(DownloadParams $params): ?ResponseInterface
    {
        return null;
    }

    /**
     * 下载内容后置操作
     *
     * @param \Yurun\Crawler\Module\Downloader\Model\DownloadParams $params
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function afterDownload(DownloadParams $params, ResponseInterface $response): ResponseInterface
    {
        return $response;
    }

    /**
     * 解析
     *
     * @param \Yurun\Crawler\Module\Parser\Model\ParserParams $params
     * @return \Yurun\Crawler\Module\DataModel\Contract\IDataModel
     */
    public function parse(ParserParams $params): IDataModel
    {
        $parserAnnotation = $this->getParserAnnotation();
        $modelClass = $parserAnnotation->model;
        $data = $this->beforeParse($params, $modelClass);
        if($data)
        {
            return $data;
        }
        /** @var \Yurun\Crawler\Module\Parser\Contract\IParser $parser */
        $parser = App::getBean('CrawlerParser');
        $data = $parser->parse($this, $params->response, $modelClass);
        return $this->afterParse($params, $modelClass, $data);
    }

    /**
     * 解析前置操作
     *
     * @param \Yurun\Crawler\Module\Parser\Model\ParserParams $params
     * @param string $modelClass
     * @return \Yurun\Crawler\Module\DataModel\Contract\IDataModel|null
     */
    protected function beforeParse(ParserParams $params, string $modelClass): ?IDataModel
    {
        return null;
    }

    /**
     * 解析后置操作
     *
     * @param \Yurun\Crawler\Module\Parser\Model\ParserParams $params
     * @param string $modelClass
     * @param \Yurun\Crawler\Module\DataModel\Contract\IDataModel $data
     * @return \Yurun\Crawler\Module\DataModel\Contract\IDataModel|null
     */
    protected function afterParse(ParserParams $params, string $modelClass, IDataModel $data): IDataModel
    {
        return $data;
    }

    /**
     * 处理
     *
     * @param \Yurun\Crawler\Module\Processor\Model\ProcessorParams $params
     * @return void
     */
    public function process(ProcessorParams $params)
    {
        $this->beforeProcess($params);
        $processorAnnotation = $this->getProcessorAnnotation();
        // 注解定义的处理器
        foreach((array)$processorAnnotation->class as $class)
        {
            /** @var \Yurun\Crawler\Module\Processor\Contract\IProcessor $processor */
            $processor = App::getBean($class);
            $processor->process($this, $params->dataModel);
        }
        $this->afterProcess($params);
    }

    /**
     * 处理前置操作
     *
     * @param \Yurun\Crawler\Module\Processor\Model\ProcessorParams $params
     * @return void
     */
    protected function beforeProcess(ProcessorParams $params)
    {

    }

    /**
     * 处理后置操作
     *
     * @param \Yurun\Crawler\Module\Processor\Model\ProcessorParams $params
     * @return void
     */
    protected function afterProcess(ProcessorParams $params)
    {

    }

    /**
     * 获取采集项目注解列表
     *
     * @return \Yurun\Crawler\Module\Crawler\Annotation\CrawlerItem
     */
    public function getCrawlerItemAnnotation(): CrawlerItem
    {
        $class = BeanFactory::getObjectClass($this);
        $result = AnnotationManager::getClassAnnotations($class, CrawlerItem::class)[0] ?? null;
        if(!$result)
        {
            throw new InvalidArgumentException(sprintf('Class %s must have a @CrawlerItem annotation', $class));
        }
        return $result;
    }

    /**
     * 获取下载器注解
     *
     * @return \Yurun\Crawler\Module\Crawler\Annotation\Downloader
     */
    public function getDownloaderAnnotation(): Downloader
    {
        $class = BeanFactory::getObjectClass($this);
        $downloader = AnnotationManager::getClassAnnotations($class, Downloader::class)[0] ?? null;
        if($downloader)
        {
            return $downloader;
        }
        else
        {
            $crawlerItem = $this->getCrawlerItemAnnotation();
            /** @var \Yurun\Crawler\Module\Crawler\Contract\BaseCrawler $crawler */
            $crawler = App::getBean($crawlerItem->class);
            return $crawler->getDownloaderAnnotation();
        }
    }

    /**
     * 获取代理 IP 池注解
     *
     * @return \Yurun\Crawler\Module\Crawler\Annotation\ProxyPool|null
     */
    public function getProxyPoolAnnotation(): ?ProxyPool
    {
        $class = BeanFactory::getObjectClass($this);
        $proxyPool = AnnotationManager::getClassAnnotations($class, ProxyPool::class)[0] ?? null;
        if($proxyPool)
        {
            return $proxyPool;
        }
        else
        {
            $crawlerItem = $this->getCrawlerItemAnnotation();
            /** @var \Yurun\Crawler\Module\Crawler\Contract\BaseCrawler $crawler */
            $crawler = App::getBean($crawlerItem->class);
            return $crawler->getProxyPoolAnnotation();
        }
    }

    /**
     * 获取解析器注解
     *
     * @return \Yurun\Crawler\Module\Crawler\Annotation\Parser
     */
    public function getParserAnnotation(): Parser
    {
        $class = BeanFactory::getObjectClass($this);
        $result = AnnotationManager::getClassAnnotations($class, Parser::class)[0] ?? null;
        if(!$result)
        {
            throw new InvalidArgumentException(sprintf('Class %s must have a @Parser annotation', $class));
        }
        return $result;
    }

    /**
     * 获取处理器注解
     *
     * @return \Yurun\Crawler\Module\Crawler\Annotation\Processor
     */
    public function getProcessorAnnotation(): Processor
    {
        $class = BeanFactory::getObjectClass($this);
        $result = AnnotationManager::getClassAnnotations($class, Processor::class)[0] ?? null;
        if(!$result)
        {
            throw new InvalidArgumentException(sprintf('Class %s must have a @Processor annotation', $class));
        }
        return $result;
    }

    /**
     * 获取爬虫对象
     *
     * @return ICrawler
     */
    public function getCrawler(): ICrawler
    {
        $crawlerItemAnnotation = $this->getCrawlerItemAnnotation();
        return App::getBean($crawlerItemAnnotation->class);
    }

    /**
     * 获取爬虫项名称
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * 智能获取注解，可以写在：采集项、爬虫类
     *
     * @param string $annotationClassName
     * @return \Imi\Bean\Annotation\Base|null
     */
    public function autoGetAnnotation(string $annotationClassName): ?\Imi\Bean\Annotation\Base
    {
        $class = BeanFactory::getObjectClass($this);
        $annotation = AnnotationManager::getClassAnnotations($class, $annotationClassName)[0] ?? null;
        if($annotation)
        {
            return $annotation;
        }
        $crawler = $this->getCrawler();
        $class = BeanFactory::getObjectClass($crawler);
        return AnnotationManager::getClassAnnotations($class, $annotationClassName)[0] ?? null;
    }

}
