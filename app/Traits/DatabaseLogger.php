<?php

namespace App\Traits;

use App\Services\Log\LogService;

trait DatabaseLogger
{
    public function logToDatabase(
        ?string $type = 'user',
        ?string $typeAction = null,
        ?string $module = null,
        ?string $level = 'info',
        ?int $idEntity = null,
        ?string $customMessage = null
    ): void {
        $logService = app(LogService::class);
        $logService->storeLog($level, $typeAction, $type, $module, $idEntity, $customMessage);
    }
}
