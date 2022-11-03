<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StokLogModel extends Model
{
    use HasFactory, SoftDeletes;
    public $table           = "stock_log_history";
    public $primaryKey      = "id";
    public $incrementing    = true;
    public $timestamps      = true;
    protected $fillable = [
        'fk_kode_barang',
        'fk_id_pegawai',
        'stock_sebelum',
        'stock_sesudah',
    ];
    
    public function insertData($kodeBarang, $idPeg, $stokSebelum, $stokSesudah){
        $data   = new StokLogModel();
        $data->id               = null;
        $data->fk_kode_barang   = $kodeBarang;
        $data->fk_id_pegawai    = $idPeg;
        $data->stock_sebelum     = $stokSebelum;
        $data->stock_sesudah    = $stokSesudah;
        $data->save();
    }

    public function getAllData()
    {
        $data = StokLogModel::withTrashed()->select('stock_log_history.*','users.name')
                            ->join('users', 'users.id','stock_log_history.fk_id_pegawai')
                            ->orderBy('id','desc')
                            ->paginate(5);
        return $data;
    }

    public function getAllDataForSearch($searchval)
    {
        $data = StokLogModel::withTrashed()->select('stock_log_history.*','users.name')
                            ->join('users', 'users.id','stock_log_history.fk_id_pegawai')
                            ->where('stock_log_history.fk_kode_barang','like', "$searchval%")
                            ->orWhere('stock_log_history.fk_kode_barang','like', "%$searchval%")
                            ->orWhere('users.name','like', "$searchval%")
                            ->orWhere('users.name','like', "%$searchval%")
                            ->orderBy('id','desc')
                            ->paginate(5);
        return $data;
    }
}
