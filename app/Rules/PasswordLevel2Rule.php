<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PasswordLevel2Rule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Minimal 16 karakter
        if (strlen($value) < 16) {
            return false;
        }

        // Harus mengandung minimal 1 huruf besar
        if (!preg_match('/[A-Z]/', $value)) {
            return false;
        }

        // Harus mengandung minimal 1 huruf kecil
        if (!preg_match('/[a-z]/', $value)) {
            return false;
        }

        // Harus mengandung minimal 1 angka
        if (!preg_match('/[0-9]/', $value)) {
            return false;
        }

        // Harus mengandung minimal 1 simbol khusus
        if (!preg_match('/[@$!%*?&#^()_+=\{\}\[\]:;"\'<>,.\/\\\\|-]/', $value)) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Password harus minimal 16 karakter dan mengandung minimal 1 huruf besar, 1 huruf kecil, 1 angka, dan 1 simbol khusus (@$!%*?&#^()_+={}[]:;"\'<>,./\\|-).';
    }
}
