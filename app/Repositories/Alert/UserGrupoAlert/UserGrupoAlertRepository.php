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
        'grup_alert_id' => $item['grup_alert_id'],
        'user_id'       => $item['user_id'],
    ]);

    // 1️⃣ Atualiza ou cria os registros recebidos
    foreach ($pairs as $item) {
        $this->model->updateOrCreate(
            [
                'grup_alert_id' => $item['grup_alert_id'],
                'user_id'       => $item['user_id'],
            ],
            [
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null, // reativa se estiver soft-deleted
            ]
        );
    }

    // 2️⃣ Marca como deleted_at os que não foram enviados
    if ($pairs->isNotEmpty()) {
        $this->model
            ->whereNotExists(function ($query) use ($pairs) {
                $query->select(DB::raw(1))
                    ->fromRaw('(SELECT ' .
                        implode(' UNION ALL SELECT ',
                            $pairs->map(fn($p) => "{$p['grup_alert_id']} AS grup_alert_id, {$p['user_id']} AS user_id")->toArray()
                        ) .
                    ') AS temp')
                    ->whereColumn('temp.grup_alert_id', 'user_grupo_alert.grup_alert_id')
                    ->whereColumn('temp.user_id', 'user_grupo_alert.user_id');
            })
            ->whereNull('deleted_at')
            ->update([
                'deleted_at' => $now,
                'updated_at' => $now,
            ]);
    }
}

}