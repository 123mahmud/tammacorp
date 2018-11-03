<?php

namespace App\Http\Controllers\Keuangan\laporan_keuangan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Keuangan\d_akun as akun;
use App\Model\Keuangan\d_group_akun as group_akun;
use DB;

class laporan_neraca_controller extends Controller
{
    public function index(Request $request){

    	if($request->jenis == "bulan"){
    		$data_date = explode('-', $request->durasi_1_neraca_bulan)[0].'-'.(explode('-', $request->durasi_1_neraca_bulan)[1] + 1).'-01';

        	$data_before = date('Y-m-d', strtotime('-1 months', strtotime($data_date)));
            $data_real = $request->durasi_1_neraca_bulan.'-01';

        // return $data_real;

        $pendapatanAkm = 0;

        $pendapatan = group_akun::select('*')
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

            foreach ($pendapatan as $key => $value) {
                $nilai = count_laba_rugi($pendapatan, $value->id_group, 'pasiva', $data_real);
                $pendapatanAkm += $nilai;
            }

    		$data = group_akun::select('*')
    			->where('type_group', 'neraca')
    			->with(['akun_neraca' => function($query) use ($data_real){
    				$query->where('type_akun', 'DETAIL')
    						->select(
                                        'd_akun.id_akun',
                                        'd_akun.group_neraca',
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

          // return json_encode($beban); 

          $saldo_laba = $pendapatanAkm;
    	}

    	// return json_encode($data);
    	return view('keuangan.laporan_keuangan.neraca.index', compact('request', 'data_real', 'data_date', 'data', 'saldo_laba'));
    }
}
