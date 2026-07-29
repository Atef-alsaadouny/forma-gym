<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'member_id' => ['required', 'integer', Rule::exists('members', 'id')],
            'date' => ['nullable', 'date'],
            'checked_in_at' => ['nullable', 'date_format:Y-m-d H:i:s'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ];
    }
}
