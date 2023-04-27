<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        if (auth()->user())
        {
            return [
                'body' => ['required', 'string'],
            ];
        }
        else
        {
            return [
                'user_name' => ['required', 'string', 'max:255'],
                'body' => ['required', 'string'],
            ];
        }
    }
}
