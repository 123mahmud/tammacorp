<?php

namespace App\Http\Controllers\Keuangan\Transaksi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Keuangan\transaksi as transaksi;
use App\Model\Keuangan\d_jurnal as jurnal;
use App\Model\Keuangan\d_jurnal_dt as jurnal_dt;

use DB;

class transaksi_kas_controller extends Controller
{
    public function index(){
    	return view('keuangan.transaksi_kas.index');
    }

    public function form_resource(){
    	// return json_encode('granted');

    	$akun_perkiraan = DB::table('d_akun')->where(DB::raw('substring(id_akun,1,4)'), '1.00')->where('type_akun', 'DETAIL')->select('id_akun', 'nama_akun')->get();

    	$akun_lawan = DB::table('d_akun')->where(DB::raw('substring(id_akun,1,4)'), '!=', '1.00')->where(DB::raw('substring(id_akun,1,4)'), '!=', '1.01')->where('type_akun', 'DETAIL')->select('id_akun', 'nama_akun')->get();

    	$list_transaksi = transaksi::where(DB::raw('substring(no_bukti,1,3)'), 'BKM')->where(DB::raw('month(tanggal_transaksi)'), date('n'))->with('jurnal.detail')->get();

    	// return json_encode($list_transaksi);

    	return response()->json([
    		'akun_perkiraan'	=> $akun_perkiraan,
    		'akun_lawan'		=> $akun_lawan,
    		'list_transaksi'	=> $list_transaksi,
    	]);
    }

    public function save(Request $request){

    	// return json_encode($request->all());

    	if($request->jenis_transaksi == 'KM'){

    		$cek = transaksi::where(DB::raw('month(tanggal_transaksi)'), date('n', strtotime($request->tanggal_transaksi)))->where(DB::raw('substring(no_bukti, 1, 3)'), 'BKM')->orderBy('id_transaksi', 'desc')->first();

    		$next = ($cek) ? (int)substr($cek->no_bukti, -5) : 0;

    		$bukti = 'BKM-'.date('myd', strtotime($request->tanggal_transaksi)).str_pad(($next + 1), 5, '0', STR_PAD_LEFT);


    		transaksi::insert([
    			'no_bukti'			=> $bukti,
    			'tanggal_transaksi'	=> date('Y-m-d', strtotime($request->tanggal_transaksi)),
    			'nama_transaksi'	=> $request->nama_transaksi,
    			'keterangan'		=> $request->keterangan,
    			'nominal'			=> str_replace('.', '.', explode(',', $request->nominal)[0])
    		]);

    		// Pembukuan Jurnal

	    		$jurnal_cek = jurnal::where(DB::raw('month(tanggal_jurnal)'), date('n', strtotime($request->tanggal_transaksi)))->where(DB::raw('substring(no_jurnal, 1, 2)'), 'KM')->orderBy('jurnal_id', 'desc')->first();

	    		$next_jurnal = ($cek) ? (int)substr($cek->no_bukti, -5) : 0;

	    		$bukti_jurnal = 'KM-'.date('myd', strtotime($request->tanggal_transaksi)).str_pad(($next + 1), 5, '0', STR_PAD_LEFT);

	    		$id_jurnal = (jurnal::max('jurnal_id')) ? (jurnal::max('jurnal_id') + 1) : 1;

	    		// return json_encode($id_jurnal);

	    		jurnal::insert([
	    			'jurnal_id'			 => $id_jurnal,
	    			'no_jurnal'		 	 => $bukti_jurnal,
	    			'jurnal_ref'		 => $bukti,
	    			'tanggal_jurnal'	 => date('Y-m-d', strtotime($request->tanggal_transaksi)),
	    			'keterangan'		 => $request->keterangan
	    		]);

	    		jurnal_dt::insert([
	    			'jrdt_jurnal'	=> $id_jurnal,
	    			'jrdt_no'		=> 1,
	    			'jrdt_acc' 		=> $request->perkiraan,
	    			'jrdt_value'	=> str_replace('.', '.', explode(',', $request->nominal)[0]),
	    			'jrdt_dk'		=> 'D'
	    		]);

	    		$akun = DB::table('d_akun')->where('id_akun', $request->akun_lawan)->first();
	    		$pos = "K";
	    		$val = str_replace('.', '.', explode(',', $request->nominal)[0]);

	    		if($akun->posisi_akun != $pos){
	    			$val = '-'.str_replace('.', '.', explode(',', $request->nominal)[0]);
	    		}

	    		// return json_encode($akun);

	    		jurnal_dt::insert([
	    			'jrdt_jurnal'	=> $id_jurnal,
	    			'jrdt_no'		=> 2,
	    			'jrdt_acc' 		=> $request->akun_lawan,
	    			'jrdt_value'	=> $val,
	    			'jrdt_dk'		=> $pos
	    		]);

	    	// Pembukuan Jurnal End

    		return response()->json([
    			'status'	=> 'berhasil',
    			'content'	=> null
    		]);

    	}else{
    		$cek = transaksi::where(DB::raw('month(tanggal_transaksi)'), date('n', strtotime($request->tanggal_transaksi)))->where(DB::raw('substring(no_bukti, 1, 3)'), 'BKK')->orderBy('id_transaksi', 'desc')->first();

    		$next = ($cek) ? (int)substr($cek->no_bukti, -5) : 0;

    		$bukti = 'BKK-'.date('myd', strtotime($request->tanggal_transaksi)).str_pad(($next + 1), 5, '0', STR_PAD_LEFT);

    		transaksi::insert([
    			'no_bukti'			=> $bukti,
    			'tanggal_transaksi'	=> date('Y-m-d', strtotime($request->tanggal_transaksi)),
    			'nama_transaksi'	=> $request->nama_transaksi,
    			'keterangan'		=> $request->keterangan,
    			'nominal'			=> str_replace('.', '.', explode(',', $request->nominal)[0])

    		]);

    		return response()->json([
    			'status'	=> 'berhasil',
    			'content'	=> null
    		]);
    	}
    }
}
