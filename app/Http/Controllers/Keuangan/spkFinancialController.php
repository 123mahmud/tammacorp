<?php

namespace App\Http\Controllers\Keuangan;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\d_formula;
use App\d_formula_result;
use App\spk_formula;
use App\m_item;
use App\d_stock;
use App\d_stock_mutation;
use App\d_productplan;
use DataTables;
use App\d_spk;
use App\lib\mutasi;

class spkFinancialController extends Controller
{

  public function spk()
  {
    return view('/keuangan/spk/index');
  }

  public function getDataTabelIndex()
  {
    $productplan =DB::table('d_productplan')
                  ->join('m_item','pp_item','=','i_id')
                  ->where('pp_isspk','N')
                  ->orderBy('pp_date','ASC')
                  ->get();
    // dd($spk);
    json_encode($productplan);
    return DataTables::of($productplan)
    ->addIndexColumn()
    ->addColumn('action', function($data){
        return '<div class="text-center">
                  <button class="btn btn-warning btn-sm"
                          title="Buat SPK"
                          onclick=BuatSpk("'.$data->pp_id.'","'.date('d-m-Y',strtotime($data->pp_date)).'","'.$data->pp_qty.'","'.$data->pp_item.'")>
                          <i class="fa fa-plus"></i>
                  </button>
              </div>';
    })

    ->editColumn('pp_date', function ($user) {
      return $user->pp_date ? with(new Carbon($user->pp_date))->format('d M Y') : '';
    })

    ->rawColumns(['action'])
    ->make(true);
  }

  public function getDataTabelSpk($tgl1,$tgl2,$tampil="semua"){
    $y = substr($tgl1, -4);
    $m = substr($tgl1, -7,-5);
    $d = substr($tgl1,0,2);
     $tanggal1 = $y.'-'.$m.'-'.$d;

    $y2 = substr($tgl2, -4);
    $m2 = substr($tgl2, -7,-5);
    $d2 = substr($tgl2,0,2);
      $tanggal2 = $y2.'-'.$m2.'-'.$d2;

    if ($tampil == 'semua') {
      $spk = d_spk::join('m_item','spk_item','=','i_id')
                  ->join('d_productplan','pp_id','=','spk_ref')
                  ->select('spk_id', 'spk_date','i_name','pp_qty','spk_code','spk_status','pp_item')
                  ->whereBetween('spk_date', [$tanggal1, $tanggal2])
                  ->orderBy('spk_date', 'DESC')
                  ->get();
    }elseif ($tampil == 'draft') {
      $spk = d_spk::join('m_item','spk_item','=','i_id')
                  ->join('d_productplan','pp_id','=','spk_ref')
                  ->select('spk_id', 'spk_date','i_name','pp_qty','spk_code','spk_status','pp_item')
                  ->where('spk_status', '=', 'DR')
                  ->whereBetween('spk_date', [$tanggal1, $tanggal2])
                  ->orderBy('spk_date', 'DESC')
                  ->get();
    }elseif ($tampil == 'progress') {
      $spk = d_spk::join('m_item','spk_item','=','i_id')
                  ->join('d_productplan','pp_id','=','spk_ref')
                  ->select('spk_id', 'spk_date','i_name','pp_qty','spk_code','spk_status','pp_item')
                  ->where('spk_status', '=', 'FN')
                  ->whereBetween('spk_date', [$tanggal1, $tanggal2])
                  ->orderBy('spk_date', 'DESC')
                  ->get();
    }else{
      $spk = d_spk::join('m_item','spk_item','=','i_id')
                  ->join('d_productplan','pp_id','=','spk_ref')
                  ->select('spk_id', 'spk_date','i_name','pp_qty','spk_code','spk_status','pp_item')
                  ->where('spk_status', '=', 'CL')
                  ->whereBetween('spk_date', [$tanggal1, $tanggal2])
                  ->orderBy('spk_date', 'DESC')
                  ->get();
    }

    return DataTables::of($spk)
    ->addIndexColumn()
    ->editColumn('status', function ($data) {
      if ($data->spk_status == "DR") {
        return '<span class="label label-warning">Draft</span>';
      }elseif ($data->spk_status == "AP") {
        return '<span class="label label-info">di Setujui</span>';
      } elseif ($data->spk_status == "PB") {
        return '<span class="label label-warning">Proses</span>';
      } elseif ($data->spk_status == "FN") {
        return '<span class="label label-success">Selesai</span>';
      }
    })
    ->addColumn('action', function($data){
        if ($data->spk_status == 'AP') {
          return '<div class="text-center">
                      <button class="btn btn-sm btn-success"
                              title="Detail"
                              type="button"
                              data-toggle="modal"
                              data-target="#myModalView"
                              onclick=detailManSpk("'.$data->spk_id.'")>
                              <i class="fa fa-eye"></i>
                      </button>
                  </div>';
        }elseif ($data->spk_status == 'FN') {
          return '<div class="text-center">
                      <button class="btn btn-sm btn-success"
                              title="Detail"
                              type="button"
                              data-toggle="modal"
                              data-target="#myModalView"
                              onclick=detailManSpk("'.$data->spk_id.'")>
                              <i class="fa fa-eye"></i>
                      </button>
                  </div>';
        }else{
          return '<div class="text-center">
                      <button class="btn btn-sm btn-warning"
                              title="Edit Bahan"
                              onclick=editSpk("'.$data->spk_id.'")>
                              <i class="glyphicon glyphicon-edit"></i>
                      </button>
                  </div>';
        }

      })
    ->editColumn('spk_date', function ($user) {
      return $user->spk_date ? with(new Carbon($user->spk_date))->format('d M Y') : '';
    })
    ->rawColumns(['status', 'action'])
    ->make(true);
  }

  public function spkCreateId(){
    $year = carbon::now()->format('y');
    $month = carbon::now()->format('m');
    $date = carbon::now()->format('d');

    $idSpk = d_spk::max('spk_id');
      if ($idSpk <= 0 || $idSpk <= '') {
        $idSpk  = 1;
      }else{
        $idSpk += 1;
      }
    $idSpk = 'SPK'  . $year . $month . $date . $idSpk;

    $data=[ 'status'=>'sukses',
            'id_spk'=>$idSpk
          ];
    return json_encode($data);
  }


  public function ubahStatusSpk($spk_id)
  {
    //get recent status SPK
    $recentStatusSpk = d_spk::all();
    $spk = d_spk::find($spk_id);

    if ($spk->spk_status == "FN")
    {
        //update status to CL
        $spk = d_spk::find($spk_id);
        $spk->spk_status = 'CL';
        $spk->save();
    }
    else
    {
        //update status to FN
        $spk = d_spk::find($spk_id);
        $spk->spk_status = 'FN';
        $spk->save();
    }

    return response()->json([
        'status' => 'sukses',
        'pesan' => 'Status SPK telah berhasil diubah',
    ]);
  }

  public function tabelFormula( $id, $qty){

    $hasil = d_formula_result::
        where('fr_adonan',$id)
        ->first();

    $x = $hasil->fr_result;

    $butuh = $qty / $x;

    $formula = d_formula::
        select( 'i_id',
                'i_name',
                'f_bb',
                'f_value',
                'f_scale',
                'm_sname',
                'i_sat1',
                DB::raw('(f_value * '.$butuh.') as butuh'),
                DB::raw('coalesce(s_qty, 0) as s_qty'))
        ->join('m_item','m_item.i_id','=','d_formula.f_bb')
        ->join('d_formula_result','d_formula_result.fr_id','=','f_id')
        ->join('m_satuan','m_sid','=','f_scale')
        ->leftJoin('d_stock', function($q){
          $q->on('s_item', '=', 'i_id');
          $q->on('s_item', '=', 'f_bb');
          $q->on('s_comp', '=', DB::raw('3'));
          $q->on('s_position', '=', DB::raw('3'));
        })
        ->where('fr_adonan','=',$id)
        ->get();

    return DataTables::of($formula)
    ->editColumn('f_bb', function ($data) {
      return '<input  readonly
                      class="form-control"
                      value="'.$data->i_name.'">
              <input  name="id_formula[]"
                      class="form-control hidden"
                      value="'.$data->f_bb.'">';
    })

    ->editColumn('f_value', function ($data) {
      return '<input  name="id_value[]"
                      readonly
                      class="form-control text-right f_value hidden"
                      onkeyup="total(this, event)";
                      value="'.round($data->butuh, 2).'">
              <input  name=""
                      readonly
                      class="form-control text-right"
                      value="'.number_format( $data->butuh ,0,',','.').'">';
                      
    })


    ->editColumn('m_sname', function ($data) {
      return '<input  name=""
                      readonly
                      class="form-control"
                      value="'.$data->m_sname.'">
              <input  name="scale[]"
                      readonly
                      class="form-control hidden"
                      value="'.$data->i_sat1.'">';
    })

    ->addColumn('d_stock', function($data){
      return  '<input name="d_stock[]"
                      class="form-control text-right d_stock hidden"
                      readonly
                      value="'.round($data->s_qty, 2).'">
              <input name=""
                      class="form-control text-right"
                      readonly
                      value="'.number_format( $data->s_qty ,0,',','.').'">';
    })

    ->addColumn('purchesing', function($data){
      return  '<input name=""
                      class="form-control text-right hasil"
                      readonly value="">';
    })
    ->addIndexColumn()
    ->rawColumns(['f_bb','f_value','purchesing','d_stock','m_sname'])
    ->make(true);
  }

  public function simpanSpk(Request $request){
    // dd($request->all());
  DB::beginTransaction();
  try {
    $formula = $request->id_formula;
    $value = $request->id_value;
    $scale = $request->scale;
    $request->tgl_spk = date('Y-m-d',strtotime($request->tgl_spk));

    $spk_id = d_spk::max('spk_id')+1;
      d_spk::create([
            'spk_id' =>$spk_id,
            'spk_ref' =>$request->id_plan,
            'spk_date' =>Carbon::now(),
            'spk_item' =>$request->iditem,
            'spk_code' =>$request->id_spk,
            'spk_qty' =>$request->jumlah,
            'spk_status'=>$request->status,
      ]);

    $productplan=DB::table('d_productplan')->where('pp_id',$request->id_plan);
    $productplan->update([
        'pp_isspk'=>'Y'
    ]);

    for ($i=0; $i < count($formula) ; $i++) {
      spk_formula::insert([
                    'fr_spk' => $spk_id,
                    'fr_detailid' => $i+1,
                    'fr_formula'  => $formula[$i],
                    'fr_value' => $value[$i],
                    'fr_scale' => $scale[$i]
      ]);

    // if(mutasi::mutasiStok(  $formula[$i],
    //                         $value[$i],
    //                         $comp=3,
    //                         $position=3,
    //                         $flag=2,
    //                         $request->id_spk)){}

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

  public function simpanDraftSpk(Request $request){

  DB::beginTransaction();
  try {
    $formula = $request->id_formula;
    $value = $request->id_value;
    $scale = $request->scale;
    $request->tgl_spk = date('Y-m-d',strtotime($request->tgl_spk));

    $spk_id = d_spk::max('spk_id')+1;
      d_spk::create([
            'spk_id' =>$spk_id,
            'spk_ref' =>$request->id_plan,
            'spk_date' =>Carbon::now(),
            'spk_item' =>$request->iditem,
            'spk_code' =>$request->id_spk,
            'spk_qty' =>$request->jumlah,
            'spk_status'=>$request->status,
      ]);

    $productplan=DB::table('d_productplan')->where('pp_id',$request->id_plan);
    $productplan->update([
        'pp_isspk'=>'Y'
    ]);

    for ($i=0; $i < count($formula) ; $i++) {
      spk_formula::insert([
                    'fr_spk' => $spk_id,
                    'fr_detailid' => $i+1,
                    'fr_formula'  => $formula[$i],
                    'fr_value' => $value[$i],
                    'fr_scale' => $scale[$i]
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

  public function editSpk($id){

    $spk = d_spk::select( 'pp_date',
                          'i_name',
                          'pp_item',
                          'pp_qty',
                          'spk_code',
                          'spk_id')
      ->where('spk_id',$id)
      ->join('m_item','i_id','=','spk_item')
      ->join('d_productplan','pp_id','=','spk_ref')
      ->first();

    // dd($spk);
    $data=[ 'status'=>'sukses',
            'data'=>$spk ];
    // dd($data);
    return json_encode($data);
  }

  public function detailSpk(Request $request){
    $spk = d_spk::select( 'pp_date',
                          'i_name',
                          'pp_qty',
                          'spk_code')
      ->where('spk_id',$request->x)
      ->join('m_item','i_id','=','spk_item')
      ->join('d_productplan','pp_id','=','spk_ref')
      ->get();

    $formula = spk_formula::select( 'i_code',
                                    'i_name',
                                    'fr_value',
                                    'm_sname')
      ->where('fr_spk',$request->x)
      ->join('m_item','i_id','=','fr_formula')
      ->join('m_satuan','m_sid','=','fr_scale')
      ->get();

    return view('keuangan.spk.detail-formula',compact('spk','formula'));
  }

  public function updateStatus(Request $request, $id){
    // dd($request->all());
    DB::beginTransaction();
    try {
    $formula = $request->id_formula;
    $value = $request->id_value;
    $scale = $request->scale;
    $data = d_spk::where('spk_id',$id)->first();
    $data->update([
      'spk_status' => 'AP'
    ]);

    for ($i=0; $i < count($formula) ; $i++) {
    // if(mutasi::mutasiStok(  $formula[$i],
    //                         $value[$i],
    //                         $comp=3,
    //                         $position=3,
    //                         $flag=2,
    //                         $data->spk_code)){}
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
