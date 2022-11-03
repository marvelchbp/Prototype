<?php

namespace App\Http\Resources\Transaksi;

use Illuminate\Http\Resources\Json\JsonResource;

class RiwayatTransaksiResource extends JsonResource
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
            'id' => $this->id_htrans,
            'fk_id_pegawai' => $this->fk_id_pegawai,
            'nama_pegawai' => $this->name,
            'fk_kode_member' => $this->fk_kode_member,
            'nama_member' => $this->nama_member,
            'fk_kode_promo' => $this->fk_kode_promo,
            'pajak' => $this->pajak,
            'total_qty' => $this->total_qty,
            'total_transaksi' => $this->total_transaksi,
            'tunai_transaksi' => $this->tunai_transaksi,
            'kembali_transaksi' => $this->kembali_transaksi,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
