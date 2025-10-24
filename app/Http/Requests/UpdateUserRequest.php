<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $map = [];

        if ($this->filled('name')) {
            $map['mu_name'] = $this->input('name');
        }

        if ($this->filled('email')) {
            $map['mu_email'] = $this->input('email');
        }

        if ($this->filled('password')) {
            $map['mu_password'] = $this->input('password');
            $map['mu_password_confirmation'] = $this->input('password_confirmation');
        }

        if ($this->filled('role')) {
            $map['mu_role'] = $this->input('role');
        }

        if ($this->filled('age')) {
            $map['mu_age'] = $this->input('age');
        }

        if ($this->filled('height')) {
            $map['mu_height'] = $this->input('height');
        }

        if ($this->filled('weight')) {
            $map['mu_weight'] = $this->input('weight');
        }

        if ($this->filled('gender')) {
            $map['mu_gender'] = $this->input('gender');
        }

        if ($this->has('plan_code')) {
            $map['mu_plan_code'] = $this->input('plan_code');
        }

        if ($this->has('settings')) {
            $map['mu_settings'] = $this->input('settings');
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
        $user_id = optional($this->route('user'))->mu_id ?? Auth::user()->mu_id;

        return [
            'mu_name' => ['sometimes', 'string', 'max:255'],
            'mu_email' => [
                'sometimes',
                'email',
                Rule::unique('mm_users', 'mu_email')
                    ->ignore($user_id, 'mu_id')
                    ->whereNull('mu_deleted_at'),
            ],
            'mu_password' => ['sometimes', 'string', 'min:8', 'confirmed'],
            'mu_role' => [
                'sometimes',
                'nullable',
                'string',
                Rule::exists('mm_user_roles', 'mur_code')
                    ->whereNull('mur_deleted_at'),
            ],
            'mu_age' => ['sometimes', 'integer', 'min:10'],
            'mu_height' => ['sometimes', 'integer', 'min:120'],
            'mu_weight' => ['sometimes', 'integer', 'min:30'],
            'mu_gender' => ['sometimes', 'in:male,female'],
            'mu_plan_code' => [
                'sometimes',
                'nullable',
                'string',
                Rule::exists('mm_plans', 'mp_code')
                    ->whereNull('mp_deleted_at'),
            ],
            'mu_settings' => ['sometimes', 'nullable', 'array'],
        ];
    }

    public function attributes(): array
    {
        return [
            'mu_name' => 'name',
            'mu_email' => 'email',
            'mu_password' => 'password',
            'mu_role' => 'role',
            'mu_age' => 'age',
            'mu_height' => 'height',
            'mu_weight' => 'weight',
            'mu_gender' => 'gender',
            'mu_plan_code' => 'plan_code',
            'mu_settings' => 'settings',
        ];
    }
}
