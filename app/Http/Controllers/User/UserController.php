<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\AbstractController;
use App\Services\User\UserService;
use Exception;
use Illuminate\Http\Response;

class UserController extends AbstractController
{
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }
}