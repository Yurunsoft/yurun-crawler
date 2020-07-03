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
        // 'maindb'    =>    [
        //     // 同步池子
        //     'sync'    =>    [
        //         'pool'    =>    [
        //             'class'        =>    \Imi\Db\Pool\SyncDbPool::class,
        //             'config'    =>    [
        //                 'maxResources'    =>    10,
        //                 'minResources'    =>    0,
        //             ],
        //         ],
        //         'resource'    =>    [
        //             'host'        => '127.0.0.1',
        //             'port'        => 3306,
        //             'username'    => 'root',
        //             'password'    => 'root',
        //             'database'    => 'database_name',
        //             'charset'     => 'utf8mb4',
        //         ],
        //     ],
        //     // 异步池子，worker进程使用
        //     'async'    =>    [
        //         'pool'    =>    [
        //             'class'        =>    \Imi\Db\Pool\CoroutineDbPool::class,
        //             'config'    =>    [
        //                 'maxResources'    =>    10,
        //                 'minResources'    =>    0,
        //             ],
        //         ],
        //         'resource'    =>    [
        //             'host'        => '127.0.0.1',
        //             'port'        => 3306,
        //             'username'    => 'root',
        //             'password'    => 'root',
        //             'database'    => 'database_name',
        //             'charset'     => 'utf8mb4',
        //         ],
        //     ]
        // ],
        'redis'    =>    [
            'sync'    =>    [
                'pool'    =>    [
                    'class'        =>    \Imi\Redis\SyncRedisPool::class,
                    'config'    =>    [
                        'maxResources'    =>    10,
                        'minResources'    =>    0,
                    ],
                ],
                'resource'    =>    [
                    'host'      => '127.0.0.1',
                    'port'      => 6379,
                    'password'  => null,
                ]
            ],
            'async'    =>    [
                'pool'    =>    [
                    'class'        =>    \Imi\Redis\CoroutineRedisPool::class,
                    'config'    =>    [
                        'maxResources'    =>    10,
                        'minResources'    =>    0,
                    ],
                ],
                'resource'    =>    [
                    'host'      => '127.0.0.1',
                    'port'      => 6379,
                    'password'  => null,
                ]
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

];