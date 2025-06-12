<?php
namespace App\Services\Log;

use App\Repositories\Log\UserLogRepository;
use App\Services\AbstractService;

class UserLogService extends AbstractService
{
    public function __construct(UserLogRepository $repository)
    {
        parent::__construct($repository);
    }
}