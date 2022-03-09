<?php

/*
 * This file is part of the Xthk/laravel-logger.
 *
 * (c) Xthk <longjian.huang@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

if (! function_exists('logger_async')) {
    /**
     * Log a debug message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return \Illuminate\Foundation\Bus\PendingDispatch|mixed
     */
    function logger_async(string $message, array $context = [])
    {
        return dispatch(new Xthk\Logger\Jobs\LogJob($message, $context, request()->server()));
    }
}


/*
 * This file is part of the jiannei/helpers.
 *
 * (c) jiannei <longjian.huang@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

if (!function_exists('format_duration')) {
    /**
     * Format duration.
     */
    function format_duration(float $seconds): string
    {
        return round($seconds * 1000, 2) . 'ms';
    }
}

if (!function_exists('human_filesize')) {
    /**
     * human filesize.
     *
     * @param $size
     */
    function human_filesize($size, int $precision = 2): string
    {
        $units = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $i     = 0;
        while (($size / 1024) > 0.9) {
            $size /= 1024;
            ++$i;
        }

        return round($size, $precision) . ' ' . $units[$i];
    }
}

if (!function_exists('strtobool')) {
    /**
     * Convert string to boolean.
     *
     * @param $str
     */
    function strtobool($str): bool
    {
        return (bool)json_decode(strtolower($str));
    }
}
if (! function_exists('getXthkLoggerRequest')) {
    function getXthkLoggerRequest($request)
    {
        $requestMessage = [
            'url' => $request->url(),
            'method' => $request->method(),
            'ip' => $request->ips(),
            'path' => $request->path(),
            'headers' => $request->header(),
            'query' => $request->query()
        ];

        if ($request->file()) {
            // 文件内容不做日志记录，使用<file>做标识
            $requestMessage['body'] = '<file>';
        } else {
            // 获取请求体Body信息
            $bodyContent = $request->all();
            // 从.env文件中获取参数内容的长度


            if ($bodyContent && in_array($request->method(), ['POST', 'PATCH'])) {

                foreach ($request->all() as $key => $value) {

                    $bodyContent[$key] = $value;
                }
            }
            $requestMessage['body'] = $bodyContent;
        }
        return $requestMessage;
    }
}
//链路相关
if (! function_exists('getXthkLoggerId')) {
    function getXthkLoggerId($request)
    {
        return $request->server->get('x-b3-traceid');
    }
}
if (!function_exists('request')) {

    /**
     * @return \Laravel\Lumen\Application|mixed
     */
    function request()
    {
        return app(\Illuminate\Http\Request::class);
    }
}