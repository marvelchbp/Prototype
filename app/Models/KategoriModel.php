<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KategoriModel extends Model
{
    use HasFactory, SoftDeletes;
    public $table           = "kategori_models";
    public $primaryKey      = "kode_kategori";
    public $incrementing    = false;
    public $timestamps      = true;
    protected $fillable = [
        'nama_kategori',
        'jumlah_barang',
    ];
    
    public function insertData($kode, $nama){
        $data   = new KategoriModel();
        $data->kode_kategori        = $kode;
        $data->nama_kategori        = $nama;
        $data->jumlah_barang        = 0;
        $data->save();
    }

    public function updateData($kode, $nama){
        $data = KategoriModel::find($kode);
        $data->nama_kategori = $nama;
        $data->save();
    }

    public function updateJumlahBarang($kode, $jumlah){
        $data = KategoriModel::find($kode);
        $data->jumlah_barang += $jumlah;
        $data->save();
    }

    public function updateJumlahBarangKurang($kode, $jumlah){
        $data = KategoriModel::find($kode);
        $data->jumlah_barang -= $jumlah;
        $data->save();
    }

    public function deleteData($kode){
        $data = KategoriModel::find($kode);
        $data->delete();
    }
    
    public function restoreData($kode){
        $data = KategoriModel::withTrashed()
                    ->where('kode_kategori', $kode)
                    ->restore();
    }
    
    public function findKategori($kode)
    {
        $data = KategoriModel::find($kode);
        return $data;
    }

    public function findKategoriWithTrashed($kode)
    {
        $data = KategoriModel::withTrashed()
                            ->find($kode);
        return $data;
    }

    public function findNamaWithTrashed($nama)
    {
        $data = KategoriModel::withTrashed()
                            ->where('nama_kategori',$nama)
                            ->get();
        return $data;
    }

    public function getAllKategori()
    {
        return KategoriModel::withTrashed()
                            ->paginate(5);
    }

    public function getAllKategoriForSearch($searchval)
    {
        return KategoriModel::withTrashed()
                            ->where('kategori_models.kode_kategori','like', "$searchval%")
                            ->orWhere('kategori_models.kode_kategori','like', "%$searchval%")
                            ->orWhere('kategori_models.nama_kategori','like', "$searchval%")
                            ->orWhere('kategori_models.nama_kategori','like', "%$searchval%")
                            ->orderBy('kategori_models.kode_kategori','asc')
                            ->paginate(5);
    }

    public function getAllKategoriWithoutTrashed()
    {
        return KategoriModel::get();
    }
}
