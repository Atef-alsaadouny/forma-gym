<?php

declare(strict_types=1);

namespace App\Http\Requests\Trainer;

use App\Enums\MemberRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTrainerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        $trainer = $this->route('trainer');

        return [
            'first_name' => ['sometimes', 'string', 'max:255'],
            'last_name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($trainer?->user_id),
            ],
            'phone' => ['nullable', 'string', 'max:20'],

            'specialization' => ['nullable', 'string', 'max:255'],
            'experience_years' => ['nullable', 'integer', 'min:0', 'max:70'],
            'bio' => ['nullable', 'string', 'max:5000'],
            'certifications' => ['nullable', 'string', 'max:1000'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],

            'gender' => ['nullable', 'string', Rule::in(['male', 'female'])],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'status' => ['nullable', 'string', Rule::in(['active', 'inactive', 'suspended'])],
            'is_available' => ['nullable', 'boolean'],
            'rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'joined_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:5000'],

            'branch_id' => ['nullable', 'integer', Rule::exists('branches', 'id')],
        ];
    }
}
