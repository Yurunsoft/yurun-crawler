<?php
namespace Yurun\Crawler\Module\DataModel\Contract;

use Imi\Util\Imi;
use Imi\Bean\BeanFactory;
use Yurun\Crawler\Util\DocBlockUtil;
use Imi\Bean\Annotation\AnnotationManager;
use Imi\Util\Traits\TNotRequiredDataToProperty;
use Yurun\Crawler\Module\Parser\Annotation\BaseParserAnnotation;

/**
 * 数据模型基类
 */
abstract class BaseDataModel implements IDataModel
{
    use TNotRequiredDataToProperty;

    /**
     * 从数组加载数据
     *
     * @param array $array
     * @return void
     */
    public function loadFromArray(array $array)
    {
        $modelClass = BeanFactory::getObjectClass($this);
        foreach(AnnotationManager::getPropertiesAnnotations(BeanFactory::getObjectClass($this)) as $property => $annotations)
        {
            if(!isset($array[$property]))
            {
                continue;
            }
            foreach($annotations as $annotation)
            {
                if($annotation instanceof BaseParserAnnotation)
                {
                    $propertyType = DocBlockUtil::getPropertyType($modelClass, $property, $propertyTypeIsArray);
                    if(class_exists($propertyType))
                    {
                        if($propertyTypeIsArray)
                        {
                            $items = [];
                            foreach($array[$property] as $item)
                            {
                                $model = new $propertyType;
                                $model->loadFromArray($item);
                                $items[] = $model;
                            }
                            $this->$property = $items;
                        }
                        else
                        {
                            $this->$property = $model = new $propertyType;
                            $model->loadFromArray($array[$property]);
                        }
                    }
                    else
                    {
                        $this->$property = $array[$property];
                    }
                }
            }
        }
    }

}
