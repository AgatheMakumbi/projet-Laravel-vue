<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChoicesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'chapter_id' => 'required|exists:chapters,id',
        'label' => 'required|string|max:255',
        'target_chapter_id' => 'required|exists:chapters,id|different:chapter_id',
    ];
    }
}
