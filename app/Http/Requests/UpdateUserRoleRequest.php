<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateUserRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $map = [];

        if ($this->filled('code')) {
            $map['mur_code'] = $this->input('code');
        }

        if ($this->filled('name')) {
            $map['mur_name'] = $this->input('name');
        }

        $this->merge($map);
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['errors' => $validator->errors()], 422)
        );
    }

    public function rules(): array
    {
        $user_role_id = optional($this->route('user_role'))->mur_id;

        return [
            'mur_code' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('mm_user_roles', 'mur_code')
                    ->ignore($user_role_id, 'mur_id')
                    ->whereNull('mur_deleted_at'),
            ],
            'mur_name' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('mm_user_roles', 'mur_name')
                    ->ignore($user_role_id, 'mur_id')
                    ->whereNull('mur_deleted_at'),
            ],
        ];
    }
}
