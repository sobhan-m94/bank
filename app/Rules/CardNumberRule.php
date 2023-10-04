<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CardNumberRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cardToArr = str_split($value);
        $cardTotal = 0;
        for ($i = 0; $i < 16; $i++) {
            $c = (int)$cardToArr[$i];
            if ($i % 2 === 0) {
                $cardTotal += (($c * 2 > 9) ? ($c * 2) - 9 : ($c * 2));
            } else {
                $cardTotal += $c;
            }
        }
        if ($cardTotal % 10 !== 0) {
            $fail(':value یک شماره کارت معتبر نیست.');
        }
    }
}
