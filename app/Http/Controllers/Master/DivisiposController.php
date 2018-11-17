<?php

namespace App\Http\Controllers\Master;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use DataTables;

class DivisiposController extends Controller
{
    public function index(){
    	
    	return view('master.datadivisi_posisi.index');
    }

    public function tableDivisi(){

    	$divisi = DB::table('m_divisi')->get();
    	// dd($divisi);
        return Datatables::of($divisi) 
    		->addIndexColumn()          
            ->addColumn('action', function ($data) {
                     return  '<div class="text-center">
                     			<button id="edit" onclick="editDivisi('.$data->c_id.')" class="btn btn-warning btn-sm" title="Edit"><i class="glyphicon glyphicon-pencil"></i></button>'.'
                                 <button id="delete" onclick="hapusDivisi('.$data->c_id.')" class="btn btn-danger btn-sm" title="Hapus"><i class="glyphicon glyphicon-trash"></i></button>
                             </div>';
            })

            ->rawColumns(['action'])
            ->make(true);
    }

    public function editDivisi($id){
    	$divisi = DB::table('m_divisi')->where('c_id',$id)->first();

    	return view('master.datadivisi_posisi.edit_divisi',compact('divisi'));
    }

    public function updateDivisi(Request $request, $id){
    	DB::beginTransaction();
            try {
    	DB::table('m_divisi')->where('c_id',$id)
    		->update([
    			'c_divisi' => $request->c_divisi,
    			'c_divisi_akronim' =>$request->c_divisi_akronim,
    			'updated_at' => Carbon::now()
    		]);
    	DB::commit();
	    return response()->json([
	          'status' => 'sukses'
	      ]);
	    } catch (\Exception $e) {
	    DB::rollback();
	    return response()->json([
	        'status' => 'gagal',
	        'data' => $e
	      ]);
	    }

    }

    public function tablePosisi(){
    	$posisi = DB::table('m_sub_divisi')->get();
    	// dd($posisi);
    	return Datatables::of($posisi) 
    		->addIndexColumn()          
            ->addColumn('action', function ($data) {
                     return  '<div class="text-center">
                     			<button id="edit" onclick="editPosisi('.$data->c_id.')" class="btn btn-warning btn-sm" title="Edit"><i class="glyphicon glyphicon-pencil"></i></button>'.'
                                 <button id="delete" onclick="hapusPosisi('.$data->c_id.')" class="btn btn-danger btn-sm" title="Hapus"><i class="glyphicon glyphicon-trash"></i></button>
                             </div>';
            })

            ->rawColumns(['action'])
            ->make(true);
    }

   	public function editPosisi($id){
   		$posisi = DB::table('m_sub_divisi')->where('c_id',$id)->first();

   		return view('master.datadivisi_posisi.edit_posisi',compact('posisi'));
   	}

   	public function updatePosisi(Request $request, $id){
   		DB::beginTransaction();
            try {
   		DB::table('m_sub_divisi')->where('c_id',$id)
   			->update([
   				'c_subdivisi' => $request->c_subdivisi,
   				'updated_at' => Carbon::now()
   			]);
   		DB::commit();
	    return response()->json([
	          'status' => 'sukses'
	      ]);
	    } catch (\Exception $e) {
	    DB::rollback();
	    return response()->json([
	        'status' => 'gagal',
	        'data' => $e
	      ]);
	    }
   	}

   	public function tambahPosisi(){

   		return view('master.datadivisi_posisi.tambah-posisi');
   	}

   	public function savePosisi(Request $request){
   		DB::beginTransaction();
            try {
   		$id = DB::table('m_sub_divisi')->select('c_id')->max('c_id')+1;
   		DB::table('m_sub_divisi')->where('c_id',$id)
			->insert([
				'c_id' => $id,
				'c_subdivisi' => $request->c_subdivisi,
				'created_at' => Carbon::now()
			]);
		DB::commit();
	    return response()->json([
	          'status' => 'sukses'
	      ]);
	    } catch (\Exception $e) {
	    DB::rollback();
	    return response()->json([
	        'status' => 'gagal',
	        'data' => $e
	      ]);
	    }
   	}

   	public function tambahDivisi(){

   		return view('master.datadivisi_posisi.tambah-divisi');
   	}

   	public function simpanDivisi(Request $request){
   		DB::beginTransaction();
            try {
   		$id = DB::table('m_divisi')->select('c_id')->max('c_id')+1;
   		DB::table('m_divisi')->where('c_id',$id)
			->insert([
				'c_id' => $id,
				'c_divisi' => $request->c_divisi,
				'c_divisi_akronim' => $request->c_divisi_akronim,
				'created_at' => Carbon::now()
			]);
		DB::commit();
	    return response()->json([
	          'status' => 'sukses'
	      ]);
	    } catch (\Exception $e) {
	    DB::rollback();
	    return response()->json([
	        'status' => 'gagal',
	        'data' => $e
	      ]);
	    }
   	}

   	public function hapusDivisi($id){
   		DB::beginTransaction();
            try {
   		$id = DB::table('m_divisi')->where('c_id',$id)->delete();
		DB::commit();
	    return response()->json([
	          'status' => 'sukses'
	      ]);
	    } catch (\Exception $e) {
	    DB::rollback();
	    return response()->json([
	        'status' => 'gagal',
	        'data' => $e
	      ]);
	    }
   	}

   	public function hapusPosisi($id){
   		DB::beginTransaction();
            try {
   		$id = DB::table('m_sub_divisi')->where('c_id',$id)->delete();
		DB::commit();
	    return response()->json([
	          'status' => 'sukses'
	      ]);
	    } catch (\Exception $e) {
	    DB::rollback();
	    return response()->json([
	        'status' => 'gagal',
	        'data' => $e
	      ]);
	    }
   	}
}
