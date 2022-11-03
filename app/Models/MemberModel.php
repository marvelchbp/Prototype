<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberModel extends Model
{
    use HasFactory, SoftDeletes;
    public $table           = "member_models";
    public $primaryKey      = "kode_member";
    public $incrementing    = true;
    public $timestamps      = true;
    protected $fillable = [
        'nama_member',
        'wilayah',
        'alamat',
        'nomor_telepon_member',
    ];
    
    public function insertData($nama, $wilayah, $alamat, $telp){
        $data   = new MemberModel();
        $data->kode_member          = null;
        $data->nama_member          = $nama;
        $data->wilayah              = $wilayah;
        $data->alamat               = $alamat;
        $data->nomor_telepon_member = $telp;
        $data->save();
    }

    public function updateData($kode, $nama, $wilayah, $alamat, $telp){
        $data = MemberModel::find($kode);
        $data->nama_member          = $nama;
        $data->wilayah              = $wilayah;
        $data->alamat               = $alamat;
        $data->nomor_telepon_member = $telp;
        $data->save();
    }

    public function deleteData($kode){
        $data = MemberModel::find($kode);
        $data->delete();
    }
    
    public function restoreData($kode){
        $data = MemberModel::withTrashed()
                    ->where('kode_member', $kode)
                    ->restore();
    }
    
    public function findMember($kode)
    {
        $data = MemberModel::find($kode);
        return $data;
    }

    public function findMemberWithTrashed($kode)
    {
        $data = MemberModel::withTrashed()
                            ->find($kode);
        return $data;
    }

    public function getAllMember()
    {
        return MemberModel::withTrashed()
                            ->paginate(5);
    }

    public function getAllMemberForSearch($searchval)
    {
        return MemberModel::withTrashed()
                            ->where('member_models.nama_member','like', "$searchval%")
                            ->orWhere('member_models.nama_member','like', "%$searchval%")
                            ->paginate(5);
    }

    public function getAllMemberForTransaksi()
    {
        $data = MemberModel::select('member_models.kode_member','member_models.nama_member')
                            ->paginate(5);
        return $data;
    }
}
