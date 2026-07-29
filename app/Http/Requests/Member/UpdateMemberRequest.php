<?php

declare(strict_types=1);

namespace App\Http\Requests\Member;

use App\Enums\MemberRole;
use App\Models\Member;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        $member = $this->route('member');

        return [
            'first_name' => ['sometimes', 'string', 'max:255'],
            'last_name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($member?->user_id),
            ],
            'phone' => ['nullable', 'string', 'max:20'],

            'emergency_contact' => ['nullable', 'string', 'max:255'],
            'emergency_phone' => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'gender' => ['nullable', 'string', Rule::in(['male', 'female'])],
            'status' => ['nullable', 'string', Rule::in(['active', 'inactive', 'suspended', 'expired'])],
            'joined_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:5000'],

            'branch_id' => ['nullable', 'integer', Rule::exists('branches', 'id')],
        ];
    }
}
