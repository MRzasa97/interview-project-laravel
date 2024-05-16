<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DateOrMonthYearRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $datePattern = '/^\d{4}\-\d{2}\-\d{2}$/'; // yyyy-mm-dd
        $monthYearPattern = '/^\d{4}\-\d{2}$/'; // yyyy-mm

        if(!(preg_match($datePattern, $value) || preg_match($monthYearPattern, $value)))
        {
            $fail("The date must follow either yyyy-mm-dd or yyyy-mm format!");
        }
    }
}
