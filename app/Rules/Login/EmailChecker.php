<?php

namespace App\Rules\Login;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class EmailChecker implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $user = User::all();
        foreach ($user as $key => $item) {
            if($item->email == $value){
                return true;
            }
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Email Tidak Tersedia!';
    }
}
