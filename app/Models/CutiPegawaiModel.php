<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CutiPegawaiModel extends Model
{
    use HasFactory, SoftDeletes;
    public $table           = "cuti_pegawai";
    public $primaryKey      = "id";
    public $incrementing    = true;
    public $timestamps      = true;
    protected $fillable = [
        'fk_emailPegawai',
        'tanggalAwalCuti',
        'tanggalAkhirCuti',
        'jumlahCuti',
    ];

    public function insertData($idPegawai, $tanggalAwal, $tanggalAkhir,$jumlahCuti){
        $data   = new CutiPegawaiModel();
        $data->id               = null;
        $data->fk_emailPegawai  = $idPegawai;
        $data->tanggalAwalCuti  = $tanggalAwal;
        $data->tanggalAkhirCuti = $tanggalAkhir;
        $data->jumlahCuti       = $jumlahCuti;
        $data->save();
    }

    public function updateData($idCuti, $tanggalAwal, $tanggalAkhir,$jumlahCuti){
        $data = CutiPegawaiModel::find($idCuti);
        $data->tanggalAwalCuti  = $tanggalAwal;
        $data->tanggalAkhirCuti = $tanggalAkhir;
        $data->jumlahCuti       = $jumlahCuti;
        $data->save();
    }

    public function deleteData($id){
        $data = CutiPegawaiModel::find($id);
        $data->delete();
    }

    public function findDataCutiById($idPegawai)
    {
        return CutiPegawaiModel::select('cuti_pegawai.id')
                                ->where('cuti_pegawai.fk_emailPegawai',$idPegawai)
                                ->get();
    }

}
