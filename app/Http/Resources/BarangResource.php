<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BarangResource extends JsonResource
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
            'kode_kategori' => $this->kode_kategori,
            'nama_kategori' => $this->nama_kategori,
            'satuan' => $this->kode_satuan,
            'faktor' => $this->faktor,
            'harga_grosir' => $this->harga_grosir,
            'harga_eceran' => $this->harga_eceran,
            'harga_khusus' => $this->harga_khusus,
            'deskripsi' => $this->deskripsi,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
