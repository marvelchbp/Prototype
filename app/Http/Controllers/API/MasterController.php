<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BarangResource;
use App\Http\Resources\KategoriResource;
use App\Http\Resources\MemberResource;
use App\Http\Resources\PromoResource;
use App\Http\Resources\SatuanResource;
use App\Http\Resources\StokLogResource;
use App\Http\Resources\StokResource;
use App\Http\Resources\Transaksi\RiwayatTransaksiResource;
use App\Http\Resources\UserResource;
use App\Models\BarangModel;
use App\Models\CutiPegawaiModel;
use App\Models\HeaderTransaksiModel;
use App\Models\KategoriModel;
use App\Models\MemberModel;
use App\Models\PromoModel;
use App\Models\SatuanModel;
use App\Models\StokLogModel;
use App\Models\User;
use App\Rules\Barang\kodeBarangChecker;
use App\Rules\Kategori\kodeChecker;
use App\Rules\Kategori\nameChecker;
use App\Rules\Promo\KodePromoChecker;
use App\Rules\Satuan\kodeSatuanChecker;
use App\Rules\Stok\kodeBarangStokChecker;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;

class MasterController extends Controller
{
    public function getDataPegawai()
    {
        $users = new User();
        $dataPegawai = $users->getAllPegawai();

        return UserResource::collection($dataPegawai);
    }

    public function addJabatan(Request $request)
    {
        $messages = [
            'email.required' => 'Email Tidak Boleh Kosong!',
            'jabatan.required' => 'Jabatan Tidak Boleh Kosong!',
        ];
        $validation = Validator::make($request->all(), [
            'email' => 'required',
            'jabatan' => 'required',
        ], $messages);
        
        if($validation->fails()){
            $response = [
                'status' => 400,
                'success' => false,
                'message' => $validation->errors()
            ];

            return response()->json($response, 400);
        }
        
        $dataUser = new User();
        $dataPegawaiById = $dataUser->findUser($request->id);
        if($dataPegawaiById == null){
            $message = "Data User Tidak Ditemukan Atau Telah Dihapus!";
        }else{
            $user = new User();
            $user->addJabatanById($request->jabatan,$request->id);
            $message = "Data Sudah Ditambahkan!";
        }

        $response = [
            'status' => 200,
            'success'=> true,
            'message'=> $message,
        ];
        return response()->json($response, 200);

    }

    public function addCutiPegawai(Request $request)
    {
        $messages = [
            'email.required' => 'Email Tidak Boleh Kosong!',
            'tglAwal.required' => 'Tanggal Awal Cuti Tidak Boleh Kosong!',
            'tglAkhir.required' => 'Tanggal Akhir Cuti Tidak Boleh Kosong!',
            'tglAwal.before_or_equal' => 'Tanggal Awal Cuti Harus Sebelum Tanggal Akhir!',
            'tglAkhir.after_or_equal' => 'Tanggal Akhir Cuti Harus Sesudah Tanggal Awal!',
        ];
        $validation = Validator::make($request->all(), [
            'email' => 'required',
            'tglAwal' => 'required|before_or_equal:tglAkhir',
            'tglAkhir' => 'required|after_or_equal:tglAwal',
        ], $messages);
        
        if($validation->fails()){
            $response = [
                'status' => 400,
                'success' => false,
                'message' => $validation->errors()
            ];

            return response()->json($response, 400);
        }
        
        $dataUser = new User();
        $dataPegawaiById = $dataUser->findUser($request->id);
        if($dataPegawaiById == null){
            $message = "Data User Tidak Ditemukan Atau Telah Dihapus!";

            $response = [
                'status' => 200,
                'success'=> true,
                'message'=> $message,
                'data' => [
                    'id' => $request->id,
                    'email' => $request->email,
                    'tanggalAwal' => $request->tglAwal,
                    'tanggalAkhir' => $request->tglAkhir,
                    'jumlahHari' => 0,
                ]
            ];
            return response()->json($response, 200);
        }else{
            $fdate = $request->tglAwal;
            $tdate = $request->tglAkhir;
            $datetime1 = new DateTime($fdate);
            $datetime2 = new DateTime($tdate);
            $interval = $datetime1->diff($datetime2);
            $days = $interval->format('%a');
            $cuti = new CutiPegawaiModel();
            $dataId = 0;
            foreach ($cuti->findDataCutiById($request->id) as $key) {
                $dataId = $key->id;
            }
            if($dataId == 0){
                $cuti->insertData($request->id,$datetime1->modify('+1 day')->format('Y/m/d'),$datetime2->modify('+1 day')->format('Y/m/d'),$days+1);
                $message = "Data Sudah Ditambahkan!";
            }
            else if($dataId != 0){
                $cuti->updateData($dataId,$datetime1->modify('+1 day')->format('Y/m/d'),$datetime2->modify('+1 day')->format('Y/m/d'),$days+1);
                $message = "Data Sudah Diubah!";
            }

            $response = [
                'status' => 200,
                'success'=> true,
                'message'=> $message,
                'data' => [
                    'id' => $request->id,
                    'email' => $request->email,
                    'tanggalAwal' =>$datetime1->modify('+1 day')->format('d/m/Y'),
                    'tanggalAkhir' => $datetime2->modify('+1 day')->format('d/m/Y'),
                    'jumlahHari' => $days+1,
                ]
            ];
            return response()->json($response, 200);
        }

    }

    public function deleteCutiPegawai(Request $request)
    {
        $messages = [
            'email.required' => 'Email Tidak Boleh Kosong!',
        ];
        $validation = Validator::make($request->all(), [
            'email' => 'required',
        ], $messages);
        
        if($validation->fails()){
            $response = [
                'status' => 400,
                'success' => false,
                'message' => $validation->errors()
            ];

            return response()->json($response, 400);
        }
        
        $dataUser = new User();
        $dataPegawaiById = $dataUser->findUser($request->id);
        if($dataPegawaiById == null){
            $message = "Data User Tidak Ada!";
        }else{
            $cuti = new CutiPegawaiModel();
            $dataId = 0;
            foreach ($cuti->findDataCutiById($request->id) as $key) {
                $dataId = $key->id;
            }
            if($dataId == 0){
                $message = "Belum Tersedia Data Cuti!";
            }
            else if($dataId != 0){
                $cuti->deleteData($dataId);
                $message = "Data Terhapus!";
            }
        }

        $response = [
            'status' => 200,
            'success'=> true,
            'message'=> $message,
        ];
        return response()->json($response, 200);
    }

    public function deletePegawai(Request $request)
    {
        $pegawai = new User();
        $dataPegawaiById = $pegawai->findUserWithTrash($request->id);
        $dataDeleted_at = $dataPegawaiById->deleted_at;
        if($dataDeleted_at == null){
            $pegawai->deleteData($request->id);
            $message = "Data Pegawai Berhasil Terhapus!";
        }
        else if($dataDeleted_at != null){
            $pegawai->restoreData($request->id);
            $message = "Data Pegawai Berhasil Di Restore!";
        }

        $response = [
            'status' => 200,
            'success'=> true,
            'message'=> $message,
            'data' => $dataPegawaiById
        ];
        return response()->json($response, 200);
    }

    public function getDataPromo()
    {
        $promo = new PromoModel();
        $dataPromo = $promo->getAllPromo();

        return PromoResource::collection($dataPromo);
    }

    public function insertPromo(Request $request)
    {
        $messages = [
            'kode_promo.required' => 'Kode Promo Tidak Boleh Kosong!',
            'potongan.required' => 'Potongan Tidak Boleh Kosong!',
            'kode_promo.max' => 'Kode Promo Maksimal Memiliki 30 Karakter!',
            'deskripsi_promo.max' => 'Deskripsi Maksimal Memiliki 255 Karakter!',
            'potongan.number' => 'Potongan Hanya Bisa Angka!',
        ];
        $validation = Validator::make($request->all(), [
            'kode_promo' => ['required','max:30', new KodePromoChecker()],
            'deskripsi_promo' => 'max:255',
            'potongan' => 'required|numeric',
        ], $messages);
        
        if($validation->fails()){
            $response = [
                'status' => 400,
                'success' => false,
                'message' => $validation->errors()
            ];

            return response()->json($response, 400);
        }

        $promo = new PromoModel();
        $promo->insertData(strtoupper($request->kode_promo),$request->deskripsi_promo,$request->potongan);
        $message = "Data Berhasil Ditambahkan!";

        $response = [
            'status' => 200,
            'success'=> true,
            'message'=> $message,
        ];
        return response()->json($response, 200);
    }

    public function updatePromo(Request $request)
    {
        $messages = [
            'kode_promo.required' => 'Kode Promo Tidak Boleh Kosong!',
            'potongan.required' => 'Potongan Tidak Boleh Kosong!',
            'kode_promo.max' => 'Kode Promo Maksimal Memiliki 30 Karakter!',
            'deskripsi_promo.max' => 'Deskripsi Maksimal Memiliki 255 Karakter!',
            'potongan.number' => 'Potongan Hanya Bisa Angka!',
        ];
        $validation = Validator::make($request->all(), [
            'kode_promo' => 'required|max:30',
            'deskripsi_promo' => 'max:255',
            'potongan' => 'required|numeric',
        ], $messages);
        
        if($validation->fails()){
            $response = [
                'status' => 400,
                'success' => false,
                'message' => $validation->errors()
            ];

            return response()->json($response, 400);
        }

        $promo =  new PromoModel();
        $dataPromoByKode = $promo->findPromo($request->kode_promo_Hid);
        if($dataPromoByKode == null){
            $message = "Data Promo Tidak Ditemukan atau Sudah Terhapus!";
        }else{
            if($request->kode_promo_Hid != $request->kode_promo){
                $dataPromoFindMatch = $promo->findPromoWithTrash($request->kode_promo);
                if($dataPromoFindMatch != null){
                    $message = "Kode Promo Sudah Dipakai!";
                }else {
                    $promo->updateData(strtoupper($request->kode_promo_Hid),strtoupper($request->kode_promo),$request->deskripsi_promo,$request->potongan);
                    $message = "Data Berhasil Diubah!";
                }
            }else if($request->kode_promo_Hid == $request->kode_promo){
                $promo->updateData(strtoupper($request->kode_promo_Hid),strtoupper($request->kode_promo),$request->deskripsi_promo,$request->potongan);
                $message = "Data Berhasil Diubah!";
            }
        }

        $response = [
            'status' => 200,
            'success'=> true,
            'message'=> $message,
        ];
        return response()->json($response, 200);
    }

    public function deletePromo(Request $request)
    {
        $promo = new PromoModel();
        $dataPromoByKode = $promo->findPromoWithTrash($request->kode_promo);
        $dataDeleted_at = $dataPromoByKode->deleted_at;
        if($dataDeleted_at == null){
            $promo->deleteData($request->kode_promo);
            $message = "Data Promo Berhasil Terhapus!";
        }
        else if($dataDeleted_at != null){
            $promo->restoreData($request->kode_promo);
            $message = "Data Promo Berhasil Di Restore!";
        }

        $response = [
            'status' => 200,
            'success'=> true,
            'message'=> $message,
            'data' => $dataPromoByKode
        ];
        return response()->json($response, 200);
    }

    public function getDataMember()
    {
        $member = new MemberModel();
        $dataMember = $member->getAllMember();

        return MemberResource::collection($dataMember);
    }

    public function insertMember(Request $request)
    {
        $messages = [
            'nama.required' => 'Nama Member Tidak Boleh Kosong!',
            'nama.string' => 'Nama Member Hanya Boleh Berupa Huruf!',
            'nama.max' => 'Nama Member Maksimal Memiliki 50 Karakter!',
            'wilayah.string' => 'Wilayah Hanya Boleh Huruf!',
            'wilayah.max' => 'Kode Promo Maksimal Memiliki 100 Karakter!',
            'alamat.max' => 'Alamat Maksimal Memiliki 250 Karakter!',
            'telp.numeric' => 'Nomor Telepon Hanya Boleh Angka!',
            'telp.max_digits' => 'Nomor Telepon Maksimal Terdiri dari 15 Digit Angka!',
        ];
        $validation = Validator::make($request->all(), [
            'nama' => 'required|string|max:50',
            'wilayah' => 'nullable|string|max:100',
            'alamat' => 'max:255',
            'telp' => 'nullable|numeric|max_digits:15',
        ], $messages);
        
        if($validation->fails()){
            $response = [
                'status' => 400,
                'success' => false,
                'message' => $validation->errors()
            ];

            return response()->json($response, 400);
        }

        $member = new MemberModel();
        $member->insertData($request->nama,$request->wilayah,$request->alamat,$request->telp);
        $message = "Data Berhasil Ditambahkan!";

        $response = [
            'status' => 200,
            'success'=> true,
            'message'=> $message,
        ];
        return response()->json($response, 200);
    }

    public function updateMember(Request $request)
    {
        $messages = [
            'nama.required' => 'Nama Member Tidak Boleh Kosong!',
            'nama.string' => 'Nama Member Hanya Boleh Berupa Huruf!',
            'nama.max' => 'Nama Member Maksimal Memiliki 50 Karakter!',
            'wilayah.string' => 'Wilayah Hanya Boleh Huruf!',
            'wilayah.max' => 'Kode Promo Maksimal Memiliki 100 Karakter!',
            'alamat.max' => 'Alamat Maksimal Memiliki 250 Karakter!',
            'telp.numeric' => 'Nomor Telepon Hanya Boleh Angka!',
            'telp.max_digits' => 'Nomor Telepon Maksimal Terdiri dari 15 Digit Angka!',
        ];
        $validation = Validator::make($request->all(), [
            'nama' => 'required|string|max:50',
            'wilayah' => 'nullable|string|max:100',
            'alamat' => 'max:255',
            'telp' => 'nullable|numeric|max_digits:15',
        ], $messages);
        
        if($validation->fails()){
            $response = [
                'status' => 400,
                'success' => false,
                'message' => $validation->errors()
            ];

            return response()->json($response, 400);
        }

        $member =  new MemberModel();
        $dataMemberByKode = $member->findMember($request->kode);
        if($dataMemberByKode == null){
            $message = "Data Member Tidak Ditemukan atau Sudah Terhapus!";
        }else{
            $member->updateData($request->kode,$request->nama,$request->wilayah,$request->alamat,$request->telp);
            $message = "Data Berhasil Diubah!";
        }

        $response = [
            'status' => 200,
            'success'=> true,
            'message'=> $message,
        ];
        return response()->json($response, 200);
    }

    public function deleteMember(Request $request)
    {
        $member = new MemberModel();
        $dataMemberByKode = $member->findMemberWithTrashed($request->kode);
        $dataDeleted_at = $dataMemberByKode->deleted_at;
        if($dataDeleted_at == null){
            $member->deleteData($request->kode);
            $message = "Data Member Berhasil Terhapus!";
        }
        else if($dataDeleted_at != null){
            $member->restoreData($request->kode);
            $message = "Data Member Berhasil Di Restore!";
        }

        $response = [
            'status' => 200,
            'success'=> true,
            'message'=> $message,
            'data' => $dataMemberByKode
        ];
        return response()->json($response, 200);
    }

    public function getDataKategori()
    {
        $kategori = new KategoriModel();
        $dataKategori = $kategori->getAllKategori();

        return KategoriResource::collection($dataKategori);
    }

    public function getDataKategoriForSelect()
    {
        $kategori = new KategoriModel();
        $dataKategori = $kategori->getAllKategoriWithoutTrashed();

        return KategoriResource::collection($dataKategori);
    }

    public function insertKategori(Request $request)
    {
        $messages = [
            'kode.required' => 'Kode Kategori Tidak Boleh Kosong!',
            'kode.numeric' => 'Kode Kategori Hanya Boleh Angka!',
            'kode.digits_between' => 'Minimal digit Kategori adalah 2! Contoh "05"',
            'nama.required' => 'Nama Kategori Tidak Boleh Kosong!',
            'nama.string' => 'Nama Kategori Berupa Huruf!',
            'nama.max' => 'Nama Kategori Maksimal Memiliki 100 Karakter!',
        ];
        $validation = Validator::make($request->all(), [
            'kode' => [
                'required',
                'numeric',
                'digits_between:2,3', 
                new kodeChecker()
            ],
            'nama' => [
                'required',
                'string',
                'max:100', 
                new nameChecker()
            ],
        ], $messages);
        
        if($validation->fails()){
            $response = [
                'status' => 400,
                'success' => false,
                'message' => $validation->errors()
            ];

            return response()->json($response, 400);
        }

        $kategori = new KategoriModel();
        $kategori->insertData($request->kode,strtoupper($request->nama));
        $message = "Data Berhasil Ditambahkan!";

        $response = [
            'status' => 200,
            'success'=> true,
            'message'=> $message,
        ];
        return response()->json($response, 200);
    }

    public function updateKategori(Request $request)
    {
        $messages = [
            'nama.required' => 'Nama Kategori Tidak Boleh Kosong!',
            'nama.string' => 'Nama Kategori Berupa Huruf!',
            'nama.max' => 'Nama Kategori Maksimal Memiliki 100 Karakter!',
        ];
        $validation = Validator::make($request->all(), [
            'nama' => [
                'required',
                'string',
                'max:100'
            ],
        ], $messages);
        
        if($validation->fails()){
            $response = [
                'status' => 400,
                'success' => false,
                'message' => $validation->errors()
            ];

            return response()->json($response, 400);
        }

        $kategori =  new KategoriModel();
        $dataKategoriByKode = $kategori->findKategori($request->kode);
        if($dataKategoriByKode == null){
            $message = "Data Kategori Tidak Ditemukan atau Sudah Terhapus!";

            $response = [
                'status' => 200,
                'success'=> true,
                'message'=> $message,
            ];
            return response()->json($response, 200);
        }else{
            if(strtoupper($request->nama_hid) == strtoupper($request->nama)){
                $kategori->updateData($request->kode,strtoupper($request->nama));
                $message = "Data Berhasil Diubah!";

                $response = [
                    'status' => 200,
                    'success'=> true,
                    'message'=> $message,
                ];
                return response()->json($response, 200);
            }else if(strtoupper($request->nama_hid) != strtoupper($request->nama)) {
                $dataKategoriFindMatch = $kategori->findNamaWithTrashed(strtoupper($request->nama));
                $dataNamaKategori = "";
                foreach ($dataKategoriFindMatch as $value) {
                    $dataNamaKategori =$value->nama_kategori;
                }
                if($dataNamaKategori != ""){
                    $message = "Nama Kategori Sudah Dipakai!";
                }else {
                    $kategori->updateData($request->kode,strtoupper($request->nama));
                    $message = "Data Berhasil Diubah!";
                }
                $response = [
                    'status' => 200,
                    'success'=> true,
                    'message'=> $message,
                ];
                return response()->json($response, 200);
            }
        }
    }

    public function deleteKategori(Request $request)
    {
        $kategori = new KategoriModel();
        $dataKategoriByKode = $kategori->findKategoriWithTrashed($request->kode);
        $dataDeleted_at = $dataKategoriByKode->deleted_at;
        if($dataDeleted_at == null){
            $kategori->deleteData($request->kode);
            $message = "Data Kategori Berhasil Terhapus!";
        }
        else if($dataDeleted_at != null){
            $kategori->restoreData($request->kode);
            $message = "Data Kategori Berhasil Di Restore!";
        }

        $response = [
            'status' => 200,
            'success'=> true,
            'message'=> $message,
            'data' => $dataKategoriByKode
        ];
        return response()->json($response, 200);
    }

    public function getDataSatuan()
    {
        $satuan = new SatuanModel();
        $dataSatuan = $satuan->getAllSatuan();

        return SatuanResource::collection($dataSatuan);
    }

    public function getDataSatuanForSelect()
    {
        $satuan = new SatuanModel();
        $dataSatuan = $satuan->getAllSatuanWithoutTrashed();

        return SatuanResource::collection($dataSatuan);
    }

    public function insertSatuan(Request $request)
    {
        $messages = [
            'kode_satuan.required' => 'Kode Satuan Tidak Boleh Kosong!',
            'kode_satuan.string' => 'Format Kode Satuan Hanya Boleh Huruf',
            'kode_satuan.max' => 'Maximal Panjang Karakter Kode adalah 7 Karakter',
            'faktor.required' => 'Faktor Tidak Boleh Kosong!',
            'faktor.numeric' => 'Faktor Berupa Angka!',
        ];
        $validation = Validator::make($request->all(), [
            'kode_satuan' => [
                'required',
                'string',
                'max:7', 
                new kodeSatuanChecker()
            ],
            'faktor' => [
                'required',
                'numeric',
            ],
        ], $messages);
        
        if($validation->fails()){
            $response = [
                'status' => 400,
                'success' => false,
                'message' => $validation->errors()
            ];

            return response()->json($response, 400);
        }

        $satuan = new SatuanModel();
        $satuan->insertData(strtoupper($request->kode_satuan),$request->faktor);
        $message = "Data Berhasil Ditambahkan!";

        $response = [
            'status' => 200,
            'success'=> true,
            'message'=> $message,
        ];
        return response()->json($response, 200);
    }

    public function updateSatuan(Request $request)
    {
        $messages = [
            'faktor.required' => 'Faktor Tidak Boleh Kosong!',
            'faktor.numeric' => 'Faktor Berupa Angka!',
        ];
        $validation = Validator::make($request->all(), [
            'faktor' => [
                'required',
                'numeric',
            ],
        ], $messages);
        
        if($validation->fails()){
            $response = [
                'status' => 400,
                'success' => false,
                'message' => $validation->errors()
            ];

            return response()->json($response, 400);
        }

        $satuan =  new SatuanModel();
        $dataMemberByKode = $satuan->findSatuan($request->kode_satuan);
        if($dataMemberByKode == null){
            $message = "Data Member Tidak Ditemukan atau Sudah Terhapus!";
        }else{
            $satuan->updateData($request->kode_satuan,$request->faktor);
            $message = "Data Berhasil Diubah!";
        }
        
        $response = [
            'status' => 200,
            'success'=> true,
            'message'=> $message,
        ];
        return response()->json($response, 200);
    }

    public function deleteSatuan(Request $request)
    {
        $satuan = new SatuanModel();
        $dataSatuanByKode = $satuan->findSatuanWithTrashed($request->kode_satuan);
        $dataDeleted_at = $dataSatuanByKode->deleted_at;
        if($dataDeleted_at == null){
            $satuan->deleteData($request->kode_satuan);
            $message = "Data Kategori Berhasil Terhapus!";
        }
        else if($dataDeleted_at != null){
            $satuan->restoreData($request->kode_satuan);
            $message = "Data Kategori Berhasil Di Restore!";
        }

        $response = [
            'status' => 200,
            'success'=> true,
            'message'=> $message,
            'data' => $dataSatuanByKode
        ];
        return response()->json($response, 200);
    }

    public function getDataBarang()
    {
        $barang = new BarangModel();
        $dataBarang= $barang->getAllBarang();

        return BarangResource::collection($dataBarang);
    }

    public function insertBarang(Request $request)
    {
        $messages = [
            'kode_barang.required' => 'Kode Barang Tidak Boleh Kosong!',
            'kode_barang.max' => 'Maximal Panjang Karakter Kode adalah 30 Karakter',
            'barcode.max' => 'Maximal Panjang Karakter Barcode adalah 255 Karakter',
            'nama_barang.required' => 'Nama Barang Tidak Boleh Kosong!',
            'nama_barang.max' => 'Maximal Panjang Karakter Nama Barang adalah 150 Karakter',
            'kategori_barang.required' => 'Kategori Tidak Boleh Kosong!',
            'satuan.required' => 'Satuan Tidak Boleh Kosong!',
            'harga_grosir.required' => 'Harga Grosir Tidak Boleh Kosong!',
            'harga_grosir.numeric' => 'Harga Grosir Harus Berupa Angka!',
            'harga_grosir.max_digits' => 'Harga Grosir Maksimal 8 Digit Angka!',
            'harga_eceran.required' => 'Harga Eceran Tidak Boleh Kosong!',
            'harga_eceran.numeric' => 'Harga Eceran Harus Berupa Angka!',
            'harga_eceran.max_digits' => 'Harga Eceran Maksimal 8 Digit Angka!',
            'harga_khusus.numeric' => 'Harga Khusus Harus Berupa Angka!',
            'harga_khusus.max_digits' => 'Harga Khusus Maksimal 8 Digit Angka!',
            'deskripsi.max' => 'Maximal Panjang Karakter Deskripsi adalah 255 Karakter'
        ];
        $validation = Validator::make($request->all(), [
            'kode_barang' => [
                'required',
                'max:30', 
                new kodeBarangChecker()
            ],
            'barcode' => 'nullable|max:255',
            'nama_barang' => 'required|max:150',
            'kategori_barang' => 'required',
            'satuan' => 'required',
            'harga_grosir' => 'required|numeric|max_digits:8',
            'harga_eceran' => 'required|numeric|max_digits:8',
            'harga_khusus' => 'nullable|numeric|max_digits:8',
            'deskripsi' => 'nullable|max:255',
        ], $messages);
        
        if($validation->fails()){
            $response = [
                'status' => 400,
                'success' => false,
                'message' => $validation->errors()
            ];

            return response()->json($response, 400);
        }

        $barang = new BarangModel();
        $kategori = new KategoriModel();
        $barang->insertData(strtoupper($request->kode_barang),$request->barcode,strtoupper($request->nama_barang),$request->kategori_barang,
                                $request->satuan, $request->harga_grosir, $request->harga_eceran, $request->harga_khusus, $request->deskripsi);
        $kategori->updateJumlahBarang($request->kategori_barang,1);
        $message = "Data Berhasil Ditambahkan!";

        $response = [
            'status' => 200,
            'success'=> true,
            'message'=> $message,
            'data' => [
                'kode' => $request->kode_barang,
                'barcode' => $request->barcode,
                'nama_barang' => $request->nama_barang,
                'kategori' => $request->kategori_barang,
                'satuan' => $request->satuan,
                'harga_grosir' => $request->harga_grosir,
                'harga_eceran' => $request->harga_eceran,
                'harga_khusus' => $request->harga_khusus,
                'deskripsi' => $request->deskripsi
            ]
        ];
        return response()->json($response, 200);
    }

    public function updateBarang(Request $request)
    {
        $messages = [
            'barcode.max' => 'Maximal Panjang Karakter Barcode adalah 255 Karakter',
            'nama_barang.required' => 'Nama Barang Tidak Boleh Kosong!',
            'nama_barang.max' => 'Maximal Panjang Karakter Nama Barang adalah 150 Karakter',
            'kategori_barang.required' => 'Kategori Tidak Boleh Kosong!',
            'satuan.required' => 'Satuan Tidak Boleh Kosong!',
            'harga_grosir.required' => 'Harga Grosir Tidak Boleh Kosong!',
            'harga_grosir.numeric' => 'Harga Grosir Harus Berupa Angka!',
            'harga_grosir.max_digits' => 'Harga Grosir Maksimal 8 Digit Angka!',
            'harga_eceran.required' => 'Harga Eceran Tidak Boleh Kosong!',
            'harga_eceran.numeric' => 'Harga Eceran Harus Berupa Angka!',
            'harga_eceran.max_digits' => 'Harga Eceran Maksimal 8 Digit Angka!',
            'harga_khusus.numeric' => 'Harga Khusus Harus Berupa Angka!',
            'harga_khusus.max_digits' => 'Harga Khusus Maksimal 8 Digit Angka!',
            'deskripsi.max' => 'Maximal Panjang Karakter Deskripsi adalah 255 Karakter'
        ];
        $validation = Validator::make($request->all(), [
            'barcode' => 'nullable|max:255',
            'nama_barang' => 'required|max:150',
            'kategori_barang' => 'required',
            'satuan' => 'required',
            'harga_grosir' => 'required|numeric|max_digits:8',
            'harga_eceran' => 'required|numeric|max_digits:8',
            'harga_khusus' => 'nullable|numeric|max_digits:8',
            'deskripsi' => 'nullable|max:255',
        ], $messages);
        
        if($validation->fails()){
            $response = [
                'status' => 400,
                'success' => false,
                'message' => $validation->errors()
            ];

            return response()->json($response, 400);
        }

        $barang =  new BarangModel();
        $kategori = new KategoriModel();
        $dataBarangByKode = $barang->findBarang($request->kode_barang);
        if($dataBarangByKode == null){
            $message = "Data Barang Tidak Ditemukan atau Sudah Terhapus!";
        }else{
            if($dataBarangByKode->kategori == $request->kategori_barang){
                $barang->updateData($request->kode_barang,$request->barcode,strtoupper($request->nama_barang),$request->kategori_barang,
                                    $request->satuan, $request->harga_grosir, $request->harga_eceran, $request->harga_khusus, $request->deskripsi);
                $message = "Data Berhasil Diubah!";
            }else if($dataBarangByKode->kategori != $request->kategori_barang){
                $kategori->updateJumlahBarangKurang($dataBarangByKode->kategori,1);
                $kategori->updateJumlahBarang($request->kategori_barang,1);
                $barang->updateData($request->kode_barang,$request->barcode,strtoupper($request->nama_barang),$request->kategori_barang,
                                    $request->satuan, $request->harga_grosir, $request->harga_eceran, $request->harga_khusus, $request->deskripsi);
                $message = "Data Berhasil Diubah!";
            }
        }

        $response = [
            'status' => 200,
            'success'=> true,
            'message'=> $message,
            'data' => [
                'kode' => $request->kode_barang,
                'barcode' => $request->barcode,
                'nama_barang' => $request->nama_barang,
                'kategori' => $request->kategori_barang,
                'satuan' => $request->satuan,
                'harga_grosir' => $request->harga_grosir,
                'harga_eceran' => $request->harga_eceran,
                'harga_khusus' => $request->harga_khusus,
                'deskripsi' => $request->deskripsi
            ]
        ];
        return response()->json($response, 200);
    }

    public function deleteBarang(Request $request)
    {
        $barang = new BarangModel();
        $dataBarangByKode = $barang->findBarangWithTrashed($request->kode);
        $dataDeleted_at = $dataBarangByKode->deleted_at;
        if($dataDeleted_at == null){
            $barang->deleteData($request->kode);
            $message = "Data Kategori Berhasil Terhapus!";
        }
        else if($dataDeleted_at != null){
            $barang->restoreData($request->kode);
            $message = "Data Kategori Berhasil Di Restore!";
        }

        $response = [
            'status' => 200,
            'success'=> true,
            'message'=> $message,
            'data' => $dataBarangByKode
        ];
        return response()->json($response, 200);
    }

    public function getDataStok()
    {
        $barang = new BarangModel();
        $dataStok= $barang->getDataStokForChange();

        return StokResource::collection($dataStok);
    }

    public function getDataStokFor()
    {
        $barang = new BarangModel();
        $dataStok= $barang->getDataStokForChangeNotPaginate();

        return StokResource::collection($dataStok);
    }

    public function getDataStokForCatatan()
    {
        $stoklogHistory = new StokLogModel();
        $dataLogStok = $stoklogHistory->getAllData();

        return StokLogResource::collection($dataLogStok);
    }

    public function insertStok(Request $request)
    {
        $messages = [
            'kode.required' => 'Kode Barang Tidak Boleh Kosong!',
            'kode.max' => 'Maximal Panjang Karakter Kode adalah 30 Karakter',
            'stok.required' => 'Stock Tidak Boleh Kosong!',
            'stok.numeric' => 'Stock Harus Berupa Angka!',
            'pilihan.required' => 'Pilih Tambah Atau Ubah Stok Barang!',
        ];
        $validation = Validator::make($request->all(), [
            'kode' => [
                'required',
                'max:30', 
                new kodeBarangStokChecker()
            ],
            'stok' => [
                'required',
                'numeric',
            ],
            'pilihan' => 'required'
        ], $messages);
        
        if($validation->fails()){
            $response = [
                'status' => 400,
                'success' => false,
                'message' => $validation->errors()
            ];

            return response()->json($response, 400);
        }

        $dataStokLama = 0;
        $dataStokBaru = 0;
        $stok = new BarangModel();
        $logStok = new StokLogModel();
        $dataStokBarang = $stok->findBarang($request->kode);
        $dataStokLama = $dataStokBarang->stock;
        if(strtolower($request->pilihan) == "tambah"){
            $dataStokBaru = $dataStokLama + $request->stok;
        }else if(strtolower($request->pilihan) == "ubah"){
            $dataStokBaru = $request->stok;
        }

        $stok->updateDataStok($request->kode,$dataStokBaru);
        $logStok->insertData($request->kode, $request->id, $dataStokLama, $dataStokBaru);
        $message = "Data Stok Sudah Berhasil Diubah!";

        $response = [
            'status' => 200,
            'success'=> true,
            'message'=> $message,
            'data' => [
                'id' => $request->id,
                'kode' => $request->kode,
                'stok' => $request->stok,
                'pilihan' => $request->pilihan,
                'stokLama' => $dataStokLama
            ]
        ];
        return response()->json($response, 200);
    }

    public function updateStok(Request $request)
    {
        $messages = [
            'stok.required' => 'Stock Tidak Boleh Kosong!',
            'stok.numeric' => 'Stock Harus Berupa Angka!',
            'pilihan.required' => 'Pilih Tambah Atau Ubah Stok Barang!',
        ];
        $validation = Validator::make($request->all(), [
            'stok' => [
                'required',
                'numeric',
            ],
            'pilihan' => 'required'
        ], $messages);
        
        if($validation->fails()){
            $response = [
                'status' => 400,
                'success' => false,
                'message' => $validation->errors()
            ];

            return response()->json($response, 400);
        }

        $dataStokLama = 0;
        $dataStokBaru = 0;
        $stok = new BarangModel();
        $logStok = new StokLogModel();
        $dataStokBarang = $stok->findBarang($request->kode);
        $dataStokLama = $dataStokBarang->stock;
        if(strtolower($request->pilihan) == "tambah"){
            $dataStokBaru = $dataStokLama + $request->stok;
        }else if(strtolower($request->pilihan) == "ubah"){
            $dataStokBaru = $request->stok;
        }

        $stok->updateDataStok($request->kode,$dataStokBaru);
        $logStok->insertData($request->kode, $request->id, $dataStokLama, $dataStokBaru);
        $message = "Data Stok Sudah Berhasil Diubah!";

        $response = [
            'status' => 200,
            'success'=> true,
            'message'=> $message,
            'data' => [
                'id' => $request->id,
                'kode' => $request->kode,
                'stok' => $request->stok,
                'pilihan' => $request->pilihan,
                'stokLama' => $dataStokLama
            ]
        ];
        return response()->json($response, 200);
    }

    public function getDataAllBarang(Request $request)
    {
        $barang = new BarangModel();
        if($request->value == null){
            $dataBarangAll= $barang->getAllBarang();
        }else{
            $dataBarangAll= $barang->getAllBarangWithoutPaginate($request->value);
        }
        $response = [
            'status' => 200,
            'success'=> true,
            'message'=> "data Masuk",
            'data' => $dataBarangAll
        ];
        return response()->json($response, 200);
    }

    public function getDataAllKategori(Request $request)
    {
        $kategori = new KategoriModel();
        if($request->value == null){
            $dataKategoriAll= $kategori->getAllKategori();
        }else{
            $dataKategoriAll= $kategori->getAllKategoriForSearch($request->value);
        }
        $response = [
            'status' => 200,
            'success'=> true,
            'message'=> "data Masuk",
            'data' => $dataKategoriAll
        ];
        return response()->json($response, 200);
    }

    public function getDataAllSatuan(Request $request)
    {
        $satuan = new SatuanModel();
        if($request->value == null){
            $dataSatuanAll= $satuan->getAllSatuan();
        }else{
            $dataSatuanAll= $satuan->getAllSatuanForSearch($request->value);
        }
        $response = [
            'status' => 200,
            'success'=> true,
            'message'=> "data Masuk",
            'data' => $dataSatuanAll
        ];
        return response()->json($response, 200);
    }

    public function getDataAllPegawai(Request $request)
    {
        $pegawai = new User();
        if($request->value == null){
            $dataPegawaiAll= $pegawai->getAllPegawai();
        }else{
            $dataPegawaiAll= $pegawai->getAllPegawaiForSearch($request->value);
        }
        $response = [
            'status' => 200,
            'success'=> true,
            'message'=> "data Masuk",
            'data' => $dataPegawaiAll
        ];
        return response()->json($response, 200);
    }

    public function getDataAllMember(Request $request)
    {
        $member = new MemberModel();
        if($request->value == null){
            $dataMemberAll= $member->getAllMember();
        }else{
            $dataMemberAll= $member->getAllMemberForSearch($request->value);
        }
        $response = [
            'status' => 200,
            'success'=> true,
            'message'=> "data Masuk",
            'data' => $dataMemberAll
        ];
        return response()->json($response, 200);
    }

    public function getDataAllPromo(Request $request)
    {
        $promo = new PromoModel();
        if($request->value == null){
            $dataPromoAll= $promo->getAllPromo();
        }else{
            $dataPromoAll= $promo->getAllPromoForSearch($request->value);
        }
        $response = [
            'status' => 200,
            'success'=> true,
            'message'=> "data Masuk",
            'data' => $dataPromoAll
        ];
        return response()->json($response, 200);
    }

    public function getDataAllStok(Request $request)
    {
        $barang = new BarangModel();
        if($request->value == null){
            $dataBarangAll= $barang->getDataStokForChange();
        }else{
            $dataBarangAll= $barang->getDataStokForSearch($request->value);
        }
        $response = [
            'status' => 200,
            'success'=> true,
            'message'=> "data Masuk",
            'data' => $dataBarangAll
        ];
        return response()->json($response, 200);
    }

    public function getDataAllStokLog(Request $request)
    {
        $stoklog = new StokLogModel();
        if($request->value == null){
            $dataStokLogAll= $stoklog->getAllData();
        }else{
            $dataStokLogAll= $stoklog->getAllDataForSearch($request->value);
        }
        $response = [
            'status' => 200,
            'success'=> true,
            'message'=> "data Masuk",
            'data' => $dataStokLogAll
        ];
        return response()->json($response, 200);
    }

    public function getAllDataHeaderTransaksi()
    {
        $header = new HeaderTransaksiModel();
        $dataHeader = $header->getAllDataHeaderTransaksi();

        return RiwayatTransaksiResource::collection($dataHeader);
    }
}
