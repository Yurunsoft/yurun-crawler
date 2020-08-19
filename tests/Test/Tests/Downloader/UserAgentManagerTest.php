<?php
namespace Yurun\Crawler\Test\Tests\Downloader;

use Imi\App;
use PHPUnit\Framework\TestCase;

class UserAgentManagerTest extends TestCase
{
    public function testUserAgentManager()
    {
        /** @var \Yurun\Crawler\Module\Downloader\Util\UserAgentManager $userAgentManager */
        $userAgentManager = App::getBean('UserAgentManager');
        $this->assertEquals(['a', 'b', 'c'], $userAgentManager->getList());
        for($i = 0; $i < 100; ++$i)
        {
            $ua = $userAgentManager->getRandom();
            if(!in_array($ua, ['a', 'b', 'c']))
            {
                var_dump($ua);
                $this->assertTrue(false);
            }
        }
        $this->assertTrue(true);
    }

}
