<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Response;
use App\Http\Requests;
use DataTables;
use URL;
use App\m_item;
use App\m_satuan;
use App\m_group;
use App\m_price;
use App\d_stock;
use App\d_stock_mutation;

class itemProduksiController extends Controller
{
  public function index(){
  	
  	return view('master.data_produksi.index');
  }

  public function tableProduksi(){
  	$list = m_item::select(	'i_code',
  													'i_name',
  													'm_sname',
  													'm_gname',
  													'i_isactive',
  													'i_id')
      ->join('m_group','m_item.i_code_group','=','m_group.m_gcode')
      ->join('m_satuan','m_item.i_sat1','=','m_satuan.m_sid')
      ->where('i_type','BP')
      ->orderBy('m_item.i_id', 'DESC')
      ->get();
			// return $list;
    $data = collect($list);
        
        // return $data;

	  return Datatables::of($data)
      ->addIndexColumn()
      ->addColumn('aksi', function ($data) {
      	if ($data->i_isactive == 'TRUE') {
      		return  '<button id="edit" 
      									onclick="edit('.$data->i_id.')" 
      									class="btn btn-warning btn-sm" 
      									title="Edit">
									       <i class="glyphicon glyphicon-pencil"></i>
           					</button>'.'
                    <button id="status'.$data->i_id.'" 
	                				onclick="ubahStatus('.$data->i_id.')" 
	                				class="btn btn-primary btn-sm" 
	                				title="Aktif">
	                				<i class="fa fa-check-square" aria-hidden="true"></i>
                    </button>';
      	}else{
      		return  '<button id="edit" 
               									onclick="edit('.$data->i_id.')" 
               									class="btn btn-warning btn-sm" 
               									title="Edit">
               									<i class="glyphicon glyphicon-pencil"></i>
               					</button>'.'
                        <button id="status'.$data->i_id.'" 
                        				onclick="ubahStatus('.$data->i_id.')" 
                        				class="btn btn-danger btn-sm" 
                        				title="Tidak Aktif">
                        				<i class="fa fa-minus-square" aria-hidden="true"></i>
                        </button>';
      	}
      })
      ->addColumn('none', function ($data) {
          return '-';
      })
      ->rawColumns(['aksi','confirmed'])
      ->make(true);
  }

  public function tambahItem(){
  	$satuan  = m_satuan::get();
    $group  = m_group::get();

    return view('master.data_produksi.tambah_barang',compact('kode','group','satuan'));
  }

 public function simpanItem(Request $request){
 	// dd($request->all());
 	DB::beginTransaction();
  try {
  	$i_id = DB::table('m_item')->select('i_id')->max('i_id')+1;
  	$tanggal = date("Y-m-d h:i:s");
		$data_item = m_item::insert([
      		'i_id'	=>	$i_id,
          'i_code'	=>	$request->kode_barang,
          'i_type' =>	'BP',
          'i_code_group'	=>	$request->code_group,
          'i_name'	=>	$request->nama,
          'i_sat1'	=>	$request->satuan1,
          'i_sat2'	=>	$request->satuan2,
          'i_sat3'	=>	$request->satuan3,
          'i_insert'=>$tanggal
      ]);
    $m_pid = m_price::select('m_pid')->max('m_pid')+1;
    $price = m_price::insert([
    		'm_pid' => $m_pid,
    		'm_pitem' => $i_id,
    		'm_pisactive' => 'FALSE',
    		'm_pcreated' => Carbon::now()
    	]);
    $s_id = d_stock::select('s_id')->max('s_id')+1;
    d_stock::insert([
    		's_id' => $s_id,
    		's_comp' => '2',
    		's_position' => '2',
    		's_item' => $i_id,
    		's_qty_min' => $request->min_stock,
    		's_insert'	=> Carbon::now()
    	]);
    d_stock_mutation::insert([
        'sm_stock' => $s_id,
        'sm_detailid' => '1',
        'sm_date' => Carbon::now(),
        'sm_comp' => '2',
        'sm_position' => '2',
        'sm_mutcat' => '9',
        'sm_item' => $i_id,
        'sm_qty' => '0',
        'sm_qty_used' => '0',
        'sm_qty_sisa' => '0',
        'sm_qty_expired' => '0',
        'sm_detail' => 'PENAMBAHAN',
        'sm_insert' => Carbon::now()
      ]);
    d_stock::insert([
        's_id' => $s_id + 1,
        's_comp' => '1',
        's_position' => '1',
        's_item' => $i_id,
        's_qty_min' => $request->min_stock,
        's_insert'  => Carbon::now()
      ]);
    d_stock_mutation::insert([
        'sm_stock' => $s_id + 1,
        'sm_detailid' => '1',
        'sm_date' => Carbon::now(),
        'sm_comp' => '1',
        'sm_position' => '1',
        'sm_mutcat' => '9',
        'sm_item' => $i_id,
        'sm_qty' => '0',
        'sm_qty_used' => '0',
        'sm_qty_sisa' => '0',
        'sm_qty_expired' => '0',
        'sm_detail' => 'PENAMBAHAN',
        'sm_insert' => Carbon::now()
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

 	public function ubahStatus($id){
 		DB::beginTransaction();
  	try {
 		$data = m_item::select(	'i_id',
 								'i_isactive')
 			->where('i_id',$id)
 			->first();
 		if ($data->i_isactive == 'TRUE') {
 			m_item::where('i_id',$id)
 				->update([
 					'i_isactive' => 'FALSE'
 				]);
 		}else{
 			m_item::where('i_id',$id)
 				->update([
 					'i_isactive' => 'TRUE'
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

	public function editBarang($id){
	  $satuan  = DB::table('m_satuan')->get();
	  $data_item = m_item::where('i_id',$id)->first();
	  $min_stock = d_stock::where('s_item',$id)
	  	->where('s_comp','2')
	  	->where('s_position','2')
	  	->first();
	  $group  = DB::table('m_group')->get();

	  return view('master/data_produksi/edit_barang',compact('data_item','data_price','satuan','group', 'min_stock'));
	}

	public function updateItem(Request $request, $id){
		// dd($request->all());
		DB::beginTransaction();
  	try {
  		$item = m_item::where('i_id',$id)
  			->update([
  				'i_name' => $request->nama,
  				'i_sat1' => $request->satuan1,
  				'i_sat2' => $request->satuan2,
  				'i_sat3' => $request->satuan3,
  				'i_update' => Carbon::now()
  			]);

  		$stock = d_stock::where('s_item',$id)
  			->where('s_comp','2')
  			->where('s_position','2')
  			->update([
  				's_qty_min' => $request->min_stock,
  				's_update' => Carbon::now()
  			]);

      if ($stock == 0) {
        $s_id = d_stock::select('s_id')->max('s_id')+1;
        $stock = d_stock::insert([
          's_id' => $s_id,
          's_comp' => '2',
          's_position' => '2',
          's_item' => $id,
          's_qty_min' => $request->min_stock,
          's_insert'  => Carbon::now()
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
}
