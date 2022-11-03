<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SatuanModel extends Model
{
    use HasFactory, SoftDeletes;
    public $table           = "satuan_models";
    public $primaryKey      = "kode_satuan";
    public $incrementing    = false;
    public $timestamps      = true;
    protected $fillable = [
        'kode_satuan',
        'faktor',
    ];
    
    public function insertData($kode, $faktor){
        $data = new SatuanModel();
        $data->kode_satuan = $kode;
        $data->faktor      = $faktor;
        $data->save();
    }

    public function updateData($kode, $faktor){
        $data = SatuanModel::find($kode);
        $data->faktor      = $faktor;
        $data->save();
    }

    public function deleteData($kode){
        $data = SatuanModel::find($kode);
        $data->delete();
    }
    
    public function restoreData($kode){
        $data = SatuanModel::withTrashed()
                    ->where('kode_satuan', $kode)
                    ->restore();
    }

    public function findSatuan($kode)
    {
        $data = SatuanModel::find($kode);
        return $data;
    }

    public function getAllSatuan()
    {
        return SatuanModel::withTrashed()
                            ->orderBy('faktor','asc')
                            ->paginate(5);
    }

    public function getAllSatuanForSearch($searchval)
    {
        return SatuanModel::withTrashed()
                            ->where('satuan_models.kode_satuan','like', "$searchval%")
                            ->orWhere('satuan_models.kode_satuan','like', "%$searchval%")
                            ->orderBy('faktor','asc')
                            ->paginate(5);
    }

    public function findSatuanWithTrashed($kode)
    {
        $data = SatuanModel::withTrashed()
                            ->find($kode);
        return $data;
    }

    public function getAllSatuanWithoutTrashed()
    {
        return SatuanModel::get();
    }
}
