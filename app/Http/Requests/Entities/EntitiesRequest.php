<?php

namespace App\Http\Requests\Entities;

use App\Http\Requests\BaseFormRequest;

class EntitiesRequest extends BaseFormRequest
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
        $id = $this->route('entity') ? $this->route('entity') : null;
        return [
            'social_denomination' => ['required', 'string'],
            'customer_number' => ['required', 'string', 'max:255', 'unique:entities,customer_number,' . $id],
            'policy_number' => ['required', 'string', 'max:255', 'unique:entities,policy_number,' . $id],
            'entity_type' => ['required', 'numeric'],
        ];
    }

    public function attributes(): array
    {
        return [
            'social_denomination' => 'Denominação Social',
            'customer_number' => 'Número do Cliente',
            'policy_number' => 'Número da Apólice',
            'entity_type' => 'Tipo de Entidade',
        ];
    }
}
