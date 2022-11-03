<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Transaksi\BarangForTransaksiResource;
use App\Http\Resources\Transaksi\DetailTransaksiResource;
use App\Http\Resources\Transaksi\MemberForTransaksiResource;
use App\Http\Resources\Transaksi\PromoForTransaksiResource;
use App\Http\Resources\Transaksi\RiwayatTransaksiResource;
use App\Models\BarangModel;
use App\Models\DetailTransaksiModel;
use App\Models\HeaderTransaksiModel;
use App\Models\MemberModel;
use App\Models\PromoModel;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function getDataBarangForTransaksi()
    {
        $barang = new BarangModel();
        $dataBarangUntukPilih = $barang->getDataForTransaksiPilih();

        return BarangForTransaksiResource::collection($dataBarangUntukPilih);
    }

    public function getDataBarangBarcodeForTransaksi()
    {
        $barang = new BarangModel();
        $dataBarangUntukBarcode = $barang->getDataForTransaksiBarcode();

        return BarangForTransaksiResource::collection($dataBarangUntukBarcode);
    }

    public function getDataPromoForTransaksi()
    {
        $promo = new PromoModel();
        $dataPromoUntukTransaksi = $promo->getAllPromoForTransaksi();

        return PromoForTransaksiResource::collection($dataPromoUntukTransaksi);
    }

    public function getDataMemberForTransaksi()
    {
        $member = new MemberModel();
        $dataMemberUntukTransaksi = $member->getAllMemberForTransaksi();

        return MemberForTransaksiResource::collection($dataMemberUntukTransaksi);
    }
    
    public function insertTransaksi(Request $request)
    {
        if($request->total_qty == 0){
            $response = [
                'status' => 400,
                'success' => false,
                'message' => "Data Masih Kosong"
            ];

            return response()->json($response, 400);
        }else{
            $htrans = new HeaderTransaksiModel();
            $dtrans = new DetailTransaksiModel();
            $htrans->insertData($request->idPegawai,$request->kode_member,$request->kode_promo,$request->pajak,$request->total_qty,$request->total_trans,$request->tunai_trans,
            $request->kembalian_trans);
            $dataId = $htrans->getIdHtransLast();
            $dataNoOrder = $htrans->getLengthTrans();

            for ($i=0; $i < sizeof($request->barang_trans); $i++) { 
                if($request->barang_trans[$i]['kode'] != null){
                    $dtrans->insertData($dataId->id_htrans, $request->barang_trans[$i]['kode'], $request->barang_trans[$i]['qty'], $request->barang_trans[$i]['nama'], 
                                        $request->barang_trans[$i]['satuan'], $request->barang_trans[$i]['harga'], $request->barang_trans[$i]['discount'], $request->barang_trans[$i]['jumlah']);
                }
            }
            $response = [
                'status' => 200,
                'success'=> true,
                'message'=> "Transaksi Berhasil!",
                'data' => [
                    'idHtransLast' => sizeof($dataNoOrder),
                ]
            ];            
            return response()->json($response, 200);
        }

    }

    public function getAllDataHeaderTransaksi()
    {
        $htrans = new HeaderTransaksiModel();
        $dataHeaderUntukTransaksi = $htrans->getAllHeaderTransaksi();

        return RiwayatTransaksiResource::collection($dataHeaderUntukTransaksi);
    }

    public function getAllDataDetailTransaksi(Request $request)
    {
        $detail = new DetailTransaksiModel();
        $dataDetailTransaksi = $detail->getAllDetailTransaksi($request->id);

        $response = [
            'status' => 200,
            'success'=> true,
            'message'=> "Transaksi Berhasil!",
            'data' => [
                'detail' => DetailTransaksiResource::collection($dataDetailTransaksi),
            ]
        ];            
        return response()->json($response, 200);
    }
}
