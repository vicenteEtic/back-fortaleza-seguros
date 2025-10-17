<?php
namespace App\Repositories\Alert\UserGrupoAlert;

use App\Models\Alert\UserGrupoAlert\UserGrupoAlert;
use App\Repositories\AbstractRepository;
use Illuminate\Support\Facades\DB;

class UserGrupoAlertRepository extends AbstractRepository
{
    public function __construct(UserGrupoAlert $model)
    {
        parent::__construct($model);
    }



public function storeMany($data)
{
    $now = now();

    // Normaliza os dados recebidos
    $pairs = collect($data)->map(fn($item) => [
        'grup_alert_id' => (int) $item['grup_alert_id'],
        'user_id'       => (int) $item['user_id'],
    ]);

    // 1️⃣ Cria ou reativa os registros enviados
    foreach ($pairs as $item) {
        $this->model->updateOrCreate(
            [
                'grup_alert_id' => $item['grup_alert_id'],
                'user_id'       => $item['user_id'],
            ],
            [
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null, // reativa se estava apagado
            ]
        );
    }

    // 2️⃣ Soft delete dos que NÃO foram enviados
    if ($pairs->isNotEmpty()) {
        // monta as tuplas (1,2),(1,3)...
        $tuplas = $pairs->map(fn($p) => "({$p['grup_alert_id']}, {$p['user_id']})")->implode(',');

        // executa SQL direto (MySQL aceita tuplas em NOT IN)
        DB::statement("
            UPDATE user_grupo_alert 
            SET deleted_at = ?, updated_at = ? 
            WHERE (grup_alert_id, user_id) NOT IN ($tuplas)
            AND deleted_at IS NULL
        ", [$now, $now]);
    }
}


}