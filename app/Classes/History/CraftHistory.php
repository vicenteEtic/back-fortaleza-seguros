<?php

namespace App\Classes;

use App\Models\Log as ModelsLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use App\Jobs\LoggerJob;
use App\Models\CraftHistory as ModelsCraftHistory;
use App\Models\Registration;

class CraftHistory
{

    public function log($level, $message, $USER_NAME, $userId)
    {

        $middle = ModelsCraftHistory::create([
           'REMOTE_ADDR' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'unknown',  // Safe check for REMOTE_ADDR
            'PATH_INFO' => URL::current(),
            'REQUEST_TIME' => isset($_SERVER['REQUEST_TIME']) ? $_SERVER['REQUEST_TIME'] : null,  // Check if REQUEST_TIME is set
            'USER_NAME' => Auth::check() ? Auth::user()->first_name : 'guest',  // Handle case if user is not authenticated
            'userId' => Auth::check() ? Auth::user()->id : null,  // Handle case if user is not authenticated
            'HTTP_USER_AGENT' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'unknown',  // Check if HTTP_USER_AGENT is set
            'message' => $message,
            'level' => $level,


        ]);
    }
}
