<?php

namespace App\Rules\Satuan;

use App\Models\SatuanModel;
use Illuminate\Contracts\Validation\Rule;

class kodeSatuanChecker implements Rule
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
        $satuan = SatuanModel::all();
        foreach ($satuan as $item) {
            if($item->kode_satuan == strtoupper($value)){
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
        return 'Kode Satuan Sudah Tersedia!';
    }
}
