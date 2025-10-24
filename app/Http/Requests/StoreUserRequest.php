<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'mu_name' => $this->input('name'),
            'mu_email' => $this->input('email'),
            'mu_password' => $this->input('password'),
            'mu_password_confirmation' => $this->input('password_confirmation'),
            'mu_role' => $this->input('role'),
            'mu_age' => $this->input('age'),
            'mu_height' => $this->input('height'),
            'mu_weight' => $this->input('weight'),
            'mu_gender' => $this->input('gender'),
            'mu_plan_code' => $this->input('plan_code'),
            'mu_settings' => $this->input('settings'),
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
            'mu_name' => 'required|string|max:255',
            'mu_email' => [
                'required',
                'email',
                Rule::unique('mm_users', 'mu_email')
                    ->whereNull('mu_deleted_at'),
            ],
            'mu_password' => 'required|string|min:8|confirmed',
            'mu_role' => [
                'nullable',
                'string',
                Rule::exists('mm_user_roles', 'mur_code')
                    ->whereNull('mur_deleted_at'),
            ],
            'mu_age' => 'nullable|integer|min:0',
            'mu_height' => 'nullable|integer|min:0',
            'mu_weight' => 'nullable|integer|min:0',
            'mu_gender' => 'nullable|in:male,female',
            'mu_plan_code' => [
                'nullable',
                'string',
                Rule::exists('mm_plans', 'mp_code')
                    ->whereNull('mp_deleted_at'),
            ],
            'mu_settings' => 'nullable|array',
        ];
    }
}
