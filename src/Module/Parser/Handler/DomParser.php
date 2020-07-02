<?php
namespace Yurun\Crawler\Module\Parser\Handler;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DomCrawler\Crawler;
use Imi\Bean\Annotation\AnnotationManager;
use Yurun\Crawler\Module\Parser\Annotation\DomSelect;
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
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param \Yurun\Crawler\Module\Parser\Annotation\BaseParserAnnotation $parserAnnotation
     * @param mixed $parentInstance
     * @param boolean $isArray
     * @return mixed
     */
    public function parse(ResponseInterface $response, BaseParserAnnotation $parserAnnotation, $parentInstance = null, bool $isArray = false)
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
        if($parentInstance instanceof \phpQueryObject)
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
        if($isArray)
        {
            $result = [];
            $doc->each(function(Crawler $doc) use(&$result, $method, $params){
                $result[] = $doc->$method(...$params);
            });
            return $result;
        }
        else
        {
            return $doc->$method(...$params);
        }
    }

}
