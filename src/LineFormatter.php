<?php

namespace Xthk\Logger;

use Illuminate\Support\Str;
use Monolog\Logger;
use Monolog\Formatter\JsonFormatter;
class LineFormatter extends JsonFormatter
{
    public static $logId;

    public function format(array $record): string
    {
        $request = app(\Illuminate\Http\Request::class);
        $data = $this->normalize($record);
        isset($record['datetime']) && $data['datetime'] = $record['datetime']->format(DATE_ISO8601);
        $data['request_id']     = self::getLogId();
        $data['path']           = $request->path();
        $data['method']         = $request->method();
        if ($data['level'] >= Logger::NOTICE ) {
            // 大于等于notice级别的日志 记录请求信息
            $data['request_header'] = $request->header();
            if ($request->file()) {
                $data['request_body'] = '<file>';
            }else{
                $data['request_body'] = $request->all();
            }
        }
        return $this->toJson($data, true) . "\n";
    }

    static function setLogId($logId)
    {
        if (!empty($logId)) {
            self::$logId = $logId;
        } else {
            self::$logId = self::newLogIDInt();
        }
    }

    static function getLogId()
    {
        return self::$logId;
    }

    static function newLogIDInt()
    {
        $data = Str::uuid();
        return substr($data->getInteger(), 0, 15);
    }
}
