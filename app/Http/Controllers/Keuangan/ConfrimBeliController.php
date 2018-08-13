<?php   

namespace App\Http\Controllers\Keuangan;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Response;
use DB;
use DataTables;
use App\d_purchasingplan;
use App\d_purchasingplan_dt;
use App\d_purchasing;
use App\d_purchasing_dt;
use App\d_purchasingreturn;
use App\d_purchasingreturn_dt;
use App\d_purchasingharian;
use App\d_purchasingharian_dt;

class ConfrimBeliController extends Controller
{

  public function __construct()
  {
      $this->middleware('auth');
  }

  public function confirmPurchasePlanIndex()
  {
    return view('/keuangan/konfirmasi_pembelian/index');
  }

  public function getDataRencanaPembelian()
  {
    $data = d_purchasingplan::join('d_supplier','d_purchasingplan.d_pcsp_sup','=','d_supplier.s_id')
            ->join('d_mem','d_purchasingplan.d_pcsp_mid','=','d_mem.m_id')
            ->select('d_pcsp_id','d_pcsp_code','d_pcsp_code','s_company','d_pcsp_status','d_pcsp_datecreated','d_pcsp_dateconfirm', 'd_mem.m_id', 'd_mem.m_name')
            ->orderBy('d_pcsp_datecreated', 'DESC')
            ->get();
    //dd($data);    
    return DataTables::of($data)
    ->addIndexColumn()
    ->editColumn('status', function ($data)
      {
      if ($data->d_pcsp_status == "WT") 
      {
        return '<span class="label label-info">Waiting</span>';
      }
      elseif ($data->d_pcsp_status == "DE") 
      {
        return '<span class="label label-warning">Dapat diedit</span>';
      }
      elseif ($data->d_pcsp_status == "FN") 
      {
        return '<span class="label label-success">Finish</span>';
      }
    })
    ->editColumn('tglBuat', function ($data) 
    {
        if ($data->d_pcsp_datecreated == null) 
        {
            return '-';
        }
        else 
        {
            return $data->d_pcsp_datecreated ? with(new Carbon($data->d_pcsp_datecreated))->format('d M Y') : '';
        }
    })
    ->editColumn('tglConfirm', function ($data) 
    {
        if ($data->d_pcsp_dateconfirm == null) 
        {
            return '-';
        }
        else 
        {
            return $data->d_pcsp_dateconfirm ? with(new Carbon($data->d_pcsp_dateconfirm))->format('d M Y') : '';
        }
    })
    ->addColumn('action', function($data)
      {
        if ($data->d_pcsp_status == "WT") 
        {
            return '<div class="text-center">
                      <button class="btn btn-sm btn-primary" title="Ubah Status"
                          onclick=konfirmasiPlanAll("'.$data->d_pcsp_id.'")><i class="fa fa-check"></i>
                      </button>
                  </div>'; 
        }
        else 
        {
            return '<div class="text-center">
                      <button class="btn btn-sm btn-primary" title="Ubah Status"
                          onclick=konfirmasiPlan("'.$data->d_pcsp_id.'")><i class="fa fa-check"></i>
                      </button>
                  </div>'; 
        }
      })
    ->rawColumns(['status', 'action'])
    ->make(true);
  }

  public function confirmRencanaPembelian($id,$type)
  {

    $dataHeader = d_purchasingplan::join('d_supplier','d_purchasingplan.d_pcsp_sup','=','d_supplier.s_id')
                            ->join('d_mem','d_purchasingplan.d_pcsp_mid','=','d_mem.m_id')
                            ->select('d_pcsp_id','d_pcsp_code','s_company','d_pcsp_datecreated', 'd_pcsp_status','d_pcsp_dateconfirm', 'd_mem.m_id', 'd_mem.m_name')
                            ->where('d_pcsp_id', '=', $id)
                            ->orderBy('d_pcsp_datecreated', 'DESC')
                            ->get();

    $statusLabel = $dataHeader[0]->d_pcsp_status;
    if ($statusLabel == "WT") 
    {
        $spanTxt = 'Waiting';
        $spanClass = 'label-info';
    }
    elseif ($statusLabel == "DE")
    {
        $spanTxt = 'Dapat Diedit';
        $spanClass = 'label-warning';
    }
    else
    {
        $spanTxt = 'Di setujui';
        $spanClass = 'label-success';
    }

    if ($type == "all") 
    {
        $dataIsi = d_purchasingplan_dt::join('d_purchasingplan','d_purchasingplan_dt.d_pcspdt_idplan','=','d_purchasingplan.d_pcsp_id')
                                ->join('m_item', 'd_purchasingplan_dt.d_pcspdt_item', '=', 'm_item.i_id')
                                ->join('m_satuan', 'd_purchasingplan_dt.d_pcspdt_sat', '=', 'm_satuan.m_sid')
                                ->select('d_purchasingplan_dt.d_pcspdt_id',
                                         'd_purchasingplan_dt.d_pcspdt_item',
                                         'm_item.i_code',
                                         'm_item.i_sat1',
                                         'm_item.i_name',
                                         'm_satuan.m_sname',
                                         'm_satuan.m_sid',
                                         'd_purchasingplan_dt.d_pcspdt_qty',
                                         'd_purchasingplan_dt.d_pcspdt_prevcost',
                                         'd_purchasingplan_dt.d_pcspdt_qtyconfirm'
                                )
                                ->where('d_purchasingplan_dt.d_pcspdt_idplan', '=', $id)
                                ->orderBy('d_purchasingplan_dt.d_pcspdt_created', 'DESC')
                                ->get();
    }
    else
    {
        $dataIsi = d_purchasingplan_dt::join('d_purchasingplan','d_purchasingplan_dt.d_pcspdt_idplan','=','d_purchasingplan.d_pcsp_id')
                                ->join('m_item', 'd_purchasingplan_dt.d_pcspdt_item', '=', 'm_item.i_id')
                                ->join('m_satuan', 'd_purchasingplan_dt.d_pcspdt_sat', '=', 'm_satuan.m_sid')
                                ->select('d_purchasingplan_dt.d_pcspdt_id',
                                         'd_purchasingplan_dt.d_pcspdt_item',
                                         'm_item.i_code',
                                         'm_item.i_sat1',
                                         'm_item.i_name',
                                         'm_satuan.m_sname',
                                         'm_satuan.m_sid',
                                         'd_purchasingplan_dt.d_pcspdt_qty',
                                         'd_purchasingplan_dt.d_pcspdt_prevcost',
                                         'd_purchasingplan_dt.d_pcspdt_qtyconfirm'
                                )
                                ->where('d_purchasingplan_dt.d_pcspdt_idplan', '=', $id)
                                ->where('d_purchasingplan_dt.d_pcspdt_isconfirm', '=', "TRUE")
                                ->orderBy('d_purchasingplan_dt.d_pcspdt_created', 'DESC')
                                ->get();
    }

    foreach ($dataIsi as $val) 
    {
        //cek item type
        $itemType[] = DB::table('m_item')->select('i_type', 'i_id')->where('i_id','=', $val->d_pcspdt_item)->first();
        //get satuan utama
        $sat1[] = $val->i_sat1;
    }

    //variabel untuk count array
    $counter = 0;
    //ambil value stok by item type
    $dataStok = $this->getStokByType($itemType, $sat1, $counter);
    
    return Response()->json([
        'status' => 'sukses',
        'header' => $dataHeader,
        'data_isi' => $dataIsi,
        'data_stok' => $dataStok['val_stok'],
        'data_satuan' => $dataStok['txt_satuan'],
        'spanTxt' => $spanTxt,
        'spanClass' => $spanClass,
    ]);
  }

  public function submitRencanaPembelian(Request $request)
  {
    //dd($request->all());
    DB::beginTransaction();
    try {
        //update table d_purchasingplan
        $plan = d_purchasingplan::find($request->idPlan);
        if ($request->statusConfirm != "WT") 
        {
            $plan->d_pcsp_dateconfirm = date('Y-m-d',strtotime(Carbon::now()));
            $plan->d_pcsp_status = $request->statusConfirm;
            $plan->d_pcsp_updated = Carbon::now();
            $plan->save();

            //update table d_purchasingplan_dt
            $hitung_field = count($request->fieldIdDt);
            for ($i=0; $i < $hitung_field; $i++) 
            {
                $plandt = d_purchasingplan_dt::find($request->fieldIdDt[$i]);
                $plandt->d_pcspdt_qtyconfirm = $request->fieldConfirm[$i];
                $plandt->d_pcspdt_updated = Carbon::now();
                $plandt->d_pcspdt_isconfirm = "TRUE";
                $plandt->save();
            }
        }
        else
        {
            $plan->d_pcsp_dateconfirm = null;
            $plan->d_pcsp_status = $request->statusConfirm;
            $plan->d_pcsp_updated = Carbon::now();
            $plan->save();

            //update table d_purchasingplan_dt
            $hitung_field = count($request->fieldIdDt);
            for ($i=0; $i < $hitung_field; $i++) 
            {
                $plandt = d_purchasingplan_dt::find($request->fieldIdDt[$i]);
                $plandt->d_pcspdt_qtyconfirm = $request->fieldConfirm[$i];
                $plandt->d_pcspdt_updated = Carbon::now();
                $plandt->d_pcspdt_isconfirm = "FALSE";
                $plandt->save();
            }
        }

        DB::commit();
        return response()->json([
            'status' => 'sukses',
            'pesan' => 'Data Rencana Order Berhasil Diupdate'
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

  public function getDataOrderPembelian()
  {
    $data = d_purchasing::join('d_supplier','d_purchasing.s_id','=','d_supplier.s_id')
                ->join('d_mem','d_purchasing.d_pcs_staff','=','d_mem.m_id')
                ->select('d_pcs_date_created','d_pcs_id', 'd_pcsp_id','d_pcs_code','s_company','d_pcs_staff','d_pcs_method','d_pcs_total_net','d_pcs_date_received', 'd_pcs_date_confirm','d_pcs_status','d_mem.m_id','d_mem.m_name')
                //->where('d_pcs_status', '=', 'FN')
                ->orderBy('d_pcs_date_created', 'DESC')
                ->get();
    //dd($data);    
    return DataTables::of($data)
    ->addIndexColumn()
    ->editColumn('status', function ($data)
    {
      if ($data->d_pcs_status == "WT") 
      {
        return '<span class="label label-info">Waiting</span>';
      }
      elseif ($data->d_pcs_status == "DE") 
      {
        return '<span class="label label-warning">Dapat diedit</span>';
      }
      elseif ($data->d_pcs_status == "CF") 
      {
        return '<span class="label label-success">Dikonfirmasi</span>';
      }
      elseif ($data->d_pcs_status == "RC") 
      {
        return '<span class="label label-success">Received</span>';
      }
    })
    ->editColumn('tglOrder', function ($data) 
    {
      if ($data->d_pcs_date_created == null) 
      {
          return '-';
      }
      else 
      {
          return $data->d_pcs_date_created ? with(new Carbon($data->d_pcs_date_created))->format('d M Y') : '';
      }
    })
    ->editColumn('tglConfirm', function ($data) 
    {
      if ($data->d_pcs_date_confirm == null) 
      {
          return '-';
      }
      else 
      {
          return $data->d_pcs_date_confirm ? with(new Carbon($data->d_pcs_date_confirm))->format('d M Y') : '';
      }
    })
    ->editColumn('hargaTotalNet', function ($data) 
    {
      return 'Rp. '.number_format($data->d_pcs_total_net,2,",",".");
    })
    ->addColumn('action', function($data)
    {
      if ($data->d_pcs_status == "WT") 
      {
        return '<div class="text-center">
                  <button class="btn btn-sm btn-primary" title="Ubah Status"
                      onclick=konfirmasiOrder("'.$data->d_pcs_id.'","all")><i class="fa fa-check"></i>
                  </button>
              </div>'; 
      }
      else 
      {
        return '<div class="text-center">
                  <button class="btn btn-sm btn-primary" title="Ubah Status"
                      onclick=konfirmasiOrder("'.$data->d_pcs_id.'","confirmed")><i class="fa fa-check"></i>
                  </button>
              </div>'; 
      }
    })
    ->rawColumns(['status', 'action'])
    ->make(true);
  }

  public function confirmOrderPembelian($id,$type)
  {
    $dataHeader = d_purchasing::join('d_supplier','d_purchasing.s_id','=','d_supplier.s_id')
                ->join('d_mem','d_purchasing.d_pcs_staff','=','d_mem.m_id')
                ->select('d_pcs_date_created','d_pcs_id', 'd_pcs_duedate', 'd_pcsp_id','d_pcs_code','s_company','d_pcs_staff','d_pcs_method','d_pcs_total_net','d_pcs_date_received','d_pcs_status','d_mem.m_name','d_mem.m_id')
                ->where('d_pcs_id', '=', $id)
                ->orderBy('d_pcs_date_created', 'DESC')
                ->get();

    $statusLabel = $dataHeader[0]->d_pcs_status;
    if ($statusLabel == "WT") 
    {
        $spanTxt = 'Waiting';
        $spanClass = 'label-info';
    }
    elseif ($statusLabel == "DE")
    {
        $spanTxt = 'Dapat Diedit';
        $spanClass = 'label-warning';
    }
    else
    {
        $spanTxt = 'Di setujui';
        $spanClass = 'label-success';
    }

    if ($type == "all") 
    {
      $dataIsi = d_purchasing_dt::join('m_item', 'd_purchasing_dt.i_id', '=', 'm_item.i_id')
                ->join('m_satuan', 'd_purchasing_dt.d_pcsdt_sat', '=', 'm_satuan.m_sid')
                ->select('d_purchasing_dt.*', 'm_item.*', 'm_satuan.*')
                ->where('d_purchasing_dt.d_pcs_id', '=', $id)
                ->orderBy('d_purchasing_dt.d_pcsdt_created', 'DESC')
                ->get();
    }
    else
    {
      $dataIsi = d_purchasing_dt::join('m_item', 'd_purchasing_dt.i_id', '=', 'm_item.i_id')
                ->join('m_satuan', 'd_purchasing_dt.d_pcsdt_sat', '=', 'm_satuan.m_sid')
                ->select('d_purchasing_dt.*', 'm_item.*', 'm_satuan.*')
                ->where('d_purchasing_dt.d_pcs_id', '=', $id)
                ->where('d_purchasing_dt.d_pcsdt_isconfirm', '=', "TRUE")
                ->orderBy('d_purchasing_dt.d_pcsdt_created', 'DESC')
                ->get();
    }

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
    
    return Response()->json([
        'status' => 'sukses',
        'header' => $dataHeader,
        'data_isi' => $dataIsi,
        'data_stok' => $dataStok['val_stok'],
        'data_satuan' => $dataStok['txt_satuan'],
        'spanTxt' => $spanTxt,
        'spanClass' => $spanClass,
    ]);
  }

  public function submitOrderPembelian(Request $request)
  {
    //dd($request->all());
    DB::beginTransaction();
    try {
        //update table d_purchasing
        $purchase = d_purchasing::find($request->idOrder);
        if ($request->statusOrderConfirm != "WT") 
        {
            $purchase->d_pcs_date_confirm = date('Y-m-d',strtotime(Carbon::now()));
            $purchase->d_pcs_status = $request->statusOrderConfirm;
            $purchase->d_pcs_updated = Carbon::now();
            $purchase->save();

            //update table d_purchasing_dt
            $hitung_field = count($request->fieldConfirmOrder);
            for ($i=0; $i < $hitung_field; $i++) 
            {
                $purchasedt = d_purchasing_dt::find($request->fieldIdDtOrder[$i]);
                $purchasedt->d_pcsdt_qtyconfirm = $request->fieldConfirmOrder[$i];
                $purchasedt->d_pcsdt_updated = Carbon::now();
                $purchasedt->d_pcsdt_isconfirm = "TRUE";
                $purchasedt->save();
            }
        }
        else
        {
            $purchase->d_pcs_date_confirm = null;
            $purchase->d_pcs_status = $request->statusOrderConfirm;
            $purchase->d_pcs_updated = Carbon::now();
            $purchase->save();

            //update table d_purchasing_dt
            $hitung_field = count($request->fieldConfirmOrder);
            for ($i=0; $i < $hitung_field; $i++) 
            {
                $purchasedt = d_purchasing_dt::find($request->fieldIdDtOrder[$i]);
                $purchasedt->d_pcsdt_qtyconfirm = $request->fieldConfirmOrder[$i];
                $purchasedt->d_pcsdt_updated = Carbon::now();
                $purchasedt->d_pcsdt_isconfirm = "FALSE";
                $purchasedt->save();
            }
        }

        DB::commit();
        return response()->json([
            'status' => 'sukses',
            'pesan' => 'Data Konfirmasi Order Berhasil Diupdate'
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

  public function getDataReturnPembelian()
  {
    $data = d_purchasingreturn::join('d_supplier','d_purchasingreturn.d_pcsr_supid','=','d_supplier.s_id')
                ->join('d_purchasing','d_purchasingreturn.d_pcsr_pcsid','=','d_purchasing.d_pcs_id')
                ->join('d_mem','d_purchasingreturn.d_pcs_staff','=','d_mem.m_id')
                ->select('d_purchasingreturn.*', 'd_supplier.s_id', 'd_supplier.s_company', 'd_purchasing.d_pcs_code', 'd_mem.m_name', 'd_mem.m_id')
                ->orderBy('d_pcsr_created', 'DESC')
                ->get();
    //dd($data);    
    return DataTables::of($data)
    ->addIndexColumn()
    ->editColumn('tglReturn', function ($data) 
    {
      if ($data->d_pcsr_datecreated == null) 
      {
          return '-';
      }
      else 
      {
          return $data->d_pcsr_datecreated ? with(new Carbon($data->d_pcsr_datecreated))->format('d M Y') : '';
      }
    })
    ->editColumn('metode', function ($data) 
    {
      if ($data->d_pcsr_method == 'TK') { return 'Tukar Barang'; } else { return 'Potong Nota'; }
    })
    ->editColumn('hargaTotal', function ($data) 
    {
      return 'Rp. '.number_format($data->d_pcsr_pricetotal,2,",",".");
    })
    ->editColumn('status', function ($data)
    {
      if ($data->d_pcsr_status == "WT") 
      {
        return '<span class="label label-info">Waiting</span>';
      }
      elseif ($data->d_pcsr_status == "DE") 
      {
        return '<span class="label label-warning">Dapat diedit</span>';
      }
      elseif ($data->d_pcsr_status == "CF") 
      {
        return '<span class="label label-success">Dikonfirmasi</span>';
      }
    })
    ->editColumn('tglConfirm', function ($data) 
    {
      if ($data->d_pcsr_dateconfirm == null) 
      {
          return '-';
      }
      else 
      {
          return $data->d_pcsr_dateconfirm ? with(new Carbon($data->d_pcsr_dateconfirm))->format('d M Y') : '';
      }
    })
    ->addColumn('action', function($data)
    {
      if ($data->d_pcsr_status == "WT") 
      {
        return '<div class="text-center">
                  <button class="btn btn-sm btn-primary" title="Ubah Status"
                      onclick=konfirmasiReturn("'.$data->d_pcsr_id.'","all")><i class="fa fa-check"></i>
                  </button>
              </div>'; 
      }
      else 
      {
        return '<div class="text-center">
                  <button class="btn btn-sm btn-primary" title="Ubah Status"
                      onclick=konfirmasiReturn("'.$data->d_pcsr_id.'","confirmed")><i class="fa fa-check"></i>
                  </button>
              </div>'; 
      }
    })
    ->rawColumns(['status', 'action'])
    ->make(true);
  }

  public function confirmReturnPembelian($id,$type)
  {
    $dataHeader = d_purchasingreturn::join('d_supplier','d_purchasingreturn.d_pcsr_supid','=','d_supplier.s_id')
                ->join('d_purchasing','d_purchasingreturn.d_pcsr_pcsid','=','d_purchasing.d_pcs_id')
                ->join('d_mem','d_purchasingreturn.d_pcs_staff','=','d_mem.m_id')
                ->select('d_purchasingreturn.*', 'd_supplier.s_id', 'd_supplier.s_company', 'd_purchasing.d_pcs_code', 'd_mem.m_name', 'd_mem.m_id')
                ->where('d_pcsr_id', '=', $id)
                ->orderBy('d_pcsr_created', 'DESC')
                ->get();

    foreach ($dataHeader as $val) 
    {   
      $data = array(
          'hargaTotalReturn' => 'Rp. '.number_format($val->d_pcsr_pricetotal,2,",","."),
          'tanggalReturn' => date('d-m-Y',strtotime($val->d_pcsr_datecreated))
      );
    }

    $statusLabel = $dataHeader[0]->d_pcsr_status;
    if ($statusLabel == "WT") 
    {
        $spanTxt = 'Waiting';
        $spanClass = 'label-info';
    }
    elseif ($statusLabel == "DE")
    {
        $spanTxt = 'Dapat Diedit';
        $spanClass = 'label-warning';
    }
    else
    {
        $spanTxt = 'Di setujui';
        $spanClass = 'label-success';
    }

    if ($type == "all") 
    {
      $dataIsi = d_purchasingreturn_dt::join('m_item', 'd_purchasingreturn_dt.d_pcsrdt_item', '=', 'm_item.i_id')
                ->join('d_purchasingreturn', 'd_purchasingreturn_dt.d_pcsrdt_idpcsr', '=', 'd_purchasingreturn.d_pcsr_id')
                ->join('m_satuan', 'd_purchasingreturn_dt.d_pcsrdt_sat', '=', 'm_satuan.m_sid')
                ->select('d_purchasingreturn_dt.*', 'm_item.*', 'd_purchasingreturn.d_pcsr_code', 'm_satuan.*')
                ->where('d_purchasingreturn_dt.d_pcsrdt_idpcsr', '=', $id)
                ->orderBy('d_purchasingreturn_dt.d_pcsrdt_created', 'DESC')
                ->get();
    }
    else
    {
      $dataIsi = d_purchasingreturn_dt::join('m_item', 'd_purchasingreturn_dt.d_pcsrdt_item', '=', 'm_item.i_id')
                ->join('d_purchasingreturn', 'd_purchasingreturn_dt.d_pcsrdt_idpcsr', '=', 'd_purchasingreturn.d_pcsr_id')
                ->join('m_satuan', 'd_purchasingreturn_dt.d_pcsrdt_sat', '=', 'm_satuan.m_sid')
                ->select('d_purchasingreturn_dt.*', 'm_item.*', 'd_purchasingreturn.d_pcsr_code', 'm_satuan.*')
                ->where('d_purchasingreturn_dt.d_pcsrdt_idpcsr', '=', $id)
                ->where('d_purchasingreturn_dt.d_pcsrdt_isconfirm', '=', "TRUE")
                ->orderBy('d_purchasingreturn_dt.d_pcsrdt_created', 'DESC')
                ->get();
    }

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
    
    return Response()->json([
        'status' => 'sukses',
        'header' => $dataHeader,
        'header2' => $data,
        'data_isi' => $dataIsi,
        'data_stok' => $dataStok['val_stok'],
        'data_satuan' => $dataStok['txt_satuan'],
        'spanTxt' => $spanTxt,
        'spanClass' => $spanClass
    ]);
  }

  public function submitReturnPembelian(Request $request)
  {
    //dd($request->all());
    DB::beginTransaction();
    try {
        //update table d_purchasingreturn
        $purchase = d_purchasingreturn::find($request->idReturn);
        if ($request->statusReturnConfirm != "WT") 
        {
            $purchase->d_pcsr_dateconfirm = date('Y-m-d',strtotime(Carbon::now()));
            $purchase->d_pcsr_status = $request->statusReturnConfirm;
            $purchase->d_pcsr_updated = Carbon::now();
            $purchase->save();

            //update table d_purchasingreturn_dt
            $hitung_field = count($request->fieldConfirmReturn);
            for ($i=0; $i < $hitung_field; $i++) 
            {
                $purchasedt = d_purchasingreturn_dt::find($request->fieldIdDtReturn[$i]);
                $purchasedt->d_pcsrdt_qtyconfirm = $request->fieldConfirmReturn[$i];
                $purchasedt->d_pcsrdt_updated = Carbon::now();
                $purchasedt->d_pcsrdt_isconfirm = "TRUE";
                $purchasedt->save();
            }
        }
        else
        {
            $purchase->d_pcsr_dateconfirm = null;
            $purchase->d_pcsr_status = $request->statusReturnConfirm;
            $purchase->d_pcsr_updated = Carbon::now();
            $purchase->save();

            //update table d_purchasing_dt
            $hitung_field = count($request->fieldConfirmReturn);
            for ($i=0; $i < $hitung_field; $i++) 
            {
                $purchasedt = d_purchasingreturn_dt::find($request->fieldIdDtReturn[$i]);
                $purchasedt->d_pcsrdt_qtyconfirm = $request->fieldConfirmReturn[$i];
                $purchasedt->d_pcsrdt_updated = Carbon::now();
                $purchasedt->d_pcsrdt_isconfirm = "FALSE";
                $purchasedt->save();
            }
        }

        DB::commit();
        return response()->json([
            'status' => 'sukses',
            'pesan' => 'Data Konfirmasi Return Berhasil Diupdate'
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

  public function getDataBelanjaHarian()
  {
    $data = d_purchasingharian::join('d_supplier','d_purchasingharian.d_pcsh_supid','=','d_supplier.s_id')
            ->join('d_mem', 'd_purchasingharian.d_pcsh_staff','=','d_mem.m_id')
            ->select('d_purchasingharian.*', 'd_supplier.s_id', 'd_supplier.s_company', 'd_mem.m_id', 'd_mem.m_name')
            ->orderBy('d_pcsh_created', 'DESC')
            ->get();
    //dd($data);    
    return DataTables::of($data)
    ->addIndexColumn()
    ->editColumn('status', function ($data)
    {
      if ($data->d_pcsh_status == "WT") 
      {
        return '<span class="label label-info">Waiting</span>';
      }
      elseif ($data->d_pcsh_status == "CF") 
      {
        return '<span class="label label-success">Disetujui</span>';
      }
      elseif ($data->d_pcsh_status == "DE") 
      {
        return '<span class="label label-warning">Dapat Diedit</span>';
      }
    })
    ->editColumn('tglBelanja', function ($data) 
    {
        if ($data->d_pcsh_date == null) 
        {
            return '-';
        }
        else 
        {
            return $data->d_pcsh_date ? with(new Carbon($data->d_pcsh_date))->format('d M Y') : '';
        }
    })
    ->editColumn('tglConfirm', function ($data) 
    {
        if ($data->d_pcsh_dateconfirm == null) 
        {
            return '-';
        }
        else 
        {
            return $data->d_pcsh_dateconfirm ? with(new Carbon($data->d_pcsh_dateconfirm))->format('d M Y') : '';
        }
    })
    ->editColumn('hargaTotal', function ($data) 
    {
      return 'Rp. '.number_format($data->d_pcsh_totalprice,2,",",".");
    })
    ->addColumn('action', function($data)
    {
      if ($data->d_pcsh_status == "WT") 
      {
        return '<div class="text-center">
                  <button class="btn btn-sm btn-primary" title="Ubah Status"
                      onclick=konfirmasiBelanjaHarian("'.$data->d_pcsh_id.'","all")><i class="fa fa-check"></i>
                  </button>
              </div>'; 
      }
      else 
      {
        return '<div class="text-center">
                  <button class="btn btn-sm btn-primary" title="Ubah Status"
                      onclick=konfirmasiBelanjaHarian("'.$data->d_pcsh_id.'","confirmed")><i class="fa fa-check"></i>
                  </button>
              </div>'; 
      }
    })
    ->rawColumns(['status', 'action'])
    ->make(true);
  }

  public function confirmBelanjaHarian($id,$type)
  {
    $dataHeader = d_purchasingharian::join('d_supplier','d_purchasingharian.d_pcsh_supid','=','d_supplier.s_id')
                ->join('d_mem', 'd_purchasingharian.d_pcsh_staff','=','d_mem.m_id')
                ->select('d_purchasingharian.*', 'd_supplier.s_id', 'd_supplier.s_company', 'd_mem.m_name', 'd_mem.m_id')
                ->where('d_pcsh_id', '=', $id)
                ->orderBy('d_pcsh_created', 'DESC')
                ->get();

    $statusLabel = $dataHeader[0]->d_pcsh_status;
    if ($statusLabel == "WT") 
    {
        $spanTxt = 'Waiting';
        $spanClass = 'label-info';
    }
    elseif ($statusLabel == "DE")
    {
        $spanTxt = 'Dapat Diedit';
        $spanClass = 'label-warning';
    }
    else
    {
        $spanTxt = 'Di setujui';
        $spanClass = 'label-success';
    }

    if ($type == "all") 
    {
      $dataIsi = d_purchasingharian_dt::join('m_item', 'd_purchasingharian_dt.d_pcshdt_item', '=', 'm_item.i_id')
                ->join('m_satuan', 'd_purchasingharian_dt.d_pcshdt_sat', '=', 'm_satuan.m_sid')
                ->select('d_purchasingharian_dt.*', 'm_item.*', 'm_satuan.m_sname', 'm_satuan.m_sid')
                ->where('d_purchasingharian_dt.d_pcshdt_pcshid', '=', $id)
                ->orderBy('d_purchasingharian_dt.d_pcshdt_created', 'DESC')
                ->get();
    }
    else
    {
      $dataIsi = d_purchasingharian_dt::join('m_item', 'd_purchasingharian_dt.d_pcshdt_item', '=', 'm_item.i_id')
                ->join('m_satuan', 'd_purchasingharian_dt.d_pcshdt_sat', '=', 'm_satuan.m_sid')
                ->select('d_purchasingharian_dt.*', 'm_item.*', 'm_satuan.m_sname', 'm_satuan.m_sid')
                ->where('d_purchasingharian_dt.d_pcshdt_pcshid', '=', $id)
                ->where('d_purchasingharian_dt.d_pcshdt_isconfirm', '=', "TRUE")
                ->orderBy('d_purchasingharian_dt.d_pcshdt_created', 'DESC')
                ->get();
    }

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
    
    return Response()->json([
        'status' => 'sukses',
        'header' => $dataHeader,
        'data_isi' => $dataIsi,
        'data_stok' => $dataStok['val_stok'],
        'data_satuan' => $dataStok['txt_satuan'],
        'spanTxt' => $spanTxt,
        'spanClass' => $spanClass,
    ]);
  }

  public function submitBelanjaHarian(Request $request)
  {
    //dd($request->all());
    DB::beginTransaction();
    try {
        //update table d_belanjaharian
        $bharian = d_purchasingharian::find($request->idBelanja);
        if ($request->statusBelanjaConfirm != "WT") 
        {
            $bharian->d_pcsh_dateconfirm = date('Y-m-d',strtotime(Carbon::now()));
            $bharian->d_pcsh_status = $request->statusBelanjaConfirm;
            $bharian->d_pcsh_updated = Carbon::now();
            $bharian->save();

            //update table d_purchasingharian_dt
            $hitung_field = count($request->fieldConfirmBelanja);
            for ($i=0; $i < $hitung_field; $i++) 
            {
                $bhariandt = d_purchasingharian_dt::find($request->fieldIdDtBelanja[$i]);
                $bhariandt->d_pcshdt_qtyconfirm = $request->fieldConfirmBelanja[$i];
                $bhariandt->d_pcshdt_updated = Carbon::now();
                $bhariandt->d_pcshdt_isconfirm = "TRUE";
                $bhariandt->save();
            }
        }
        else
        {
            $bharian->d_pcsh_dateconfirm = null;
            $bharian->d_pcsh_status = $request->statusBelanjaConfirm;
            $bharian->d_pcsh_updated = Carbon::now();
            $bharian->save();

            //update table d_purchasingharian_dt
            $hitung_field = count($request->fieldConfirmBelanja);
            for ($i=0; $i < $hitung_field; $i++) 
            {
                $bhariandt = d_purchasingharian_dt::find($request->fieldIdDtBelanja[$i]);
                $bhariandt->d_pcshdt_qtyconfirm = $request->fieldConfirmBelanja[$i];
                $bhariandt->d_pcshdt_updated = Carbon::now();
                $bhariandt->d_pcshdt_isconfirm = "FALSE";
                $bhariandt->save();
            }
        }

        DB::commit();
        return response()->json([
            'status' => 'sukses',
            'pesan' => 'Data Konfirmasi Belanja Harian Berhasil Diupdate'
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

  public function konvertRp($value)
  {
    $value = str_replace(['Rp', '\\', '.', ' '], '', $value);
    return str_replace(',', '.', $value);
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
        elseif ($val->i_type == "BL") //bahan baku
        {
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '2' AND s_position = '2' limit 1) ,'0') as qtyStok"));
            $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')->select('m_satuan.m_sname')->where('m_item.i_sat1', '=', $arrSatuan[$counter])->first();

            $stok[] = $query[0];
            $satuan[] = $satUtama->m_sname;
            $counter++;
        }
    }

    $data = array('val_stok' => $stok, 'txt_satuan' => $satuan);
    return $data;
  }

}