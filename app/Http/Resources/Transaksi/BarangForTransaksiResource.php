<?php

namespace App\Http\Resources\Transaksi;

use Illuminate\Http\Resources\Json\JsonResource;

class BarangForTransaksiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'kode_barang' => $this->kode_barang,
            'barcode' => $this->barcode,
            'nama_barang' => $this->nama_barang,
            'satuan' => $this->kode_satuan,
            'harga' => $this->harga_eceran,
            'harga_khusus' => $this->harga_khusus,
        ];
    }
}
