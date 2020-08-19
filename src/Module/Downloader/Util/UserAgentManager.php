<?php
namespace Yurun\Crawler\Module\Downloader\Util;

use Imi\Bean\Annotation\Bean;

/**
 * @Bean("UserAgentManager")
 */
class UserAgentManager
{
    /**
     * UserAgent 列表
     *
     * @var array
     */
    protected $list;

    /**
     * Get userAgent 列表
     *
     * @return array
     */ 
    public function getList(): array
    {
        return $this->list;
    }

    /**
     * 获取随机 UserAgent
     *
     * @return string|null
     */
    public function getRandom(): ?string
    {
        if(!$this->list)
        {
            return null;
        }
        return $this->list[array_rand($this->list)];
    }

}
