<?php

namespace App\Http\Requests\Alert;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class AlertUpdateStatusRequest extends BaseFormRequest
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
     */
    public function rules(): array
    {
        return [
            'is_active' => ['required', 'boolean'], // melhor validar como booleano
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'is_active.required' => 'O campo is_active é obrigatório.',
            'is_active.boolean'  => 'O campo is_active deve ser verdadeiro ou falso.',
        ];
    }
}
