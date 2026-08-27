<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RenderIssueModalRequest extends FormRequest
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
            'type' => [
                'required',
                'string',
                Rule::in(['issue', 'book', 'empty']),
            ],

            'id' => [
                'required_if:type,book,issue',
                'integer',

                Rule::when(
                    $this->input('type') === 'book',
                    Rule::exists('books', 'id')
                ),

                Rule::when(
                    $this->input('type') === 'issue',
                    Rule::exists('book_issues', 'id')
                ),
            ],
        ];
    }
}
