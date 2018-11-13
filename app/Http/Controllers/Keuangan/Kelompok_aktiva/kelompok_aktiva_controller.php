<?php

namespace App\Http\Controllers\keuangan\Kelompok_aktiva;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DataTables;
use DB;
use Session;

class kelompok_aktiva_controller extends Controller
{
    public function index(){
    	return view('keuangan.aktiva.kelompok_aktiva.index');
    }

    public function list_table(Request $request)
    {   
        $list = DB::table("d_golongan_aktiva")->select("*")->orderBy("created_at", "desc")->get();

        // return $list;
        $data = collect($list);
        
        return Datatables::of($data)
                    ->editColumn('ga_golongan', function($data) {
                          $alpha = "";

                          switch ($data->ga_golongan) {
                              case '1':
                                  $alpha = 'Non Bangunan - Kelompok 1';
                                  break;

                              case '2':
                                  $alpha = 'Non Bangunan - Kelompok 2';
                                  break;

                              case '3':
                                  $alpha = 'Non Bangunan - Kelompok 3';
                                  break;

                              case '4':
                                  $alpha = 'Non Bangunan - Kelompok 4';
                                  break;

                              case '5':
                                  $alpha = 'Bangunan - Permanen';
                                  break;

                              case '5':
                                  $alpha = 'Bangunan - Non Permanen';
                                  break;
                              
                              default:
                                  $alpha = "Tidak Diketahui";
                                  break;
                          }

                          return $alpha;
                    })
                    ->addColumn('action', function ($data) {

                             return  '<button id="edit" onclick="edit(this)" class="btn btn-warning btn-sm" title="Edit"><i class="glyphicon glyphicon-pencil"></i></button>';
                    })
                    ->rawColumns(['action','confirmed'])
                    ->make(true);
    }

    public function list(){
    	$data = DB::table('d_golongan_aktiva as a')
                    ->join('d_akun as b', 'b.id_akun', '=', 'a.ga_akun_harta')
                    ->join('d_akun as c', 'c.id_akun', '=', 'a.ga_akun_penyusutan')
                    ->join('d_akun as d', 'd.id_akun', '=', 'a.ga_akun_akumulasi')
                    ->select('a.*', 'b.nama_akun as akun_harta', 'c.nama_akun as akun_penyusutan', 'd.nama_akun as akun_akumulasi')
                    ->orderBy('created_at', 'desc')
                    ->get();

    	return json_encode($data);
    }

    public function add(){
    	return view('keuangan.aktiva.kelompok_aktiva.add');
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

    public function update(Request $request){
        // return json_encode($request->all());
        $kelompok = DB::table('d_golongan_aktiva')->where('ga_nomor', $request->nomor_kelompok);

        if(!$kelompok->first()){
            return response()->json([
                'status'    => 'gagal',
                'flag'      => 'error',
                'content'   => 'Data Kelompok Yang Ingin Dirubah Tidak Bisa Ditemukan. Cobalah Untuk Memuat Ulang Halaman.'
            ]);
        }
        
        $aktiva = DB::table('d_aktiva')->where('a_kelompok', $request->nomor_kelompok)->first();

        if($aktiva){

            $kelompok->update([
                'ga_nama'               => $request->nama_kelompok,
                'ga_keterangan'         => $request->keterangan_kelompok
            ]);

            return response()->json([
                'status'    => 'berhasil',
                'flag'      => 'warning',
                'content'   => 'Perubahan Berhasil, Namun Hanya Pada Nama dan Keterangan Kelompok Saja.'
            ]);
        }else{

            $kelompok->update([
                'ga_nama'               => $request->nama_kelompok,
                'ga_keterangan'         => $request->keterangan_kelompok,
                'ga_golongan'           => $request->golongan_kelompok,
                'ga_masa_manfaat'       => $request->masa_manfaat,
                'ga_garis_lurus'        => $request->persentase_gl,
                'ga_saldo_menurun'      => $request->persentase_sm,
                'ga_akun_harta'         => $request->akun_harta,
                'ga_akun_penyusutan'    => $request->akun_penyusutan,
                'ga_akun_akumulasi'     => $request->akun_akumulasi
            ]);

            return response()->json([
                'status'    => 'berhasil',
                'flag'      => 'success',
                'content'   => 'Kelompok Aktiva Berhasil Diubah.'
            ]);
        }
    }

    public function delete(Request $request){
        $kelompok = DB::table('d_golongan_aktiva')->where('ga_nomor', $request->id);
        $aktiva = DB::table('d_aktiva')->where('a_kelompok', $request->id)->first();

        if(!$kelompok->first()){
            return response()->json([
                'status'    => 'gagal',
                'flag'      => 'error',
                'content'   => 'Data Kelompok Yang Ingin Dihapus Tidak Bisa Ditemukan. Cobalah Untuk Memuat Ulang Halaman.'
            ]);
        }else if($aktiva){
            return response()->json([
                'status'    => 'gagal',
                'flag'      => 'error',
                'content'   => 'Data Kelompok Yang Ingin Dihapus Digunakan Oleh Aktiva. Tidak Bisa Dihapus..'
            ]);
        }

        $kelompok->delete();

        return response()->json([
            'status'    => 'berhasil',
            'flag'      => 'success',
            'content'   => 'Kelompok Aktiva Berhasil Dihapus.'
        ]);

    }
}
