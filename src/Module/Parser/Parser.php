<?php
namespace Yurun\Crawler\Module\Parser;

use Imi\App;
use Imi\Util\Imi;
use Imi\Bean\Annotation\Bean;
use Yurun\Crawler\Util\DocBlockUtil;
use Psr\Http\Message\ResponseInterface;
use Imi\Bean\Annotation\AnnotationManager;
use Yurun\Crawler\Module\Parser\Contract\IParser;
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
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param string $modelClass
     * @param mixed $parentInstance
     * @param boolean $isArray
     * @return \Yurun\Crawler\Module\DataModel\Contract\IDataModel|array
     */
    public function parse(ResponseInterface $response, string $modelClass, $parentInstance = null, bool $isArray = false)
    {
        if($isArray)
        {
            $result = [];
            foreach($parentInstance as $item)
            {
                $result[] = $this->parse($response, $modelClass, $item, false);
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
                        $propertyType = DocBlockUtil::getPropertyType($modelClass, $property);
                        $propertyTypeIsArray = false !== strpos('[]', $propertyType);
                        if($propertyTypeIsArray)
                        {
                            $propertyTypeClass = substr($propertyType, 0, -2);
                        }
                        else
                        {
                            $propertyTypeClass = $propertyType;
                            $propertyTypeIsArray = 'array' === $propertyType;
                        }
                        if(false !== strpos($propertyTypeClass, '\\') && !class_exists($propertyTypeClass))
                        {
                            $newClass = Imi::getClassNamespace($modelClass) . '\\' . $propertyTypeClass;
                            if(class_exists($newClass))
                            {
                                $propertyTypeClass = $newClass;
                            }
                        }
                        $parseResult = $parserHandler->parse($response, $annotation, $parentInstance, $propertyTypeIsArray);
                        if(is_subclass_of($propertyTypeClass, IDataModel::class))
                        {
                            $model->$property = $this->parse($response, $propertyTypeClass, $parseResult, $propertyTypeIsArray);
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
