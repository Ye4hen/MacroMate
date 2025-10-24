<?php

namespace App\Http\Requests;

use App\Enums\MealTypeEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreMealRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'mm_type' => $this->input('type'),
            'mm_order' => $this->input('order'),
            'mm_date' => $this->input('date'),
            'foods' => $this->input('foods', []),
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
        $user = auth()->user();

        if (!$user instanceof \App\Domain\Models\User) {
            abort(403, 'Unauthorized user instance.');
        }

        $user_code = $user->getUserCode();
        $max_order = count(MealTypeEnum::cases());

        return [
            'mm_date' => 'required|date',
            'mm_type' => [
                'required',
                Rule::enum(MealTypeEnum::class),
                Rule::unique('mm_meals', 'mm_type')
                    ->where('mm_user', $user_code)
                    ->where('mm_date', $this->input('date'))
                    ->whereNull('mm_deleted_at'),
            ],
            'mm_order' => [
                'required', 'integer', 'min:1', "max:$max_order",
                Rule::unique('mm_meals', 'mm_order')
                    ->where('mm_user', $user_code)
                    ->where('mm_date', $this->input('date'))
                    ->whereNull('mm_deleted_at'),
            ],

            'foods' => 'required|array|min:1',
            'foods.*.code' => [
                'required',
                'string',
                Rule::exists('mm_foods', 'mf_code')
                    ->whereNull('mf_deleted_at'),
            ],
            'foods.*.quantity' => 'required|numeric|min:1',
            'foods.*.unit' => 'required|string|max:20',
        ];
    }
}
