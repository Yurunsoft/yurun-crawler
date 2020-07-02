<?php
namespace Yurun\CrawlerApp\Module\Weather\CityList;

use Imi\Bean\Annotation\Bean;
use Imi\Log\Log;
use Yurun\Crawler\Module\DataModel\Contract\IDataModel;
use Yurun\Crawler\Module\Processor\Contract\IProcessor;

/**
 * 城市列表处理器
 * @Bean("CityListProcessor")
 */
class CityListProcessor implements IProcessor
{
    /**
     * 处理数据模型
     *
     * @param \Yurun\CrawlerApp\Module\Weather\CityList\CityListModel $data
     * @return void
     */
    public function process(IDataModel $data)
    {
        Log::info('City count:' . count($data->list));
    }

}
