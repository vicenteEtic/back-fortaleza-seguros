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
        'new_password' => 'required|password_requirements|confirmed',
    ];
}


   public function withValidator(Validator $validator)
{
    $validator->addExtension('password_requirements', function ($attribute, $value, $parameters, $validator) {
        return preg_match(
            '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W).{9,}$/',
            $value
        );
    });

    $validator->addReplacer('password_requirements', function ($message, $attribute, $rule, $parameters) {
        return 'A senha deve ter no mínimo 9 caracteres, conter pelo menos uma letra maiúscula, uma letra minúscula, um número e um símbolo.';
    });
}

}
