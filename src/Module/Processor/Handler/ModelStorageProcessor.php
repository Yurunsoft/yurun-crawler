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
        if(!is_subclass_of($modelStorage->model, \Imi\Model\BaseModel::class))
        {
            throw new \InvalidArgumentException(sprintf('%s is not a model class', $modelStorage->model));
        }
        if($fields = $modelStorage->fields)
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
        else
        {
            $model = ($modelStorage->model)::newInstance($data);
        }
        // 重复数据不入库判断
        if($uniqueFields = $modelStorage->uniqueFields)
        {
            /** @var \Imi\Db\Query\Interfaces\IQuery $query */
            $query = ($modelStorage->model)::dbQuery();
            foreach($uniqueFields as $field)
            {
                $query->where($field, '=', $model->$field);
            }
            if(1 == $query->fieldRaw('1')->limit(1)->select()->getScalar())
            {
                return;
            }
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
