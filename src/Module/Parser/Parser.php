<?php
namespace Yurun\Crawler\Module\Parser;

use Imi\App;
use Imi\Util\Imi;
use Imi\Bean\Annotation\Bean;
use Yurun\Crawler\Util\DocBlockUtil;
use Psr\Http\Message\ResponseInterface;
use Imi\Bean\Annotation\AnnotationManager;
use Yurun\Crawler\Module\Parser\Contract\IParser;
use Yurun\Crawler\Module\Crawler\Contract\ICrawlerItem;
use Yurun\Crawler\Module\DataModel\Contract\IDataModel;
use Yurun\Crawler\Module\Parser\Annotation\BaseParserAnnotation;

/**
 * @Bean("CrawlerParser")
 */
class Parser implements IParser
{
    /**
     * 解析响应数据为数据模型
     *
     * @param \Yurun\Crawler\Module\Crawler\Contract\ICrawlerItem $crawlerItem
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param string $modelClass
     * @param mixed $parentInstance
     * @param boolean $isArray
     * @return \Yurun\Crawler\Module\DataModel\Contract\IDataModel|array
     */
    public function parse(ICrawlerItem $crawlerItem, ResponseInterface $response, string $modelClass, $parentInstance = null, bool $isArray = false)
    {
        if($isArray)
        {
            $result = [];
            foreach($parentInstance as $item)
            {
                $result[] = $this->parse($crawlerItem, $response, $modelClass, $item, false);
            }
            return $result;
        }
        else
        {
            $model = new $modelClass;
            foreach(AnnotationManager::getPropertiesAnnotations($modelClass) as $property => $annotations)
            {
                foreach($annotations as $annotation)
                {
                    if($annotation instanceof BaseParserAnnotation)
                    {
                        /** @var \Yurun\Crawler\Module\Parser\Contract\IParserHandler $parserHandler */
                        $parserHandler = App::getBean($annotation->parser);
                        $propertyType = DocBlockUtil::getPropertyType($modelClass, $property, $propertyTypeIsArray);
                        $parseResult = $parserHandler->parse($crawlerItem, $response, $annotation, $parentInstance, $propertyTypeIsArray);
                        if(is_subclass_of($propertyType, IDataModel::class))
                        {
                            $model->$property = $this->parse($crawlerItem, $response, $propertyType, $parseResult, $propertyTypeIsArray);
                        }
                        else
                        {
                            $model->$property = $parseResult;
                        }
                        break;
                    }
                }
            }
            return $model;
        }
    }

}
