<?php

namespace Features\Core\Rules;

use Features\Core\Services\ValidateCartNumberService;
use Illuminate\Contracts\Validation\InvokableRule;

class ValidCreditCart implements InvokableRule
{
    public function __invoke($attribute, $value, $fail)
    {
        if (!ValidateCartNumberService::run($value)) {
            $fail('The :attribute must be valid.');
        }
    }
}
