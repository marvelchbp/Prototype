<?php

namespace App\Rules\Promo;

use App\Models\PromoModel;
use Illuminate\Contracts\Validation\Rule;

class KodePromoChecker implements Rule
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
        $promo = PromoModel::all();
        foreach ($promo as $item) {
            if($item->kode_promo == $value){
                return false;
            }
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
        return 'Kode Promo Sudah Tersedia!';
    }
}
