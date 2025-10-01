<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Validator;
class ChangePasswordRequest extends BaseFormRequest
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
   public function rules()
    {
        return [
            'current_password' => 'required',
            'new_password' => 'required|password_requirements',
        ];
    }

    public function withValidator(Validator $validator)
    {
        // Adiciona a regra customizada
        $validator->addExtension('password_requirements', function ($attribute, $value, $parameters, $validator) {
            return preg_match(
                '/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+])[A-Za-z\d!@#$%^&*()_+]{8,}$/',
                $value
            );
        });

        // Mensagem personalizada
        $validator->addReplacer('password_requirements', function ($message, $attribute, $rule, $parameters) {
            return 'A senha deve ter pelo menos 8 caracteres, incluir uma letra maiúscula, uma letra minúscula, um número e um caractere especial.';
        });
    }
}
