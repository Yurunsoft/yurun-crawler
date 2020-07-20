<?php
namespace Yurun\Crawler\Module\Parser\Handler;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DomCrawler\Crawler;
use Imi\Bean\Annotation\AnnotationManager;
use Yurun\Crawler\Module\Parser\Annotation\DomSelect;
use Yurun\Crawler\Module\Parser\Enum\DomSelectMethod;
use Yurun\Crawler\Module\Crawler\Contract\ICrawlerItem;
use Yurun\Crawler\Module\DataModel\Contract\IDataModel;
use Yurun\Crawler\Module\Parser\Contract\IParserHandler;
use Yurun\Crawler\Module\Parser\Annotation\BaseParserAnnotation;

/**
 * Dom 解析器
 */
class DomParser implements IParserHandler
{
    /**
     * 解析响应数据为数据模型
     *
     * @param \Yurun\Crawler\Module\Crawler\Contract\ICrawlerItem $crawlerItem
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param \Yurun\Crawler\Module\Parser\Annotation\BaseParserAnnotation $parserAnnotation
     * @param mixed $parentInstance
     * @param boolean $isArray
     * @return mixed
     */
    public function parse(ICrawlerItem $crawlerItem, ResponseInterface $response, BaseParserAnnotation $parserAnnotation, $parentInstance = null, bool $isArray = false)
    {
        switch(get_class($parserAnnotation))
        {
            case DomSelect::class:
                return $this->parseDomSelect($response, $parserAnnotation, $parentInstance, $isArray);
            default:
                throw new \InvalidArgumentException(sprintf('Parser annotation %s parse method not found', get_class($parserAnnotation)));
        }
    }

    /**
     * Dom 解析
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param \Yurun\Crawler\Module\Parser\Annotation\DomSelect $parserAnnotation
     * @param mixed $parentInstance
     * @param boolean $isArray
     * @return mixed
     */
    public function parseDomSelect(ResponseInterface $response, DomSelect $parserAnnotation, $parentInstance = null, bool $isArray = false)
    {
        if($parentInstance instanceof \Symfony\Component\DomCrawler\Crawler)
        {
            $doc = $parentInstance;
        }
        else
        {
            $doc = new Crawler($parentInstance ?? $response->getBody()->__toString());
        }
        if($parserAnnotation->selector)
        {
            $doc = $doc->filter($parserAnnotation->selector);
        }
        $method = $parserAnnotation->method;
        if(null === $method)
        {
            return $doc;
        }
        $params = (array)$parserAnnotation->param;
        if(DomSelectMethod::TEXT === $method && !$params)
        {
            $params = ['', true];
        }
        if($isArray)
        {
            $result = [];
            foreach($doc as $item)
            {
                $result[] = (new Crawler($item))->$method(...$params);
            }
            return $result;
        }
        else if($doc->count() > 0)
        {
            return $doc->$method(...$params);
        }
    }

}
