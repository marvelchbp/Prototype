<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StokLogResource extends JsonResource
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
            'id' => $this->id,
            'fk_kode_barang' => $this->fk_kode_barang,
            'fk_id_pegawai' => $this->fk_id_pegawai,
            'name' => $this->name,
            'stock_sebelum' => $this->stock_sebelum,
            'stock_sesudah' => $this->stock_sesudah,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
