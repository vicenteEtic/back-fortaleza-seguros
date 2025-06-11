<?php

namespace App\Http\Requests\Diligence;

use App\Http\Requests\BaseFormRequest;

class DiligenceRequest extends BaseFormRequest
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
            ['name', 'required', 'string', 'max:255'],
            ['description', 'nullable', 'string'],
            ['max', 'required', 'integer'],
            ['min', 'required', 'integer'],
            ['risk', 'required', 'string', 'max:255'],
            ['color', 'required', 'string', 'max:255'],
        ];
    }
}
