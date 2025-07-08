<?php

namespace App\Http\Controllers\Indicator;

use App\Enum\TypeIndicator;
use App\Http\Controllers\AbstractController;
use App\Http\Requests\Indicator\IndicatorTypeRequest;
use App\Services\Indicator\IndicatorTypeService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

class IndicatorTypeController extends AbstractController
{
    protected ?string $logType = 'user';
    protected ?string $nameEntity = "Tipo de Indicador";
    protected ?string $fieldName = "indicator_id";

    public function __construct(IndicatorTypeService $service)
    {
        $this->service = $service;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IndicatorTypeRequest $request, TypeIndicator $indicatorType)
    {
        try {
            $this->logRequest();
            $data = $request->validated();

            if ($indicatorType && in_array($indicatorType, TypeIndicator::cases(), true)) {
                $data['indicator_id'] = $indicatorType;
            }

            $indicatorTypeStore = $this->service->store($data);
            return response()->json($indicatorTypeStore, Response::HTTP_CREATED);
        } catch (Exception $e) {
            $this->logRequest($e);
            $this->logToDatabase(
                type: 'indicator',
                level: 'error',
                customMessage: "Erro ao criar tipo de indicador.",
            );
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IndicatorTypeRequest $request, $id)
    {
        try {
            $this->logRequest();
            $indicatorTypeStore = $this->service->update($request->validated(), $id);
            $this->logToDatabase(
                type: 'indicator',
                level: 'info',
                customMessage: "Tipo de indicador atualizado com sucesso."
            );
            return response()->json($indicatorTypeStore, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            $this->logRequest($e);
            return response()->json(['error' => 'Resource not found.'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            $this->logRequest($e);
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store specific indicator types.
     */
    public function storeCapacidadeIdentificacaoVerificacao(IndicatorTypeRequest $request)
    {
        $this->logToDatabase(
            type: 'user',
            level: 'info',
            customMessage: "Capacidade de Identificação e Verificação criada com sucesso."
        );
        return $this->store($request, TypeIndicator::CAPACIDADE_IDENTIFICACAO_VERIFICACAO);
    }


    public function storeTipoActividadePrincipal(IndicatorTypeRequest $request)
    {
        $this->logToDatabase(
            type: 'user',
            level: 'info',
            customMessage: "Tipo de Actividade Principal criado com sucesso."
        );
        return $this->store($request, TypeIndicator::TIPO_ACTIVIDADE_PRINCIPAL);
    }

    public function storeTipoSeguro(IndicatorTypeRequest $request)
    {
        $this->logToDatabase(
            type: 'user',
            level: 'info',
            customMessage: "Tipo de Seguro criado com sucesso."
        );
        return $this->store($request, TypeIndicator::TIPO_SEGURO);
    }

    public function storeRiscoProdutosServicosTransacoes4(IndicatorTypeRequest $request)
    {
        $this->logToDatabase(
            type: 'user',
            level: 'info',
            customMessage: "Risco de Produtos, Serviços e Transações 4 criado com sucesso."
        );
        return $this->store($request, TypeIndicator::RISCO_PRODUTOS_SERVICOS_TRANSACOES_4);
    }

    public function storeTipoActividadePrincipalColectiva(IndicatorTypeRequest $request)
    {
        $this->logToDatabase(
            type: 'user',
            level: 'info',
            customMessage: "Tipo de Actividade Principal Colectiva criado com sucesso."
        );
        return $this->store($request, TypeIndicator::TIPO_ACTIVIDADE_PRINCIPAL_COLECTIVA);
    }

    public function storeCanal(IndicatorTypeRequest $request)
    {
        $this->logToDatabase(
            type: 'user',
            level: 'info',
            customMessage: "Canal criado com sucesso."
        );
        return $this->store($request, TypeIndicator::CANAIS);
    }

    public function storeCae(IndicatorTypeRequest $request)
    {
        $this->logToDatabase(
            type: 'user',
            level: 'info',
            customMessage: "CAE criado com sucesso."
        );
        return $this->store($request, TypeIndicator::CAE);
    }
}
