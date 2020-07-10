<?php
namespace Yurun\Crawler\Module\Parser\Handler;

use Imi\Util\Imi;
use Imi\Util\ArrayData;
use Psr\Http\Message\ResponseInterface;
use Yurun\Crawler\Module\Parser\Annotation\JsonSelect;
use Yurun\Crawler\Module\Crawler\Contract\ICrawlerItem;
use Yurun\Crawler\Module\Parser\Contract\IParserHandler;
use Yurun\Crawler\Module\Parser\Annotation\BaseParserAnnotation;

/**
 * JSON 解析器
 */
class JsonParser implements IParserHandler
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
            case JsonSelect::class:
                return $this->parseJsonSelect($response, $parserAnnotation, $parentInstance, $isArray);
            default:
                throw new \InvalidArgumentException(sprintf('Parser annotation %s parse method not found', get_class($parserAnnotation)));
        }
    }

    /**
     * Dom 解析
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param \Yurun\Crawler\Module\Parser\Annotation\JsonSelect $parserAnnotation
     * @param mixed $parentInstance
     * @param boolean $isArray
     * @return mixed
     */
    public function parseJsonSelect(ResponseInterface $response, JsonSelect $parserAnnotation, $parentInstance = null, bool $isArray = false)
    {
        if(is_string($parentInstance))
        {
            $jsonData = json_decode($parentInstance, true);
            if(false === $jsonData)
            {
                $jsonData = $parentInstance;
            }
        }
        else if(null === $parentInstance)
        {
            $jsonData = json_decode($response->getBody()->__toString(), true);
        }
        else
        {
            $jsonData = $parentInstance;
        }
        $selector = $parserAnnotation->selector;
        if(null === $selector)
        {
            return $jsonData;
        }
        $selectorMuiltLevel = false === strpos($selector, '.');
        if($selectorMuiltLevel)
        {
            $parsedSelector = Imi::parseDotRule($selector);
        }
        if($isArray)
        {
            $result = [];
            foreach($jsonData as $jsonItem)
            {
                if($selectorMuiltLevel)
                {
                    $arrayData = new ArrayData($jsonItem);
                    $result[] = $arrayData->get($parsedSelector, null);
                }
                else
                {
                    $result[] = $jsonItem[$selector];
                }
            }
            return $result;
        }
        else
        {
            if($selectorMuiltLevel)
            {
                $arrayData = new ArrayData($jsonData);
                return $arrayData->get($parsedSelector, null);
            }
            else
            {
                return $jsonData[$selector];
            }
        }
    }

}
