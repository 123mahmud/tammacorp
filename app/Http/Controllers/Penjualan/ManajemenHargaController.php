<?php

namespace App\Http\Controllers\Penjualan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Response;
use App\Http\Requests;
use App\m_price;
use DataTables;
use URL;


class ManajemenHargaController extends Controller
{
	public function tabelHarga(){
		$data = m_price::select(  'm_pid',
                              'i_code',
                              'm_gname',
                              'm_psell1',
                              'm_psell2',
                              'm_psell3',
                              'm_hpp',
                              'm_barang_rusak',
                              'i_type',
                              'i_name')
			->join('m_item','i_id','=','m_pitem')
      ->join('m_group','m_group.m_gcode','=','i_code_group')
      ->where('m_item.i_isactive', '=', 'TRUE')
      ->where('i_type','!=','BB')
			->get();

		return DataTables::of($data)
    ->addIndexColumn()
    ->addColumn('i_name', function($data){
      return $data->i_code .' - '. $data->i_name ;
    })
    ->editColumn('m_psell1', function ($data) {
      return '<div class="text-right">
      <input readonly class="form-control text-right" value="'.number_format( $data->m_psell1 ,2,',','.').'">
      </div>';
    })
    ->editColumn('m_psell2', function ($data) {
      return '<div class="text-right">
      <input readonly class="form-control text-right" value="'.number_format( $data->m_psell2 ,2,',','.').'">
      </div>';
    })
    ->editColumn('m_psell3', function ($data) {
      return '<div class="text-right">
      <input readonly class="form-control text-right" value="'.number_format( $data->m_psell3 ,2,',','.').'">
      </div>';
    })

    ->editColumn('m_hpp', function ($data) {
      return '<div class="text-right">
      <input readonly class="form-control text-right" value="'.number_format( $data->m_hpp ,2,',','.').'">
      </div>';
    })

    ->editColumn('m_barang_rusak', function ($data) {
      return '<div class="text-right">
      <input readonly class="form-control text-right" value="'.number_format( $data->m_barang_rusak ,2,',','.').'">
      </div>';
    })

    ->addColumn('action', function($data){
      return '<div class="text-center">
                  <button style="margin-left:5px;" 
                          title="Edit" 
                          type="button"
                          data-toggle="modal" 
                          data-target="#myModalEdit"
                          class="btn btn-warning btn-sm" 
                          onclick="editmpsell('.$data->m_pid.')">
                          <i class="fa fa-pencil"></i>
                  </button>
            </div>';
    })
    ->rawColumns(['i_name','action','m_psell1','m_psell2','m_psell3','m_hpp','m_barang_rusak'])
    ->make(true);
	}

  public function konvertRp($value){
    $value = str_replace(['Rp', '\\', '.', ' '], '', $value);

    return str_replace(',', '.', $value);
  }

  public function editMpsell($id){
    $data = m_price::select('*')
      ->join('m_item','i_id','=','m_pitem')
      ->where('m_pid',$id)
      ->first();
      dd($data);
    
    return view('penjualan.manajemenharga.modal-edit',compact('data'));
  }

  public function updateMpsell(Request $request){
    // dd($request->all());
    DB::beginTransaction();
        try {
    m_price::where('m_pid',$request->m_pid)
      ->update([
        'm_psell1' => ($this->konvertRp($request->m_psell1)),
        'm_psell2' => ($this->konvertRp($request->m_psell2)),
        'm_psell3' => ($this->konvertRp($request->m_psell3)),
        'm_hpp' => ($this->konvertRp($request->m_psell4)),
        'm_barang_rusak' => ($this->konvertRp($request->m_psell5)),
        'm_pupdated' => Carbon::now()
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
}
