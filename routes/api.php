<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MasterController;
use App\Http\Controllers\API\TransaksiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->prefix('v1/auth/')->group(function(){
    Route::post('register','register');
    Route::post('login','login');
});

Route::controller(MasterController::class)->prefix('v1/master/')->group(function(){
    Route::get('pegawai','getDataPegawai');
    Route::get('promo','getDataPromo');
    Route::get('member','getDataMember');
    Route::get('kategori','getDataKategori');
    Route::get('satuan','getDataSatuan');
    Route::get('barang','getDataBarang');
    Route::get('headertrans','getAllDataHeaderTransaksi');
    Route::post('barangsearch','getDataAllBarang');
    Route::post('kategorisearch','getDataAllKategori');
    Route::post('satuansearch','getDataAllSatuan');
    Route::post('pegawaisearch','getDataAllPegawai');
    Route::post('membersearch','getDataAllMember');
    Route::post('promosearch','getDataAllPromo');
    Route::post('stoksearch','getDataAllStok');
    Route::post('stoklogsearch','getDataAllStokLog');
    Route::get('stok','getDataStok');
    Route::get('stokdashboard','getDataStokFor');
    Route::get('catatanstok','getDataStokForCatatan');
    Route::get('kategoriselect','getDataKategoriForSelect');
    Route::get('satuanselect','getDataSatuanForSelect');
    Route::post('jabatanPegawai','addJabatan');
    Route::post('addCuti','addCutiPegawai');
    Route::post('deleteCuti','deleteCutiPegawai');
    Route::post('deletePegawai','deletePegawai');
    Route::post('insertpromo','insertPromo');
    Route::post('updatepromo','updatePromo');
    Route::post('deletepromo','deletePromo');
    Route::post('insertmember','insertMember');
    Route::post('updatemember','updateMember');
    Route::post('deletemember','deleteMember');
    Route::post('insertkategori','insertKategori');
    Route::post('updatekategori','updateKategori');
    Route::post('deletekategori','deleteKategori');
    Route::post('insertsatuan','insertSatuan');
    Route::post('updatesatuan','updateSatuan');
    Route::post('deletesatuan','deleteSatuan');
    Route::post('insertbarang','insertBarang');
    Route::post('updatebarang','updateBarang');
    Route::post('deletebarang','deleteBarang');
    Route::post('insertstok','insertStok');
    Route::post('updatestok','updateStok');
});

Route::controller(TransaksiController::class)->prefix('v1/transaksi/')->group(function(){
    Route::get('barangtransaksi','getDataBarangForTransaksi');
    Route::get('barangbarcode','getDataBarangBarcodeForTransaksi');
    Route::get('promotransaksi','getDataPromoForTransaksi');
    Route::get('membertransaksi','getDataMemberForTransaksi');
    Route::get('datariwayat','getAllDataHeaderTransaksi');
    Route::post('datadetailriwayat','getAllDataDetailTransaksi');
    Route::post('inserttransaksi','insertTransaksi');
});

