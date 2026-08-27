<?php

namespace App\Http\Requests;

use App\Enums\BookIssueStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookIssueRequest extends FormRequest
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
            'selected_id_book' => ['required', 'integer', 'exists:books,id'],
            'selected_id_reader' => ['required', 'integer', 'exists:users,id'],
            'status' => ['required', Rule::enum(BookIssueStatus::class)],
            'issued_at' => ['required', 'date', 'date_format:Y-m-d', 'before_or_equal:today', 'before:return_to'],
            'return_to' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:today', 'after:issued_at'],
        ];
    }
}
