<?php

namespace App\Http\Requests\Alert\AlertUser;

use App\Http\Requests\BaseFormRequest;
use App\Models\Alert\Alert;
use Illuminate\Validation\Rule;
class AlertUserRequest extends BaseFormRequest
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
            'alert_id' => ['required', Rule::exists(Alert::class, 'id')],
            'user_id' => 'required',
 
        ];
    }
}