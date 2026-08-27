<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'publish_year' => ['required', 'integer', 'min:1450', 'max:' . date('Y')],
            'total' => ['required', 'integer', 'min:0', 'max:1000'],
            'isbn' => [
                'required',
                'string',
                'max:20',
                Rule::unique('books', 'isbn')->ignore($this->route('book')),
            ],
            'searched_ids' => ['required', 'array', 'min:1', 'max:5'],
            'searched_ids.*' => ['required', 'integer', 'exists:authors,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'название',
            'publish_year' => 'год издания',
            'isbn' => 'ISBN',
            'searched_ids' => 'авторы',
        ];
    }
}
