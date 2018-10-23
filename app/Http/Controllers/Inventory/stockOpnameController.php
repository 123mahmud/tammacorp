<?php

namespace App\Http\Controllers\Inventory;

use App\m_item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Response;
use App\Http\Requests;
use App\d_gudangcabang;
use App\d_stock;
use App\d_opname;
use App\d_stock_mutation;
use App\d_opnamedt;
use App\lib\mutasi;
use Auth;
use DataTables;
use URL;

class stockOpnameController extends Controller
{
    public function index()
    {
        $data = d_gudangcabang::all();
        $staff['nama'] = Auth::user()->m_name;
        $staff['id'] = Auth::User()->m_id;
        return view('inventory.stockopname.index', compact('data','staff'));
    }

    public function tableOpname(Request $request, $comp, $position)
    {
      $term = $request->term;
      $results = array();
      $queries = d_stock::
        select('i_id',
               'i_code',
               'i_name',
               'm_sname',
               's_qty')
        ->where('m_item.i_name', 'LIKE', '%'.$term.'%')
        ->where('s_comp',$comp)
        ->where('s_comp',$position)
        ->where('i_isactive','TRUE')
        ->join('m_item','i_id','=','s_item')
        ->join('m_satuan','m_sid','=','i_sat1')
        ->take(15)->get();

      if ($queries == null) {
        $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
      } else {
        foreach ($queries as $query)
        {
          $results[] = [  'id' => $query->i_id,
                          'label' => $query->i_code .' - '.$query->i_name,
                          'i_code' => $query->i_code,
                          'i_name' => $query->i_name,
                          's_qtykw' => number_format($query->s_qty,0,',','.'),
                          's_qty' => $query->s_qty,
                          'm_sname' => $query->m_sname,
                      ];
        }
      }

    return Response::json($results);

    }

    function saveOpname(Request $request){
      // dd($request->all());
      DB::beginTransaction();
        try {
      $o_id = d_opname::max('o_id') + 1;
      //nota
      $year = carbon::now()->format('y');
      $month = carbon::now()->format('m');
      $date = carbon::now()->format('d');
      $nota = 'OD'  . $year . $month . $date . $o_id;
      //end Nota
      d_opname::insert([
          'o_id' => $o_id,
          'o_nota' => $nota,
          'o_staff' => $request->o_staff,
          'o_comp' => $request->o_comp,
          'o_position' => $request->o_position,
          'o_insert' => Carbon::now()
      ]);

      for ($i=0; $i < count($request->i_id); $i++) {
          d_opnamedt::insert([
            'od_ido' => $o_id,
            'od_idodt' => $i+1,
            'od_item' => $request->i_id[$i],
            'od_opname' => $request->opname[$i]
          ]);

          $cek = d_stock::select('s_id','s_qty')
                ->where('s_item', $request->i_id[$i])
                ->where('s_comp', $request->o_comp)
                ->where('s_position', $request->o_position)
                ->first();

          $hasil = $cek->s_qty + $request->opname[$i];

          $sm_detailid = d_stock_mutation::select('sm_detailid')
            ->where('sm_item', $request->i_id[$i])
            ->where('sm_comp', $request->o_comp)
            ->where('sm_position', $request->o_position)
            ->max('sm_detailid')+1;

          if ( $request->opname[$i] <= 0) {//+
            if(mutasi::mutasiStok(  $request->i_id[$i],
                                    - $request->opname[$i],
                                    $comp=$request->o_comp,
                                    $position=$request->o_position,
                                    $flag=7,
                                    $nota)){}
          } else {//-
            $cek->update([
              's_qty' => $hasil
            ]);

            d_stock_mutation::create([
              'sm_stock' => $cek->s_id,
              'sm_detailid' => $sm_detailid,
              'sm_date' => Carbon::now(),
              'sm_comp' => $request->o_comp,
              'sm_position' => $request->o_position,
              'sm_mutcat' => 7,
              'sm_item' => $request->i_id[$i],
              'sm_qty' => $request->opname[$i],
              'sm_qty_used' => 0,
              'sm_qty_sisa' => $request->opname[$i],
              'sm_qty_expired' => 0,
              'sm_detail' => 'PENAMBAHAN',
              'sm_reff' => $nota,
              'sm_insert' => Carbon::now()
            ]);
          }
      }

      $nota = d_opname::where('o_id',$o_id)
          ->first();

      DB::commit();
      return response()->json([
          'status' => 'sukses',
          'nota' => $nota
        ]);
      } catch (\Exception $e) {
      DB::rollback();
      return response()->json([
        'status' => 'gagal',
        'data' => $e
        ]);
      }
    }

    public function history($tgl1, $tgl2){
      $y = substr($tgl1, -4);
      $m = substr($tgl1, -7,-5);
      $d = substr($tgl1,0,2);
       $tgll = $y.'-'.$m.'-'.$d;

      $y2 = substr($tgl2, -4);
      $m2 = substr($tgl2, -7,-5);
      $d2 = substr($tgl2,0,2);
        $tgl2 = $y2.'-'.$m2.'-'.$d2;
        $tgl2 = date('Y-m-d',strtotime($tgl2 . "+1 days"));

      $opname = d_opname::select(
            'o_id',
            'o_insert',
            'o_nota',
            'u1.cg_cabang as comp',
            'u2.cg_cabang as position')
        ->join('d_gudangcabang as u1', 'd_opname.o_comp', '=', 'u1.cg_id')
        ->join('d_gudangcabang as u2', 'd_opname.o_position', '=', 'u2.cg_id')
        ->where('o_insert','>=',$tgll)
        ->where('o_insert','<=',$tgl2)
        ->get();

      return DataTables::of($opname)
      ->editColumn('date', function ($data) {
        return date('d M Y', strtotime($data->o_insert)).' : '.substr($data->o_insert, 10, 18);;

      })

      ->addColumn('action', function($data)
      {
        return  '<div class="text-center">
                    <button type="button"
                        class="btn btn-success fa fa-eye btn-sm"
                        title="Detail"
                        type="button"
                        data-toggle="modal"
                        data-target="#myModalView"
                        onclick="OpnameDet('."'".$data->o_id."'".')"
                    </button>
                </div>';
      })

      ->rawColumns(['date','action'])
      ->make(true);

    }

    public function getOPname(Request $request){
      $data = d_opnamedt::select( 'i_code',
                            'i_type',
                            'i_name',
                            'od_opname',
                            'm_sname')
        ->where('od_ido',$request->x)
        ->join('m_item','i_id','=','od_item')
        ->join('m_satuan','m_sid','=','i_sat1')
        ->get();

      return view('inventory.stockopname.detail-opname',compact('data'));

    }
}
