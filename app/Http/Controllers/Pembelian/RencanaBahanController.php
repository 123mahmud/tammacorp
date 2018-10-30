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
use App\d_purchasingplan;
use App\d_purchasingplan_dt;

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
      $menit = Carbon::now('Asia/Jakarta')->format('H:i:s');
      //dd(Carbon::createFromFormat('Y-m-d H:i:s', $tgl2, 'Asia/Jakarta'));
      $tanggal1 = date('Y-m-d',strtotime($tgl1));
      $tanggal2 = date('Y-m-d',strtotime($tgl2));

      $tanggalMenit1 = date('Y-m-d '.$menit ,strtotime($tgl1));
      $tanggalMenit2 = date('Y-m-d '.$menit ,strtotime($tgl2));

      $dataHeader = spk_formula::join('d_spk', 'spk_formula.fr_spk', '=', 'd_spk.spk_id')
                ->join('m_item','spk_formula.fr_formula','=','m_item.i_id')
                ->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')
                ->select(
                    'd_spk.*',
                    'spk_formula.*',
                    'm_item.i_id as item_id',
                    'm_item.i_name',
                    'm_item.i_code',
                    'm_item.i_sat1',
                    DB::raw('IFNULL(
                              (SELECT SUM(fr_value) FROM spk_formula 
                              JOIN d_spk on spk_formula.fr_spk = d_spk.spk_id 
                              WHERE spk_date BETWEEN "'.$tanggal1.'" AND "'.$tanggal2.'"
                              AND fr_formula = item_id), "0")
                              as total'),
                    DB::raw("IFNULL( 
                              (SELECT SUM(d_pcspdt_qtyconfirm) 
                                FROM d_purchasingplan_dt 
                                WHERE d_pcspdt_created BETWEEN '".$tanggalMenit1."' AND '".$tanggalMenit2."'
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
          $dataHeader[$j]['selisih'] = $data['stok'][$j] - ($dataHeader[$j]['total'] - $dataHeader[$j]['qtyOrderPlan']);
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
          return number_format((int)$data->selisih,0,",",".");
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
      $menit = Carbon::now('Asia/Jakarta')->format('H:i:s');
      $tanggalMenit1 = date('Y-m-d '.$menit ,strtotime($request->tgl1));
      $tanggalMenit2 = date('Y-m-d '.$menit ,strtotime($request->tgl2));

      // $sup = DB::table('m_item')->select('i_sup_list')->where('i_id', $request->id)->first();
      // $list_sup = explode(',', $sup->i_sup_list);
      $list_sup = DB::table('d_barang_sup')->select('d_bs_supid')->where('d_bs_itemid', $request->id)->get();
      if (count($list_sup) > 0) 
      {
        $d_sup = [];
        for ($i=0; $i <count($list_sup); $i++) 
        { 
          $aa = DB::table('d_supplier')->select('s_id','s_company')->where('s_id', $list_sup[$i]->d_bs_supid)->first();
          $d_sup[] = array('sup_id' => $aa->s_id, 'sup_txt'=> $aa->s_company);
        }

        $dataHeader = d_spk::join('spk_formula', 'd_spk.spk_id', '=', 'spk_formula.fr_spk')
                      ->join('m_item','spk_formula.fr_formula','=','m_item.i_id')
                      ->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')
                      ->select(
                          'd_spk.*',
                          DB::raw('SUM(fr_value) as total'),
                          'spk_formula.*',
                          'm_item.i_id as item_id',
                          'm_item.i_name',
                          'm_item.i_code',
                          'm_item.i_sat1',
                          DB::raw("IFNULL( 
                                    (SELECT SUM(d_pcspdt_qtyconfirm) 
                                      FROM d_purchasingplan_dt 
                                      WHERE d_pcspdt_created BETWEEN '".$tanggalMenit1."' AND '".$tanggalMenit2."'
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
            $dataHeader[$j]['selisih'] = $data['stok'][$j] - ($dataHeader[$j]['total'] - $dataHeader[$j]['qtyOrderPlan']);
            $dataHeader[$j]['tanggal1'] = $request->tgl1;
            $dataHeader[$j]['tanggal2'] = $request->tgl2;
          }
        }
        return view('purchasing/rencanabahanbaku/proses', [ 'd_sup' => $d_sup, 'data' => $dataHeader ]);
      }
      else
      {
        $request->session()->flash('gagal', 'Tidak terdapat relasi supplier pada barang tersebut');
        return redirect('purchasing/rencanabahanbaku/bahan');
      }
    }

    public function suggestItem(Request $request)
    {
      $menit = Carbon::now('Asia/Jakarta')->format('H:i:s');
      $tanggalMenit1 = date('Y-m-d '.$menit ,strtotime($request->tgl1));
      $tanggalMenit2 = date('Y-m-d '.$menit ,strtotime($request->tgl2));

      $list_item = DB::table('d_supplier_brg')->select('d_sb_itemid')->where('d_sb_supid', $request->idsup)->get();
      if (count($list_item) > 0) 
      {
        $d_item = [];
        for ($i=0; $i <count($list_item); $i++) 
        { 
          $aa = DB::table('m_item')->select('i_id','i_name','i_code')->where('i_id', $list_item[$i]->d_sb_itemid)->first();
          //$bb = DB::table('spk_formula')->select('fr_formula')->where('fr_spk', $request->idspk)->where('fr_formula', $list_item[$i]->d_sb_itemid)->first();
          $bb = DB::table('spk_formula')->select('fr_formula')->where('fr_formula', $list_item[$i]->d_sb_itemid)->first();
          if ($request->item != $aa->i_id) {
            if (!empty($bb->fr_formula)) {
              $d_item[] = array('item_id' => $aa->i_id, 'item_txt'=> $aa->i_name, 'item_code'=> $aa->i_code);
            }
          }
        }

        $hasil = [];
        for ($j=0; $j <count($d_item); $j++) 
        { 
          $dataHeader[] = spk_formula::join('d_spk', 'spk_formula.fr_spk', '=', 'd_spk.spk_id')
                                ->join('m_item', 'spk_formula.fr_formula', '=', 'm_item.i_id')
                                ->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')
                                ->select(
                                  'd_spk.*',
                                  'spk_formula.*',
                                  'm_item.i_name',
                                  'm_item.i_code',
                                  'm_item.i_sat1',
                                  'm_item.i_id as item_id',
                                  DB::raw('IFNULL(
                                            (SELECT SUM(fr_value) FROM spk_formula 
                                            JOIN d_spk on spk_formula.fr_spk = d_spk.spk_id 
                                            WHERE spk_date BETWEEN "'.$request->tgl1.'" AND "'.$request->tgl2.'"
                                            AND fr_formula = item_id), "0")
                                            as totalQTySpk'),
                                  DB::raw("IFNULL( 
                                          (SELECT SUM(d_pcspdt_qtyconfirm) 
                                            FROM d_purchasingplan_dt 
                                            WHERE d_pcspdt_created BETWEEN '".$tanggalMenit1."' AND '".$tanggalMenit2."'
                                            AND d_pcspdt_item = item_id) ,'0') 
                                            as qtyOrderPlan")
                                )
                                ->where('d_spk.spk_status', '=', 'DR')
                                ->where('spk_formula.fr_formula', '=', $d_item[$j])
                                // ->whereBetween('d_spk.spk_date', [$request->tgl1, $request->tgl2])
                                ->groupBy('spk_formula.fr_formula')
                                ->first();
        }
             
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
          for ($k=0; $k <count($itemType); $k++) 
          { 
            if ($itemType[$k]->i_type == "BJ") //brg jual
            {
              $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '".$itemType[$k]->i_id."' AND s_comp = '2' AND s_position = '2' limit 1) ,'0') as qtyStok"));
              $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')->select('m_satuan.m_sname')->where('m_item.i_sat1', '=', $sat1[$counter])->first();

              $dataHeader[$k]['stok'] = $query[0]->qtyStok;
              $dataHeader[$k]['satuan'] = $satUtama->m_sname;
              $counter++;
            }
            elseif ($itemType[$k]->i_type == "BB") //bahan baku
            {
              $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '".$itemType[$k]->i_id."' AND s_comp = '3' AND s_position = '3' limit 1) ,'0') as qtyStok"));
              $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')->select('m_satuan.m_sname')->where('m_item.i_sat1', '=', $sat1[$counter])->first();

              $dataHeader[$k]['stok'] = $query[0]->qtyStok;
              $dataHeader[$k]['satuan'] = $satUtama->m_sname;
              $counter++;
            }
            elseif ($itemType[$k]->i_type == "BP") //bahan produksi
            {
              $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '".$itemType[$i]->i_id."' AND s_comp = '6' AND s_position = '6' limit 1) ,'0') as qtyStok"));
              $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')->select('m_satuan.m_sname')->where('m_item.i_sat1', '=', $sat1[$counter])->first();

              $dataHeader[$k]['stok'] = $query[0]->qtyStok;
              $dataHeader[$k]['satuan'] = $satUtama->m_sname;
              $counter++;
            }
          }

          for ($l=0; $l < count($dataHeader); $l++) 
          { 
            $dataHeader[$l]['selisih'] = $dataHeader[$l]['stok'] - ($dataHeader[$l]['totalQTySpk'] - $dataHeader[$l]['qtyOrderPlan']);
            $dataHeader[$l]['abs_selisih'] = abs($dataHeader[$l]['selisih']);
            $dataHeader[$l]['tanggal1'] = $request->tgl1;
            $dataHeader[$l]['tanggal2'] = $request->tgl2;
          }
        }

        return response()->json([
            'status' => 'sukses',
            'list' => $d_item,
            'data' => $dataHeader,
        ]);
      }
      else
      {
        return response()->json([
            'status' => 'gagal'
        ]);
      }
    }

    public function lookupSupplier(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term)) 
        {
          $list_sup = DB::table('d_barang_sup')->select('d_bs_supid')->where('d_bs_itemid', $request->itemid)->get();
          foreach ($list_sup as $val) 
          {
            $sup = DB::table('d_supplier')->select('s_id','s_company')->where('s_id', $val->d_bs_supid)->first();
            $formatted_tags[] = ['id' => $sup->s_id, 'text' => $sup->s_company];
          }
          return Response::json($formatted_tags);
        }
        else
        {
          $list_sup = DB::table('d_barang_sup')
          ->join('d_supplier', 'd_barang_sup.d_bs_supid','=','d_supplier.s_id')
          ->select('d_bs_supid')->where('s_company', 'LIKE', '%'.$term.'%')->where('d_bs_itemid', $request->itemid)->get();
          foreach ($list_sup as $val) 
          {
            $sup = DB::table('d_supplier')->select('s_id','s_company')->where('s_id', $val->d_bs_supid)->first();
            $formatted_tags[] = ['id' => $sup->s_id, 'text' => $sup->s_company];
          }

          return Response::json($formatted_tags);  
        }
    }

    public function submitData(Request $request)
    {
      //dd($request->all());
      DB::beginTransaction();
      try 
      {
        $kode_plan = $this->kodeRencanaPembelian();
        $id_peg = Auth::User()->m_id;

        //insert to table d_purchasingplan
        $plan = new d_purchasingplan;
        $plan->d_pcsp_code = $kode_plan;
        $plan->d_pcsp_sup = $request->i_sup;
        $plan->d_pcsp_mid = $id_peg;
        $plan->d_pcsp_datecreated = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $plan->d_pcsp_created = Carbon::now('Asia/Jakarta');
        $plan->save();

        //get last id plan then insert id to d_purchasingplan_dt
        $lastIdPlan = d_purchasingplan::select('d_pcsp_id')->max('d_pcsp_id');
        if ($lastIdPlan == 0 || $lastIdPlan == '') 
        {
          $lastIdPlan  = 1;
        }
        
        for ($i=0; $i < count($request->itemid); $i++) 
        {
          $plandt = new d_purchasingplan_dt;
          $plandt->d_pcspdt_idplan = $lastIdPlan;
          $plandt->d_pcspdt_item = $request->itemid[$i];
          $plandt->d_pcspdt_sat = $request->satuanid[$i];
          $plandt->d_pcspdt_qty = str_replace('.', '', $request->qtyreq[$i]);
          //get prev cost
          $prevCost = DB::table('d_stock_mutation')
                          ->select('sm_hpp', 'sm_qty')
                          ->where('sm_item', '=', $request->itemid[$i])
                          ->where('sm_mutcat', '=', "14")
                          ->orderBy('sm_date', 'desc')
                          ->limit(1)
                          ->first();

          if ($prevCost == null) 
          {
            $default_cost = DB::table('m_price')->select('m_pbuy1')->where('m_pitem', '=', $request->itemid[$i])->first();
            $hargaLalu = $default_cost->m_pbuy1;
          }
          else
          {
            $hargaLalu = $prevCost->sm_hpp;
          }
          //end get prev cost
          $plandt->d_pcspdt_prevcost = $hargaLalu;
          $plandt->d_pcspdt_created = Carbon::now('Asia/Jakarta');
          $plandt->save();
        }

        DB::commit();
        return response()->json([
          'status' => 'sukses',
          'pesan' => 'Data berhasil diproses ke list rencana pembelian'
        ]);
      }          
      catch (\Exception $e) 
      {
        DB::rollback();
        return response()->json([
            'status' => 'gagal',
            'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n : ".$e->getLine()
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

    public function kodeRencanaPembelian()
    {
      $query = DB::select(DB::raw("SELECT MAX(RIGHT(d_pcsp_code,4)) as kode_max from d_purchasingplan WHERE DATE_FORMAT(d_pcsp_datecreated, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));
      $kd = "";

        if(count($query)>0)
        {
          foreach($query as $k)
          {
            $tmp = ((int)$k->kode_max)+1;
            $kd = sprintf("%05s", $tmp);
          }
        }
        else
        {
          $kd = "00001";
        }

        return $codePlan = "ROR-".date('ym')."-".$kd;
    }

    public function konvertRp($value)
    {
      $value = str_replace(['Rp', '\\', '.', ' '], '', $value);
      return (int)str_replace(',', '.', $value);
    }
}
