<?php

namespace App\Http\Controllers\Keuangan\laporan_keuangan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Keuangan\d_akun as akun;

use DB;

class laporan_neraca_saldo_controller extends Controller
{
    public function index(Request $request){
    	// return json_encode($request->all());

      	$data_date = $request->durasi_1_neraca_saldo_bulan.'-01'; 

        $data = akun::where('type_akun', 'detail')
                        ->leftJoin('d_akun_saldo', 'd_akun_saldo.id_akun', '=', 'd_akun.id_akun')
                        ->where('d_akun_saldo.periode', $data_date)
                        ->select(
                                  'd_akun.id_akun',
                                  'd_akun.nama_akun',
                                  DB::raw('coalesce(d_akun_saldo.saldo_awal, 0) as saldo_awal'),
                                  DB::raw('coalesce(d_akun_saldo.mutasi_kas_debet, 0) as mutasi_kas_debet'),
                                  DB::raw('coalesce(d_akun_saldo.mutasi_kas_kredit, 0) as mutasi_kas_kredit'),
                                  DB::raw('coalesce(d_akun_saldo.mutasi_bank_debet, 0) as mutasi_bank_debet'),
                                  DB::raw('coalesce(d_akun_saldo.mutasi_bank_kredit, 0) as mutasi_bank_kredit'),
                                  DB::raw('coalesce(d_akun_saldo.mutasi_memorial_debet, 0) as mutasi_memorial_debet'),
                                  DB::raw('coalesce(d_akun_saldo.mutasi_memorial_kredit, 0) as mutasi_memorial_kredit'),
                                  DB::raw('coalesce(d_akun_saldo.saldo_akhir, 0) as saldo_akhir')
                                )
                        ->orderBy('d_akun.id_akun')
                        ->get();

        // return json_encode($data);

        // return json_encode($data_saldo);

    	return view('keuangan.laporan_keuangan.neraca_saldo.index', compact('request', 'data_saldo', 'data_date', 'data'));
    }
}
