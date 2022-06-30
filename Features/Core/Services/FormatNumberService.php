<?php

namespace Features\Core\Services;

class FormatNumberService
{
    public static function run(string $number, string $from = 'fa', string $to = 'en')
    {
        try {
            $result = match ($from . '-' . $to) {
                'fa-en' => self::faToEn($number),
                'en-fa' => self::enToFa($number),

                'ar-en' => self::arToEn($number),
                'en-ar' => self::enToAr($number),

                default => $number,
            };

        } catch (\Exception $e) {
            return $number;
        }

        return $result;

    }

    private static function faToEn($string)
    {
        return strtr($string, ['۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9']);
    }

    private static function arToEn($string): string
    {
        return strtr($string, ['۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9']);
    }

    private static function enToFa($string): string
    {
        return strtr($string, ['0' => '۰', '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴', '5' => '۵', '6' => '۶', '7' => '۷', '8' => '۸', '9' => '۹']);
    }

    private static function enToAr($string): string
    {
        return strtr($string, ['0' => '٠', '1' => '١', '2' => '٢', '3' => '٣', '4' => '٤', '5' => '٥', '6' => '٦', '7' => '٧', '8' => '٨', '9' => '٩']);
    }
}
