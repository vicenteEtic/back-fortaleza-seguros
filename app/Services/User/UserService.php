<?php
namespace App\Services\User;

use App\Repositories\User\UserRepository;
use App\Services\AbstractService;

class UserService extends AbstractService
{
    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }
}