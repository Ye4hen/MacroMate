<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StorePlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'mp_name' => $this->input('name'),
            'mp_cal_index' => $this->input('calories_index'),
            'mp_pfc' => $this->input('pfc'),
            'activity_codes' => $this->input('activities', []),
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
            'mp_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('mm_plans', 'mp_name')
                    ->whereNull('mp_deleted_at'),
            ],
            'mp_cal_index' => 'required|numeric|min:0',
            'mp_pfc' => 'required|array',
            'mp_pfc.proteins' => 'required|numeric|min:0',
            'mp_pfc.fat' => 'required|numeric|min:0',
            'mp_pfc.carbs' => 'required|numeric|min:0',
            'activity_codes' => 'sometimes|array',
            'activity_codes.*' => 'string|exists:mm_activities,ma_code',
        ];
    }
}
