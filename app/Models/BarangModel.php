<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BarangModel extends Model
{
    use HasFactory, SoftDeletes;
    public $table           = "barang_models";
    public $primaryKey      = "kode_barang";
    public $incrementing    = false;
    public $timestamps      = true;
    protected $fillable = [
        'kode_barang',
        'barcode',
        'nama_barang',
        'kategori',
        'satuan',
        'harga_grosir',
        'harga_eceran',
        'harga_khusus',
        'stock',
        'deskripsi',
    ];
    
    public function insertData($kode, $barcode, $nama_barang, $kategori, $satuan, $hGrosir, $hEceran, $hKhusus, $deskripsi){
        $data   = new BarangModel();
        $data->kode_barang  = $kode;
        $data->barcode      = $barcode;
        $data->nama_barang  = $nama_barang;
        $data->kategori     = $kategori;
        $data->satuan       = $satuan;
        $data->harga_grosir = $hGrosir;
        $data->harga_eceran = $hEceran;
        $data->harga_khusus = $hKhusus;
        $data->stock        = 0;
        $data->deskripsi    = $deskripsi;
        $data->save();
    }

    public function updateData($kode, $barcode, $nama_barang, $kategori, $satuan, $hGrosir, $hEceran, $hKhusus, $deskripsi){
        $data   = BarangModel::find($kode);
        $data->barcode      = $barcode;
        $data->nama_barang  = $nama_barang;
        $data->kategori     = $kategori;
        $data->satuan       = $satuan;
        $data->harga_grosir = $hGrosir;
        $data->harga_eceran = $hEceran;
        $data->harga_khusus = $hKhusus;
        $data->deskripsi    = $deskripsi;
        $data->save();
    }

    public function updateDataStok($kode, $stok){
        $data = BarangModel::find($kode);
        $data->stock        = $stok;
        $data->save();
    }

    public function deleteData($kode){
        $data = BarangModel::find($kode);
        $data->delete();
    }
    
    public function restoreData($kode){
        $data = BarangModel::withTrashed()
                    ->where('kode_barang', $kode)
                    ->restore();
    }
    
    public function findBarang($kode)
    {
        $data = BarangModel::find($kode);
        return $data;
    }

    public function findBarangWithTrashed($kode)
    {
        $data = BarangModel::withTrashed()
                            ->find($kode);
        return $data;
    }

    public function getAllBarang()
    {
        return BarangModel::withTrashed()->select('barang_models.*','kategori_models.kode_kategori','kategori_models.nama_kategori','satuan_models.kode_satuan','satuan_models.faktor')
                ->join('kategori_models', 'kategori_models.kode_kategori', 'barang_models.kategori')
                ->join('satuan_models', 'satuan_models.kode_satuan', 'barang_models.satuan')
                ->orderBy('barang_models.kode_barang','asc')
                ->paginate(5);
    }

    public function getAllBarangWithoutPaginate($searchval)
    {
        return BarangModel::withTrashed()->select('barang_models.*','kategori_models.kode_kategori','kategori_models.nama_kategori','satuan_models.kode_satuan','satuan_models.faktor')
                ->join('kategori_models', 'kategori_models.kode_kategori', 'barang_models.kategori')
                ->join('satuan_models', 'satuan_models.kode_satuan', 'barang_models.satuan')
                ->where('barang_models.kode_barang','like', "$searchval%")
                ->orWhere('barang_models.kode_barang','like', "%$searchval%")
                ->orWhere('barang_models.nama_barang','like', "$searchval%")
                ->orWhere('barang_models.nama_barang','like', "%$searchval%")
                ->orderBy('barang_models.kode_barang','asc')
                ->paginate(5);
    }

    public function getAllBarangWithoutTrashed()
    {
        return BarangModel::get();
    }

    public function getDataStokForChange()
    {
        $data = BarangModel::select('barang_models.kode_barang', 'barang_models.stock')
                            ->where('barang_models.stock','<=','5')
                            ->orderBy('barang_models.stock','asc')
                            ->paginate(5);
        return $data;
    }

    public function getDataStokForChangeNotPaginate()
    {
        $data = BarangModel::select('barang_models.kode_barang', 'barang_models.stock')
                            ->where('barang_models.stock','<=','5')
                            ->orderBy('barang_models.stock','asc')
                            ->get();
        return $data;
    }

    public function getDataStokForSearch($searchval)
    {
        $data = BarangModel::select('barang_models.kode_barang', 'barang_models.stock')
                            ->where('barang_models.kode_barang','like', "$searchval%")
                            ->orWhere('barang_models.kode_barang','like', "%$searchval%")
                            ->where('barang_models.stock','<=','5')
                            ->orderBy('barang_models.stock','asc')
                            ->paginate(5);
        return $data;
    }

    public function getDataForTransaksiPilih()
    {
        return BarangModel::select('barang_models.*','satuan_models.kode_satuan')
                ->join('satuan_models', 'satuan_models.kode_satuan', 'barang_models.satuan')
                ->orderBy('barang_models.kode_barang','asc')
                ->paginate(5);
    }

    public function getDataForTransaksiBarcode()
    {
        return BarangModel::select('barang_models.*','satuan_models.kode_satuan')
                ->join('satuan_models', 'satuan_models.kode_satuan', 'barang_models.satuan')
                ->orderBy('barang_models.kode_barang','asc')
                ->get();
    }
}
