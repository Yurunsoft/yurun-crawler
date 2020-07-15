# 开始编写采集——配置

## 配置

**beanScan：**

首先，别忘记在项目配置文件中配置 `beanScan`，把我们要编写的类所在命名空间包含进去。

比如在项目下建了 `Yurun\CrawlerApp\Module` 目录用于放采集模块，那就在 `beanScan` 中配置 `Yurun\CrawlerApp\Module` 

**连接池：**

MySQL 连接池配置详见：<https://doc.imiphp.com/components/db/index.html>
Redis 连接池配置详见：<https://doc.imiphp.com/components/redis/index.html>

**限流：**

限流键名前缀：

```php
'ratelimitPrefix'   =>  imiGetEnv('RATELIMIT_PREFIX', 'yurun:crawler:'),
```

**消息队列：**

文件：`config/beans.php`

参考默认的配置即可。

```php
'imiQueue'  =>  [
    // 队列列表
    'list'  =>  [
        // 默认下载器队列
        'defaultDownloader' =>  [
            // 使用的队列驱动
            'driver'        =>  \Imi\Queue\Driver\RedisQueueDriver::class,
            // 消费协程数量，下载器的可以稍微多一些
            'co'            =>  1024,
            // 消费进程数量；可能会受进程分组影响，以同一组中配置的最多进程数量为准
            'process'       =>  1,
            // 消费循环尝试 pop 的时间间隔，单位：秒
            'timespan'      =>  0.1,
            // 进程分组名称
            'processGroup'  =>  'downloader',
            // 自动消费
            'autoConsumer'  =>  true,
            // 消费者类
            'consumer'      =>  'DownloaderConsumer',
            // 驱动类所需要的参数数组
            'config'        =>  [
                'poolName'  =>  'redis',
                'prefix'    =>  'yurun:crawler:queue:',
            ]
        ],
        // 默认解析器队列
        'defaultParser' =>  [
            // 使用的队列驱动
            'driver'        =>  \Imi\Queue\Driver\RedisQueueDriver::class,
            // 消费协程数量
            'co'            =>  1,
            // 消费进程数量；可能会受进程分组影响，以同一组中配置的最多进程数量为准
            'process'       =>  swoole_cpu_num(),
            // 消费循环尝试 pop 的时间间隔，单位：秒
            'timespan'      =>  0.1,
            // 进程分组名称
            'processGroup'  =>  'parser',
            // 自动消费
            'autoConsumer'  =>  true,
            // 消费者类
            'consumer'      =>  'ParserConsumer',
            // 驱动类所需要的参数数组
            'config'        =>  [
                'poolName'  =>  'redis',
                'prefix'    =>  'yurun:crawler:queue:',
            ]
        ],
        // 默认处理器队列
        'defaultProcessor' =>  [
            // 使用的队列驱动
            'driver'        =>  \Imi\Queue\Driver\RedisQueueDriver::class,
            // 消费协程数量
            'co'            =>  swoole_cpu_num(),
            // 消费进程数量；可能会受进程分组影响，以同一组中配置的最多进程数量为准
            'process'       =>  swoole_cpu_num(),
            // 消费循环尝试 pop 的时间间隔，单位：秒
            'timespan'      =>  0.1,
            // 进程分组名称
            'processGroup'  =>  'processor',
            // 自动消费
            'autoConsumer'  =>  true,
            // 消费者类
            'consumer'      =>  'ProcessorConsumer',
            // 驱动类所需要的参数数组
            'config'        =>  [
                'poolName'  =>  'redis',
                'prefix'    =>  'yurun:crawler:queue:',
            ]
        ],
    ],
],
```
