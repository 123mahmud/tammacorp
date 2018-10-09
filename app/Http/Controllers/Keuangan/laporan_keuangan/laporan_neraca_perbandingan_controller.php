<?php

namespace App\Http\Controllers\keuangan\laporan_keuangan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Keuangan\d_akun as akun;
use App\Model\Keuangan\d_group_akun as group_akun;
use DB;

class laporan_neraca_perbandingan_controller extends Controller
{
    public function index(Request $request){

    	if($request->jenis == "bulan"){
    		$data_date_1 = explode('-', $request->durasi_bulan_2)[0].'-'.(explode('-', $request->durasi_bulan_2)[1] + 1).'-01';
    		$data_real_1 = $request->durasi_bulan_2.'-01';

    		$data_date_2 = explode('-', $request->durasi_bulan_1)[0].'-'.(explode('-', $request->durasi_bulan_1)[1] + 1).'-01';
    		$data_real_2 = $request->durasi_bulan_1.'-01';

    		// return $data_date;

    		$data = group_akun::select('*')
    			->where('type_group', 'neraca')
    			->with(['akun_neraca' => function($query) use ($data_date_1){
    				$query->where('type_akun', 'DETAIL')
    						->select('id_akun', 'group_neraca', 'nama_akun', 'opening_date', 'opening_balance', 'posisi_akun')->with([
                                      'mutasi_bank_debet' => function($query) use ($data_date_1){
                                            $query->join('d_jurnal', 'd_jurnal.jurnal_id', '=', 'jrdt_jurnal')
                                                  ->join('d_akun', 'id_akun', '=', 'jrdt_acc')
                                                  ->where('tanggal_jurnal', '<', $data_date_1)
                                                  ->where('tanggal_jurnal', '>', DB::raw("opening_date"))
                                                  ->groupBy('jrdt_acc', 'opening_date')
                                                  ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'));
                                      }
                                ])
    						->get();
    			}])
    			->select('id_group', 'nama_group', 'no_group')
    			->orderBy('id_group', 'asc')
    			->get();

    		$data_2 = group_akun::select('*')
    			->where('type_group', 'neraca')
    			->with(['akun_neraca' => function($query) use ($data_date_2){
    				$query->where('type_akun', 'DETAIL')
    						->select('id_akun', 'group_neraca', 'nama_akun', 'opening_date', 'opening_balance', 'posisi_akun')->with([
                                      'mutasi_bank_debet' => function($query) use ($data_date_2){
                                            $query->join('d_jurnal', 'd_jurnal.jurnal_id', '=', 'jrdt_jurnal')
                                                  ->join('d_akun', 'id_akun', '=', 'jrdt_acc')
                                                  ->where('tanggal_jurnal', '<', $data_date_2)
                                                  ->where('tanggal_jurnal', '>', DB::raw("opening_date"))
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
    	return view('keuangan.laporan_keuangan.neraca_perbandingan.index', compact('request', 'data_real_1', 'data_date_1', 'data_real_2', 'data_date_2', 'data', 'data_2'));

    }
}
