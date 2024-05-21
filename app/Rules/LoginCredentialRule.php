<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LoginCredentialRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if the input is an email
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return;
        }

        // Check if the input is a valid username
        if ($this->isValidUsername($value)) {
            return;
        }

        // If neither email nor username is valid, fail the validation
        $fail('The :attribute must be a valid email address or username.');
    }

    /**
     * Check if the input is a valid username.
     *
     * @param  string  $value
     * @return bool
     */
    protected function isValidUsername($value)
    {
        // Define your username validation rules here
        // For example, only allow alphanumeric characters and underscores
        return preg_match('/^[\w]+$/', $value);
    }
}
