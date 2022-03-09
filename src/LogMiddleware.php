<?php

namespace Xthk\Logger;

use Closure;
use Illuminate\Http\Request;

class LogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $logId = $request->header("x-b3-traceid") ?: $request->header("XT-LOGID");
        if (empty($logId)) {
            $logId = $request->input('request_id');
        }
        LineFormatter::setLogId($logId);
        return $next($request);
    }
}
