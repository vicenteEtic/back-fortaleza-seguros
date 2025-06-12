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

    public function storeLogUser(string $level, string $message, string $type,$id_entity): void
    {
        $data = [
            'remote_addr' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'path_info' => URL::current(),
            'request_time' => $_SERVER['REQUEST_TIME'] ?? null,
            'user_id' => Auth::check() ? Auth::user()->id : null,
            'http_user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            'message' => $message,
            'level' => $level,
            'type' => $type,
            'id_entity' => $id_entity,

        ];

        $this->logRepository->store($data);
    }
}
