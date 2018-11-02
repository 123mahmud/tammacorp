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
        $data_real = $request->durasi_bulan_1.'-01';

        $pendapatan = DB::table('d_jurnal_dt')
                            ->join('d_jurnal', 'd_jurnal.jurnal_id', '=', 'd_jurnal_dt.jrdt_jurnal')
                            ->where('d_jurnal.tanggal_jurnal', '>=', $data_before)
                            ->where('d_jurnal.tanggal_jurnal', '<', $data_date)
                            ->whereIn('jrdt_acc', function($query){
                                $query->select('id_akun')
                                            ->from('d_akun')
                                            ->where('kelompok_akun', 'PENDAPATAN')
                                            ->where('type_akun', 'DETAIL')
                                            ->orWhere('kelompok_akun', 'PENDAPATAN LAIN LAIN')
                                            ->where('type_akun', 'DETAIL')->get();
                            })->select(DB::raw('coalesce(sum(jrdt_value), 0) as pendapatan'))->first();

        $beban = DB::table('d_jurnal_dt')
                            ->join('d_jurnal', 'd_jurnal.jurnal_id', '=', 'd_jurnal_dt.jrdt_jurnal')
                            ->where('d_jurnal.tanggal_jurnal', '>=', $data_before)
                            ->where('d_jurnal.tanggal_jurnal', '<', $data_date)
                            ->whereIn('jrdt_acc', function($query){
                                $query->select('id_akun')
                                            ->from('d_akun')
                                            ->where('kelompok_akun', 'POTONGAN PENJUALAN')
                                            ->where('type_akun', 'DETAIL')
                                            ->orWhere('kelompok_akun', 'BEBAN POKOK PENJUALAN')
                                            ->where('type_akun', 'DETAIL')
                                            ->orWhere('kelompok_akun', 'BEBAN PRODUKSI')
                                            ->where('type_akun', 'DETAIL')
                                            ->orWhere('kelompok_akun', 'BEBAN PERALATAN PRODUKSI')
                                            ->where('type_akun', 'DETAIL')
                                            ->orWhere('kelompok_akun', 'BEBAN POKOK LAIN LAIN')
                                            ->where('type_akun', 'DETAIL')
                                            ->orWhere('kelompok_akun', 'SELISIH SALDO PERSEDIAAN BARANG')
                                            ->where('type_akun', 'DETAIL')
                                            ->orWhere(DB::raw('substring(id_akun, 1, 1)'), "6")
                                            ->where('type_akun', 'DETAIL')
                                            ->orWhere(DB::raw('substring(id_akun, 1, 3)'), "800")
                                            ->where('type_akun', 'DETAIL')->get();
                            })->select(DB::raw('coalesce(sum(jrdt_value), 0) as beban'))->first();

    		$data = group_akun::select('*')
    			->where('type_group', 'neraca')
    			->with(['akun_neraca' => function($query) use ($data_date){
    				$query->where('type_akun', 'DETAIL')
    						->select('id_akun', 'group_neraca', 'nama_akun', 'opening_date', 'opening_balance', 'posisi_akun')->with([
                                      'mutasi_bank_debet' => function($query) use ($data_date){
                                            $query->join('d_jurnal', 'd_jurnal.jurnal_id', '=', 'jrdt_jurnal')
                                                  ->join('d_akun', 'id_akun', '=', 'jrdt_acc')
                                                  ->where('tanggal_jurnal', '<', $data_date)
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

          return 

          $saldo_laba = $pendapatan->pendapatan - $beban->beban;
    	}

    	// return json_encode($data);
    	return view('keuangan.laporan_keuangan.neraca.index', compact('request', 'data_real', 'data_date', 'data', 'saldo_laba'));
    }
}
