<?php

namespace App\Http\Controllers\keuangan\laporan_keuangan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Keuangan\d_akun as akun;
use App\Model\Keuangan\d_group_akun as group_akun;
use DB;

class laporan_arus_kas_controller extends Controller
{
    public function index(Request $request){
    	// return json_encode($request->all());

    	if($request->jenis == "bulan"){

        $durasi        = $request->durasi_1_arus_kas_bulan."-01";
        $durasi_before = date('Y-m-d', strtotime('-1 months', strtotime($durasi)));
        $durasi_end    = date('Y-m-d', strtotime('+1 months', strtotime($durasi)));

        // return json_encode($durasi_before." -> ".$durasi." s/d ".$durasi_end);

        $tipeTransaksi = DB::table('dk_transaksi_cashflow')->select('tc_id', 'tc_name', 'tc_cashflow')->get();
        $detail = DB::table('d_jurnal_dt')
                      ->join('d_jurnal', 'd_jurnal.jurnal_id', '=', 'd_jurnal_dt.jrdt_jurnal')
                      ->join('d_akun', 'd_jurnal_dt.jrdt_acc', '=', 'd_akun.id_akun')
                      ->whereNotNull('jrdt_cashflow')
                      ->where('d_jurnal.tanggal_jurnal', '>=', $durasi)
                      ->where('d_jurnal.tanggal_jurnal', '<', $durasi_end)
                      ->select('d_jurnal_dt.*', 'd_jurnal.tanggal_jurnal', 'd_akun.posisi_akun')
                      ->get();

        // return json_encode($tipeTransaksi);
    	}

    	// return json_encode($detail);
    	return view('keuangan.laporan_keuangan.arus_kas.index', compact('request', 'durasi', 'detail', 'tipeTransaksi'));
    }
}
