<?php
namespace Yurun\Crawler\Module\Crawler\Contract;

use Imi\App;
use Imi\Bean\BeanFactory;
use InvalidArgumentException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Imi\Bean\Annotation\AnnotationManager;
use Yurun\Crawler\Module\Crawler\Annotation\Parser;
use Yurun\Crawler\Module\Crawler\Annotation\Processor;
use Yurun\Crawler\Module\Crawler\Annotation\Downloader;
use Yurun\Crawler\Module\DataModel\Contract\IDataModel;
use Yurun\Crawler\Module\Crawler\Annotation\CrawlerItem;

/**
 * 采集项目基类
 */
abstract class BaseCrawlerItem implements ICrawlerItem
{
    /**
     * 下载
     *
     * @param \Psr\Http\Message\RequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function download(RequestInterface $request): ResponseInterface
    {
        $response = $this->beforeDownload($request);
        if($response)
        {
            return $response;
        }
        $downloaderAnnotation = $this->getDownloaderAnnotation();
        /** @var \Yurun\Crawler\Module\Downloader\Contract\IDownloader $diownloader */
        $diownloader = App::getBean($downloaderAnnotation->class);
        $response = $diownloader->download($request);
        return $this->afterDownload($request, $response);
    }

    /**
     * 下载内容前置操作
     *
     * @param \Psr\Http\Message\RequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface|null
     */
    protected function beforeDownload(RequestInterface &$request): ?ResponseInterface
    {
        return null;
    }

    /**
     * 下载内容后置操作
     *
     * @param \Psr\Http\Message\RequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function afterDownload(RequestInterface &$request, ResponseInterface $response): ResponseInterface
    {
        return $response;
    }

    /**
     * 解析
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return \Yurun\Crawler\Module\DataModel\Contract\IDataModel
     */
    public function parse(ResponseInterface $response): IDataModel
    {
        $parserAnnotation = $this->getParserAnnotation();
        $modelClass = $parserAnnotation->model;
        $data = $this->beforeParse($response, $modelClass);
        if($data)
        {
            return $data;
        }
        /** @var \Yurun\Crawler\Module\Parser\Contract\IParser $parser */
        $parser = App::getBean('CrawlerParser');
        $data = $parser->parse($response, $modelClass);
        return $this->afterParse($response, $modelClass, $data);
    }

    /**
     * 解析前置操作
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param string $modelClass
     * @return \Yurun\Crawler\Module\DataModel\Contract\IDataModel|null
     */
    protected function beforeParse(ResponseInterface $response, string $modelClass): ?IDataModel
    {
        return null;
    }

    /**
     * 解析后置操作
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param string $modelClass
     * @param \Yurun\Crawler\Module\DataModel\Contract\IDataModel $data
     * @return \Yurun\Crawler\Module\DataModel\Contract\IDataModel|null
     */
    protected function afterParse(ResponseInterface $response, string $modelClass, IDataModel $data): IDataModel
    {
        return $data;
    }

    /**
     * 处理
     *
     * @param \Yurun\Crawler\Module\DataModel\Contract\IDataModel $data
     * @return void
     */
    public function process(IDataModel $data)
    {
        $this->beforeProcess($data);
        $processorAnnotation = $this->getProcessorAnnotation();
        /** @var \Yurun\Crawler\Module\Processor\Contract\IProcessor $processor */
        $processor = App::getBean($processorAnnotation->class);
        $processor->process($data);
        $this->afterProcess($data);
    }

    /**
     * 处理前置操作
     *
     * @param \Yurun\Crawler\Module\DataModel\Contract\IDataModel $data
     * @return void
     */
    protected function beforeProcess(IDataModel $data)
    {

    }

    /**
     * 处理后置操作
     *
     * @param \Yurun\Crawler\Module\DataModel\Contract\IDataModel $data
     * @return void
     */
    protected function afterProcess(IDataModel $data)
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

}
