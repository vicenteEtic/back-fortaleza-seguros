<?php

namespace App\Http\Controllers;

use App\Models\Log\Log as LogLog;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use App\Models\Log as ModelsLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use App\Jobs\LoggerJob;
use App\Services\Log\LogService;

abstract class Controller
{
    use AuthorizesRequests, ValidatesRequests;
    protected LogService $logService;

    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }


    protected function logRequest($e = null)
    {
        $request = request()->all();
        $requestFiltered = $this->filterSensitiveData($request);
        if (app()->environment() !== 'testing') {
            if ($e) {
                Log::channel('generic')->error($e->getMessage(), ['Payload: ' . json_encode($requestFiltered), 'Trace: ' . $e->getTraceAsString()]);
            } else {
                Log::channel('generic')->info('URL: ' . request()->getRequestUri() . PHP_EOL . 'Método: ' . request()->method(), ['Payload: ' . json_encode($requestFiltered)]);
            }
        }
    }

    private function filterSensitiveData(array $requestData): array
    {
        $sensitiveData = ['password', 'senha', 'senhaAtual'];

        foreach ($sensitiveData as $key) {
            if (isset($requestData[$key])) {
                unset($requestData[$key]);
            }
        }

        return $requestData;
    }
    public function arrayChangeKeyCaseRecursive($array, $case = CASE_LOWER)
    {
        $array = array_change_key_case($array, $case);
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = $this->arrayChangeKeyCaseRecursive($value, $case);
            }
        }
        return $array;
    }
    public function storeLogUser(string $level = 'info', string $message): void {
        $this->logService->storeLogUser($level, $message);
    }
    
   
}
