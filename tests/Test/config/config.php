<?php

use Imi\Log\LogLevel;
return [
    'configs'    =>    [
    ],
    // bean扫描目录
    'beanScan'    =>    [
        'Yurun\Crawler\Test\Module',
    ],
    // 组件命名空间
    'components'    =>  [
        'Crawler'   =>  'Yurun\Crawler',
    ],
    'beans'    =>    [
        'Logger'            =>  [
            'exHandlers'    =>  [
                // 指定级别日志输出trace
                [
                    'class'        =>    \Imi\Log\Handler\File::class,
                    'options'    =>    [
                        'levels'        => [
                            LogLevel::ALERT,
                            LogLevel::CRITICAL,
                            LogLevel::DEBUG,
                            LogLevel::EMERGENCY,
                            LogLevel::ERROR,
                            LogLevel::NOTICE,
                            LogLevel::WARNING,
                        ],
                        'fileName'      => dirname(__DIR__) . '/logs/{Y}-{m}-{d}.log',
                        'format'        => "{Y}-{m}-{d} {H}:{i}:{s} [{level}] {message}\n{trace}",
                        'traceFormat'   => '#{index}  {call} called at [{file}:{line}]',
                    ],
                ],
                [
                    'class'     => \Imi\Log\Handler\Console::class,
                    'options'   => [
                        'levels'        => [
                            'Test',
                        ],
                        'format'        => '{message}',
                        'logCacheNumber'=> 10240,
                    ],
                ],
            ],
        ],
        'ErrorLog'          =>  [
            // 'level' =>  ,
        ],
        'UserAgentManager'  =>  [
            'list'  =>  [
                // 这里可以放想要用的 UserAgent 列表
                'a',
                'b',
                'c',
            ],
        ],
    ],
    
    // 连接池配置
    'pools'    =>    [
        // 主数据库
        'maindb'    =>    [
            'pool'    =>    [
                // 同步池类名
                'syncClass'     =>    \Imi\Db\Pool\SyncDbPool::class,
                // 协程池类名
                'asyncClass'    =>    \Imi\Db\Pool\CoroutineDbPool::class,
                // 连接池配置
                'config'        =>    [
                    'maxResources'    =>    10,
                    'minResources'    =>    0,
                    'checkStateWhenGetResource' =>  false,
                ],
            ],
            // 连接池资源配置
            'resource'    =>    [
                'host'        => imiGetEnv('MYSQL_SERVER_HOST', '127.0.0.1'),
                'port'        => imiGetEnv('MYSQL_SERVER_PORT', 3306),
                'username'    => imiGetEnv('MYSQL_SERVER_USERNAME', 'root'),
                'password'    => imiGetEnv('MYSQL_SERVER_PASSWORD', 'root'),
                'database'    => 'db_yurun_crawler_test',
                'charset'     => 'utf8mb4',
            ],
        ],
        'redis' =>  [
            'pool' => [
                // 同步池类名
                'syncClass'     =>    \Imi\Redis\SyncRedisPool::class,
                // 协程池类名
                'asyncClass'    =>    \Imi\Redis\CoroutineRedisPool::class,
                'config' => [
                    'maxResources'    =>    10,
                    'minResources'    =>    0,
                    'checkStateWhenGetResource' =>  false,
                ],
            ],
            // 数组资源配置
            'resource' => [
                'host'      => imiGetEnv('REDIS_SERVER_HOST', '127.0.0.1'),
                'port'      => imiGetEnv('REDIS_SERVER_PORT', 6379),
                'password'  => imiGetEnv('REDIS_SERVER_PASSWORD'),
            ],
        ],
    ],
    // db 配置
    'db' =>  [
        // 数默认连接池名
        'defaultPool'   =>  'maindb',
    ],
    // redis 配置
    'redis' =>  [
        // 数默认连接池名
        'defaultPool'   =>  'redis',
    ],
];