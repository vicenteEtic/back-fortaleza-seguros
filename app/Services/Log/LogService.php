<?php

namespace App\Services\Log;

use App\Repositories\Log\LogRepository;
use App\Services\AbstractService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class LogService extends AbstractService
{
    protected $logRepository;

    public function __construct(LogRepository $repository)
    {
        parent::__construct($repository);
        $this->logRepository = $repository;
    }

    public function storeLogUser(string $level, string $message): void
    {
        $data = [
            'REMOTE_ADDR' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'PATH_INFO' => URL::current(),
            'REQUEST_TIME' => $_SERVER['REQUEST_TIME'] ?? null,
            'USER_NAME' => Auth::check() ? Auth::user()->first_name : 'guest',
            'userId' => Auth::check() ? Auth::user()->id : null,
            'HTTP_USER_AGENT' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            'message' => $message,
            'level' => $level,
        ];

        $this->logRepository->store($data);

    }
}
