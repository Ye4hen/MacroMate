<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
          'ma_name' => $this->input('name'),
          'ma_cals' => $this->input('calories'),
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
          'ma_name' => 'required|unique:mm_activities,ma_name|string|max:255',
          'ma_cals' => 'required|integer|min:0',
        ];
    }
}
