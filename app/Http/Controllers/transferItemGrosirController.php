<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\d_transferItem;
use App\d_transferItemDt;
use App\d_stock_mutation;
use App\lib\mutasi;
use DB;
use Validator;
use Carbon\Carbon;
use App\d_stock;
use Auth;
use Response;
use DataTables;
use URL;

class transferItemGrosirController extends Controller
{
    
  public function indexGrosir(){

    return view('transfer-grosir.index-grosir');

  }

  public function dataTransferAppr(Request $request, $tgl1, $tgl2, $tampil){ 
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
      $data = d_transferItem::whereDate('ti_time','>=',$tgll)
        ->whereDate('ti_time','<=',$tgl2)
        ->get();
    }elseif ($tampil == 'Waiting') {
       $data = d_transferItem::whereDate('ti_time','>=',$tgll)
        ->whereDate('ti_time','<=',$tgl2)
        ->where(function ($b) use ($term) {
                  $b->where('ti_isapproved','N')
                    ->where('ti_issent','N')
                    ->where('ti_isreceived','N');
              })
        ->get();
    }elseif ($tampil == 'Approved') {
       $data = d_transferItem::whereDate('ti_time','>=',$tgll)
        ->whereDate('ti_time','<=',$tgl2)
        ->where(function ($b) use ($term) {
                  $b->where('ti_isapproved','Y')
                    ->where('ti_issent','N')
                    ->where('ti_isreceived','N');
              })
        ->get();
    }elseif ($tampil == 'Send') {
       $data = d_transferItem::whereDate('ti_time','>=',$tgll)
        ->whereDate('ti_time','<=',$tgl2)
        ->where(function ($b) use ($term) {
                  $b->where('ti_isapproved','Y')
                    ->where('ti_issent','Y')
                    ->where('ti_isreceived','N');
              })
        ->get();
    }elseif ($tampil == 'Received') {
       $data = d_transferItem::whereDate('ti_time','>=',$tgll)
        ->whereDate('ti_time','<=',$tgl2)
        ->where(function ($b) use ($term) {
                  $b->where('ti_isapproved','Y')
                    ->where('ti_issent','Y')
                    ->where('ti_isreceived','Y');
              })
        ->get();
    }
    

    return DataTables::of($data)

    ->editColumn('ti_time', function ($user) {
                return date('d M Y', strtotime($user->ti_time)) . ', ' . date('H:i:s', strtotime($user->ti_time));
            })
    
    ->addColumn('status', function($data){

      if($data->ti_isapproved=='N' &&  $data->ti_issent=='N' &&  $data->ti_isreceived=='N')

        return  '<div class="text-center">
                    <span class="label label-red">Waiting</span>
                </div>';

      elseif($data->ti_isapproved=='Y' &&  $data->ti_issent=='N' &&  $data->ti_isreceived=='N')

        return  '<div class="text-center">
                    <span class="label label-yellow">Approved</span>
                </div>';

      elseif($data->ti_isapproved=='Y' &&  $data->ti_issent=='Y' &&  $data->ti_isreceived=='N')

        return  '<div class="text-center">
                    <span class="label label-blue">Send</span>
                </div>';

      elseif($data->ti_isapproved=='Y' &&  $data->ti_issent=='Y' &&  $data->ti_isreceived=='Y')

        return  '<div class="text-center">
                    <span class="label label-success">Received</span>
                </div>';

      })

    ->addColumn('action', function($data){

      if($data->ti_isapproved=='N')

        if($data->ti_isapproved=='Y' &&  $data->ti_issent=='Y' &&  $data->ti_isreceived=='Y')

        return '<div class="text-center">
                  <a  onclick="edit('.$data->ti_id.')"    
                      class="btn btn-warning btn-sm" 
                      title="Setujui">
                      <i class="fa fa-eye"></i>
                      Lihat
                  </a>
                </div>'; 

        else 

        return '<div class="text-center">
                  <a  onclick="edit('.$data->ti_id.')"    
                      class="btn btn-warning btn-sm" 
                      title="Setujui">
                      <i class="fa fa-check-circle-o"></i> 
                      Setujui & Kirim
                  </a> 
                </div>';                   

      })
    ->rawColumns(['ti_time', 'status', 'action'])

    ->make(true);

  }

  public function grosirTransfer(){        
      $transferItem=d_transferItem::paginate();
      return view('transfer-grosir.grosir-transfer',compact('transferItem'));
  }
  public function approveTransfer($id){

      $transferItem=d_transferItem::where('ti_id',$id)->first();
      $transferItemDt=d_transferItemDt::
                      join('m_item','d_transferitem_dt.tidt_item','=','m_item.i_id')->
                      leftjoin('d_stock',function($join){
                      $join->on('i_id', '=', 's_item');        
                      $join->on('s_comp', '=', 's_position');                
                      $join->on('s_comp', '=',DB::raw("'2'"));           
                      })->  
                      where('tidt_id',$id)->get();
  /*dd($transferItemDt);*/
      return view('transfer-grosir.approve-transfer',compact('transferItem','transferItemDt'));
  }

  public function simpanApprove(Request $request){
    // dd($request->all());
  DB::beginTransaction();
    try {  
    $tglAppr='';
    $tglSend='';
    $ttlAppr=0;
    $ttlSend=0;
    $isAppr='N';
    $isSend='N';
    for ($i=0; $i <count($request->tidt_id) ; $i++) {                 
   	 $qtyAwal=0;
        if($request->qtyAppr[$i]!='' || $request->qtyAppr[$i]!='0' && $request->qtyAppr[$i]!='' || $request->qtyAppr[$i]!=null){
                $tglAppr=date('Y-m-d g:i:s');
                $ttlAppr++;
                
            }
        if($request->qtySend[$i]!='' || $request->qtySend[$i]!='0' && $request->qtySend[$i]!='' || $request->qtySend[$i]!=null){
                $tglSend=date('Y-m-d g:i:s');
                $ttlSend++;
                
            }
    
        $transferItemDt = d_transferItemDt::where('tidt_id',$request->tidt_id[$i])
                        ->where('tidt_detail',$request->tidt_detail[$i]);
        if($transferItemDt->first()){
            $qtyAwal=$transferItemDt->first()->tidt_qty_send;
        }

        $transferItemDt->update([
            'tidt_qty_appr'=>$request->qtyAppr[$i],
            'tidt_apprtime'=>$tglAppr,
            'tidt_qty_send'=>$request->qtySend[$i],
            'tidt_sendtime'=>$tglSend,
        ]);


        //update qty grosir 3/3
        $stockGrosir = d_stock::where('s_item',$request->tidt_item[$i])
             ->where('s_comp',DB::raw('1'))
             ->where('s_position',DB::raw('5'))
             ->first();
        // dd($stockGrosir);

        if(mutasi::mutasiStok(  $request->tidt_item[$i],
                                $request->qtySend[$i],
                                $comp=2,
                                $position=2,
                                $flag=11,
                                $request->ri_nomor)){}
               
        if($stockGrosir == null){
            $s_id = d_stock::max('s_id')+1;
            d_stock::create([
                    's_id'      =>$s_id,
                    's_comp'    =>1,
                    's_position' =>5,
                    's_item'    =>$request->tidt_item[$i],
                    's_qty'     =>$request->qtySend[$i],

            ]);

            d_stock_mutation::create([
                'sm_stock' => $s_id,
                'sm_detailid' =>1,
                'sm_date' => Carbon::now(),
                'sm_comp' => 1,
                'sm_position' => 5,
                'sm_mutcat' => 1,
                'sm_item' => $request->tidt_item[$i],
                'sm_qty' => $request->qtySend[$i],
                'sm_qty_used' => 0,
                'sm_qty_sisa' => $request->qtySend[$i],
                'sm_qty_expired' => 0,
                'sm_detail' => 'TRANSFER RETAIL',
                'sm_reff' => $request->ri_nomor,
                'sm_insert' => Carbon::now()
              ]);

      }else{
        
        $hasil = $stockGrosir->s_qty + $request->qtySend[$i];
              $stockGrosir->update([
                's_qty'     => $hasil
              ]);
            
        $sm_detailid = d_stock_mutation::select('sm_detailid')
                ->where('sm_item',$request->tidt_item[$i])
                ->where('sm_comp','1')
                ->where('sm_position','5')
                ->max('sm_detailid')+1;

              d_stock_mutation::create([
                'sm_stock' => $stockGrosir->s_id,
                'sm_detailid' => $sm_detailid,
                'sm_date' => Carbon::now(),
                'sm_comp' => 1,
                'sm_position' => 5,
                'sm_mutcat' => 1,
                'sm_item' => $request->tidt_item[$i],
                'sm_qty' => $request->qtySend[$i],
                'sm_qty_used' => 0,
                'sm_qty_sisa' => $request->qtySend[$i],
                'sm_qty_expired' => 0,
                'sm_detail' => 'TRANSFER RETAIL',
                'sm_reff' => $request->ri_nomor,
                'sm_insert' => Carbon::now()
              ]);

      }
    }

      if(count($request->tidt_id)==$ttlAppr){
          $isAppr='Y';

      }
      if(count($request->tidt_id)==$ttlSend){
          $isSend='Y';
      }
      $transferItem=d_transferItem::where('ti_id',$request->tidt_id);

      $transferItem->update([
                    'ti_isapproved'=>$isAppr,
                    'ti_issent'=>$isSend
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

  public function simpanTransferGrosir(Request $request){
    // dd($request->all());
  DB::beginTransaction();
      try {
      //set no req
      $year = carbon::now()->format('y');
      $month = carbon::now()->format('m');
      $date = carbon::now()->format('d');

      $ti_id = d_transferItem::max('ti_id')+1;     

      $idreq = 'REQ'  . $year . $month . $date . $ti_id;
      //end no req

    d_transferItem::create([
                'ti_id'         =>$ti_id,
                'ti_time'       =>Carbon::now(), 
                'ti_code'       =>$idreq, 
                'ti_order'      =>'GR',
                'ti_note'       =>$request->tf_keterangan,
                'ti_isapproved' =>'Y',
                'ti_issent' =>'Y',
    ]);

    for ($i=0; $i <count($request->kode_item) ; $i++) { 
      $tidt_id=d_transferItemDt::where('tidt_id',$ti_id)->max('tidt_detail')+1;
       d_transferItemDt::create([
          'tidt_id'      =>$ti_id,
          'tidt_detail'  =>$tidt_id, 
          'tidt_item'    =>$request->kode_item[$i], 
          'tidt_qty'     =>$request->sd_qty[$i],
          'tidt_qty_appr'=>$request->sd_qty[$i],
          'tidt_apprtime'=>Carbon::now(),
          'tidt_qty_send'=>$request->sd_qty[$i],
          'tidt_sendtime'=>Carbon::now(),
      ]);

       //stock 11/3
      $stockGrosir = d_stock::where('s_item',$request->kode_item[$i])
             ->where('s_comp',DB::raw('1'))
             ->where('s_position',DB::raw('5'))
             ->first();
      // dd($stockGrosir);

      if(mutasi::mutasiStok(  $request->kode_item[$i],
                              $request->sd_qty[$i],
                              $comp=2,
                              $position=2,
                              $flag=11,
                              $idreq)){}
             
      if($stockGrosir == null){
            $s_id = d_stock::max('s_id')+1;
            d_stock::create([
                    's_id'      =>$s_id,
                    's_comp'    =>1,
                    's_position' =>5,
                    's_item'    =>$request->kode_item[$i],
                    's_qty'     =>$request->sd_qty[$i],

            ]);

            d_stock_mutation::create([
                'sm_stock' => $s_id,
                'sm_detailid' =>1,
                'sm_date' => Carbon::now(),
                'sm_comp' => 1,
                'sm_position' => 5,
                'sm_mutcat' => 1,
                'sm_item' => $request->kode_item[$i],
                'sm_qty' => $request->sd_qty[$i],
                'sm_qty_used' => 0,
                'sm_qty_sisa' => $request->sd_qty[$i],
                'sm_qty_expired' => 0,
                'sm_detail' => 'TRANSFER RETAIL',
                'sm_reff' => $idreq,
                'sm_insert' => Carbon::now()
              ]);

      }else{

        $hasil = $stockGrosir->s_qty + $request->sd_qty[$i];
              $stockGrosir->update([
                's_qty'     => $hasil
              ]);
            
        $sm_detailid = d_stock_mutation::select('sm_detailid')
                ->where('sm_item',$request->kode_item[$i])
                ->where('sm_comp','1')
                ->where('sm_position','5')
                ->max('sm_detailid')+1;

              d_stock_mutation::create([
                'sm_stock' => $stockGrosir->s_id,
                'sm_detailid' => $sm_detailid,
                'sm_date' => Carbon::now(),
                'sm_comp' => 1,
                'sm_position' => 5,
                'sm_mutcat' => 1,
                'sm_item' => $request->kode_item[$i],
                'sm_qty' => $request->sd_qty[$i],
                'sm_qty_used' => 0,
                'sm_qty_sisa' => $request->sd_qty[$i],
                'sm_qty_expired' => 0,
                'sm_detail' => 'TRANSFER RETAIL',
                'sm_reff' => $idreq,
                'sm_insert' => Carbon::now()
              ]);

      }
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

   public function dataTransferGrosir(Request $request, $tgl3, $tgl4, $tampil1){  
    $term = $request->$tampil1;

    $y = substr($tgl3, -4);
    $m = substr($tgl3, -7,-5);
    $d = substr($tgl3,0,2);
      $tgl3 = $y.'-'.$m.'-'.$d;

    $y2 = substr($tgl4, -4);
    $m2 = substr($tgl4, -7,-5);
    $d2 = substr($tgl4,0,2);
      $tgl4 = $y2.'-'.$m2.'-'.$d2;

    if ($tampil1 == 'Semua') {
      $data = d_transferItem::
        whereDate('ti_time','>=',$tgl3)
        ->whereDate('ti_time','<=',$tgl4)
        ->get();

    }elseif ($tampil1 == 'Send') {
      $data = d_transferItem::
        where(function ($b) use ($term) {
                  $b->where('ti_isapproved','Y')
                    ->where('ti_issent','Y')
                    ->where('ti_isreceived','N');
        })
        ->whereDate('ti_time','>=',$tgl3)
        ->whereDate('ti_time','<=',$tgl4)
        ->get();
    }elseif ($tampil1 == 'Received') {
      $data = d_transferItem::
        where(function ($b) use ($term) {
                  $b->where('ti_isapproved','Y')
                    ->where('ti_issent','Y')
                    ->where('ti_isreceived','Y');
        })
        ->whereDate('ti_time','>=',$tgl3)
        ->whereDate('ti_time','<=',$tgl4)
        ->get();
      }

    
    return DataTables::of($data)

    // ->editColumn('ti_date', function ($data) {
    //   return date('d M Y', strtotime($data->ti_date));
    // })

    ->editColumn('ti_time', function ($user) {
                return date('d M Y', strtotime($user->ti_time)) . ', ' . date('H:i:s', strtotime($user->ti_time));
            })
    
    ->addColumn('status', function($data){

        if($data->ti_isapproved=='Y' &&  $data->ti_issent=='Y' &&  $data->ti_isreceived=='N')

          return '<div class="text-center">
                    <span class="label label-blue">Send</span>
                  </div>';

        elseif($data->ti_isapproved=='Y' &&  $data->ti_issent=='Y' &&  $data->ti_isreceived=='Y')

          return '<div class="text-center">
                    <span class="label label-success">Received</span>
                  </div>';

      })

    ->addColumn('action', function($data){
      return '<div class="text-center">
                <a  onclick="editTransferGrosir('.$data->ti_id.')" 
                    class="btn btn-warning btn-sm" 
                    title="Lihat">
                    <i class="fa fa-eye"></i>
                </a>
              </div>';                  

    })

    ->rawColumns(['ti_time','status', 'action'])

    ->make(true);     

      // return view('transfer-grosir.data-transfer-grosir',compact('transferItem'));
  }

  public function EditTransferGrosir($id){
      $transferItem=d_transferItem::where('ti_id',$id)->first();
      $transferItemDt=d_transferItemDt::
                      join('m_item','d_transferitem_dt.tidt_item','=','m_item.i_id')->
                      where('tidt_id',$id)->get();
      return view('transfer-grosir.edit-transfer-grosir',compact('transferItem','transferItemDt'));
  }


    public function UpdateTransferGrosir(Request $request,$id){
      return DB::transaction(function () use ($request,$id) {
       $qtyAwal=0;
      $transferItem=d_transferItem::where('ti_id',$id);
      $transferItem->update([                                                                                
                  'ti_note'       =>$request->ri_keterangan,
      ]);

      for ($i=0; $i <count($request->kode_item) ; $i++) { 
          if($request->tidt_id[$i]==''){
              $tidt_id=d_transferItemDt::where('tidt_id',$id)->max('tidt_detail')+1;
               d_transferItemDt::create([
                  'tidt_id'           =>$id,
                  'tidt_detail'       =>$tidt_id, 
                  'tidt_item'     =>$request->kode_item[$i], 
                  'tidt_qty'      =>$request->sd_qty[$i],

                  'tidt_qty_appr'=>$request->sd_qty[$i],
                  'tidt_apprtime'=>date('Y-m-d g:i:s'),
                  'tidt_qty_send'=>$request->sd_qty[$i],
                  'tidt_sendtime'=>date('Y-m-d g:i:s'),
              ]);
               //stock 3/3
              $stockGrosir=d_stock::                        
                     where('s_item',$request->kode_item[$i])->
                     where('s_comp',DB::raw('2'))->
                     where('s_position',DB::raw('2'));

              if($stockGrosir->first()){
                          $stockGrosir->update([
                              's_qty'=>$stockGrosir->first()->s_qty-$request->qtySend[$i]
                          ]);
              }else{
                          DB::rollback();
                          $data=['status'=>'Gagal','info'=>'Stok Tidak Mencukupi'];
                          return json_encode($data);
              }



               //stock 11/3
              $stockRetailInGrosir=d_stock::                        
                     where('s_item',$request->tidt_item[$i])->
                     where('s_comp',DB::raw('1'))->
                     where('s_position',DB::raw('2'));
                     
              if($stockRetailInGrosir->first()){
                          $stockRetailInGrosir->update([
                              's_qty'=>$stockRetailInGrosir->first()->s_qty+$request->qtySend[$i]
                          ]);
                  }else{
                          $s_id=d_stock::max('s_id');
                          d_stock::create([
                                  's_id'      =>$s_id+1,
                                  's_comp'    =>1,
                                  's_position' =>2,
                                  's_item'    =>$request->tidt_item[$i],
                                  's_qty'     =>$request->qtySend[$i],

                          ]);
                  }






          }else if($request->tidt_id[$i]!='') {
              $transferItemDt=d_transferItemDt::where('tidt_id',$id)->where('tidt_detail',$request->tidt_detail[$i]);
              if($transferItemDt->first()){
                  $qtyAwal=$transferItemDt->first()->tidt_qty_send;
              }
               $transferItemDt->update([                                        
                  'tidt_qty'      =>$request->sd_qty[$i],
                  'tidt_qty_appr'=>$request->sd_qty[$i],
                  'tidt_apprtime'=>date('Y-m-d g:i:s'),
                  'tidt_qty_send'=>$request->sd_qty[$i],
                  'tidt_sendtime'=>date('Y-m-d g:i:s'),
              ]);


             
                //stock 3/3
              $stockGrosir=d_stock::                        
                     where('s_item',$request->kode_item[$i])->
                     where('s_comp',DB::raw('2'))->
                     where('s_position',DB::raw('2'));

              if($stockGrosir->first()){
                          $stockGrosir->update([
                              's_qty'=>($stockGrosir->first()->s_qty+$qtyAwal)-$request->qtySend[$i]
                          ]);
              }else{
                          DB::rollback();
                          $data=['status'=>'Gagal','info'=>'Stok Tidak Mencukupi'];
                          return json_encode($data);
              }


                 //stock 11/3
              $stockRetailInGrosir=d_stock::                        
                     where('s_item',$request->tidt_item[$i])->
                     where('s_comp',DB::raw('1'))->
                     where('s_position',DB::raw('2'));
                     
              if($stockRetailInGrosir->first()){
                          $stockRetailInGrosir->update([
                              's_qty'=>($stockRetailInGrosir->first()->s_qty-$qtyAwal)+$request->qtySend[$i]
                          ]);
                  }else{
                          $s_id=d_stock::max('s_id');
                          d_stock::create([
                                  's_id'      =>$s_id+1,
                                  's_comp'    =>1,
                                  's_position' =>2,
                                  's_item'    =>$request->tidt_item[$i],
                                  's_qty'     =>$request->qtySend[$i],

                          ]);
                  }




          }
      }
  /*dd($request->all());*/
      $data=['status'=>'sukses'];     
      return json_encode($data);
     
  });
  }

     public function HapusTransferGrosir($id){
      return DB::transaction(function () use ($id) {
           $transferItem=d_transferItem::where('ti_id',$id);             
           if($transferItem->first()->ti_isreceived=='Y'){
                  $data=['status'=>'Gagal','info'=>'Maaf, Transfer Item Telah di Terima'];
                  return json_encode($data);
           }else{
                $transferItem->delete();
                $data=['status'=>'sukses'];
              return json_encode($data);
           }
           
      });
  }


    public function print_setuju($id)
    {
        $query = DB::table('d_transferitem_dt')
        ->select('i_name', 'tidt_qty', 'tidt_qty_appr')
        ->join('m_item', 'm_item.i_id', '=', 'd_transferitem_dt.tidt_item')
        ->join('d_transferitem', 'd_transferitem.ti_id', '=', 'd_transferitem_dt.tidt_id')
        ->where('ti_code', $id)
        ->get()
        ->toArray()
        ;

        $query_chunk = array_chunk($query, 20);
        // return $query_chunk;

      

      

        return view('transfer-grosir.print.print_persetujuan', compact('query_chunk'));
    }

}
