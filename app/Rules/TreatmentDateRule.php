<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class TreatmentDateRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_array($value)){
            $fail(":attribute must be an array.");
        }

        foreach ($value as $date){
            if (is_int($value) && $date > 0 && $date < 8){
                $fail('The :attribute array must contain integer values lower than 8.');
            }
        }
    }
}
