<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIndicatorTypeRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'description' => ['required', 'string'],
            'risk' => ['required', 'string'],
            'score' => ['required', 'numeric'],
        ];
    }
    public function messages()
    {
        return [
            'description.required' => 'A descrição é obrigatória.',
            'risk.required' => 'O risco é obrigatório.',
            'score.required' => 'O score é obrigatório.',
            'score.numeric' => 'O score deve ser um número.',
        ];
    }
}
