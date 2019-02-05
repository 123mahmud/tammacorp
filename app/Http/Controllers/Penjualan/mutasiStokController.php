<?php

namespace App\Http\Controllers\Penjualan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use DB;
use App\d_stock_mutation;

class mutasiStokController extends Controller
{
    public function tableGrosirRetail($tgl1, $tgl2)
    {
      $y = substr($tgl1, -4);
      $m = substr($tgl1, -7,-5);
      $d = substr($tgl1,0,2);
       $tgll = $y.'-'.$m.'-'.$d;

      $y2 = substr($tgl2, -4);
      $m2 = substr($tgl2, -7,-5);
      $d2 = substr($tgl2,0,2);
        $tgl2 = $y2.'-'.$m2.'-'.$d2;
        $tgl2 = date('Y-m-d',strtotime($tgl2 . "+1 days"));

        $data = DB::table('d_stock_mutation')
            ->join('m_item', 'm_item.i_id', '=', 'd_stock_mutation.sm_item')
            ->join('d_gudangcabang as u1', 'd_stock_mutation.sm_comp', '=', 'u1.cg_id')
            ->join('d_gudangcabang as u2', 'd_stock_mutation.sm_position', '=', 'u2.cg_id')
            ->join('d_stock_mutcat','d_stock_mutcat.smc_id','=','d_stock_mutation.sm_mutcat')
            ->select('sm_date',
                    'i_code',
                    'i_name',
                    'u1.cg_cabang as comp',
                    'u2.cg_cabang as position',
                    'smc_note',
                    'sm_qty',
                    'sm_qty_used',
                    'sm_qty_sisa',
                    'sm_detail',
                    'sm_reff')
            ->where('sm_insert','>=',$tgll)
            ->where('sm_insert','<=',$tgl2)
            ->where('sm_comp', '2');
            dd($data);
        return DataTables::of($data)
            ->editColumn('sm_date', function ($data) {
                return date('d M Y H:i', strtotime($data->sm_date));
            })
            ->make(true);
    }

    /**
     * @return mixed
     */
    public function tablePenjualanRetail()
    {
        $data = d_stock_mutation::select('sm_date',
            'i_code',
            'i_name',
            'cg_cabang',
            'smc_note',
            'sm_qty',
            'sm_qty_used',
            'sm_qty_sisa',
            'sm_detail',
            'sm_reff')
            ->join('m_item', 'i_id', '=', 'sm_item')
            ->join('d_gudangcabang','cg_id','=','sm_position')
            ->join('d_stock_mutcat','smc_id','=','sm_mutcat')
            ->where('sm_comp', '1')
            ->orderBy('i_name','asc')
            ->get();

        return DataTables::of($data)
            ->editColumn('sm_date', function ($data) {
                return date('d M Y H:i', strtotime($data->sm_date));
            })
            ->make(true);

    }
}
