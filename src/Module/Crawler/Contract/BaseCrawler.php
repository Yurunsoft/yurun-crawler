<?php
namespace Yurun\Crawler\Module\Crawler\Contract;

use Imi\Bean\BeanFactory;
use Imi\Aop\Annotation\Inject;
use Imi\Bean\Annotation\AnnotationManager;
use Yurun\Crawler\Module\Crawler\Cron\CrawlerCronTask;
use Yurun\Crawler\Module\Crawler\Annotation\Downloader;
use Yurun\Crawler\Module\Crawler\Annotation\CrawlerCron;

/**
 * 爬虫基类
 */
abstract class BaseCrawler implements ICrawler
{
    /**
     * 本对象真实的类名
     *
     * @var string
     */
    protected $realClassName;

    /**
     * @Inject("CronManager")
     *
     * @var \Imi\Cron\CronManager
     */
    protected $cronManager;

    public function __construct()
    {
        $this->realClassName = BeanFactory::getObjectClass($this);
    }

    /**
     * 开始爬取
     *
     * @return void
     */
    public function start()
    {
        $this->parseCron();
        $this->__start();
    }

    /**
     * 开始操作，子类中覆盖实现
     *
     * @return void
     */
    protected abstract function __start();

    /**
     * 获取下载器注解
     *
     * @return \Yurun\Crawler\Module\Crawler\Annotation\Downloader
     */
    public function getDownloaderAnnotation(): Downloader
    {
        $downloader = AnnotationManager::getClassAnnotations($this->realClassName, Downloader::class)[0] ?? null;
        if(null === $downloader)
        {
            $downloader = new Downloader;
        }
        return $downloader;
    }

    /**
     * 处理定时任务
     *
     * @return void
     */
    protected function parseCron()
    {
        $crawlerCron = AnnotationManager::getClassAnnotations($this->realClassName, CrawlerCron::class)[0] ?? null;
        if(!$crawlerCron)
        {
            return;
        }
        $this->cronManager->addCronByAnnotation($crawlerCron, CrawlerCronTask::class);
    }

}
