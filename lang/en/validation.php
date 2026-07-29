<?php

return [
    'required' => 'The :attribute field is required.',
    'string' => 'The :attribute must be a string.',
    'max' => [
        'string' => 'The :attribute must not be greater than :max characters.',
    ],
    'min' => [
        'string' => 'The :attribute must be at least :min characters.',
    ],
    'regex' => 'The :attribute format is invalid.',
    'numeric' => 'The :attribute must be a number.',
    'integer' => 'The :attribute must be an integer.',
    'boolean' => 'The :attribute field must be true or false.',
    'email' => 'The :attribute must be a valid email address.',
    'unique' => 'The :attribute has already been taken.',
    'exists' => 'The selected :attribute is invalid.',
    'in' => 'The selected :attribute is invalid.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'attributes' => [
        'name' => 'Full Name',
        'phone' => 'Phone Number',
        'email' => 'Email',
        'booking_ref' => 'Booking Reference',
        'plan' => 'Plan',
        'price' => 'Price',
        'duration' => 'Duration',
        'trainer_id' => 'Trainer',
        'locker' => 'Locker',
    ],
];
