<?php

namespace Xthk\Logger;

use Illuminate\Support\Str;
use Monolog\Logger;
use Monolog\Formatter\JsonFormatter;
class LineFormatter extends JsonFormatter
{
    public static $logId;

    // 重构
    public function format(array $record): string
    {
        if(!in_array($record['message'],["apilog","dblog"])){
            return "";
        }
        $newRecord = [
            'datetime' => $record['datetime']->format('Y-m-d H:i:s'),
            'message_type' => $record['message']
        ];
        if (!empty($record['context'])) {
            $newRecord = array_merge($newRecord, $record['context']);
        }

        $json = $this->toJson($this->normalize( $newRecord), true) . ($this->appendNewline ? "\n" : '');

        return $json;
    }

//    public function format(array $record): string
//    {
//        $request = app(\Illuminate\Http\Request::class);
//        $data = $this->normalize($record);
//        isset($record['datetime']) && $data['datetime'] = $record['datetime']->format(DATE_ISO8601);
//        $data['request_id']     = self::getLogId();
//        $data['path']           = $request->path();
//        $data['method']         = $request->method();
//        if ($data['level'] >= Logger::NOTICE ) {
//            // 大于等于notice级别的日志 记录请求信息
//            $data['request_header'] = $request->header();
//            if ($request->file()) {
//                $data['request_body'] = '<file>';
//            }else{
//                $data['request_body'] = $request->all();
//            }
//        }
//        return $this->toJson($data, true) . "\n";
//    }

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
