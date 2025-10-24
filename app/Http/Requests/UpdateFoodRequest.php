<?php

namespace App\Http\Requests;

use App\Enums\FoodTypeEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateFoodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $map = [];

        if ($this->filled('name')) {
            $map['mf_name'] = $this->input('name');
        }

        if ($this->filled('type')) {
            $map['mf_type'] = $this->input('type');
        }

        if ($this->hasFile('image')) {
            $file = $this->file('image');
            $path = $file->store('foods/' . date('Y/m'), 'public');
            $map['mf_image_url'] = $path;
            $map['mf_image_disk'] = 'public';
        }

        if ($this->filled('calories')) {
            $map['mf_cals'] = $this->input('calories');
        }

        if ($this->has('pfcfw')) {
            $map['mf_pfcfw'] = $this->input('pfcfw');
        }

        if ($this->has('plan_code')) {
            $map['mf_plan_code'] = $this->input('plan_code');
        }

        if ($this->has('updated_by')) {
            $map['mf_updated_by'] = $this->input('updated_by');
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
        return [
          'mf_name' => [
            'sometimes',
            'string',
            'max:255',
            Rule::unique('mm_foods', 'mf_name')
              ->ignore($this->route('code'), 'mf_code')
              ->whereNull('mf_deleted_at'),
          ],
          'mf_type' => ['sometimes', new Enum(FoodTypeEnum::class)],
          'image' => ['sometimes', 'file', 'image', 'mimes:jpeg,png,jpg,gif,webp,avif', 'max:5120'],
          'mf_cals' => ['sometimes', 'integer', 'min:0'],
          'mf_pfcfw' => ['sometimes', 'array'],
          'mf_pfcfw.proteins' => ['sometimes', 'numeric', 'min:0'],
          'mf_pfcfw.fat' => ['sometimes', 'numeric', 'min:0'],
          'mf_pfcfw.carbs' => ['sometimes', 'numeric', 'min:0'],
          'mf_pfcfw.fiber' => ['sometimes', 'numeric', 'min:0'],
          'mf_pfcfw.water' => ['sometimes', 'numeric', 'min:0'],
          'mf_plan_code' => [
            'sometimes',
            'nullable',
            'string',
            Rule::exists('mm_plans', 'mp_code')
              ->whereNull('mp_deleted_at'),
          ],
          'mf_updated_by' => [
            'sometimes',
            'nullable',
            'string',
            Rule::exists('mm_users', 'mu_code')
              ->whereNull('mu_deleted_at'),
          ],
        ];
    }
}
