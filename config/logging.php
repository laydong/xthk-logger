<?php

/*
 * This file is part of the Xthk/laravel-logger.
 *
 * (c) Xthk <longjian.huang@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

return [
    'channels' => [
        'xthkFile' => [
            'driver' => 'daily',
            'path' =>  rtrim(env("LOG_XTHK_PATH",storage_path()),'/')."/".env("APP_NAME")."/file.log",
            'level' => 'debug',
            'days' => 5,
            'tap' => [Xthk\Logger\XthkLogFormatter::class],
            'value_max_length' => env('REQUEST_LOG_VALUE_MAX_LENGTH', 300),
        ]
    ],

    'xthkFile' => [
        'driver' => 'daily',
        'path' =>  rtrim(env("LOG_XTHK_PATH",storage_path()),'/')."/".env("APP_NAME")."/file.log",
        'level' => 'debug',
        'days' => 5,
        'tap' => [Xthk\Logger\XthkLogFormatter::class],
        'value_max_length' => env('REQUEST_LOG_VALUE_MAX_LENGTH', 300),
    ],
    'xthklog' => [
        // 日志驱动模式：
        'driver' => 'daily',
        // 日志存放路径
        'path' => rtrim(env('LOG_XTHK_PATH', storage_path('logs')), '/') . '/xthk.log',

        'tap' => [Xthk\Logger\XthkLogFormatter::class],
        // 日志等级：
        'level' => env('LOG_XTHK_LEVEL', 'debug'),
        // 日志分片周期，多少天一个文件
        'days' => env('LOG_XTHK_DAYS', 7),
    ],

    'xthkDblog' => [
        'enabled' => env('LOG_DBLOG', false),
        'message' => 'dblog',
        'connection' => env('LOG_QUERY_CONNECTION', config('queue.default')), // queue connection
        'queue' => env('LOG_QUERY_QUEUE', 'default'), // queue name

        // Only record queries that are slower than the following time
        // Unit: milliseconds
        'slower_than' => 0,
    ],

    'xthkApilog' => [
        'enabled' => env('LOG_APILOG', false),
        'message' => 'apilog',
        'connection' => env('LOG_REQUEST_CONNECTION', config('queue.default')), // queue connection
        'queue' => env('LOG_REQUEST_QUEUE', 'default'), // queue name
    ],
];
