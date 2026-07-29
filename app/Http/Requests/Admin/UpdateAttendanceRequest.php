<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'checked_in_at' => ['sometimes', 'required', 'date_format:Y-m-d H:i:s'],
            'checked_out_at' => ['nullable', 'date_format:Y-m-d H:i:s', 'after:checked_in_at'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ];
    }
}
