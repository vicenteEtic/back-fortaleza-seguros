<?php

namespace App\Services\User;

use App\Services\AbstractService;
use Illuminate\Support\Facades\Hash;
use App\Repositories\User\UserRepository;

class UserService extends AbstractService
{
    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }

    public function store(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return $this->repository->store($data);
    }
}
