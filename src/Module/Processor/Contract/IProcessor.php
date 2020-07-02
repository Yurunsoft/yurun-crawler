<?php
namespace Yurun\Crawler\Module\Processor\Contract;

use Yurun\Crawler\Module\DataModel\Contract\IDataModel;

/**
 * 处理器接口
 */
interface IProcessor
{
    /**
     * 处理数据模型
     *
     * @param \Yurun\Crawler\Module\DataModel\Contract\IDataModel $data
     * @return void
     */
    public function process(IDataModel $data);

}
