<?php

namespace App\Rules\Kategori;

use App\Models\KategoriModel;
use Illuminate\Contracts\Validation\Rule;

class kodeChecker implements Rule
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
        $kategori = KategoriModel::withTrashed()->get();
        foreach ($kategori as $item) {
            if($item->kode_kategori == $value){
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
        return 'Kode Kategori Sudah Tersedia!';
    }
}
