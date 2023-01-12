<?php

namespace App\Http\Requests;

use App\Rules\Document;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterAuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max: 255'],
            'email' => ['required', 'email', 'min:3', 'max: 255', 'unique:users'],
            'document' => ['required', 'string', 'unique:users', new Document],
            'password' => ['required', 'string', 'min:8', 'max: 255', Password::default()],
        ];
    }
}
