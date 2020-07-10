<?php
namespace Yurun\Crawler\Module\Parser\Handler;

use Imi\Util\Imi;
use Imi\Util\ArrayData;
use Psr\Http\Message\ResponseInterface;
use Yurun\Crawler\Module\Crawler\Contract\ICrawlerItem;
use Yurun\Crawler\Module\Parser\Annotation\RegularMatch;
use Yurun\Crawler\Module\Parser\Contract\IParserHandler;
use Yurun\Crawler\Module\Parser\Annotation\BaseParserAnnotation;

/**
 * 正则解析器
 */
class RegularParser implements IParserHandler
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
            case RegularMatch::class:
                return $this->parseRegularMatch($response, $parserAnnotation, $parentInstance, $isArray);
            default:
                throw new \InvalidArgumentException(sprintf('Parser annotation %s parse method not found', get_class($parserAnnotation)));
        }
    }

    /**
     * Dom 解析
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param \Yurun\Crawler\Module\Parser\Annotation\RegularMatch $parserAnnotation
     * @param mixed $parentInstance
     * @param boolean $isArray
     * @return mixed
     */
    public function parseRegularMatch(ResponseInterface $response, RegularMatch $parserAnnotation, $parentInstance = null, bool $isArray = false)
    {
        if(is_string($parentInstance))
        {
            if($isArray)
            {
                preg_match_all($parserAnnotation->pattern, $parentInstance, $matches, PREG_SET_ORDER);
            }
            else
            {
                preg_match($parserAnnotation->pattern, $parentInstance, $matches);
            }
        }
        else if(null === $parentInstance)
        {
            if($isArray)
            {
                preg_match_all($parserAnnotation->pattern, $response->getBody()->__toString(), $matches, PREG_SET_ORDER);
            }
            else
            {
                preg_match($parserAnnotation->pattern, $response->getBody()->__toString(), $matches);
            }
        }
        else
        {
            $matches = $parentInstance;
        }
        $resultIndex = $parserAnnotation->index;
        if(null === $resultIndex)
        {
            return $matches;
        }
        $indexMuiltLevel = false === strpos($resultIndex, '.');
        if($indexMuiltLevel)
        {
            $parsedIndex = Imi::parseDotRule($resultIndex);
        }
        if($isArray)
        {
            $result = [];
            foreach($matches as $matchItem)
            {
                if($indexMuiltLevel)
                {
                    $arrayData = new ArrayData($matchItem);
                    $result[] = $arrayData->get($parsedIndex, null);
                }
                else
                {
                    $result[] = $matchItem[$resultIndex];
                }
            }
            return $result;
        }
        else
        {
            if($indexMuiltLevel)
            {
                $arrayData = new ArrayData($matches);
                return $arrayData->get($parsedIndex, null);
            }
            else
            {
                return $matches[$resultIndex];
            }
        }
    }

}
