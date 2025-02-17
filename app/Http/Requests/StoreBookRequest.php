<?php

namespace App\Http\Requests;

use App\Rules\NotEmptyArray;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'string',
            'categories' => 'array',
            'categories.*' => [
                'string',
                'exists:categories,name'
            ],
            'authors' => [
                'required',
                'array',
                new NotEmptyArray
            ],
            'author.*' => 'string'
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        //makes sure intended string data is turned into array
        //if its neither string or array, it will throw validation error by using validation rules 'array'
        //if its array of non string value, it will throw validation error by using validation rule to each of the array items 'string'

        $authors = $this->input('authors');
        $categories = $this->input('categories');
        if (is_string($authors)) {
            $this->merge([
                'authors' => [$authors]
            ]);
        }
        if (is_string($categories)) {
            $this->merge([
                'categories' => [strtolower($categories)]
            ]);
        }
        else if (is_array($categories)){
            $lowerCasedCategory = [];
            foreach ($categories as $category) {
                if(is_string($category)){
                    $lowerCasedCategory[]= strtolower($category);
                }
                else{
                    $lowerCasedCategory[]= $category;
                }
            }
            $this->merge([
                'categories' => $lowerCasedCategory
            ]);
        }
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
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
            'title.required' => 'Book title is required.',
            'title.string' => 'Book title must be a valid string.',
            'title.max' => 'Book title must not exceed 255 characters.',
            'description.string' => 'Book description must be a valid string.',
            'categories.array' => 'The book categories must be a string or an array',
            'categories.*.string' => 'Each book categories must be a valid string.',
            'categories.*.exists' => 'One or more selected book categories do not exist.',
            'authors.required' => 'Book authors is required.'
        ];
    }
}
