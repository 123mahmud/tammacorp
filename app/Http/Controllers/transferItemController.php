<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\d_transferItem;
use App\d_transferItemDt;
use DB;
use Validator;
use Carbon\Carbon;
use App\d_stock;
use App\d_stock_mutation;
use App\lib\mutasi;
use Auth;
use Response;
use DataTables;
use URL;

class transferItemController extends Controller
{
  public function noNota(){
              
    $buka = 'REQ';
    return json_encode($buka);
  }

  public function index(){
      return view('transfer.index');
  }

  public function dataTransfer(Request $request, $tgl1, $tgl2, $tampil){ 
    $term = $request->$tampil;

    $y = substr($tgl1, -4);
    $m = substr($tgl1, -7,-5);
    $d = substr($tgl1,0,2);
     $tgll = $y.'-'.$m.'-'.$d;

    $y2 = substr($tgl2, -4);
    $m2 = substr($tgl2, -7,-5);
    $d2 = substr($tgl2,0,2);
      $tgl2 = $y2.'-'.$m2.'-'.$d2; 

    if ($tampil == 'Semua') {
      $data = d_transferItem::where('ti_order',DB::raw("'RT'"))
        ->whereDate('ti_time','>=',$tgll)
        ->whereDate('ti_time','<=',$tgl2)
        ->get();
    }elseif ($tampil == 'Waiting') {
      $data = d_transferItem::where('ti_order',DB::raw("'RT'"))
        ->whereDate('ti_time','>=',$tgll)
        ->whereDate('ti_time','<=',$tgl2)
        ->where(function ($b) use ($term) {
                  $b->where('ti_isapproved','N')
                    ->where('ti_issent','N')
                    ->where('ti_isreceived','N');
              })
        ->get();
    }elseif ($tampil == 'Approved') {
      $data = d_transferItem::where('ti_order',DB::raw("'RT'"))
        ->whereDate('ti_time','>=',$tgll)
        ->whereDate('ti_time','<=',$tgl2)
        ->where(function ($b) use ($term) {
                  $b->where('ti_isapproved','Y')
                    ->where('ti_issent','N')
                    ->where('ti_isreceived','N');
              })
        ->get();
    }elseif ($tampil == 'Send') {
      $data = d_transferItem::where('ti_order',DB::raw("'RT'"))
      ->whereDate('ti_time','>=',$tgll)
      ->whereDate('ti_time','<=',$tgl2)
      ->where(function ($b) use ($term) {
                $b->where('ti_isapproved','Y')
                  ->where('ti_issent','Y')
                  ->where('ti_isreceived','N');
            })
      ->get();
    }elseif ($tampil == 'Received') {
      $data = d_transferItem::where('ti_order',DB::raw("'RT'"))
      ->whereDate('ti_time','>=',$tgll)
      ->whereDate('ti_time','<=',$tgl2)
      ->where(function ($b) use ($term) {
                $b->where('ti_isapproved','Y')
                  ->where('ti_issent','Y')
                  ->where('ti_isreceived','Y');
            })
      ->get();
    }

    return DataTables::of($data)

    ->editColumn('ti_time', function ($data) {
       return date('d M Y', strtotime($data->ti_time)) . ', ' . date('H:i:s', strtotime($data->ti_time));
    })
    
    ->addColumn('status', function($data){

      if($data->ti_isapproved=='N' &&  $data->ti_issent=='N' &&  $data->ti_isreceived=='N')
        return '<div class="text-center">
                  <span class="label label-red">Waiting</span>
                </div>';

      elseif($data->ti_isapproved=='Y' &&  $data->ti_issent=='N' &&  $data->ti_isreceived=='N')

        return '<div class="text-center">
                  <span class="label label-yellow">Approved</span>
                </div>';

      elseif($data->ti_isapproved=='Y' &&  $data->ti_issent=='Y' &&  $data->ti_isreceived=='N')

        return '<div class="text-center">
                  <span class="label label-blue">Send</span>
                </div>';

      elseif($data->ti_isapproved=='Y' &&  $data->ti_issent=='Y' &&  $data->ti_isreceived=='Y')

        return '<div class="text-center">
                  <span class="label label-success">Received</span>
                </div>';

      })

    ->addColumn('action', function($data){

      if($data->ti_isapproved=='N')

        return  '<div class="text-center">
                    <a onclick="editTransfer('.$data->ti_id.')"    
                        class="btn btn-warning btn-sm" 
                        title="Edit">
                        <i class="glyphicon glyphicon-pencil"></i>
                    </a>
                    <a  onclick="hapusTransfer('.$data->ti_id.')" 
                        class="btn btn-danger btn-sm"
                        id="hapus'.$data->ti_id.'" 
                        title="Hapus">
                        <i class="glyphicon glyphicon-trash"></i>
                    </a>
                </div>';
      else
        return  '<div class="text-center">
                    <a onclick="lihatTransfer('.$data->ti_id.')"    
                        class="btn btn-warning btn-sm" 
                        title="Edit">
                        <i class="fa fa-eye"></i>
                    </a>
                </div>';

      })
    ->rawColumns(['ti_time','status', 'action'])

    ->make(true);

  }
  
  public function simpanTransfer(Request $request){
    // dd($request->all());
    DB::beginTransaction();
      try {
      //no req
      $year = carbon::now()->format('y');
      $month = carbon::now()->format('m');
      $date = carbon::now()->format('d');

      $idreq = d_transferItem::select('ti_id')->max('ti_id');        
          if ($idreq <= 0 || $idreq <= '') {
            $idreq  = 1;
          }else{
            $idreq += 1;
          }                
      $idreq = 'REQ'  . $year . $month . $date . $idreq;
      //end no req
    	$ti_id = d_transferItem::max('ti_id')+1;
    	d_transferItem::create([
    				'ti_id'			=>$ti_id,
            'ti_date'   =>Carbon::now(),
    				'ti_time'		=>Carbon::now(), 
    				'ti_code'		=>$idreq, 
    				'ti_order'		=>'RT',
    				'ti_note'		=>$request->ri_keterangan,
    				
    	]);
    
    	for ($i=0; $i <count($request->kode_item) ; $i++) { 
    			$tidt_id=d_transferItemDt::where('tidt_id',$ti_id)->max('tidt_detail')+1;
    			 d_transferItemDt::create([
    				'tidt_id'			=>$ti_id,
    				'tidt_detail'		=>$tidt_id, 
    				'tidt_item'		=>$request->kode_item[$i], 
    				'tidt_qty'		=>$request->sd_qty[$i]
    			]);
    	}

    	DB::commit();
      return response()->json([
          'status' => 'sukses',
          'nota' => $idreq
        ]);
      } catch (\Exception $e) {
      DB::rollback();
      return response()->json([
        'status' => 'gagal',
        'data' => $e
        ]);
      }
  }

  public function lihatTransfer(Request $request, $id)
  {
      
      $transferItem=d_transferItem::where('ti_id',$id)->first();
      $transferItemDt=d_transferItemDt::
                      join('m_item','d_transferitem_dt.tidt_item','=','m_item.i_id')->
                      where('tidt_id',$id)->get();
                      

      return view('transfer.lihat-transfer',compact('transferItem','transferItemDt'));

  }

  public function editTransfer(Request $request,$id)
  {
      
      $transferItem=d_transferItem::where('ti_id',$id)->first();
      $transferItemDt=d_transferItemDt::
                      join('m_item','d_transferitem_dt.tidt_item','=','m_item.i_id')->
                      where('tidt_id',$id)->get();
                      

      return view('transfer.edit-transfer',compact('transferItem','transferItemDt'));

  }

  public function updateTransfer(Request $request)
  {
  	return DB::transaction(function () use ($request) {    		
  	$ti_id=d_transferItem::max('ti_id')+1;
  	d_transferItem::create([
  				'ti_id'			=>$ti_id,
  				'ti_time'		=>date('Y-m-d',strtotime($request->ri_tanggal)), 
  				'ti_code'		=>$request->ri_nomor, 
  				'ti_order'		=>'RT',
  				//'ti_orderstaff'	=>,
  				'ti_note'		=>$request->ri_keterangan,
  				
  	]);
  
  	for ($i=0; $i <count($request->kode_item) ; $i++) { 
  			$tidt_id=d_transferItemDt::where('tidt_id',$ti_id)->max('tidt_detail')+1;
  			 d_transferItemDt::create([
  				'tidt_id'			=>$ti_id,
  				'tidt_detail'		=>$tidt_id, 
  				'tidt_item'		=>$request->kode_item[$i], 
  				'tidt_qty'		=>$request->sd_qty[$i]
  			]);
  	}
     
  });

  }

  public function HapusTransfer($id){
    DB::beginTransaction();
      try {  
       d_transferItem::where('ti_id',$id)->delete();
       d_transferItemDt::where('tidt_id',$id)->delete();            
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

  public function indexPenerimaanTransfer(){

      return view('transfer.penerimaan.index');
  }

  public function dataPenerimaanTransfer(Request $request, $tgl3, $tgl4, $tampil1){
    $term = $tampil1;
    // dd($term);
    $y = substr($tgl3, -4);
    $m = substr($tgl3, -7,-5);
    $d = substr($tgl3,0,2);
      $tgl3 = $y.'-'.$m.'-'.$d;

    $y2 = substr($tgl4, -4);
    $m2 = substr($tgl4, -7,-5);
    $d2 = substr($tgl4,0,2);
      $tgl4 = $y2.'-'.$m2.'-'.$d2;

    if ($tampil1 == 'Semua') {
      $data = d_transferItem::where('ti_issent','Y')
        ->whereDate('ti_time','>=',$tgl3)
        ->whereDate('ti_time','<=',$tgl4)
        ->get();
    }elseif ($tampil1 == 'Send') {
      $data = d_transferItem::where('ti_issent','Y')
        ->whereDate('ti_time','>=',$tgl3)
        ->whereDate('ti_time','<=',$tgl4)
        ->where(function ($b) use ($term) {
                $b->where('ti_isapproved','Y')
                  ->where('ti_issent','Y')
                  ->where('ti_isreceived','N');
            })
        ->get();
    }elseif ($tampil1 == 'Received') {
      $data = d_transferItem::where('ti_issent','Y')
        ->whereDate('ti_time','>=',$tgl3)
        ->whereDate('ti_time','<=',$tgl4)
        ->where(function ($b) use ($term) {
                  $b->where('ti_isapproved','Y')
                    ->where('ti_issent','Y')
                    ->where('ti_isreceived','Y');
              })
        ->get();
    }
    
    return DataTables::of($data)

    ->editColumn('ti_time', function ($data) {
      return date('d M Y', strtotime($data->ti_time)) . ', ' . date('H:i:s', strtotime($data->ti_time));
    })
    
    ->addColumn('status', function($data){

      if($data->ti_isapproved=='Y' &&  $data->ti_issent=='Y' &&  $data->ti_isreceived=='N')

        return  '<div class="text-center">
                    <span class="label label-blue">Send</span>
                </div>';

      elseif($data->ti_isapproved=='Y' &&  $data->ti_issent=='Y' &&  $data->ti_isreceived=='Y')

        return  '<div class="text-center">
                    <span class="label label-success">Received</span>
                </div>';

      })

    ->addColumn('action', function($data){

      if($data->ti_isapproved=='Y' &&  $data->ti_issent=='Y' &&  $data->ti_isreceived=='N')

        return '<div class="text-center">
                  <a  onclick="lihatPenerimaan('.$data->ti_id.')" 
                      class="btn btn-warning btn-sm" 
                      title="Penerimaan Barang">
                      <i class="fa fa-chevron-circle-down">
                      </i> &nbsp;Terima
                  </a>
                </div>';

      else

        return '<div class="text-center">
                  <a  onclick="lihatRC('.$data->ti_id.')" 
                      class="btn btn-warning btn-sm" 
                      title="Lihat Penerimaan">
                      <i class="fa fa-eye"></i> &nbsp;Terima
                  </a>
                </div>';


      })
    ->rawColumns(['ti_time','status', 'action'])

    ->make(true);    

  }

  public function lihatPenerimaan($id){
      $transferItem = d_transferItem::where('ti_id',$id)->first();
      $transferItemDt = d_transferItemDt::
                      join('m_item','d_transferitem_dt.tidt_item','=','m_item.i_id')->
                      leftjoin('d_stock',function($join){
                      $join->on('i_id', '=', 's_item');        
                      $join->on('s_comp', '=', 's_position');                
                      $join->on('s_comp', '=',DB::raw("'1'"));           
                      })
                      ->where('tidt_id',$id)
                      ->get();
      return view('transfer.penerimaan.penerimaan-transfer',compact('transferItem','transferItemDt'));
  }

public function simpaPenerimaan(Request $request){
  // dd($request->all());
  DB::beginTransaction();
    try {   
    $transferItem = d_transferItem::where('ti_id',$request->ti_id)
      ->first();
    $transferItem->update([
                  'ti_isreceived'=>'Y'
                  ]);

    $tidt_item = $request->tidt_item;
    $s_id = d_stock::select('s_id')->max('s_id');

    for ($i=0; $i <count($tidt_item) ; $i++) { 
      d_transferItemDt::where('tidt_id',$request->tidt_id[$i])
        ->where('tidt_item',$tidt_item[$i])
        ->update([
          'tidt_qty_received' => $request->qtyRecieved[$i],
          'tidt_receivedtime' => Carbon::now()
        ]);
      $stock = d_stock::where('s_item',$tidt_item[$i])
             ->where('s_comp',DB::raw('1'))
             ->where('s_position',DB::raw('1'));
      
      if(mutasi::mutasiStok(  $request->tidt_item[$i],
                              $request->qtyRecieved[$i],
                              $comp=1,
                              $position=5,
                              $flag=10,
                              $request->ri_nomor)){}

      if($stock->first()){
        $stock->update([
            's_qty'=>$stock->first()->s_qty+$request->qtyRecieved[$i]
        ]);

        $getItem = d_stock::join('d_stock_mutation','sm_stock', '=', 's_id')
            ->select( 's_id')
            ->where('s_item',$tidt_item[$i])
            ->get();

        $sm_detailid = d_stock_mutation::select('sm_detailid')
          ->where('sm_item',$request->tidt_item[$i])
          ->max('sm_detailid')+1;

        d_stock_mutation::create([
              'sm_stock' => $getItem[$i]->s_id,
              'sm_detailid' =>$sm_detailid,
              'sm_date' => Carbon::now(),
              'sm_comp' => 1,
              'sm_position' => 1,
              'sm_mutcat' => 9,
              'sm_item' => $request->tidt_item[$i],
              'sm_qty' => $request->qtyRecieved[$i],
              'sm_qty_used' => 0,
              'sm_qty_sisa' => $request->qtyRecieved[$i],
              'sm_qty_expired' => 0,
              'sm_detail' => 'PENAMBAHAN',
              'sm_reff' => $request->ri_nomor,
              'sm_insert' => Carbon::now()
        ]);

      }else{

        $s_id=d_stock::max('s_id');
        d_stock::create([
                's_id'      =>$s_id+1,
                's_comp'    =>1,
                's_position' =>1,
                's_item'    =>$request->tidt_item[$i],
                's_qty'     =>$request->qtyRecieved[$i],
        ]);

        d_stock_mutation::create([
              'sm_stock' => $s_id+1,
              'sm_detailid' =>$i+1,
              'sm_date' => Carbon::now(),
              'sm_comp' => 1,
              'sm_position' => 1,
              'sm_mutcat' => 9,
              'sm_item' => $request->tidt_item[$i],
              'sm_qty' => $request->qtyRecieved[$i],
              'sm_qty_used' => 0,
              'sm_qty_sisa' => $request->qtyRecieved[$i],
              'sm_qty_expired' => 0,
              'sm_detail' => 'PENAMBAHAN',
              'sm_reff' => $request->ri_nomor,
              'sm_insert' => Carbon::now()
        ]);
      }
    }
    
    $transferItem=d_transferItem::where('ti_id',$request->ti_id);
    $transferItem->update([
                'ti_isreceived'=>'Y'
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

  public function data(){
      return DB::transaction(function () {
     
        $getBarang=d_stock_mutation::where('sm_qty_sisa','>',0)->get();
            $totalPermintaan = 35;
                    for ($k = 0; $k < count($getBarang); $k++) {
                        $totalQty = $getBarang[$k]->sm_qty_sisa;
                        if ($totalPermintaan <= $totalQty) {
                            $total[$k]['detailid'] = $getBarang[$k]->sm_detailid;
                            $total[$k]['jumlah'] = $totalPermintaan;
                            $total[$k]['hpp'] = $getBarang[$k]->sm_hpp;
                            $k = count($getBarang);
                        } elseif ($totalPermintaan > $totalQty) {
                            $total[$k]['detailid'] = $getBarang[$k]->sm_detailid;
                            $total[$k]['jumlah'] = $totalQty;
                            $total[$k]['hpp'] = $getBarang[$k]->sm_hpp;
                            $totalPermintaan = $totalPermintaan - $totalQty;
                        }
                    } 
      });
  }

  public function UpdateTransferGrosir(Request $request,$id){
    DB::beginTransaction();
    try {
    d_transferItem::where('ti_id',$id)
      ->update([
        'ti_note' => $request->ri_keterangan
      ]);

    d_transferItemDt::where('tidt_id',$id)->delete();
    for ($i=0; $i < count($request->kode_item); $i++) { 

      d_transferItemDt::insert([
            'tidt_id' => $id,
            'tidt_detail' => $i+1,
            'tidt_item' => $request->kode_item[$i],
            'tidt_qty' => $request->sd_qty[$i]
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

  public function lihatPenerimaanRc($id){
    $transferItem = d_transferItem::where('ti_id',$id)->first();
    $transferItemDt = d_transferItemDt::
                    join('m_item','d_transferitem_dt.tidt_item','=','m_item.i_id')->
                    leftjoin('d_stock',function($join){
                    $join->on('i_id', '=', 's_item');        
                    $join->on('s_comp', '=', 's_position');                
                    $join->on('s_comp', '=',DB::raw("'1'"));           
                    })
                    ->where('tidt_id',$id)
                    ->get();
    
    return view('transfer.penerimaan.table-received', compact('transferItem','transferItemDt'));
  }

}
