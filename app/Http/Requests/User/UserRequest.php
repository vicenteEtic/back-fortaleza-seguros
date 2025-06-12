<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseFormRequest;

class UserRequest extends BaseFormRequest
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'is_active' => ['nullable', 'boolean'],
            'role_id' => ['required', 'integer', 'exists:role,id'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    public function attributes()
    {
        return [
            'first_name' => 'Nome',
            'last_name' => 'Sobrenome',
            'phone' => 'Telefone',
            'email' => 'E-mail',
            'is_active' => 'Status Ativo',
            'role_id' => 'Função',
            'password' => 'Senha',
        ];
    }
}
