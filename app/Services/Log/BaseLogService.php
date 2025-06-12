<?php

namespace App\Services\Log;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

abstract class BaseLogService
{
    protected function getCommonLogData(): array
    {
        $user = Auth::user();

        return [
            'REMOTE_ADDR'      => request()->ip() ?? 'unknown',
            'PATH_INFO'        => URL::current(),
            'REQUEST_TIME'     => now()->timestamp,
            'USER_NAME'        => $user?->first_name ?? 'guest',
            'userId'           => $user?->id ?? 1,
            'HTTP_USER_AGENT'  => request()->userAgent() ?? 'unknown',
        ];
    }
}
