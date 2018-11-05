<?php

namespace App\Http\Controllers\keuangan\aktiva;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DataTables;
use DB;
use Session;

class aktiva_controller extends Controller
{
    public function index(){
    	return "index belum siap";
    }

    public function add(){
    	return view('keuangan.aktiva.add');
    }

    public function form_resource(){
    	$data = DB::table('d_golongan_aktiva as a')
                    ->join('d_akun as b', 'b.id_akun', '=', 'a.ga_akun_harta')
                    ->join('d_akun as c', 'c.id_akun', '=', 'a.ga_akun_penyusutan')
                    ->join('d_akun as d', 'd.id_akun', '=', 'a.ga_akun_akumulasi')
                    ->select(
                    	'a.ga_nomor as value',
                    	'a.ga_masa_manfaat',
                    	'a.ga_garis_lurus',
                    	'a.ga_saldo_menurun',
                    	'a.ga_nama as nama',
                    	'a.ga_akun_harta',
                    	'a.ga_akun_penyusutan',
                    	'a.ga_akun_akumulasi',
                    	'b.nama_akun as akun_harta',
                    	'c.nama_akun as akun_penyusutan',
                    	'd.nama_akun as akun_akumulasi'
                    )
                    ->orderBy('a.ga_nama', 'asc')
                    ->get();

    	return json_encode([
    		"kelompok_aktiva" => $data,
    	]);
    }

    public function store(Request $request){
    	// return json_encode($request->all());

    	return response()->json([
            'status'    => 'berhasil',
            'flag'      => 'success',
            'content'   => 'Data Aktiva Berhasil Disimpan.'
        ]);
    	
    	$kelompok = DB::table('d_golongan_aktiva')->where('ga_nomor', $request->kelompok_aktiva)->first();
    	$tanggal_beli = explode('-', $request->tanggal_beli)[1].'-'.explode('-', $request->tanggal_beli)[0].'-01';
    	$tanggal_berakhir = date('Y-m-d', strtotime('+'.(($request->masa_manfaat * 12) - 1).' months', strtotime($tanggal_beli)));
    	$cek = DB::table('d_aktiva')->max('a_id');
    	$id = ($cek) ? ($cek + 1) : '1';
    	$nomor = 'ACT-'.str_pad($id, 3, '0', STR_PAD_LEFT);

    	DB::table('d_aktiva')->insert([
    		'a_id'					=> $id,
    		'a_nomor'				=> $nomor,
    		'a_name'				=> $request->nama_aset,
    		'a_kelompok'			=> $request->kelompok_aktiva,
    		'a_tanggal_beli' 		=> $tanggal_beli,
    		'a_harga_beli'			=> str_replace(',', '', $request->harga_beli),
    		'a_metode_penyusutan'	=> $request->metode_penyusutan,
    		'a_nilai_sisa'			=> str_replace(',', '', $request->harga_beli),
    		'a_tanggal_habis'		=> $tanggal_berakhir,
    		'a_status'				=> 'active'
    	]);

    	if(!$kelompok){
    		return response()->json([
	            'status'    => 'gagal',
	            'flag'      => 'error',
	            'content'   => 'Data Kelompok Aktiva Yang Dipilih Tidak Ada. Cobalah Untuk Memuat Ulang Halaman.'
	        ]);
    	}

    	return response()->json([
            'status'    => 'berhasil',
            'flag'      => 'success',
            'content'   => 'Data Aktiva Berhasil Disimpan.'
        ]);
    	
    }
}
