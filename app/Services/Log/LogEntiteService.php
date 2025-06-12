<?php


namespace App\Services\Log;
use App\Models\Log\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class LogService
{
    public static function create(string $message, string $level = 'info'): void
    {
        $request = request();
        Log::create([
        'REMOTE_ADDR' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'unknown',  // Safe check for REMOTE_ADDR
            'PATH_INFO' => URL::current(),
            'REQUEST_TIME' => isset($_SERVER['REQUEST_TIME']) ? $_SERVER['REQUEST_TIME'] : 1,  // Check if REQUEST_TIME is set
            'USER_NAME' => Auth::check() ? Auth::user()->first_name : 'guest',  // Handle case if user is not authenticated
            'userId' => Auth::check() ? Auth::user()->id : 1,  // Handle case if user is not authenticated
            'HTTP_USER_AGENT' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'unknown',  // Check if HTTP_USER_AGENT is set
            'message' => $message,
            'level' => $level,
        ]);
    }
}
