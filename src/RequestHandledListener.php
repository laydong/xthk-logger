<?php

/*
 * This file is part of the Xthk/laravel-logger.
 *
 * (c) Xthk <longjian.huang@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Xthk\Logger;

use Xthk\Logger\Events\RequestHandledEvent;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class RequestHandledListener
{
    public function handle(RequestHandledEvent $event)
    {
        $start = $event->request->server('REQUEST_TIME_FLOAT');
        $end = microtime(true);
        //探针日志不记录
        if(in_array($event->request->path(),["healthz","ready"])){
            return;
        }
        $context = [
            "app_name"=>env("APP_NAME",""),
            'request' => getXthkLoggerRequest($event->request),
            'request_id' =>  LineFormatter::getLogId(),
            'respon' => $event->response instanceof SymfonyResponse ? json_decode($event->response->getContent(), true) : (string) $event->response,
            'start_time' => $start,
            'end_time' => $end,
            'run_time' => format_duration($end - $start),
        ];

        logger_async(\config('logging.xthkApilog.message'), $context)
            ->onConnection(\config('logging.xthkApilog.connection'))
            ->onQueue(\config('logging.xthkApilog.queue'));
    }
}
