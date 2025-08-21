<?php

namespace App\Services\Entities;

use App\External\PepExternalApi;
use App\Repositories\Entities\PepRepository;
use App\Services\AbstractService;

class PepService extends AbstractService
{

    public function __construct(PepRepository $repository, private readonly PepExternalApi $pepExternalApi)
    {
        parent::__construct($repository);
    }

    public function GetPepExternal(array $data)
    {
        $name = $data['name'] ?? null;
        return $this->pepExternalApi::getAllPep($name);
    }
}
