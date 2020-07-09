<?php
namespace Yurun\Crawler\Module\Processor\Model;

use Imi\Bean\BeanFactory;
use Yurun\Crawler\Contract\BaseQueueMessage;
use Yurun\Crawler\Module\DataModel\Contract\IDataModel;

/**
 * 处理器消息
 */
class ProcessorMessage extends BaseQueueMessage
{
    /**
     * 爬虫名称
     *
     * @var string
     */
    public $crawler;

    /**
     * 爬虫项名称
     *
     * @var string
     */
    public $crawlerItem;

    /**
     * 数据模型类名
     *
     * @var string
     */
    public $dataModelClass;

    /**
     * 数据模型
     *
     * @var \Yurun\Crawler\Module\DataModel\Contract\IDataModel
     */
    public $dataModel;

    /**
     * 其它数据
     *
     * @var array|null
     */
    public $data;

    public function __construct(string $crawler = null, string $crawlerItem = null, IDataModel $dataModel = null, array $data = [])
    {
        $this->crawler = $crawler;
        $this->crawlerItem = $crawlerItem;
        $this->dataModel = $dataModel;
        $this->dataModelClass = BeanFactory::getObjectClass($dataModel);
        $this->data = $data;
    }

    /**
     * 从数组加载到当前对象
     *
     * @param array $array
     * @return void
     */
    public function loadFromArray(array $array)
    {
        if(isset($array['dataModel'], $array['dataModelClass']))
        {
            $dataModelClass = $array['dataModelClass'];
            /** @var \Yurun\Crawler\Module\DataModel\Contract\IDataModel $dataModel */
            $dataModel = new $dataModelClass;
            $dataModel->loadFromArray($array['dataModel']);
            $array['dataModel'] = $dataModel;
        }
        parent::loadFromArray($array);
    }

}
