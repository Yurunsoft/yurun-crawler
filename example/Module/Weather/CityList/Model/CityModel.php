<?php
namespace Yurun\CrawlerApp\Module\Weather\CityList\Model;

use Yurun\Crawler\Module\Parser\Annotation\JsonSelect;
use Yurun\Crawler\Module\DataModel\Contract\IDataModel;

/**
 * 城市模型
 */
class CityModel implements IDataModel
{
    /**
     * @JsonSelect("id")
     *
     * @var int
     */
    public $id;

    /**
     * @JsonSelect("pid")
     *
     * @var int
     */
    public $pid;

    /**
     * @JsonSelect("city_code")
     *
     * @var string
     */
    public $cityCode;

    /**
     * @JsonSelect("city_name")
     *
     * @var string
     */
    public $cityName;

    /**
     * @JsonSelect("post_code")
     *
     * @var string
     */
    public $postCode;

    /**
     * @JsonSelect("area_code")
     *
     * @var string
     */
    public $areaCode;

    /**
     * @JsonSelect("ctime")
     *
     * @var string
     */
    public $ctime;

}
