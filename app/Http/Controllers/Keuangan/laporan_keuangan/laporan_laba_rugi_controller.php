<?php

namespace App\Http\Controllers\Keuangan\laporan_keuangan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Keuangan\d_akun as akun;
use App\Model\Keuangan\d_group_akun as group_akun;
use DB;

class laporan_laba_rugi_controller extends Controller
{
    public function index(Request $request){

    	// return json_encode($request->all());

    	if($request->jenis == "bulan"){
    		$data_date = explode('-', $request->durasi_1_laba_rugi_bulan)[0].'-'.(explode('-', $request->durasi_1_laba_rugi_bulan)[1] + 1).'-01';
    		$data_real = $request->durasi_1_laba_rugi_bulan.'-01';

    		// return $data_date;

    		$data = group_akun::select('*')
    			->where('type_group', 'laba/rugi')
    			->with(['akun_laba_rugi' => function($query) use ($data_date, $data_real){
    				$query->where('type_akun', 'DETAIL')
    						->select(
                            'd_akun.id_akun',
                            'd_akun.group_laba_rugi',
                            'd_akun.nama_akun',
                            'd_akun.opening_date',
                            'd_akun.opening_balance',
                            'd_akun.posisi_akun',
                            DB::raw('coalesce(d_akun_saldo.saldo_akhir) as saldo')
                        )
                ->leftJoin('d_akun_saldo', 'd_akun_saldo.id_akun', '=', 'd_akun.id_akun')
                ->where('d_akun_saldo.periode', $data_real)
                ->get();
    			}])
    			->select('id_group', 'nama_group', 'no_group')
    			->orderBy('id_group', 'asc')
    			->get();
    	}

    	// return json_encode($data);
    	return view('keuangan.laporan_keuangan.laba_rugi.index', compact('request', 'data_real', 'data_date', 'data'));
    }
}
