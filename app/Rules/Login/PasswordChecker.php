<?php

namespace App\Rules\Login;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class PasswordChecker implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($email = null)
    {
        $this->email = $email;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = User::where('email',$this->email)->first();
        if($user != null) if(Hash::check($value,$user->password)) return true;
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Password Salah';
    }
}
