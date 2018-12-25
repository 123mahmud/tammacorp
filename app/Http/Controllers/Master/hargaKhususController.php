<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use DataTables;
use URL;
use App\m_item_price;
use App\m_price_group;
use App\m_item;

class hargaKhususController extends Controller
{
    public function index()
    {
    	$group = m_price_group::where('pg_active','TRUE')
    		->get();

    	return view('master.harga_khusus.index',compact('group'));
    }

    public function tableGroup($id){
    	$item = m_item_price::select('ip_item',
    								'i_name',
    								'ip_price')
    		->join('m_item','m_item.i_id','=','ip_item')
    		->where('ip_group',$id)
    		->get();
    	
    	return DataTables::of($item)

    	->editColumn('ip_price', function ($data)
        {
            return '<div>
                      <span class="pull-right">
                        '.number_format( $data->ip_price ,2,',','.').'
                      </span>
                    </div>';
        })

    	->addColumn('action', function($data)
		{
		  return '<div class="text-center">
		            <a onclick=hapus('.$data->ip_item.')
		              class="btn btn-danger btn-sm"
		              title="Hapus">
		              <i class="fa fa-trash-o"></i>
		            </a>
		          </div>';

		})
    	->rawColumns(['ip_price','action'])
        ->make(true);

    }

    public function tableMasterGroup(){
    	$masterGroup = m_price_group::all();

    	return DataTables::of($masterGroup)
    	->addIndexColumn()
    	->addColumn('action', function ($data) {
      	if ($data->pg_active == 'TRUE') {
      		return  '<div class="text-center">'.
	      				'<button id="edit" 
							onclick="edit('.$data->pg_id.')" 
							class="btn btn-warning btn-sm" 
							title="Edit">
					       <i class="glyphicon glyphicon-pencil"></i>
	   					</button>'.'
	                    <button id="status'.$data->pg_id.'" 
	        				onclick="ubahStatus('.$data->pg_id.')" 
	        				class="btn btn-primary btn-sm" 
	        				title="Aktif">
	        				<i class="fa fa-check-square" aria-hidden="true"></i>
	                    </button>'.
                    '</div>';
      	}else{
      		return  '<div class="text-center">'.
	      				'<button id="status'.$data->pg_id.'" 
	        				onclick="ubahStatus('.$data->pg_id.')" 
	        				class="btn btn-danger btn-sm" 
	        				title="Tidak Aktif">
	        				<i class="fa fa-minus-square" aria-hidden="true"></i>
	                    </button>'.
	                '</div>';
      	}
      })
		->rawColumns(['action'])
    	->make(true);
    }
    
    public function tambahGroup(){

    	return view('master.harga_khusus.tambah_group');
    }

    public function insertGroup(Request $request){
    	DB::beginTransaction();
            try {
    	$id = m_price_group::select('pg_id')->max('pg_id')+1;
    	m_price_group::create([
    		'pg_id' => $id,
            'pg_name' => $request->pg_name,
            'pg_created' => Carbon::now()
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

    public function moveStatusGroup($id){
    	DB::beginTransaction();
            try {
    	$data = m_price_group::where('pg_id',$id)
    		->first();
    	if ($data->pg_active == 'TRUE') 
    	{
    		$data->update([
    			'pg_active' => 'FALSE'
    		]);
    	}
    	else
    	{
    		$data->update([
    			'pg_active' => 'TRUE'
    		]);
    	}
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

    public function editGroup($id){
    	$group = m_price_group::where('pg_id',$id)
    		->first();
    	return view('master.harga_khusus.edit_group',compact('group'));
    }

    public function updateGroup(Request $request, $id){
    	DB::beginTransaction();
            try {
    	m_price_group::where('pg_id',$id)
    		->update([
    			'pg_name' => $request->pg_name,
    			'pg_updated' => Carbon::now()
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

    public function autocomplete(Request $request)
    {
    	$term = $request->term;

	    $results = array();
	    
	    $queries = m_item::where('m_item.i_name', 'LIKE', '%'.$term.'%')
	      ->join('m_satuan','m_sid','=','i_sat1')
	      ->where(function ($query) {
			    $query->where('i_type','BP')
			    	->orWhere('i_type','BJ');
			})
	      ->where('i_isactive','TRUE')
	      ->orderBy('i_name')
	      ->take(15)->get();
	    
	    if ($queries == null) {
	      $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
	    } else {
	      foreach ($queries as $query) 
	      {
	        $txtSat1 = DB::table('m_satuan')->select('m_sname', 'm_sid')->where('m_sid','=', $query->i_sat1)->first();
	        $txtSat2 = DB::table('m_satuan')->select('m_sname', 'm_sid')->where('m_sid','=', $query->i_sat2)->first();
	        $txtSat3 = DB::table('m_satuan')->select('m_sname', 'm_sid')->where('m_sid','=', $query->i_sat3)->first();

	        $results[] = [  'id' => $query->i_id, 
	                        'label' => $query->i_code .' - '.$query->i_name,
	                        'name' => $query->i_name,
	                        'id_satuan' => [$query->i_sat1, $query->i_sat2, $query->i_sat3],
	                        'satuan' => [$txtSat1->m_sname, $txtSat2->m_sname, $txtSat3->m_sname],
	                        'i_code' => $query->i_code ];
	      }
	    } 

	  return Response::json($results);
    }

    public function saveHargaItem(Request $request){
    	DB::beginTransaction();
        try{
        	$cek = m_item_price::where('ip_group',$request->group)
        		->where('ip_item',$request->i_id)
        		->first();
        		// dd($cek);
        	if ($cek != null) 
        	{
        		m_item_price::where('ip_group',$request->group)
        		->where('ip_item',$request->i_id)
        		->update([
        			'ip_price' => $request->price
        		]);
        	}
        	else
        	{
        		m_item_price::create([
	        		'ip_group' => $request->group,
	        		'ip_item' => $request->i_id,
	        		'ip_price' => $request->price,
	        	]);	
        	}
        	
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

    public function deleteItemHarga(Request $request, $id)
    {
    	DB::beginTransaction();
        try{
        	m_item_price::where('ip_group',$request->idGroup)
        		->where('ip_item',$id)
        		->delete();
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
