<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AlphaNumericSpaceQuoteDotRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        /**
         * ^: Anchors the pattern to the start of the string.
         * [a-zA-Z0-9\s']: This defines the allowed characters:
         *      a-z: Allows lowercase letters (from 'a' to 'z').
         *      A-Z: Allows uppercase letters (from 'A' to 'Z').
         *      0-9: Allows numbers (from '0' to '9').
         *      \s: Allows spaces (matches any whitespace character, including space, tab, or newline).
         *      ': Allows single quotes.
         * +: This means one or more occurrences of any of the allowed characters.
         * $: Anchors the pattern to the end of the string.
         */
        if (!is_string($value) || !preg_match("/^[a-zA-Z0-9\s'.]+$/", $value)) {
            // Retrieve the message from the translation file based on the active locale
            $fail(__('validation.alpha_numeric_space_quote_dot', ['attribute' => $attribute]));
        }
    }
}