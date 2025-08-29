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

    public function countActiveAlertsByUser($userId)
    {
        return $this->model
            ->where('user_id', $userId)
            ->whereHas('alert', function ($q) {
                $q->where('is_active', 1);
            })
            ->count();
    }

    public function countInactiveAlertsByUser($userId)
    {
        return $this->model
            ->where('user_id', $userId)
            ->whereHas('alert', function ($q) {
                $q->where('is_active', 0);
            })
            ->count();
    }
    public function getUsersWithAlerts()
    {
        return $this->model
            ->distinct()
            ->pluck('user_id');
    }
    public function storeMany($data)
    {
        return $this->model->insert(
            collect($data)->map(function ($item) {
                return array_merge($item, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            })->toArray()
        );
    }
    
}
