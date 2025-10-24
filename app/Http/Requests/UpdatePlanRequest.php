<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdatePlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $map = [];

        if ($this->filled('name')) {
            $map['mp_name'] = $this->input('name');
        }

        if ($this->filled('calories_index')) {
            $map['mp_cal_index'] = $this->input('calories_index');
        }

        if ($this->has('pfc')) {
            $map['mp_pfc'] = $this->input('pfc');
        }

        if ($this->has('activities')) {
            $map['activity_codes'] = $this->input('activities');
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
        $plan_id = $this->route('code')
            ? \App\Domain\Models\Plan::where('mp_code', $this->route('code'))->value('mp_id')
            : null;

        return [
            'mp_name' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('mm_plans', 'mp_name')
                    ->ignore($plan_id, 'mp_id')
                    ->whereNull('mp_deleted_at'),
            ],
            'mp_cal_index' => ['sometimes', 'numeric', 'min:0'],
            'mp_pfc' => ['sometimes', 'array'],
            'mp_pfc.proteins' => ['sometimes', 'numeric', 'min:0'],
            'mp_pfc.fat' => ['sometimes', 'numeric', 'min:0'],
            'mp_pfc.carbs' => ['sometimes', 'numeric', 'min:0'],
            'activity_codes' => ['sometimes', 'array'],
            'activity_codes.*' => [
                'string',
                Rule::exists('mm_activities', 'ma_code')
                    ->whereNull('ma_deleted_at'),
            ],
        ];
    }
}
