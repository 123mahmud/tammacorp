<?php

namespace App\Http\Controllers\keuangan\laporan_keuangan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Keuangan\d_akun as akun;

use DB;

class laporan_buku_besar_controller extends Controller
{
    public function index(Request $request){

    	// return json_encode($request->all());

    	$data_akun = DB::table('d_akun')->where('type_akun', 'DETAIL')->select('id_akun', 'nama_akun')->orderBy('id_akun', 'asc')->get();

    	$data = [];

    	$d1 = date_format(date_create($request->durasi_1_buku_besar_bulan), "n"); $y1 = date_format(date_create($request->durasi_1_buku_besar_bulan), "Y");
      
      $d2 = date_format(date_create($request->durasi_2_buku_besar_bulan), "n"); $y2 = date_format(date_create($request->durasi_2_buku_besar_bulan), "Y");

      $data_date = date_format(date_create($request->durasi_1_buku_besar_bulan), "Y-m").'-01';

        $data_saldo = akun::select('id_akun', 'nama_akun', 'posisi_akun', DB::raw('coalesce(opening_balance, 0) as total'), 'opening_date')
                                ->orderBy('id_akun', 'asc')->with([
                                      'mutasi_bank_debet' => function($query) use ($data_date){
                                            $query->join('d_jurnal', 'd_jurnal.jurnal_id', '=', 'jrdt_jurnal')
                                                  ->join('d_akun', 'id_akun', '=', 'jrdt_acc')
                                                  ->where('tanggal_jurnal', '<', $data_date)
                                                  ->where('tanggal_jurnal', '>', DB::raw("opening_date"))
                                                  ->where("jrdt_dk", 'D')
                                                  ->groupBy('jrdt_acc', 'opening_date')
                                                  ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'), 'opening_date');
                                      },
                                      'mutasi_bank_kredit' => function($query) use ($data_date){
                                            $query->join('d_jurnal', 'd_jurnal.jurnal_id', '=', 'jrdt_jurnal')
                                                  ->join('d_akun', 'id_akun', '=', 'jrdt_acc')
                                                  ->where('tanggal_jurnal', '<', $data_date)
                                                  ->where('tanggal_jurnal', '>', DB::raw("opening_date"))
                                                  ->where("jrdt_dk", 'K')
                                                  ->groupBy('jrdt_acc', 'opening_date')
                                                  ->select('jrdt_acc', DB::raw('sum(jrdt_value) as total'), 'opening_date');
                                      },
                                ])
                                ->whereBetween('d_akun.id_akun', [$request->akun_1, $request->akun_2])
                            	  ->where('d_akun.type_akun', 'DETAIL')
                                ->orderBy('id_akun', 'asc')->get();

        $data = akun::with(['jurnal_detail' => function($query) use ($d1, $d2, $y1, $y2){
                                $query->select('jrdt_acc', 'jrdt_jurnal', 'tanggal_jurnal', 'jrdt_value', 'jrdt_dk')
                                        ->join('d_jurnal', 'jurnal_id', '=', 'jrdt_jurnal')
                                        ->with(['jurnal' => function($query) use ($d1, $d2, $y1, $y2){
                                            $query->select('jurnal_id', 'keterangan', 'tanggal_jurnal', 'jurnal_ref', 'no_jurnal')->with('detail');
                                        }])->whereHas('jurnal', function($query) use ($d1, $d2, $y1, $y2){
                                            $query->whereBetween(DB::raw("month(tanggal_jurnal)"), [$d1, $d2])
                                                    ->whereBetween(DB::raw("year(tanggal_jurnal)"), [$y1, $y2]);
                                        })->orderBy('tanggal_jurnal');
                            }])
                            ->whereBetween('d_akun.id_akun', [$request->akun_1, $request->akun_2])
                            ->where('d_akun.type_akun', 'DETAIL')
                            ->select('id_akun', 'nama_akun')
                            ->orderBy('id_akun', 'asc')->get();

        // return json_encode($d1);

    	return view('keuangan.laporan_keuangan.buku_besar.index', compact('data_akun', 'request', 'data', 'data_saldo', 'data_date'));
    }
}
