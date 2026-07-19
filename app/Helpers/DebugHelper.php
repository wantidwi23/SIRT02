<?php

use Illuminate\Support\Facades\Log;

if (!function_exists('logDebug')) {
    function logDebug($message, $data = [])
    {
        Log::channel('single')->info($message, $data);
    }
}
