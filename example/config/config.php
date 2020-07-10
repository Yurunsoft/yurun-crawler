<?php
return [
    // 项目根命名空间
    'namespace'    =>    'Yurun\CrawlerApp',

    // 配置文件
    'configs'    =>    [
        'beans'        =>    __DIR__ . '/beans.php',
    ],

    // 扫描目录
    'beanScan'    =>    [
        'Yurun\CrawlerApp\Listener',
        'Yurun\CrawlerApp\Task',
        'Yurun\CrawlerApp\Tool',
        'Yurun\CrawlerApp\Module',
    ],

    // 组件命名空间
    'components'    =>  [
        'Crawler'   =>  'Yurun\Crawler',
    ],

    // 主服务器配置
    'mainServer'    =>    [
        'namespace'    =>    'Yurun\CrawlerApp\ApiServer',
        'type'        =>    Imi\Server\Type::HTTP,
        'host'        =>    '127.0.0.1',
        'port'        =>    8080,
        'configs'    =>    [
            'worker_num'        =>  1,
            // 'task_worker_num'   =>  16,
        ],
    ],

    // 子服务器（端口监听）配置
    'subServers'        =>    [
        // 'SubServerName'   =>  [
        //     'namespace'    =>    'Yurun\Crawler\XXXServer',
        //     'type'        =>    Imi\Server\Type::HTTP,
        //     'host'        =>    '127.0.0.1',
        //     'port'        =>    13005,
        // ]
    ],

    // 连接池配置
    'pools'    =>    [
        // 主数据库
        'maindb'    =>    [
            'pool' => [
                // 同步池类名
                'syncClass'     =>    \Imi\Db\Pool\SyncDbPool::class,
                // 协程池类名
                'asyncClass'    =>    \Imi\Db\Pool\CoroutineDbPool::class,
                // 连接池配置
                'config' => [
                    // 池子中最多资源数
                    'maxResources' => 16,
                    // 池子中最少资源数
                    'minResources' => 0,
                ],
            ],
            // 连接池资源配置
            'resource' => [
                'host' => '127.0.0.1',
                'username' => 'root',
                'password' => 'root',
                'database' => 'db_yurun_crawler_example',
                'port'    => 3306,
                'charset' => 'utf8mb4',
            ],
        ],
        'redis'    =>    [
            'pool' => [
                // 同步池类名
                'syncClass'     =>    \Imi\Redis\SyncRedisPool::class,
                // 协程池类名
                'asyncClass'    =>    \Imi\Redis\CoroutineRedisPool::class,
                'config' => [
                    // 池子中最多资源数
                    'maxResources' => 16,
                    // 池子中最少资源数
                    'minResources' => 0,
                ],
            ],
            // 数组资源配置
            'resource' => [
                'host'    =>    '127.0.0.1',
                'port'    =>    6379,
            ],
        ],
    ],

    // 数据库配置
    'db'    =>    [
        // 数默认连接池名
        'defaultPool'    =>    'maindb',
    ],

    // redis 配置
    'redis' =>  [
        // 数默认连接池名
        'defaultPool'   =>  'redis',
    ],

    // 限流键名前缀
    'ratelimitPrefix'   =>  imiGetEnv('RATELIMIT_PREFIX', 'yurun:crawler:'),

    'tools'  =>  [
        'generate/model'    =>  [
            'namespace' =>  [
                'Yurun\CrawlerApp\Module\YurunBlog\Model' =>  [
                    'tables'    =>  [
                        'tb_article',
                    ],
                ],
            ],
        ],
	],
];