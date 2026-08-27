<?php

namespace App\Http\Requests;

use App\Enums\BookIssueStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookIssueRequest extends FormRequest
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
            'status' => ['required', Rule::enum(BookIssueStatus::class)],
            'issued_at' => ['required', 'date', 'date_format:Y-m-d', 'before:return_to'],
            'return_to' => ['required', 'date', 'date_format:Y-m-d', 'after:issued_at'],
        ];
    }
}
