<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostFilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //return false;
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'per_page' => $this->input('per_page', 15), // Default to 15 if not provided
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
            'author_id' => ['sometimes', 'integer', 'exists:authors,id'],
            'title' => ['sometimes', 'string', 'max:255'],
            'page' => ['sometimes', 'integer'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'], //maximum safe limit
        ];
    }
}
