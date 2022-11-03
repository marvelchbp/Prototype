<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CutiPegawaiModel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    public $table           = "users";
    public $primaryKey      = "id";
    public $incrementing    = true;
    public $timestamps      = true;
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'jabatan'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    public function deleteData($id){
        $data = User::find($id);
        $data->delete();
    }

    public function restoreData($id)
    {
        $data = User::withTrashed()
                    ->where('id', $id)
                    ->restore();
    }

    public function addJabatanById($jabatan,$id){
        $data = User::find($id);
        $data->jabatan   = $jabatan;
        $data->save();
    }

    public function findUser($id)
    {
        $data = User::find($id);
        return $data;
    }

    public function findUserWithTrash($id)
    {
        $data = User::withTrashed()->find($id);
        return $data;
    }

    public function getDataUsersByEmail($email){
        return User::where('email', $email)->get();
    }  

    public function getAllPegawai()
    {
        $CutiModel = new CutiPegawaiModel();
        return User::withTrashed()->select('users.*','cuti_pegawai.tanggalAwalCuti','cuti_pegawai.tanggalAkhirCuti','cuti_pegawai.jumlahCuti')
                ->leftJoin(
                    'cuti_pegawai',
                    function ($join) use ($CutiModel) {
                        $join->on(
                            'cuti_pegawai.fk_emailPegawai',
                            '=',
                            'users.id'
                        );
                        $join->whereNull('cuti_pegawai.deleted_at');
                    })
                ->where('users.id','<>','1')
                ->orderBy('users.id','asc')
                ->paginate(5);
    }

    public function getAllPegawaiForSearch($searchval)
    {
        $CutiModel = new CutiPegawaiModel();
        return User::withTrashed()->select('users.*','cuti_pegawai.tanggalAwalCuti','cuti_pegawai.tanggalAkhirCuti','cuti_pegawai.jumlahCuti')
                ->leftJoin(
                    'cuti_pegawai',
                    function ($join) use ($CutiModel) {
                        $join->on(
                            'cuti_pegawai.fk_emailPegawai',
                            '=',
                            'users.id'
                        );
                        $join->whereNull('cuti_pegawai.deleted_at');
                    })
                ->where('users.id','<>','1')
                ->where('users.email','like', "$searchval%")
                ->orWhere('users.email','like', "%$searchval%")
                ->orWhere('users.name','like', "$searchval%")
                ->orWhere('users.name','like', "%$searchval%")
                ->orderBy('users.id','asc')
                ->paginate(5);
    }
}
