<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user_id = $this->user() ? $this->user()->id : null;

        return [
            'name' => 'sometimes|nullable|string|max:255',
            'username' => 'sometimes|nullable|string|max:15|unique:users,username,' . $user_id,
            'email' => 'sometimes|nullable|email|unique:users,email,' . $user_id,
            'profile_picture' => 'sometimes|nullable|url',
            'title' => 'sometimes|nullable|string|max:255',
            'biography' => 'sometimes|nullable|string',
            'account_type' => 'sometimes|nullable|in:user,mentor,admin',
        ];
    }
}
