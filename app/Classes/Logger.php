<?php

namespace App\Classes;

use App\Models\Log as ModelsLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use App\Jobs\LoggerJob;
use App\Models\Registration;

class Logger
{

    public function log($level, $message,$id_document,$user_id)
    {

        $middle = ModelsLog::create([
            'REMOTE_ADDR' => $_SERVER['REMOTE_ADDR'],
            'PATH_INFO' =>  URL::current(),
            'REQUEST_TIME' =>  $_SERVER['REQUEST_TIME'],
            'USER_ID' => isset(Auth::user()->id) ? Auth::user()->id : 'N/A' ,
            'USER_NAME' =>  $user_id,
            'HTTP_USER_AGENT' => $_SERVER['HTTP_USER_AGENT'],
            'message' => $message,
            'level' => $level,
            'id_document'=>$id_document
        ]);

        if (Auth::user() != null){

            if($middle->level == 'notice' || $middle->level == 'critical'){

                $log = ModelsLog::with('user')->find($middle->id);
                LoggerJob::dispatch($log)->delay(now()->addSeconds('1'));

            }elseif($middle->level == 'emergency'){

               /* $data = Registration::where('code', $message)->first();
                LoggerJob::dispatch($data)->delay(now()->addSeconds('1'));
                */
            }
        }
    }
}
