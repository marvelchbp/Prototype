<?php

namespace App\Http\Resources\Transaksi;

use Illuminate\Http\Resources\Json\JsonResource;

class PromoForTransaksiResource extends JsonResource
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
            'kode_promo' => $this->kode_promo,
            'potongan' => $this->potongan,
        ];
    }
}
