<?php
namespace App\Services\Alert\GrupoType;

use App\Repositories\Alert\GrupoType\GrupoTypeRepository;
use App\Services\AbstractService;

class GrupoTypeService extends AbstractService
{
    public function __construct(GrupoTypeRepository $repository)
    {
        parent::__construct($repository);
    }
}