<?php
namespace App\Repositories\Alert\AlertUser;

use App\Models\Alert\AlertUser\AlertUser;
use App\Repositories\AbstractRepository;

class AlertUserRepository extends AbstractRepository
{
    public function __construct(AlertUser $model)
    {
        parent::__construct($model);
    }
}