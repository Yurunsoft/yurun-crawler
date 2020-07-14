<?php
namespace Yurun\Crawler\Test\PHPUintListener;

use Imi\App;
use Imi\Tool\Tool;
use Imi\Event\Event;
use Imi\Event\EventParam;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\Warning;
use PHPUnit\Framework\TestSuite;
use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\AssertionFailedError;
use Imi\Pool\PoolManager;
use Imi\Db\Interfaces\IDb;
use Imi\Redis\RedisHandler;

class ImiListener implements TestListener
{
    private $isLoadedImi = false;

    public function __construct()
    {
    }

    /**
     * An error occurred.
     */
    public function addError(Test $test, \Throwable $t, float $time): void
    {
    }

    /**
     * A warning occurred.
     */
    public function addWarning(Test $test, Warning $e, float $time): void
    {
    }

    /**
     * A failure occurred.
     */
    public function addFailure(Test $test, AssertionFailedError $e, float $time): void
    {
    }

    /**
     * Incomplete test.
     */
    public function addIncompleteTest(Test $test, \Throwable $t, float $time): void
    {
    }

    /**
     * Risky test.
     */
    public function addRiskyTest(Test $test, \Throwable $t, float $time): void
    {
    }

    /**
     * Skipped test.
     */
    public function addSkippedTest(Test $test, \Throwable $t, float $time): void
    {
    }

    /**
     * A test suite started.
     */
    public function startTestSuite(TestSuite $suite): void
    {
    }

    /**
     * A test suite ended.
     */
    public function endTestSuite(TestSuite $suite): void
    {
    }

    /**
     * A test started.
     */
    public function startTest(Test $test): void
    {
        if(!$this->isLoadedImi)
        {
            Event::on('IMI.INIT_TOOL', function(EventParam $param){
                $data = $param->getData();
                $data['skip'] = true;
                Tool::init();
                $this->isLoadedImi = true;
            });
            Event::on('IMI.INITED', function(EventParam $param){
                App::initWorker();
                go(function() use($param){
                    $param->stopPropagation();
                    PoolManager::use('maindb', function($resource, IDb $db){
                        $truncateList = [
                            'tb_article',
                        ];
                        foreach($truncateList as $table)
                        {
                            $db->exec('TRUNCATE ' . $table);
                        }
                        $db->exec('drop table tb_proxy_test');
                    });
                    PoolManager::use('redis', function($resource, RedisHandler $redis){
                        $redis->del('yurun:crawler:proxyPool:test');
                    });;
                });
            }, 1);
            echo 'init imi...', PHP_EOL;
            App::run('Yurun\Crawler\Test');
            echo 'imi inited!', PHP_EOL;
        }
        if(method_exists($test, '__autoInject'))
        {
            $methodRef = new \ReflectionMethod($test, '__autoInject');
            $methodRef->setAccessible(true);
            $methodRef->invoke($test);
        }
        $this->success = true;
    }

    /**
     * A test ended.
     */
    public function endTest(Test $test, float $time): void
    {
    }

}