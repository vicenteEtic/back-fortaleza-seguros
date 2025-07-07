<?php

namespace App\Http\Requests\Entities;

use App\Http\Requests\BaseFormRequest;

class ProductRiskRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required'],
            'risk_assessment_id' => ['required'],
            'score' => ['required'],
        ];
    }

    /**
     * Obtenha os nomes dos atributos personalizados para mensagens de validação.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'product_id' => 'Produto',
            'risk_assessment_id' => 'Avaliação de Risco',
            'score' => 'Pontuação',
        ];
    }
}
