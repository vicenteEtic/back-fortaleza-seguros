<?php

namespace App\Http\Requests\Log;

use App\Http\Requests\BaseFormRequest;

class LogRequest extends BaseFormRequest
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
            'level' => 'required',
            'REMOTE_ADDR' => 'required',
            'PATH_INFO' => 'required',
            'USER_NAME' => 'required',
            'USER_ID' => 'required',
            'HTTP_USER_AGENT' => 'required',
            'message' => 'required',
            'id_document' => 'required'
        ];
    }
}