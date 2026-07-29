<?php

declare(strict_types=1);

namespace App\Http\Requests\Public;

use App\Enums\SubscriptionStatus;
use App\Helpers\PhoneHelper;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreSubscriptionRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $phone = $this->input('phone');

        if ($phone) {
            $phone = PhoneHelper::normalizeArabicNumerals($phone);
            $this->merge(['phone' => $phone]);
        }
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'phone' => [
                'required',
                'string',
                'regex:/^[4569]\d{7}$/',
                function ($attribute, $value, $fail) {
                    $existingUser = User::where('phone', $value)->first();

                    if ($existingUser && $existingUser->member) {
                        $hasActive = Subscription::where('member_id', $existingUser->member->id)
                            ->whereIn('status', [SubscriptionStatus::Pending, SubscriptionStatus::Active])
                            ->where('end_date', '>=', now()->startOfDay())
                            ->exists();

                        if ($hasActive) {
                            $fail('هذا الرقم لديه اشتراك فعال بالفعل. لا يمكن التسجيل مرة أخرى.');
                        }
                    }
                },
            ],
            'trainer_id' => ['nullable', 'integer', 'in:1,2,3,4'],
            'locker' => ['nullable', 'boolean'],
            'plan' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['required', 'integer', 'min:1'],
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw (new ValidationException($validator))
            ->errorBag('default')
            ->redirectTo($this->getRedirectUrl());
    }
}
