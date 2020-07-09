<?php
namespace Yurun\Crawler\Module\DataModel\Contract;

/**
 * 数据模型接口
 */
interface IDataModel
{
    /**
     * 从数组加载数据
     *
     * @param array $array
     * @return void
     */
    public function loadFromArray(array $array);

}
