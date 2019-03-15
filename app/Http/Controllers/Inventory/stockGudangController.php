<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Response;
use App\Http\Requests;
use App\d_gudangcabang;
use App\d_stock;
use Auth;
use DataTables;
use URL;

class stockGudangController extends Controller
{

  public function index(){
    $data = d_gudangcabang::
          where(function($q) {
              $q->where('cg_gudang', '!=','GC')
                ->where('cg_gudang', '!=','GS')
                ->where('cg_gudang', '!=','GJ');
          })
          ->get();

    return view('inventory.stockgudang.index',compact('data'));
  }

  public function tableGudang($comp, $position)
  {
      $data = d_stock::
      select(
          'i_code',
          'i_name',
          'i_type',
          's_qty',
          'm_sname')
          ->where('s_comp', $comp)
          ->where('s_position', $position)
          ->where('i_isactive','TRUE')
          ->join('m_item', 'i_id', '=', 's_item')
          ->join('m_satuan', 'm_sid', '=', 'i_sat1')
          ->get();
      // dd($data);
      return DataTables::of($data)
          ->addIndexColumn()
          ->editColumn('s_qty', function ($data) {
              return '<div>
                        <span class="pull-right">
                          ' . number_format($data->s_qty, 0, ',', '.') . '
                        </span>
                      </div>';
          })

          ->editColumn('type', function ($data)
          {
              if ($data->i_type == "BJ")
              {
                  return 'Barang Jual';
              }
              elseif ($data->i_type == "BP")
              {
                  return 'Barang Produksi';
              }
              elseif ($data->i_type == "BB")
              {
                  return 'Bahan Baku';
              }
          })

          ->editColumn('item', function ($data) {
              return '<div>
                        '.$data->i_code. ' - ' .$data->i_name.'
                      </div>';
          })

          ->rawColumns(['item','s_qty', 'type'])
          ->make(true);

  }
}
