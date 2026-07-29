<?php

declare(strict_types=1);

namespace App\Helpers;

class PhoneHelper
{
    public static function normalizeArabicNumerals(string $input): string
    {
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $english = range(0, 9);

        return str_replace($arabic, $english, $input);
    }
}
