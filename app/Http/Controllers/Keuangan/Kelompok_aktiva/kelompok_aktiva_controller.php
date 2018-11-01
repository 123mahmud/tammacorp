<?php

namespace App\Http\Controllers\keuangan\Kelompok_aktiva;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

class kelompok_aktiva_controller extends Controller
{
    public function index(){
    	return "index belum siap";
    }

    public function list(){
    	$data = DB::table('d_golongan_aktiva')->select('*')->get();

    	return json_encode($data);
    }

    public function add(){
    	return view('keuangan.kelompok_aktiva.index');
    }

    public function form_resource(){
        $akun_harta = DB::table('d_akun')->where(DB::raw('substring(id_akun,1,3)'), '200')->where('type_akun', 'DETAIL')->select('id_akun as value', 'nama_akun as nama')->get();

        $akun_penyusutan = DB::table('d_akun')->where(DB::raw('substring(id_akun,1,3)'), '210')->where('type_akun', 'DETAIL')->select('id_akun as value', 'nama_akun as nama')->get();

        $akun_beban = DB::table('d_akun')->where(DB::raw('substring(id_akun,1,3)'), '630')->where('type_akun', 'DETAIL')->select('id_akun as value', 'nama_akun as nama')->get();

    	return response()->json([
            'akun_harta'  => $akun_harta,
            'akun_penyusutan'  => $akun_penyusutan,
            'akun_beban'  => $akun_beban
         ]);
    }

    public function store(Request $request){
    	// return json_encode($request->all());

    	$cek = DB::table('d_golongan_aktiva')->max('ga_id');
    	$id = ($cek) ? ($cek + 1) : '1';
    	$nomor = 'AK-'.str_pad($id, 3, '0', STR_PAD_LEFT);

    	DB::table('d_golongan_aktiva')->insert([
    		'ga_id'					=> $id,
    		'ga_nomor'				=> $nomor,
    		'ga_nama'				=> $request->nama_kelompok,
    		'ga_keterangan'			=> $request->keterangan_kelompok,
    		'ga_golongan' 			=> $request->golongan_kelompok,
    		'ga_masa_manfaat'		=> $request->masa_manfaat,
    		'ga_garis_lurus'		=> $request->persentase_gl,
    		'ga_saldo_menurun'		=> $request->persentase_sm,
    		'ga_akun_harta'			=> $request->akun_harta,
    		'ga_akun_penyusutan'	=> $request->akun_penyusutan,
    		'ga_akun_akumulasi'		=> $request->akun_akumulasi
    	]);

    	return response()->json([
    		'status'	=> 'berhasil',
    		'content'	=> null
    	]);
    }
}
