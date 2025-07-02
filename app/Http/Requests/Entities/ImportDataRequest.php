<?php

namespace App\Http\Requests\Entities;

use App\Http\Requests\BaseFormRequest;

class ImportDataRequest extends BaseFormRequest
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
            '*.identification_capacity' => ['nullable', 'string'],
            '*.beneficial_owner'     => ['nullable', 'string'],
            '*.category'             => ['nullable', 'string'],
            '*.channel'              => ['nullable', 'string'],
            '*.country_residence'    => ['nullable', 'string'],
            '*.customer_number'      => ['nullable', 'integer'],
            '*.entity_type'          => ['nullable', 'integer'],
            '*.form_establishment'   => ['nullable', 'boolean'],
            '*.nationality'          => ['nullable', 'string'],
            '*.pep'                  => ['nullable', 'boolean'],
            '*.policy_number'        => ['nullable', 'integer'],
            '*.product_risk'         => ['nullable', 'string'],
            '*.profession'           => ['nullable', 'string'],
            '*.social_denomination'  => ['nullable', 'string'],
            '*.status_residence'     => ['nullable', 'boolean'],
        ];
    }
}
