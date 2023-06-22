<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FilteredText implements ValidationRule
{
    /**
     * Determine if the validation rule passes.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === null) {
            return;
        }

        // The attribute must only contain letters, numbers, dashes,
        // underscores, exclamation marks, dollar signs, commas, dots,
        // parenthesis, apostrophes, quotation marks and a space.
        if (! preg_match('/^[\pL\pM\pN !$,."\'()_-]+$/u', $value)) {
            $fail(__('validation.custom.filtered_text'));
        }
    }
}
