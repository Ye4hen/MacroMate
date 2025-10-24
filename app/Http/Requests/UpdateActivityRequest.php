<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $map = [];

        if ($this->filled('name')) {
            $map['ma_name'] = $this->input('name');
        }

        if ($this->filled('calories')) {
            $map['ma_cals'] = $this->input('calories');
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
        $activity_id = $this->route('code')
          ? \App\Domain\Models\Activity::where('ma_code', $this->route('code'))->value('ma_id')
          : null;

        return [
          'ma_name' => [
            'sometimes',
            'string',
            'max:255',
            Rule::unique('mm_activities', 'ma_name')
              ->ignore($activity_id, 'ma_id')
              ->whereNull('ma_deleted_at'),
          ],
          'ma_cals' => ['sometimes', 'integer', 'min:0'],
          'plans_codes' => ['sometimes', 'array'],
          'plans_codes.*' => [
            'string',
            Rule::exists('mm_plans', 'mp_code')
              ->whereNull('mp_deleted_at'),
          ],
        ];
    }
}
