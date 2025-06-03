<?php

namespace App\Http\Requests\Portfolio;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PortfolioAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'about' => ['required', 'string'],
            'theme' => ['string', 'in:default'],
            'slug' => ['nullable', 'min:2', 'max:20', 'alpha_num'],
            'x_url' => ['sometimes', 'nullable', 'string'],
            'github_url' => ['sometimes', 'nullable', 'string'],
            'linkedin_url' => ['sometimes', 'nullable', 'string'],
            'website_url' => ['sometimes', 'nullable', 'string'],
            'location' => ['string', 'sometimes'],
            'meta' => ['json', 'sometimes'],
        ];
    }
}
