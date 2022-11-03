<?php

namespace App\Rules\Stok;

use App\Models\BarangModel;
use Illuminate\Contracts\Validation\Rule;

class kodeBarangStokChecker implements Rule
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
        $barang = BarangModel::all();
        foreach ($barang as $item) {
            if($item->kode_barang == strtoupper($value)){
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
        return 'Kode Barang Tidak Tersedia!';
    }
}
