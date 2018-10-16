<?php

namespace App\Http\Controllers\Pembelian;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Response;
use DB;
use DataTables;
use Auth;
use App\d_spk;
use App\spk_formula;

class RencanaBahanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
      return view('purchasing/rencanabahanbaku/bahan');
    }

    public function getRencanaByTgl($tgl1, $tgl2)
    {
      
      $tanggal1 = date('Y-m-d',strtotime($tgl1));
      $tanggal2 = date('Y-m-d',strtotime($tgl2));

      $dataHeader = d_spk::join('spk_formula', 'd_spk.spk_id', '=', 'spk_formula.fr_spk')
                ->join('m_item','spk_formula.fr_formula','=','m_item.i_id')
                ->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')
                ->join('d_purchasingplan_dt', 'spk_formula.fr_formula', '=', 'd_purchasingplan_dt.d_pcspdt_item')
                ->select(
                    'd_spk.*',
                    DB::raw('SUM(fr_value) as total'),
                    'spk_formula.*',
                    'm_item.i_id as item_id',
                    'm_item.i_name',
                    'm_item.i_code',
                    'm_item.i_sat1',
                    'd_purchasingplan_dt.d_pcspdt_item',
                    DB::raw("IFNULL( 
                              (SELECT SUM(d_pcspdt_qtyconfirm) 
                                FROM d_purchasingplan_dt 
                                WHERE d_pcspdt_created BETWEEN '".$tanggal1."' AND '".$tanggal2."'
                                AND d_pcspdt_item = item_id) ,'0') 
                                as qtyOrderPlan")
                )
                ->where('d_spk.spk_status', '=', 'DR')
                ->whereBetween('d_spk.spk_date', [$tanggal1, $tanggal2])
                ->groupBy('i_id')
                ->orderBy('i_name', 'ASC')
                ->get();

      if (count($dataHeader) > 0) 
      {
        foreach ($dataHeader as $val) 
        {
          //cek item type
          $itemType[] = DB::table('m_item')->select('i_type', 'i_id')->where('i_id','=', $val->item_id)->first();
          //get satuan utama
          $sat1[] = $val->i_sat1;
        }
        $counter = 0;
        for ($i=0; $i <count($itemType); $i++) 
        { 
          if ($itemType[$i]->i_type == "BJ") //brg jual
          {
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '".$itemType[$i]->i_id."' AND s_comp = '2' AND s_position = '2' limit 1) ,'0') as qtyStok"));
            $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')->select('m_satuan.m_sname')->where('m_item.i_sat1', '=', $sat1[$counter])->first();

            $data['stok'][$i] = $query[0]->qtyStok;
            $data['satuan'][$i] = $satUtama->m_sname;
            $counter++;
          }
          elseif ($itemType[$i]->i_type == "BB") //bahan baku
          {
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '".$itemType[$i]->i_id."' AND s_comp = '3' AND s_position = '3' limit 1) ,'0') as qtyStok"));
            $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')->select('m_satuan.m_sname')->where('m_item.i_sat1', '=', $sat1[$counter])->first();

            $data['stok'][$i] = $query[0]->qtyStok;
            $data['satuan'][$i] = $satUtama->m_sname;
            $counter++;
          }
          elseif ($itemType[$i]->i_type == "BP") //bahan produksi
          {
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '".$itemType[$i]->i_id."' AND s_comp = '6' AND s_position = '6' limit 1) ,'0') as qtyStok"));
            $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')->select('m_satuan.m_sname')->where('m_item.i_sat1', '=', $sat1[$counter])->first();

            $data['stok'][$i] = $query[0]->qtyStok;
            $data['satuan'][$i] = $satUtama->m_sname;
            $counter++;
          }
        }
        for ($j=0; $j < count($dataHeader); $j++) 
        { 
          $dataHeader[$j]['stok'] = $data['stok'][$j];
          $dataHeader[$j]['satuan'] = $data['satuan'][$j];
          $dataHeader[$j]['selisih'] = $data['stok'][$j] - $dataHeader[$j]['total'];
          $dataHeader[$j]['tanggal1'] = $tanggal1;
          $dataHeader[$j]['tanggal2'] = $tanggal2;
        }
      }

      //return Response::json($dataHeader);

      return DataTables::of($dataHeader)
        ->addIndexColumn()
        ->editColumn('stok', function ($data) 
        {
          return number_format($data->stok,0,",",".").' '.$data->satuan;
        })
        ->editColumn('qtyTotal', function ($data) 
        {
          return number_format($data->total,0,",",".");
        })
        ->editColumn('kekurangan', function ($data) 
        {
          return number_format((int)$data->stok - (int)$data->total,0,",",".");
        })
        ->editColumn('qtyorderplan', function ($data) 
        {
          return number_format((int)$data->qtyOrderPlan,0,",",".");
        })
        ->addColumn('action', function($data)
        {
          return '<div class="text-center">
                  <button class="btn btn-sm btn-success" title="Proses Rencana Pembelian"
                      onclick=proses("'.$data->item_id.'","'.$data->tanggal1.'","'.$data->tanggal2.'")>
                      <i class="fa fa-check"></i> 
                  </button>';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function prosesPurchasePlan(Request $request)
    {
      $sup = DB::table('m_item')->select('i_sup_list')->where('i_id', $request->id)->first();
      $list_sup = explode(',', $sup->i_sup_list);
      $d_sup = [];
      for ($i=0; $i <count($list_sup); $i++) 
      { 
        $aa = DB::table('d_supplier')->select('s_id','s_company')->where('s_id', $list_sup[$i])->first();
        $d_sup[] = array('sup_id' => $aa->s_id, 'sup_txt'=> $aa->s_company);
      }

      $dataHeader = d_spk::join('spk_formula', 'd_spk.spk_id', '=', 'spk_formula.fr_spk')
                    ->join('m_item','spk_formula.fr_formula','=','m_item.i_id')
                    ->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')
                    ->join('d_purchasingplan_dt', 'spk_formula.fr_formula', '=', 'd_purchasingplan_dt.d_pcspdt_item')
                    ->select(
                        'd_spk.*',
                        DB::raw('SUM(fr_value) as total'),
                        'spk_formula.*',
                        'm_item.i_id as item_id',
                        'm_item.i_name',
                        'm_item.i_code',
                        'm_item.i_sat1',
                        'd_purchasingplan_dt.d_pcspdt_item',
                        DB::raw("IFNULL( 
                                  (SELECT SUM(d_pcspdt_qtyconfirm) 
                                    FROM d_purchasingplan_dt 
                                    WHERE d_pcspdt_created BETWEEN '".$request->tgl1."' AND '".$request->tgl2."'
                                    AND d_pcspdt_item = item_id) ,'0') 
                                    as qtyOrderPlan")
                    )
                    ->where('d_spk.spk_status', '=', 'DR')
                    ->where('m_item.i_id', '=', $request->id)
                    ->whereBetween('d_spk.spk_date', [$request->tgl1, $request->tgl2])
                    ->groupBy('i_id')
                    ->orderBy('i_name', 'ASC')
                    ->get();

      if (count($dataHeader) > 0) 
      {
        foreach ($dataHeader as $val) 
        {
          //cek item type
          $itemType[] = DB::table('m_item')->select('i_type', 'i_id')->where('i_id','=', $val->item_id)->first();
          //get satuan utama
          $sat1[] = $val->i_sat1;
        }
        $counter = 0;
        for ($i=0; $i <count($itemType); $i++) 
        { 
          if ($itemType[$i]->i_type == "BJ") //brg jual
          {
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '".$itemType[$i]->i_id."' AND s_comp = '2' AND s_position = '2' limit 1) ,'0') as qtyStok"));
            $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')->select('m_satuan.m_sname')->where('m_item.i_sat1', '=', $sat1[$counter])->first();

            $data['stok'][$i] = $query[0]->qtyStok;
            $data['satuan'][$i] = $satUtama->m_sname;
            $counter++;
          }
          elseif ($itemType[$i]->i_type == "BB") //bahan baku
          {
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '".$itemType[$i]->i_id."' AND s_comp = '3' AND s_position = '3' limit 1) ,'0') as qtyStok"));
            $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')->select('m_satuan.m_sname')->where('m_item.i_sat1', '=', $sat1[$counter])->first();

            $data['stok'][$i] = $query[0]->qtyStok;
            $data['satuan'][$i] = $satUtama->m_sname;
            $counter++;
          }
          elseif ($itemType[$i]->i_type == "BP") //bahan produksi
          {
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '".$itemType[$i]->i_id."' AND s_comp = '6' AND s_position = '6' limit 1) ,'0') as qtyStok"));
            $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')->select('m_satuan.m_sname')->where('m_item.i_sat1', '=', $sat1[$counter])->first();

            $data['stok'][$i] = $query[0]->qtyStok;
            $data['satuan'][$i] = $satUtama->m_sname;
            $counter++;
          }
        }
        for ($j=0; $j < count($dataHeader); $j++) 
        { 
          $dataHeader[$j]['stok'] = $data['stok'][$j];
          $dataHeader[$j]['satuan'] = $data['satuan'][$j];
          $dataHeader[$j]['selisih'] = $data['stok'][$j] - $dataHeader[$j]['total'];
          $dataHeader[$j]['tanggal1'] = $request->tgl1;
          $dataHeader[$j]['tanggal2'] = $request->tgl2;
        }
      }

      //return response::json($dataHeader);
      // return view('hrd/manajemensurat/surat/form_phk/surat_phk',['kode' => $kode]);
      return view('purchasing/rencanabahanbaku/proses', [ 'd_sup' => $d_sup, 'data' => $dataHeader ]);
    }

    public function suggestItem(Request $request)
    {
      $dataHeader = d_spk::join('spk_formula', 'd_spk.spk_id', '=', 'spk_formula.fr_spk')
                    ->join('m_item','spk_formula.fr_formula','=','m_item.i_id')
                    ->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')
                    ->join('d_purchasingplan_dt', 'spk_formula.fr_formula', '=', 'd_purchasingplan_dt.d_pcspdt_item')
                    ->select(
                        'd_spk.*',
                        DB::raw('SUM(fr_value) as total'),
                        'spk_formula.*',
                        'm_item.i_id as item_id',
                        'm_item.i_name',
                        'm_item.i_code',
                        'm_item.i_sat1',
                        'd_purchasingplan_dt.d_pcspdt_item',
                        DB::raw("IFNULL( 
                                  (SELECT SUM(d_pcspdt_qtyconfirm) 
                                    FROM d_purchasingplan_dt 
                                    WHERE d_pcspdt_created BETWEEN '".$request->tgl1."' AND '".$request->tgl2."'
                                    AND d_pcspdt_item = item_id) ,'0') 
                                    as qtyOrderPlan")
                    )
                    ->where('d_spk.spk_status', '=', 'DR')
                    ->whereBetween('d_spk.spk_date', [$request->tgl1, $request->tgl2])
                    ->groupBy('i_id')
                    ->orderBy('i_name', 'ASC')
                    ->get();

      if (count($dataHeader) > 0) 
      {
        foreach ($dataHeader as $val) 
        {
          //cek item type
          $itemType[] = DB::table('m_item')->select('i_type', 'i_id')->where('i_id','=', $val->item_id)->first();
          //get satuan utama
          $sat1[] = $val->i_sat1;
        }
        $counter = 0;
        for ($i=0; $i <count($itemType); $i++) 
        { 
          if ($itemType[$i]->i_type == "BJ") //brg jual
          {
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '".$itemType[$i]->i_id."' AND s_comp = '2' AND s_position = '2' limit 1) ,'0') as qtyStok"));
            $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')->select('m_satuan.m_sname')->where('m_item.i_sat1', '=', $sat1[$counter])->first();

            $data['stok'][$i] = $query[0]->qtyStok;
            $data['satuan'][$i] = $satUtama->m_sname;
            $counter++;
          }
          elseif ($itemType[$i]->i_type == "BB") //bahan baku
          {
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '".$itemType[$i]->i_id."' AND s_comp = '3' AND s_position = '3' limit 1) ,'0') as qtyStok"));
            $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')->select('m_satuan.m_sname')->where('m_item.i_sat1', '=', $sat1[$counter])->first();

            $data['stok'][$i] = $query[0]->qtyStok;
            $data['satuan'][$i] = $satUtama->m_sname;
            $counter++;
          }
          elseif ($itemType[$i]->i_type == "BP") //bahan produksi
          {
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '".$itemType[$i]->i_id."' AND s_comp = '6' AND s_position = '6' limit 1) ,'0') as qtyStok"));
            $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')->select('m_satuan.m_sname')->where('m_item.i_sat1', '=', $sat1[$counter])->first();

            $data['stok'][$i] = $query[0]->qtyStok;
            $data['satuan'][$i] = $satUtama->m_sname;
            $counter++;
          }
        }
        for ($j=0; $j < count($dataHeader); $j++) 
        { 
          $dataHeader[$j]['stok'] = $data['stok'][$j];
          $dataHeader[$j]['satuan'] = $data['satuan'][$j];
          $dataHeader[$j]['selisih'] = $data['stok'][$j] - $dataHeader[$j]['total'];
          $dataHeader[$j]['tanggal1'] = $request->tgl1;
          $dataHeader[$j]['tanggal2'] = $request->tgl2;
        }
      }

      return response::json($dataHeader);
      /*return response()->json([
            'status' => 'sukses',
            'header' => $dataHeader,
        ]);*/
    
    }

    public function getDetailRencana($id)
    {
       $dataHeader = d_spk::join('m_item','d_spk.spk_item','=','m_item.i_id')
                ->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')
                ->join('d_productplan', 'd_spk.spk_ref', '=', 'd_productplan.pp_id')
                ->select('d_spk.*', 'm_item.i_id', 'm_item.i_name','m_item.i_code', 'm_item.i_sat1', 'd_productplan.pp_qty')
                ->where('d_spk.spk_id', '=', $id)
                ->where('d_spk.spk_status', '=', 'DR')
                ->orderBy('d_spk.spk_date', 'DESC')
                ->get();

        // foreach ($dataHeader as $val) 
        // {
        //   $data = array(
        //       'hargaBruto' => 'Rp. '.number_format($val->d_pcs_total_gross,2,",","."),
        //       'nilaiDiskon' => 'Rp. '.number_format($val->d_pcs_discount + $val->d_pcs_disc_value,2,",","."),
        //       'nilaiPajak' => 'Rp. '.number_format($val->d_pcs_tax_value,2,",","."),
        //       'hargaNet' => 'Rp. '.number_format($val->d_pcs_total_net,2,",",".")
        //   );
        // }

        $dataIsi = spk_formula::join('d_spk', 'spk_formula.fr_spk', '=', 'd_spk.spk_id')
                ->join('m_item', 'spk_formula.fr_formula', '=', 'm_item.i_id')
                ->join('m_satuan', 'spk_formula.fr_scale', '=', 'm_satuan.m_sid')
                ->select('spk_formula.*',
                         'd_spk.*',
                         'm_item.*',
                         'm_satuan.*'
                )
                ->where('spk_formula.fr_spk', '=', $id)
                ->get();

        foreach ($dataIsi as $val) 
        {
          //cek item type
          $itemType[] = DB::table('m_item')->select('i_type', 'i_id')->where('i_id','=', $val->i_id)->first();
          //get satuan utama
          $sat1[] = $val->i_sat1;
        }

        //variabel untuk count array
        $counter = 0;
        //ambil value stok by item type
        $dataStok = $this->getStokByType($itemType, $sat1, $counter);
        
        return response()->json([
            'status' => 'sukses',
            'header' => $dataHeader,
            'data_isi' => $dataIsi,
            'data_stok' => $dataStok['val_stok'],
            'data_satuan' => $dataStok['txt_satuan'],
        ]);
    }

    public function ubahStatus(Request $request)
    {
      //dd($request->all());
      DB::beginTransaction();
      try 
      {
        $tanggal = date("Y-m-d h:i:s");
        if ($request->isPO == 'done') {
            $status = 'FALSE';
            $pesan = 'Data SPK dirubah status menjadi BELUM PO';
        }else{
            $status = 'TRUE';
            $pesan = 'Data SPK dirubah status menjadi SUDAH PO';
        }
        
        //update d_spk
        DB::table('d_spk')
            ->where('spk_id','=',$request->id)
            ->update([
                'spk_ispo' => $status,
                'spk_update' => $tanggal
            ]);

        DB::commit();
        return response()->json([
          'status' => 'sukses',
          'pesan' => $pesan
        ]);          
      }
      catch (\Exception $e) 
      {
        DB::rollback();
        return response()->json([
            'status' => 'gagal',
            'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
        ]);
      }
    }


    public function getStokByType($arrItemType, $arrSatuan, $counter)
    {
      foreach ($arrItemType as $val) 
      {
        if ($val->i_type == "BJ") //brg jual
        {
          $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '2' AND s_position = '2' limit 1) ,'0') as qtyStok"));
          $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')->select('m_satuan.m_sname')->where('m_item.i_sat1', '=', $arrSatuan[$counter])->first();

          $stok[] = $query[0];
          $satuan[] = $satUtama->m_sname;
          $counter++;
        }
        elseif ($val->i_type == "BB") //bahan baku
        {
          $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '3' AND s_position = '3' limit 1) ,'0') as qtyStok"));
          $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')->select('m_satuan.m_sname')->where('m_item.i_sat1', '=', $arrSatuan[$counter])->first();

          $stok[] = $query[0];
          $satuan[] = $satUtama->m_sname;
          $counter++;
        }
        elseif ($val->i_type == "BP") //bahan baku
        {
          $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '6' AND s_position = '6' limit 1) ,'0') as qtyStok"));
          $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')->select('m_satuan.m_sname')->where('m_item.i_sat1', '=', $arrSatuan[$counter])->first();

          $stok[] = $query[0];
          $satuan[] = $satUtama->m_sname;
          $counter++;
        }
      }

      $data = array('val_stok' => $stok, 'txt_satuan' => $satuan);
      return $data;
    }

    public function konvertRp($value)
    {
      $value = str_replace(['Rp', '\\', '.', ' '], '', $value);
      return (int)str_replace(',', '.', $value);
    }
}
