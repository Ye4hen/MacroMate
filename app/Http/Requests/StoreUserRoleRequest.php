<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreUserRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'mur_code' => $this->input('code'),
            'mur_name' => $this->input('name'),
        ]);
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], 422));
    }

    public function rules(): array
    {
        return [
            'mur_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('mm_user_roles', 'mur_code')
                    ->whereNull('mur_deleted_at'),
            ],
            'mur_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('mm_user_roles', 'mur_name')
                    ->whereNull('mur_deleted_at'),
            ],
        ];
    }
}
