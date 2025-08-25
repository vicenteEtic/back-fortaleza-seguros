<?php
namespace App\Services\Alert\AlertUser;

use App\Repositories\Alert\AlertUser\AlertUserRepository;
use App\Services\AbstractService;

class AlertUserService extends AbstractService
{
    public function __construct(AlertUserRepository $repository)
    {
        parent::__construct($repository);
    }
}