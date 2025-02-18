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
                'integer',
                'exists:categories,id'
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
        //if its not string it will go to the validation rule 'array', if it isn't array it will fail
        //if its array of non string value, it will not pass the validation rule 'string' of 'author.*'  
        $authors = $this->input('authors');
        if (is_string($authors)) {
            $this->merge([
                'authors' => [$authors]
            ]);
        }
        
        //makes sure intended integer data is turned into array
        //if its not integer it will go to the validation rule 'array', if it isn't array it will fail
        //if its array of non integer value, it will not pass the validation rule 'integer'  of 'category.*' 
        $categories = $this->input('categories');
        if (is_int($categories)) {
            $this->merge([
                'categories' => [$categories]
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
            'categories.array' => 'The book categories must be an integer or an array',
            'categories.*.integer' => 'Each book categories must be a integer.',
            'categories.*.exists' => 'One or more selected book categories do not exists.',
            'authors.required' => 'Book authors is required.'
        ];
    }
}
