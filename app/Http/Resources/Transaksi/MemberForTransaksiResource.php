<?php

namespace App\Http\Resources\Transaksi;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberForTransaksiResource extends JsonResource
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
            'kode_member' => $this->kode_member,
            'nama_member' => $this->nama_member,
        ];
    }
}
