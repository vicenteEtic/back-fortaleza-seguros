<?php
namespace App\Repositories\Alert\UserGrupoAlert;

use App\Models\Alert\UserGrupoAlert\UserGrupoAlert;
use App\Repositories\AbstractRepository;

class UserGrupoAlertRepository extends AbstractRepository
{
    public function __construct(UserGrupoAlert $model)
    {
        parent::__construct($model);
    }
}