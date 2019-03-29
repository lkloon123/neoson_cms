<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 3/7/2019
 * Time: 10:01 AM.
 */

namespace App\Service;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\HttpLogger\LogWriter;

class RequestLoggingService implements LogWriter
{
    public function logRequest(Request $request)
    {
        $method = strtoupper($request->getMethod());
        $uri = $request->getPathInfo();
        $ip = $request->getClientIp();
        $header = $request->headers->all();

        $body = $request->except(config('http-logger.except'));

        $message = [
            'ip' => $ip,
            'method' => $method,
            'uri' => $uri,
            'header' => $header,
            'body' => $body
        ];

        Log::channel('requestlog')->info(json_encode($message, JSON_UNESCAPED_SLASHES));
    }
}
