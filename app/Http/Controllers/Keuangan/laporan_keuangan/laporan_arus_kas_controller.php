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
    		$data_date = explode('-', $request->durasi_1_arus_kas_bulan)[0].'-'.(explode('-', $request->durasi_1_arus_kas_bulan)[1] + 1).'-01';
    		$data_real = $request->durasi_1_arus_kas_bulan.'-01';

    		// return $data_date;

    		$jurnal = DB::table('d_jurnal_dt')
    					->where(DB::raw('substring(jrdt_acc,1,3)'), '100')
    					->orWhere(DB::raw('substring(jrdt_acc,1,3)'), '101')
    					->select(DB::raw('distinct(jrdt_jurnal)'))->get();

    		// return json_encode($jurnal);

    		$data = group_akun::select('*')
    			->where('type_group', 'neraca')
    			->with(['akun_neraca' => function($query) use ($data_date, $data_real){
    				$query->where('type_akun', 'DETAIL')
    						->select('id_akun', 'group_neraca', 'nama_akun', 'opening_date', 'opening_balance', 'posisi_akun')->with([
                                      'mutasi_bank_debet' => function($query) use ($data_date, $data_real){
                                            $query->join('d_jurnal', 'd_jurnal.jurnal_id', '=', 'jrdt_jurnal')
                                                  ->join('d_akun', 'id_akun', '=', 'jrdt_acc')
                                                  ->where('tanggal_jurnal', '<', $data_date)
                                                  ->where('tanggal_jurnal', '>=', $data_real)
                                                  ->where('tanggal_jurnal', '>', DB::raw("opening_date"))
                                                  ->whereIn('d_jurnal_dt.jrdt_jurnal', function($query){
                                                  	$query->select(DB::raw('distinct(jrdt_jurnal)'))
                                                  				->from('d_jurnal_dt')
										    					->where(DB::raw('substring(jrdt_acc,1,3)'), '100')
										    					->orWhere(DB::raw('substring(jrdt_acc,1,3)'), '101')->get();
                                                  })
                                                  ->groupBy('jrdt_acc', 'opening_date')
                                                  ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'));
                                      }
                                ])
    						->get();
    			}])
    			->select('id_group', 'nama_group', 'no_group')
    			->orderBy('id_group', 'asc')
    			->get();
    	}

    	// return json_encode($data);
    	return view('keuangan.laporan_keuangan.arus_kas.index', compact('request', 'data_real', 'data_date', 'data'));
    }
}
