<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailTransaksiModel extends Model
{
    use HasFactory, SoftDeletes;
    public $table           = "detail_transaksi";
    public $primaryKey      = "id";
    public $incrementing    = true;
    public $timestamps      = true;
    protected $fillable = [
        'fk_id_htrans',
        'fk_kode_barang',
        'qty',
        'nama_barang',
        'satuan',
        'harga_barang',
        'discount',
        'total',    
    ];
    
    public function insertData($htrans, $barang, $qty, $nama, $satuan, $harga, $discount, $total){
        $data   = new DetailTransaksiModel();
        $data->id               = null;
        $data->fk_id_htrans     = $htrans;
        $data->fk_kode_barang   = $barang;
        $data->qty              = $qty;
        $data->nama_barang      = $nama;
        $data->satuan           = $satuan;
        $data->harga_barang     = $harga;
        $data->discount         = $discount;
        $data->total            = $total;
        $data->save();
    }

    public function getAllDetailTransaksi($idhtrans)
    {
       $barang = new BarangModel();
       $data = DetailTransaksiModel::withTrashed()->select('detail_transaksi.*')
                ->join('header_transaksi','detail_transaksi.fk_id_htrans','header_transaksi.id_htrans')
                ->join(
                    'barang_models',
                    function ($join) use ($barang) {
                        $join->on(
                            'detail_transaksi.fk_kode_barang',
                            '=',
                            'barang_models.kode_barang'
                        );
                        $join->WhereNotNull('barang_models.created_at');
                    })
                ->where('detail_transaksi.fk_id_htrans',$idhtrans)
                ->orderBy('detail_transaksi.id','asc')
                ->get();
       return $data;
    }
}
