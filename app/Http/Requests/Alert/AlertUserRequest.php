<?php

namespace App\Http\Requests\Alert;

use App\Http\Requests\BaseFormRequest;
use App\Models\Alert\Alert;
use App\Models\User\User;
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'is_active' => ['required'],
           
        ];
    }
    
    public function messages(): array
    {
        return [
            'is_active.required' => 'O campo is_active é obrigatório.',
         
        ];
    }
    
}