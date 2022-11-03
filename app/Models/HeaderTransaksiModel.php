<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeaderTransaksiModel extends Model
{
    use HasFactory, SoftDeletes;
    public $table           = "header_transaksi";
    public $primaryKey      = "id_htrans";
    public $incrementing    = true;
    public $timestamps      = true;
    protected $fillable = [
        'fk_id_pegawai',
        'fk_kode_member',
        'fk_kode_promo',
        'pajak',
        'total_qty',
        'total_transaksi',
        'tunai_transaksi',
        'kembali_transaksi',
    ];
    
    public function insertData($pegawai, $member, $promo, $pajak, $qty, $total, $tunai, $kembalian){
        $data   = new HeaderTransaksiModel();
        $data->id_htrans         = null;
        $data->fk_id_pegawai     = $pegawai;
        $data->fk_kode_member    = $member;
        $data->fk_kode_promo     = $promo;
        $data->pajak             = $pajak;
        $data->total_qty         = $qty;
        $data->total_transaksi   = $total;
        $data->tunai_transaksi   = $tunai;
        $data->kembali_transaksi = $kembalian;
        $data->save();
    }
    
    // public function findBarang($kode)
    // {
    //     $data = BarangModel::find($kode);
    //     return $data;
    // }

    // public function findBarangWithTrashed($kode)
    // {
    //     $data = BarangModel::withTrashed()
    //                         ->find($kode);
    //     return $data;
    // }
    
    public function getIdHtransLast()
    {
        $data = HeaderTransaksiModel::select('header_transaksi.id_htrans')
                                    ->latest('header_transaksi.created_at')
                                    ->first();
        return $data;
    }

    public function getLengthTrans()
    {
        $data = HeaderTransaksiModel::get();
        return $data;
    }

    public function getAllHeaderTransaksi()
    {
       $user = new User();
       $member = new MemberModel();
       $promo = new PromoModel();
       $data = HeaderTransaksiModel::withTrashed()->select('header_transaksi.*','users.name','member_models.nama_member')
                ->join(
                    'users',
                    function ($join) use ($user) {
                        $join->on(
                            'header_transaksi.fk_id_pegawai',
                            '=',
                            'users.id'
                        );
                        $join->WhereNotNull('users.created_at');
                    })
                ->leftJoin(
                    'member_models',
                    function ($join) use ($member) {
                        $join->on(
                            'header_transaksi.fk_kode_member',
                            '=',
                            'member_models.kode_member'
                        );
                        $join->WhereNotNull('member_models.created_at');
                    })
                ->leftJoin(
                    'promo_models',
                    function ($join) use ($promo) {
                        $join->on(
                            'header_transaksi.fk_kode_promo',
                            '=',
                            'promo_models.kode_promo'
                        );
                        $join->WhereNotNull('promo_models.created_at');
                    })
                ->orderBy('header_transaksi.id_htrans','desc')
                ->paginate(5);
       return $data;
    }

    public function getAllDataHeaderTransaksi()
    {
        $data = HeaderTransaksiModel::withTrashed()->select('header_transaksi.*')
                ->orderBy('header_transaksi.created_at','desc')
                ->get();
       return $data;
    }
}
