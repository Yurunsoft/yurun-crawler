<?php
namespace Yurun\Crawler\Module\Crawler\Contract;

/**
 * 爬虫对象接口
 */
interface ICrawler
{
    /**
     * 开始爬取
     *
     * @return void
     */
    public function start();

    /**
     * 运行爬取任务
     *
     * @return void
     */
    public function run();

}
