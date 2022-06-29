<?php

namespace Features\Core\Services;

class ValidateCartNumberService
{
    public static function run(string $cart_number)
    {
        $sum = 0;
        $length = strlen($cart_number);
        for ($i = 0; $i < $length; $i++) {
            $number = $cart_number[$i];
            $key = $i + 1;

            $result = $key % 2 === 0 ? ((int) $number) : ((int) $number) * 2;

            if ($result > 9) {
                $result -= 9;
            }

            $sum += $result;
        }

        return $sum % 10 === 0;
    }
}
