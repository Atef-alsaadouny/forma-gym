<?php

declare(strict_types=1);

namespace App\Http\Requests\Public;

use App\Enums\SubscriptionStatus;
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
            $phone = $this->normalizeArabicNumerals($phone);
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

    public function messages(): array
    {
        return [
            'name.required' => 'الاسم مطلوب',
            'name.min' => 'الاسم يجب أن يكون على الأقل حرفين',
            'phone.required' => 'رقم الهاتف مطلوب',
            'phone.regex' => 'رقم الهاتف يجب أن يكون 8 أرقام ويبدأ بـ 4 أو 5 أو 6 أو 9',
            'trainer_id.exists' => 'المدرب المحدد غير موجود',
            'phone.active_subscription' => 'This phone number already has an active subscription.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw (new ValidationException($validator))
            ->errorBag('default')
            ->redirectTo($this->getRedirectUrl());
    }

    private function normalizeArabicNumerals(string $input): string
    {
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $english = range(0, 9);

        return str_replace($arabic, $english, $input);
    }
}
