<?php

namespace App\Http\Requests;

use App\Enums\SuggestionStatus;
use Illuminate\Foundation\Http\FormRequest;

class SuggestionUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', 'string', 'in:'.implode(',', array_column(SuggestionStatus::cases(), 'value'))]
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'status' => '"Status"',
        ];
    }
}
