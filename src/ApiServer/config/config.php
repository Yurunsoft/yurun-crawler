<?php

use Imi\Log\LogLevel;
return [
    'configs'    =>    [
    ],
    // bean扫描目录
    'beanScan'    =>    [
        'Yurun\Crawler\ApiServer\Controller',
    ],
    'beans'    =>    [
        'HttpDispatcher'    =>    [
            'middlewares'    =>    [
                \Imi\Server\Http\Middleware\RouteMiddleware::class,
            ],
        ],
    ],
];