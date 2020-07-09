<?php
namespace Yurun\Crawler\Contract;

/**
 * 队列消息基类
 */
abstract class BaseQueueMessage
{
    public function __toString()
    {
        return json_encode($this);
    }

    /**
     * 从数组加载到当前对象
     *
     * @param array $array
     * @return void
     */
    public function loadFromArray(array $array)
    {
        foreach($array as $k => $v)
        {
            $this->$k = $v;
        }
    }

    /**
     * 从 Json 字符串加载到当前对象
     *
     * @param string $jsonString
     * @return void
     */
    public function loadFromJsonString(string $jsonString)
    {
        $this->loadFromArray(json_decode($jsonString, true));
    }

}
