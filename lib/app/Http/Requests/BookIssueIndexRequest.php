<?php

namespace App\Http\Requests;

use App\Enums\BookIssueStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookIssueIndexRequest extends FormRequest
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
            'selected_id_book' => ['nullable', 'integer', 'exists:books,id'],
            'book_name' => ['nullable', 'string', 'max:255'],
            'book_isbn' => ['nullable', 'string', 'max:255'],

            'selected_id_reader' => ['nullable', 'integer', 'exists:users,id'],
            'reader_name' => ['nullable', 'string', 'max:255'],

            'issued_from' => ['nullable', 'date'],
            'issued_to' => ['nullable', 'date', 'after_or_equal:issued_from'],

            'return_from' => ['nullable', 'date'],
            'return_to' => ['nullable', 'date', 'after_or_equal:return_from'],

            'status' => ['nullable', 'integer', Rule::enum(BookIssueStatus::class)],
        ];
    }
}
