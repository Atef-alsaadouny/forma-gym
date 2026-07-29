<?php

declare(strict_types=1);

namespace App\Http\Requests\Trainer;

use App\Enums\MemberRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreTrainerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', Password::defaults()],

            'specialization' => ['nullable', 'string', 'max:255'],
            'experience_years' => ['nullable', 'integer', 'min:0', 'max:70'],
            'bio' => ['nullable', 'string', 'max:5000'],
            'certifications' => ['nullable', 'string', 'max:1000'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],

            'gender' => ['nullable', 'string', Rule::in(['male', 'female'])],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'joined_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:5000'],

            'branch_id' => ['nullable', 'integer', Rule::exists('branches', 'id')],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'The first name is required.',
            'last_name.required' => 'The last name is required.',
            'email.unique' => 'This email is already registered.',
            'profile_photo.image' => 'The profile photo must be an image.',
            'profile_photo.max' => 'The profile photo must not exceed 2MB.',
        ];
    }
}
