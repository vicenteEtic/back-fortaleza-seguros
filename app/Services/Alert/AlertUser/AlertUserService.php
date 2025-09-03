<?php

namespace App\Services\Alert\AlertUser;

use App\Models\Alert\Alert;
use App\Models\Alert\AlertUser\AlertUser;
use App\Models\User\User;

use App\Repositories\Alert\AlertUser\AlertUserRepository;
use App\Services\AbstractService;

class AlertUserService extends AbstractService
{
    public function __construct(AlertUserRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Resumo de alertas de UM usuário
     */
    public function getUserAlertSummary($userId)
    {
        $active   = $this->repository->countActiveAlertsByUser($userId);
        $inactive = $this->repository->countInactiveAlertsByUser($userId);

        return [
            'user_id'        => $userId,
            'active_alerts'  => $active,
            'inactive_alerts' => $inactive,
        ];
    }

    /**
     * Resumo de alertas de TODOS os usuários relacionados a alertas
     */
    public function getAllUsersAlertSummary()
    {
        // busca todos os usuários que têm alertas associados
        $userIds = $this->repository->getUsersWithAlerts();

        return collect($userIds)->map(function ($userId) {
            $user = User::find($userId);

            return [
                'id'             => $user->id,
                'name'           => $user->first_name . ' ' . $user->last_name,
                'email'          => $user->email,
                'active_alerts'  => $this->repository->countActiveAlertsByUser($userId),
                'inactive_alerts' => $this->repository->countInactiveAlertsByUser($userId),
            ];
        })->values();
    }

    /**
     * Retorna usuário com seus alerts
     */
    public function getUserWithAlerts($userId)
    {
        $user = User::with('alerts')->findOrFail($userId);

        return [
            'id'    => $user->id,
            'name'  => $user->first_name . ' ' . $user->last_name,
            'email' => $user->email,
            'alerts' => $user->alerts->map(function ($alert) {
                return [
                    'id'        => $alert->id,
                    'type'      => $alert->type,
                    'name'      => $alert->name,
                    'level'     => $alert->level,
                    'is_active' => $alert->is_active,
                    'pivot'     => [
                        'is_read'    => $alert->pivot->is_read,
                        'created_at' => $alert->pivot->created_at,
                    ]
                ];
            }),
        ];
    }

    public function storeMany(array $data)
{
    return $this->repository->storeMany($data);

}
public function countActiveAlertsForAuthenticatedUser()
{
    return $this->repository->getActiveAlertsForAuthenticatedUser();

}


}