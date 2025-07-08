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
            'remote_addr' => 'required',
            'path_info' => 'required',
            'user_name' => 'required',
            'type' => 'required',
            'user_id' => 'required',
            'http_user_agent' => 'required',
            'message' => 'required',
            'id_entity' => 'required'
        ];
    }
}