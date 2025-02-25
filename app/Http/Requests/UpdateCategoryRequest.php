<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // Set default value if not present
        $this->merge([
            'name' => $this->input('name', null)
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:100'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->expectsJson()) {
            $errors = $validator->errors();

            $firstError = $errors->first();
            $errorCount = $errors->count();
            $message = $errorCount > 1
                ? $firstError . '(and '. $errorCount - 1 .' more errors)'
                : $firstError;
            $response = response()->json([
                'code' => 422,
                'success' => false,
                'message' => $message,
                'errors' => $validator->errors()
            ], 422);

            throw new HttpResponseException($response);
        } else {
            parent::failedValidation($validator);
        }
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.string' => 'Category name must be a valid string.',
            'name.max' => 'Category name must not exceed 100 characters.'
        ];
    }

}
