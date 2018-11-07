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

        // return response()->json([
        //     'status'    => 'berhasil',
        //     'flag'      => 'success',
        //     'content'   => 'Periode Baru Berhasil Disimpan.',
        //     // 'context'   => $data,
        // ]);

    	$bulan = explode('-', $request->bulan_periode)[1].'-'.explode('-', $request->bulan_periode)[0].'-01';
    	$cek = DB::table('d_periode_keuangan')->where('pk_periode', '>', $bulan)->first();
        $cek2 = DB::table('d_periode_keuangan')->where('pk_periode', '=', $bulan)->first();

    	if($cek){
    		return response()->json([
	            'status'    => 'gagal',
	            'flag'      => 'error',
	            'content'   => 'Anda Tidak Bisa Menambahkan Bulan Yang Sudah Berlalu.',
	            'data'		=> null
	        ]);
    	}else if($cek2){
            return response()->json([
                'status'    => 'gagal',
                'flag'      => 'error',
                'content'   => 'Periode Untuk Bulan Yang Dipilih Sudah Dibuat...',
                'data'      => null
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

    public function update(Request $request){
        // return json_encode($request->all());
        $periode = DB::table('d_periode_keuangan')->where('pk_id', $request->id);

        if(!$periode->first()){
            return response()->json([
                'status'    => 'gagal',
                'flag'      => 'error',
                'content'   => 'Periode Yang Dipilih Tidak Detemukan. Cobalah Untuk Muat Ulang Halaman ...',
                'data'      => null
            ]);
        }

        $periode->update([
            'pk_status' => $request->status_periode
        ]);

        return response()->json([
            'status'    => 'berhasil',
            'flag'      => 'success',
            'content'   => 'Periode Berhasil Diubah.',
            'context'   => $request->all(),
        ]);
    }

    public function delete(Request $request){
        $periode = DB::table('d_periode_keuangan')->where('pk_id', $request->id);

        if(!$periode->first()){
            return response()->json([
                'status'    => 'gagal',
                'flag'      => 'error',
                'content'   => 'Periode Yang Dipilih Tidak Detemukan. Cobalah Untuk Muat Ulang Halaman ...',
                'data'      => null
            ]);
        }else if(strtotime($periode->first()->pk_periode) <= strtotime(date('Y-m-d'))){
            return response()->json([
                'status'    => 'gagal',
                'flag'      => 'error',
                'content'   => 'Tidak Bisa Menghapus Periode Yang Sudah/Masih Berjalan ...',
                'data'      => null
            ]);
        }

        $periode->delete();

        return response()->json([
            'status'    => 'berhasil',
            'flag'      => 'success',
            'content'   => 'Periode Berhasil Dihapus.',
            'context'   => $request->all(),
        ]);
    }

    public function integrasi(Request $request){
        // return json_encode($request->all());

        $periode = DB::table('d_periode_keuangan')->where('pk_id', $request->id)->first();

        return response()->json([
            'status'    => 'berhasil',
            'flag'      => 'success',
            'content'   => 'Periode Baru Berhasil Disimpan.',
            'data'      => null
        ]);

        if(!$periode || date('Y-m', strtotime($periode->pk_periode)) != date('Y-m') || $periode->dk_status != '1'){
            return response()->json([
                'status'    => 'gagal',
                'flag'      => 'error',
                'content'   => 'Integrasi Gagal. Pastikan Periode Pada Bulan Ini Sudah Dibuat Dan Berstatus \'Aktif\'',
                'data'      => null
            ]);
        }
    }
}
