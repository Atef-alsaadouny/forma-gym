<?php

return [
    'required' => 'حقل :attribute مطلوب',
    'string' => 'يجب أن يكون :attribute نصاً',
    'max' => [
        'string' => 'يجب ألا يزيد :attribute عن :max حرفاً',
    ],
    'min' => [
        'string' => 'يجب ألا يقل :attribute عن :min أحرف',
    ],
    'regex' => 'صيغة :attribute غير صحيحة',
    'numeric' => 'يجب أن يكون :attribute رقماً',
    'integer' => 'يجب أن يكون :attribute عدداً صحيحاً',
    'boolean' => 'يجب أن تكون قيمة :attribute صواب أو خطأ',
    'email' => 'يجب أن يكون :attribute بريداً إلكترونياً صالحاً',
    'unique' => ':attribute مستخدم بالفعل',
    'exists' => ':attribute المحدد غير موجود',
    'in' => ':attribute المحدد غير صالح',
    'confirmed' => 'تأكيد :attribute غير متطابق',
    'attributes' => [
        'name' => 'الاسم',
        'phone' => 'رقم الهاتف',
        'email' => 'البريد الإلكتروني',
        'booking_ref' => 'رقم الحجز',
        'plan' => 'الخطة',
        'price' => 'السعر',
        'duration' => 'المدة',
        'trainer_id' => 'المدرب',
        'locker' => 'الخزنة',
    ],
];
