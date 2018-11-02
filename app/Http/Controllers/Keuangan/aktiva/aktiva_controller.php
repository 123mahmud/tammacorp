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
}
