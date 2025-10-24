<?php

namespace App\Http\Requests;

use App\Enums\MealTypeEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateMealRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $map = [];

        if ($this->filled('type')) {
            $map['mm_type'] = $this->input('type');
        }

        if ($this->filled('order')) {
            $map['mm_order'] = $this->input('order');
        }

        if ($this->has('date')) {
            $map['mm_date'] = $this->input('date');
        }

        if ($this->has('foods')) {
            $map['foods'] = $this->input('foods');
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
            'mm_type' => ['sometimes', new Enum(MealTypeEnum::class)],
            'mm_order' => ['sometimes', 'integer', 'min:0'],
            'mm_date' => ['sometimes', 'date'],

            'foods' => ['sometimes', 'array', 'min:1'],
            'foods.*.code' => [
                'required_with:foods',
                'string',
                Rule::exists('mm_foods', 'mf_code')
                    ->whereNull('mf_deleted_at'),
            ],
            'foods.*.quantity' => ['required_with:foods', 'numeric', 'min:1'],
            'foods.*.unit' => ['required_with:foods', 'string', 'max:20'],
        ];
    }
}
