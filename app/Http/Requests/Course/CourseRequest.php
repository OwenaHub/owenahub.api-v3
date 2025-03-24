<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->mentor_profile;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'about' => 'required|string|max:800',
            'tags' => 'required|string|max:255',
            'thumbnail' => 'nullable|mimes:jpeg,png,jpg|image|max:2048',
            'learning_goals' => 'nullable|string',
            'requirements' => 'nullable|string',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'price' => 'nullable|numeric|min:0|max:999999.99',
            'status' => 'nullable|in:draft,suspended,published',
        ];
    }
}
