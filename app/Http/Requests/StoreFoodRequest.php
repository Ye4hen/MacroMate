<?php

namespace App\Http\Requests;

use App\Enums\FoodTypeEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreFoodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $map = [
          'mf_name' => $this->input('name'),
          'mf_type' => $this->input('type'),
          'mf_cals' => $this->input('calories'),
          'mf_pfcfw' => $this->input('pfcfw'),
          'mf_plan_code' => $this->input('plan_code'),
        ];

        $this->merge($map);
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
          'mf_name' => [
            'required',
            'string',
            'max:255',
            Rule::unique('mm_foods', 'mf_name')
              ->whereNull('mf_deleted_at'),
          ],
          'mf_type' => [
            'string',
            'sometimes',
            Rule::enum(FoodTypeEnum::class),
          ],
          'image' => ['required', 'file', 'image', 'mimes:jpeg,png,jpg,gif,webp,avif', 'max:5120'],
          'mf_cals' => 'required|integer|min:0',
          'mf_pfcfw' => 'required|array',
          'mf_pfcfw.proteins' => 'required|numeric|min:0',
          'mf_pfcfw.fat' => 'required|numeric|min:0',
          'mf_pfcfw.carbs' => 'required|numeric|min:0',
          'mf_pfcfw.fiber' => 'required|numeric|min:0',
          'mf_pfcfw.water' => 'required|numeric|min:0',
          'mf_plan_code' => 'nullable|string|exists:mm_plans,mp_code',
        ];
    }
}
