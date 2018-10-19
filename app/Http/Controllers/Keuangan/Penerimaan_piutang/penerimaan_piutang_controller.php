<?php

namespace App\Http\Controllers\keuangan\Penerimaan_piutang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use DB;

class penerimaan_piutang_controller extends Controller
{
    public function index(){
    	return view('Keuangan.penerimaan_piutang.index');
    }

    public function form_resource(){
    	$data = DB::table('m_customer')->select('c_id', 'c_name')->orderBy('c_name', 'asc')->get();
        $akun_kas = DB::table('d_akun')->where(DB::raw('substring(id_akun,1,3)'), '100')->where('type_akun', 'DETAIL')->select('id_akun', 'nama_akun')->get();
        $akun_bank = DB::table('d_akun')->where(DB::raw('substring(id_akun,1,3)'), '101')->where('type_akun', 'DETAIL')->select('id_akun', 'nama_akun')->get();

    	return response()->json([
            'supplier'  => $data,
            'akun_kas'  => $akun_kas,
            'akun_bank' => $akun_bank
            // 'akun_bank' => $bank
         ]);
    }
}
