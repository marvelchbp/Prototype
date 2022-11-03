<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Psy\CodeCleaner\ReturnTypePass;

class PromoModel extends Model
{
    use HasFactory, SoftDeletes;
    public $table           = "promo_models";
    public $primaryKey      = "kode_promo";
    public $incrementing    = false;
    public $timestamps      = true;
    protected $fillable = [
        'deskripsi_promo',
        'potongan',
    ];

    public function insertData($kode, $deskripsi, $potongan){
        $data   = new PromoModel();
        $data->kode_promo       = $kode;
        $data->deskripsi_promo  = $deskripsi;
        $data->potongan         = $potongan;
        $data->save();
    }

    public function updateData($kodeAwal, $kodeGanti, $deskripsi, $potongan){
        $data = PromoModel::find($kodeAwal);
        $data->kode_promo       = $kodeGanti;
        $data->deskripsi_promo  = $deskripsi;
        $data->potongan         = $potongan;
        $data->save();
    }

    public function deleteData($kode){
        $data = PromoModel::find($kode);
        $data->delete();
    }

    public function restoreData($kode){
        $data = PromoModel::withTrashed()
                    ->where('kode_promo', $kode)
                    ->restore();
    }

    public function getAllPromo()
    {
        return PromoModel::withTrashed()
                            ->paginate(5);
    }

    public function getAllPromoForSearch($searchval)
    {
        return PromoModel::withTrashed()
                            ->where('promo_models.kode_promo','like', "$searchval%")
                            ->orWhere('promo_models.kode_promo','like', "%$searchval%")
                            ->paginate(5);
    }

    public function findPromo($kode)
    {
        $data = PromoModel::find($kode);
        return $data;
    }
    public function findPromoWithTrash($kode)
    {
        $data = PromoModel::withTrashed()->find($kode);
        return $data;
    }

    public function getAllPromoForTransaksi()
    {
        $data = PromoModel::select('promo_models.kode_promo','promo_models.potongan')
                            ->paginate(5);
        return $data;
    }
}
