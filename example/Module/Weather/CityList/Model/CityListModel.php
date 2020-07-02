<?php
namespace Yurun\CrawlerApp\Module\Weather\CityList;

use Yurun\Crawler\Module\Parser\Annotation\JsonSelect;
use Yurun\Crawler\Module\DataModel\Contract\IDataModel;

/**
 * 城市列表模型
 */
class CityListModel implements IDataModel
{
    /**
     * @JsonSelect()
     *
     * @var CityModel[]
     */
    public $list;

}
