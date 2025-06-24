<?php

namespace App\Http\Requests\Alerta;

use App\Http\Requests\BaseFormRequest;

class AlertaRequest extends BaseFormRequest
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
            'name' => 'required',
            'level' => 'required',
            'origin_id' => 'required',
            'entity_id' => 'required',
            'score' => 'required'
        ];
    }
}