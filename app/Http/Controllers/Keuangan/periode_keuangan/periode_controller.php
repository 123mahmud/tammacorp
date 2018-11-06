<?php

namespace App\Http\Controllers\keuangan\periode_keuangan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DataTables;
use DB;
use Session;

class periode_controller extends Controller
{
    public function index(){
    	return view('keuangan.periode_keuangan.index');
    }

    public function list_periode(){
    	$list = DB::table("d_periode_keuangan as a")
        				->select("a.*")
        				->orderBy("pk_periode", "desc")->get();
        
        return json_encode($list);
    }

    public function store(Request $request){
    	// return json_encode($request->all());

    	$bulan = explode('-', $request->bulan_periode)[1].'-'.explode('-', $request->bulan_periode)[0].'-01';
    	$cek = DB::table('d_periode_keuangan')->where('pk_periode', '>=', $bulan)->first();

    	if($cek){
    		return response()->json([
	            'status'    => 'gagal',
	            'flag'      => 'error',
	            'content'   => 'Anda Tidak Bisa Menambahkan Bulan Yang Sudah Berlalu.',
	            'data'		=> null
	        ]);
    	}

    	$id = (DB::table('d_periode_keuangan')->max('pk_id')) ? (DB::table('d_periode_keuangan')->max('pk_id') + 1) : '1';

    	$data = [
    		'pk_id'			=> $id,
    		'pk_periode'	=> $bulan,
    		'pk_status'		=> $request->status_periode,
    	];

    	DB::table('d_periode_keuangan')->insert($data);

    	return response()->json([
            'status'    => 'berhasil',
            'flag'      => 'success',
            'content'   => 'Periode Baru Berhasil Disimpan.',
            'context'	=> $data,
        ]);
    }
}
