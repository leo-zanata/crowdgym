<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AfterOrBeforeTime implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $openingTime = request()->input('opening');

        $opening = \Carbon\Carbon::createFromFormat('H:i', $openingTime);
        $closing = \Carbon\Carbon::createFromFormat('H:i', $value);

        if ($opening->gt($closing)) {
            $closing->addDay();
        }

        if ($closing->lte($opening)) {
            $fail('O horário de fechamento deve ser depois do horário de abertura.');
        }
    }
}