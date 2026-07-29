<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePackageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'duration_days' => ['required', 'integer', 'min:1', 'max:36500'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'number_of_sessions' => ['nullable', 'integer', 'min:1', 'max:9999'],
            'features' => ['nullable', 'string', 'max:10000'],
            'is_active' => ['boolean'],
            'sort_order' => ['integer', 'min:0', 'max:9999'],
            'branch_id' => ['nullable', 'integer', Rule::exists('branches', 'id')],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The package name is required.',
            'duration_days.required' => 'The duration is required.',
            'duration_days.min' => 'Duration must be at least 1 day.',
            'price.required' => 'The price is required.',
            'price.min' => 'Price cannot be negative.',
        ];
    }
}
