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
<<<<<<< HEAD
            'REQUEST_TIME' => $_SERVER['REQUEST_TIME'] ?? null,
            'USER_NAME' => Auth::check() ? Auth::user()->first_name : 'guest',
            'userId' => Auth::check() ? Auth::user()->id : null,
            'HTTP_USER_AGENT' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
=======
            'REQUEST_TIME' => isset($_SERVER['REQUEST_TIME']) ? $_SERVER['REQUEST_TIME'] : 1,  // Check if REQUEST_TIME is set
            'USER_NAME' => Auth::check() ? Auth::user()->first_name : 'guest',  // Handle case if user is not authenticated
            'userId' => Auth::check() ? Auth::user()->id : 1,  // Handle case if user is not authenticated
            'HTTP_USER_AGENT' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'unknown',  // Check if HTTP_USER_AGENT is set
>>>>>>> 88120df (feat: log de atividades)
            'message' => $message,
            'level' => $level,
        ];

        $this->logRepository->store($data);

    }
}
