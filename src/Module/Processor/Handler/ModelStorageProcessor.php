<?php
namespace Yurun\Crawler\Module\Processor\Handler;

use Imi\Bean\BeanFactory;
use Imi\Bean\Annotation\Bean;
use Imi\Bean\Annotation\AnnotationManager;
use Yurun\Crawler\Module\Crawler\Contract\ICrawlerItem;
use Yurun\Crawler\Module\DataModel\Contract\IDataModel;
use Yurun\Crawler\Module\Processor\Contract\IProcessor;
use Yurun\Crawler\Module\Processor\Annotation\ModelStorage;

/**
 * 数据模型存储处理器
 * @Bean("ModelStorageProcessor")
 */
class ModelStorageProcessor implements IProcessor
{
    /**
     * 处理数据模型
     *
     * @param \Yurun\Crawler\Module\Crawler\Contract\ICrawlerItem $crawlerItem
     * @param \Yurun\Crawler\Module\DataModel\Contract\IDataModel $data
     * @return void
     */
    public function process(ICrawlerItem $crawlerItem, IDataModel $data)
    {
        $modelStorage = $this->getModelStorageAnnotation($crawlerItem);
        if(!$modelStorage)
        {
            return;
        }
        $fields = $modelStorage->fields;
        if($fields)
        {
            $model = ($modelStorage->model)::newInstance();
            foreach($data as $k => $v)
            {
                if(isset($fields[$k]))
                {
                    $model->{$fields[$k]} = $v;
                }
                else
                {
                    $model->$k = $v;
                }
            }
        }
        else if(is_subclass_of($modelStorage->model, \Imi\Model\BaseModel::class))
        {
            $model = ($modelStorage->model)::newInstance($data);
        }
        else
        {
            throw new \InvalidArgumentException(sprintf('%s is not a model class', $modelStorage->model));
        }
        $model->insert();
    }

    /**
     * 获取模型存储注解
     *
     * @param \Yurun\Crawler\Module\Crawler\Contract\ICrawlerItem $crawlerItem
     * @return \Yurun\Crawler\Module\Processor\Annotation\ModelStorage|null
     */
    public function getModelStorageAnnotation(ICrawlerItem $crawlerItem): ?ModelStorage
    {
        $class = BeanFactory::getObjectClass(BeanFactory::getObjectClass($crawlerItem));
        return AnnotationManager::getClassAnnotations($class, ModelStorage::class)[0] ?? null;
    }

}
