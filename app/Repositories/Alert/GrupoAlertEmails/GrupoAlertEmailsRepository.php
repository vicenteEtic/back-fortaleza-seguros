<?php
namespace App\Repositories\Alert\GrupoAlertEmails;

use App\Models\Alert\GrupoAlertEmails\GrupoAlertEmails;
use App\Repositories\AbstractRepository;

class GrupoAlertEmailsRepository extends AbstractRepository
{
    public function __construct(GrupoAlertEmails $model)
    {
        parent::__construct($model);
    }
}