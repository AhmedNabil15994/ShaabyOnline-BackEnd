<?php

namespace Modules\User\Rule\WebService;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class OldPasswordRule implements Rule
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
        return Hash::check($value, auth()->user()->password);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('user::api.users.validation.current_password.not_match');
    }
}
