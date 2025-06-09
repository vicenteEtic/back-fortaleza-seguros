<?php

namespace App\Classes;

use App\Models\Log as ModelsLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use App\Jobs\LoggerJob;
use App\Models\CraftHistory as ModelsCraftHistory;
use App\Models\EntitieHistorie;
use App\Models\Registration;

class EntitieHistories
{

    public function log($level, $message,$fk_entities,$userId)
    {

        $middle = EntitieHistorie::create([
        'REMOTE_ADDR' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'unknown',  // Safe check for REMOTE_ADDR
            'PATH_INFO' => URL::current(),
           'REQUEST_TIME' => isset($_SERVER['REQUEST_TIME']) ? $_SERVER['REQUEST_TIME'] : null,  // Check if REQUEST_TIME is set
            'fk_user'=>  $userId,
            'HTTP_USER_AGENT' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'unknown',  // Check if HTTP_USER_AGENT is set
            'message' => $message,
            'level' => $level,
            'fk_entities' => $fk_entities,

        ]);


}
}
