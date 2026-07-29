<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePackageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'duration_days' => ['sometimes', 'required', 'integer', 'min:1', 'max:36500'],
            'price' => ['sometimes', 'required', 'numeric', 'min:0', 'max:99999999.99'],
            'number_of_sessions' => ['nullable', 'integer', 'min:1', 'max:9999'],
            'features' => ['nullable', 'string', 'max:10000'],
            'is_active' => ['boolean'],
            'sort_order' => ['integer', 'min:0', 'max:9999'],
            'branch_id' => ['nullable', 'integer', Rule::exists('branches', 'id')],
        ];
    }
}
