<?php

return [
    'xthklog' => [
        // 日志驱动模式：
        'driver' => 'daily',
        // 日志存放路径
        'path' => rtrim(env('LOG_XTHK_PATH', storage_path('logs')), '/') . '/file.log',

        'tap' => [Xthk\Logger\XthkLogFormatter::class],
        // 日志等级：
        'level' => env('LOG_XTHK_LEVEL', 'debug'),
        // 日志分片周期，多少天一个文件
        'days' => env('LOG_XTHK_DAYS', 7),
    ],
];
