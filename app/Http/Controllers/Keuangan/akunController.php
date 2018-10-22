<?php

namespace App\Http\Controllers\Keuangan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DataTables;
use DB;
use Session;

class akunController extends Controller
{
    public function index(){	
    	return view('master.datakeuangan.datakeuangan.keuangan');
    }

    public function datatable_akun(Request $request)
    {   
        if($request->list == 'general')
            $list = DB::table("d_akun")->where("type_akun", "GENERAL")->whereNotNull("kelompok_akun")->where("kelompok_akun", "!=", "-")->select("*")->orderBy("id_akun", "asc")->get();
        else
            $list = DB::table("d_akun")->where("type_akun", "DETAIL")->select("*")->orderBy("id_akun", "asc")->get();

        // return $list;
        $data = collect($list);
        
        // return $data;

        if($request->list == 'general'){
            return Datatables::of($data)
                	->editColumn('group_laba_rugi', function($data) {
    				  return ($data->group_laba_rugi == "") ? "-" : $data->group_laba_rugi;
    				})
    				->editColumn('group_neraca', function($data) {
    				  return ($data->group_neraca == "") ? "-" : $data->group_neraca;
    				})
    				->editColumn('posisi_akun', function($data) {
    				  return ($data->posisi_akun == "D") ? "DEBET" : "KREDIT";
    				})
                    ->addColumn('none', function ($data) {
                        return '-';
                    })
                    ->rawColumns(['action','confirmed'])
                    ->make(true);
        }else{
            return Datatables::of($data)
                    ->editColumn('group_laba_rugi', function($data) {
                      return ($data->group_laba_rugi == "") ? "-" : $data->group_laba_rugi;
                    })
                    ->editColumn('group_neraca', function($data) {
                      return ($data->group_neraca == "") ? "-" : $data->group_neraca;
                    })
                    ->editColumn('posisi_akun', function($data) {
                      return ($data->posisi_akun == "D") ? "DEBET" : "KREDIT";
                    })
                    ->addColumn('action', function ($data) {

                             return  '<button id="edit" onclick="edit(this)" class="btn btn-warning btn-sm" title="Edit"><i class="glyphicon glyphicon-pencil"></i></button>'.'
                                            <button id="delete" onclick="hapus(this)" class="btn btn-danger btn-sm" title="Hapus"><i class="glyphicon glyphicon-trash"></i></button>';
                    })
                    ->addColumn('none', function ($data) {
                        return '-';
                    })
                    ->rawColumns(['action','confirmed'])
                    ->make(true);
        }
    }

    public function tambah_akun()
    {
    	$datakelompok = json_encode(DB::table("d_akun")->where("type_akun", "GENERAL")->whereNotNull("kelompok_akun")->where("kelompok_akun", "!=", "-")->select("id_akun as value", "nama_akun as text")->get());
    	$datagroupneraca = json_encode(DB::table("d_group_akun")->where("type_group", "neraca")->select("no_group as value", "nama_group as text")->get());
    	$datagrouplabarugi = json_encode(DB::table("d_group_akun")->where("type_group", "laba/rugi")->select("no_group as value", "nama_group as text")->get());

    	// return $datagrouplabarugi;

        return view("master.datakeuangan.datakeuangan.tambah_akun")
        		->withDatakelompok($datakelompok)
        		->withDatagroupneraca($datagroupneraca)
        		->withDatagrouplabarugi($datagrouplabarugi);
    }

    public function save_akun(Request $request){
    	// return json_encode($request->all());

    	$response = [
    		'status'	=> "sukses",
    		'content'	=> 'null'
    	];

    	$cek = DB::table("d_akun")->where("id_akun", $request->kelompok_akun.".".$request->nomor_akun)->first();

        // return json_encode($cek);

    	if($cek){
    		$response = [
    			'status'	=> 'exist_id',
    			'content'	=>  $cek->nama_akun
    		];

    		return json_encode($response);
    	}

    	if($request->type_akun == "GENERAL"){
    		$cek = DB::table("d_akun")->where("group_neraca", $request->group_neraca_general)->where("type_akun", "GENERAL")->first();

	    	if($cek && !is_null($cek->group_neraca)){
	    		$response = [
	    			'status'	=> 'exist_group_neraca',
	    			'content'	=>  $cek->nama_akun
	    		];
	    		return json_encode($response);
	    	}

	    	$cek = DB::table("d_akun")->where("group_laba_rugi", $request->group_laba_rugi_general)->where("type_akun", "GENERAL")->first();
    		
            // return json_encode($cek);

	    	if($cek && !is_null($cek->group_laba_rugi)){
	    		$response = [
	    			'status'	=> 'exist_group_laba_rugi',
	    			'content'	=>  $cek->nama_akun
	    		];

	    		return json_encode($response);
	    	}

	    	$data = [
	    		"id_akun"			=> $request->kelompok_akun.$request->nomor_akun,
	    		"nama_akun"			=> $request->nama_akun,
	    		"kelompok_akun"		=> $request->nama_kelompok,
	    		"posisi_akun"		=> $request->posisi_akun,
	    		"type_akun"			=> $request->type_akun,
	    		"group_neraca"		=> null,
	    		"group_laba_rugi"	=> null
	    	];

	    	DB::table("d_akun")->insert($data);


    	}else{
    		$data = [
	    		"id_akun"			=> $request->kelompok_akun.".".$request->nomor_akun,
	    		"nama_akun"			=> $request->nama_akun,
	    		"kelompok_akun"		=> $request->nama_kelompok,
	    		"posisi_akun"		=> $request->posisi_akun,
	    		"type_akun"			=> $request->type_akun,
	    		"group_neraca"		=> (isset($request->group_neraca_detail)) ? $request->group_neraca_detail : null,
	    		"group_laba_rugi"	=> (isset($request->group_laba_rugi_detail)) ? $request->group_laba_rugi_detail : null,
	    	];

	    	$saldo = [
	    		"id_akun"			=> $request->kelompok_akun.".".$request->nomor_akun,
	    		"bulan"				=> date("m"),
	    		"tahun"				=> date("Y"),
	    		"saldo"				=> str_replace(".", "", explode(',', $request->saldo_bulan_ini)[0])
	    	];

	    	DB::table("d_akun")->insert($data);
	    	DB::table("d_akun_saldo")->insert($saldo);
    	}

    	return json_encode($response);
    }

    public function edit_akun(Request $request){

    	$akun = DB::table("d_akun")
    			->where("d_akun.id_akun", $request->id)
    			->select("d_akun.*")->first();

    	// return json_encode($akun);

    	$datagroupneraca = json_encode(DB::table("d_group_akun")->where("type_group", "neraca")->select("no_group as value", "nama_group as text")->get());
        $datagrouplabarugi = json_encode(DB::table("d_group_akun")->where("type_group", "laba/rugi")->select("no_group as value", "nama_group as text")->get());

    	return view("master.datakeuangan.datakeuangan.edit_akun")
        		->withDatagroupneraca($datagroupneraca)
        		->withAkun($akun)
        		->withDatagrouplabarugi($datagrouplabarugi);
    }

    public function update_akun(Request $request){
    	// return json_encode($request->all());

    	$response = [
    		'status'	=> "sukses",
    		'content'	=> 'null'
    	];

    	$data = [
    		"nama_akun"			=> $request->nama_akun,
    		"posisi_akun"		=> $request->posisi_akun,
    		"group_neraca"		=> (isset($request->group_neraca_detail)) ? $request->group_neraca_detail : null,
    		"group_laba_rugi"	=> (isset($request->group_laba_rugi_detail)) ? $request->group_laba_rugi_detail : null,
    	];

    	Db::table("d_akun")->where("id_akun", $request->id_akun)->update($data);

    	return json_encode($response);
    }

    public function hapus_akun(Request $request){

        $on_jurnal = DB::table('d_jurnal_dt')->where('jrdt_acc', $request->id)->first();
        $akun = DB::table('d_akun')->where('id_akun', $request->id)->first();

        if($on_jurnal)
            return response()->json(['status'=>2]);

        if($akun)
            return response()->json(['status'=>3]);

    	DB::table("d_akun")->where("id_akun", $request->id)->delete();

    	return response()->json(['status'=>1]);
    }
}
