<?php

namespace App\Http\Requests\Permission;

use App\Http\Requests\BaseFormRequest;

class PermissionRequest extends BaseFormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nome da Permissão',
            'description' => 'Descrição da Permissão',
            'is_active' => 'Status'
        ];
    }
}
