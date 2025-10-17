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
                'deleted_at' => null,
            ]
        );
    }

    // 2️⃣ Apaga fisicamente os que não vieram
    if ($pairs->isNotEmpty()) {
        $tuplas = $pairs->map(fn($p) => "({$p['grup_alert_id']}, {$p['user_id']})")->implode(',');

        DB::statement("
            DELETE FROM user_grupo_alert 
            WHERE (grup_alert_id, user_id) NOT IN ($tuplas)
        ");
    }
}
}