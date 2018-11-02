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
use App\d_purchasing;
use App\d_purchasing_dt;
use App\d_terima_pembelian;
use App\d_terima_pembelian_dt;

class OrderPembelianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function order()
    {
        return view('purchasing/orderpembelian/index');
    }

    public function tambah_order()
    {
      //code order
      $query = DB::select(DB::raw("SELECT MAX(RIGHT(d_pcs_code,4)) as kode_max from d_purchasing WHERE DATE_FORMAT(d_pcs_date_created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));
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

      $codePO = "PO-".date('ym')."-".$kd;
      $staff['nama'] = Auth::user()->m_name;
      $staff['id'] = Auth::User()->m_id;
      return view ('/purchasing/orderpembelian/tambah_order',compact('codePO', 'staff'));
    }

    public function getSupplier(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term)) {
            $sup = DB::table('d_supplier')->get();
            foreach ($sup as $val) {
                $formatted_tags[] = ['id' => $val->s_id, 'text' => $val->s_company];
            }
            return Response::json($formatted_tags);
        }
        else
        {
            $sup = DB::table('d_supplier')->where('s_company', 'LIKE', '%'.$term.'%')->get();
            foreach ($sup as $val) {
                $formatted_tags[] = ['id' => $val->s_id, 'text' => $val->s_company];
            }

            return Response::json($formatted_tags);  
        }
    }

    public function getDataRencanaBeli(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term)) {
            $sup = DB::table('d_purchasingplan_dt')
                     ->select('d_purchasingplan.d_pcsp_code', 'd_purchasingplan_dt.d_pcspdt_idplan')
                     ->join('d_purchasingplan','d_purchasingplan_dt.d_pcspdt_idplan','=','d_purchasingplan.d_pcsp_id')
                     ->where('d_purchasingplan_dt.d_pcspdt_isconfirm', '=', "TRUE")
                     ->where('d_purchasingplan_dt.d_pcspdt_ispo', '=', "FALSE")
                     ->groupBy('d_purchasingplan_dt.d_pcspdt_idplan')
                     ->get();
            foreach ($sup as $val) {
                $formatted_tags[] = ['id' => $val->d_pcspdt_idplan, 'text' => $val->d_pcsp_code];
            }
            return Response::json($formatted_tags);
        }
        else
        {
            $sup = DB::table('d_purchasingplan_dt')
                     ->select('d_purchasingplan.d_pcsp_code', 'd_purchasingplan_dt.d_pcspdt_idplan')
                     ->join('d_purchasingplan','d_purchasingplan_dt.d_pcspdt_idplan','=','d_purchasingplan.d_pcsp_id')
                     ->where('d_purchasingplan.d_pcsp_code', 'LIKE', '%'.$term.'%')
                     ->where('d_purchasingplan_dt.d_pcspdt_isconfirm', '=', "TRUE")
                     ->where('d_purchasingplan_dt.d_pcspdt_ispo', '=', "FALSE")
                     ->groupBy('d_purchasingplan_dt.d_pcspdt_idplan')
                     ->get();
            foreach ($sup as $val) {
                $formatted_tags[] = ['id' => $val->d_pcspdt_idplan, 'text' => $val->d_pcsp_code];
            }

            return Response::json($formatted_tags);  
        }
    }

    public function getOrderByTgl($tgl1, $tgl2)
    {
      $y = substr($tgl1, -4);
      $m = substr($tgl1, -7,-5);
      $d = substr($tgl1,0,2);
       $tanggal1 = $y.'-'.$m.'-'.$d;

      $y2 = substr($tgl2, -4);
      $m2 = substr($tgl2, -7,-5);
      $d2 = substr($tgl2,0,2);
      $tanggal2 = $y2.'-'.$m2.'-'.$d2;

      $data = d_purchasing::join('d_supplier','d_purchasing.s_id','=','d_supplier.s_id')
              ->join('d_mem','d_purchasing.d_pcs_staff','=','d_mem.m_id')
              ->select('d_pcs_date_created','d_pcs_id', 'd_pcsp_id','d_pcs_code','s_company','d_pcs_method','d_pcs_total_net','d_pcs_date_received','d_pcs_status','d_mem.m_id','d_mem.m_name')
              ->whereBetween('d_purchasing.d_pcs_date_created', [$tanggal1, $tanggal2])
              ->orderBy('d_pcs_created', 'DESC')
              ->get();

      return DataTables::of($data)
      ->addIndexColumn()
      ->editColumn('status', function ($data)
      {
        if ($data->d_pcs_status == "WT") 
        {
          return '<span class="label label-default">Waiting</span>';
        }
        elseif ($data->d_pcs_status == "DE") 
        {
          return '<span class="label label-warning">Dapat diedit</span>';
        }
        elseif ($data->d_pcs_status == "CF") 
        {
          return '<span class="label label-info">Disetujui</span>';
        }
        else
        {
          return '<span class="label label-success">Diterima</span>';
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
      ->editColumn('hargaTotalNet', function ($data) 
      {
        return number_format($data->d_pcs_total_net,0,",",".");
      })
      ->editColumn('tglMasuk', function ($data) 
      {
        if ($data->d_pcs_date_received == null) 
        {
            return '-';
        }
        else 
        {
            return $data->d_pcs_date_received ? with(new Carbon($data->d_pcs_date_received))->format('d M Y') : '';
        }
      })
      ->addColumn('action', function($data)
      {
        if ($data->d_pcs_status == "WT") 
        {
          return '<div class="text-center">
                      <button class="btn btn-sm btn-success" title="Detail"
                          onclick=detailOrder("'.$data->d_pcs_id.'")><i class="fa fa-info-circle"></i> 
                      </button>
                      <button class="btn btn-sm btn-warning" title="Edit"
                          onclick=editOrder("'.$data->d_pcs_id.'")><i class="fa fa-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" title="Delete"
                          onclick=deleteOrder("'.$data->d_pcs_id.'")><i class="fa fa-times-circle"></i>
                      </button>
                  </div>'; 
        }
        elseif ($data->d_pcs_status == "DE") 
        {
          return '<div class="text-center">
                      <button class="btn btn-sm btn-success" title="Detail"
                          onclick=detailOrder("'.$data->d_pcs_id.'")><i class="fa fa-info-circle"></i> 
                      </button>
                      <button class="btn btn-sm btn-warning" title="Edit"
                          onclick=editOrder("'.$data->d_pcs_id.'")><i class="fa fa-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" title="Delete"
                          onclick=deleteOrder("'.$data->d_pcs_id.'") disabled><i class="fa fa-times-circle"></i>
                      </button>
                  </div>'; 
        }
        else
        {
          return '<div class="text-center">
                      <button class="btn btn-sm btn-success" title="Detail"
                          onclick=detailOrder("'.$data->d_pcs_id.'")><i class="fa fa-info-circle"></i> 
                      </button>
                      <button class="btn btn-sm btn-warning" title="Edit"
                          onclick=editOrder("'.$data->d_pcs_id.'") disabled><i class="fa fa-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" title="Delete"
                          onclick=deleteOrder("'.$data->d_pcs_id.'") disabled><i class="fa fa-times-circle"></i>
                      </button>
                  </div>'; 
        }  
      })
      ->rawColumns(['status', 'action'])
      ->make(true);
    }

    public function getDataDetail($id)
    {
        $dataHeader = d_purchasing::join('d_supplier','d_purchasing.s_id','=','d_supplier.s_id')
                ->join('d_mem','d_purchasing.d_pcs_staff','=','d_mem.m_id')
                ->select('d_purchasing.*', 'd_supplier.s_company', 'd_supplier.s_name','d_mem.m_id','d_mem.m_name')
                ->where('d_pcs_id', '=', $id)
                ->orderBy('d_pcs_date_created', 'DESC')
                ->get();

        $statusLabel = $dataHeader[0]->d_pcs_status;
        if ($statusLabel == "WT") 
        {
          $spanTxt = 'Waiting';
          $spanClass = 'label-default';
        }
        elseif ($statusLabel == "DE")
        {
          $spanTxt = 'Dapat Diedit';
          $spanClass = 'label-warning';
        }
        elseif ($statusLabel == "CF")
        {
          $spanTxt = 'Di setujui';
          $spanClass = 'label-info';
        }
        else
        {
          $spanTxt = 'Barang telah diterima';
          $spanClass = 'label-success';
        }

        foreach ($dataHeader as $val) 
        {
          $data = array(
              'hargaBruto' => 'Rp. '.number_format($val->d_pcs_total_gross,2,",","."),
              'nilaiDiskon' => 'Rp. '.number_format($val->d_pcs_discount + $val->d_pcs_disc_value,2,",","."),
              'nilaiPajak' => 'Rp. '.number_format($val->d_pcs_tax_value,2,",","."),
              'hargaNet' => 'Rp. '.number_format($val->d_pcs_total_net,2,",",".")
          );
        }

        $dataIsi = d_purchasing_dt::join('m_item', 'd_purchasing_dt.i_id', '=', 'm_item.i_id')
                ->join('m_satuan', 'd_purchasing_dt.d_pcsdt_sat', '=', 'm_satuan.m_sid')
                ->select('d_purchasing_dt.d_pcsdt_id',
                         'd_purchasing_dt.d_pcs_id',
                         'd_purchasing_dt.i_id',
                         'm_item.i_name',
                         'm_item.i_code',
                         'm_item.i_sat1',
                         'm_satuan.m_sname',
                         'm_satuan.m_sid',
                         'd_purchasing_dt.d_pcsdt_prevcost',
                         'd_purchasing_dt.d_pcsdt_qty',
                         'd_purchasing_dt.d_pcsdt_price',
                         'd_purchasing_dt.d_pcsdt_total'
                )
                ->where('d_purchasing_dt.d_pcs_id', '=', $id)
                ->orderBy('d_purchasing_dt.d_pcsdt_created', 'DESC')
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
            'header2' => $data,
            'data_isi' => $dataIsi,
            'data_stok' => $dataStok['val_stok'],
            'data_satuan' => $dataStok['txt_satuan'],
            'spanTxt' => $spanTxt,
            'spanClass' => $spanClass,
        ]);
    }

    public function getDataTabelHistory($tgl1, $tgl2, $tampil)
    {
        $y = substr($tgl1, -4);
        $m = substr($tgl1, -7,-5);
        $d = substr($tgl1,0,2);
        $tanggal1 = $y.'-'.$m.'-'.$d;

        $y2 = substr($tgl2, -4);
        $m2 = substr($tgl2, -7,-5);
        $d2 = substr($tgl2,0,2);
        $tanggal2 = $y2.'-'.$m2.'-'.$d2;

        if ($tampil == 'wait') {
          $isConfirm = "FALSE";
          $indexStatus = "WT";
        }elseif ($tampil == 'edit') {
          $isConfirm = "TRUE";
          $indexStatus = "DE";
        }elseif ($tampil == 'confirm') {
          $isConfirm = "TRUE";
          $indexStatus = "CF";
        }else if ($tampil == 'received') {
          $isConfirm = "TRUE";
          $indexStatus = "RC";
        }else {
          $isConfirm = "TRUE";
          $indexStatus = "RV";
        }

        $data = DB::table('d_purchasing_dt')
            ->select('d_purchasing_dt.*', 'd_purchasing.*', 'm_item.i_name', 'd_supplier.s_company', 'm_satuan.m_sname', 'd_terima_pembelian_dt.d_tbdt_qty')
            ->leftJoin('d_purchasing','d_purchasing_dt.d_pcs_id','=','d_purchasing.d_pcs_id')
            ->leftJoin('d_supplier','d_purchasing.s_id','=','d_supplier.s_id')
            ->leftJoin('m_item','d_purchasing_dt.i_id','=','m_item.i_id')
            ->leftJoin('m_satuan','d_purchasing_dt.d_pcsdt_sat','=','m_satuan.m_sid')
            ->leftJoin('d_terima_pembelian_dt','d_purchasing_dt.d_pcsdt_idpdt','=','d_terima_pembelian_dt.d_tbdt_idpcsdt')
            ->where('d_purchasing_dt.d_pcsdt_isconfirm','=',$isConfirm)
            ->where('d_purchasing.d_pcs_status','=',$indexStatus)
            ->whereBetween('d_purchasing.d_pcs_date_created', [$tanggal1, $tanggal2])
            ->get();

        for ($z=0; $z < count($data); $z++) 
        {   
          //variabel untuk menyimpan penjumlahan array qty penerimaan
          $hasil_qty_rcv = 0;
          //get data qty received
          $qtyRcv = DB::select(DB::raw("SELECT IFNULL(sum(d_tbdt_qty), 0) as zz FROM d_terima_pembelian_dt where d_tbdt_idpcsdt = '".$data[$z]->d_pcsdt_id."'"));
          
          foreach ($qtyRcv as $nilai) 
          {
            $hasil_qty_rcv = (int)$nilai->zz;
          }
          //create new object properties and assign value
          $data[$z]->qty_received = $hasil_qty_rcv;
        }

        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('status', function ($data)
          {
          if ($data->d_pcs_status == "WT") 
          {
            return '<span class="label label-default">Waiting</span>';
          }
          elseif ($data->d_pcs_status == "DE") 
          {
            return '<span class="label label-warning">Dapat diedit</span>';
          }
          elseif ($data->d_pcs_status == "CF") 
          {
            return '<span class="label label-info">Disetujui</span>';
          }
          elseif ($data->d_pcs_status == "RC") 
          {
            return '<span class="label label-success">Diterima</span>';
          }
          else
          {
            return '<span class="label label-warning">Revisi</span>';
          }
        })
        ->editColumn('tglBuat', function ($data) 
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
        ->editColumn('tglTerima', function ($data) 
        {
            if ($data->d_pcs_date_received == null) 
            {
                return '-';
            }
            else 
            {
                return $data->d_pcs_date_received ? with(new Carbon($data->d_pcs_date_received))->format('d M Y') : '';
            }
        })
        ->editColumn('qtyTerima', function ($data) 
        {
            $qty = ($data->qty_received == null) ? '-' : $data->qty_received;
            return $qty;
        })
        ->addColumn('action', function($data)
        {
          if ($data->d_pcs_status == "WT" || $data->d_pcs_status == "DE" || $data->d_pcs_status == "CF" || $data->d_pcs_status == "RV") 
          {
            return '<div class="text-center"> - </div>'; 
          }
          elseif ($data->d_pcs_status == "RC") 
          {
            return '<div class="text-center">
                      <button class="btn btn-sm btn-success" title="Detail"
                          onclick=detailMasukPeritem("'.$data->d_pcsdt_id.'")><i class="fa fa-eye"></i> 
                      </button>
                    </div>'; 
          }
          
        })
        ->rawColumns(['status', 'action'])
        ->make(true);
    }

    public function getPenerimaanPeritem($id)
    {
        $dataHeader = d_purchasing_dt::join('d_purchasing','d_purchasing_dt.d_pcs_id','=','d_purchasing.d_pcs_id')
            ->join('d_supplier','d_purchasing_dt.d_pcsdt_sid','=','d_supplier.s_id')
            ->select('d_purchasing.d_pcs_code', 'd_purchasing_dt.d_pcsdt_qty', 'd_purchasing.d_pcs_date_created', 'd_supplier.s_company')
            ->where('d_purchasing_dt.d_pcsdt_id', '=', $id)
            ->get();

        $dataIsi = d_terima_pembelian_dt::join('d_terima_pembelian', 'd_terima_pembelian_dt.d_tbdt_idtb', '=', 'd_terima_pembelian.d_tb_id')
                ->join('m_item', 'd_terima_pembelian_dt.d_tbdt_item', '=', 'm_item.i_id')
                ->join('m_satuan', 'd_terima_pembelian_dt.d_tbdt_sat', '=', 'm_satuan.m_sid')
                ->select('m_item.i_name', 'm_item.i_code', 'm_satuan.m_sname', 'd_terima_pembelian_dt.d_tbdt_qty', 'd_terima_pembelian.d_tb_code', 'd_terima_pembelian_dt.d_tbdt_date_received', 'd_terima_pembelian.d_tb_date')
                ->where('d_terima_pembelian_dt.d_tbdt_idpcsdt', '=', $id)
                ->orderBy('d_terima_pembelian_dt.d_tbdt_date_received', 'ASC')
                ->get();

        foreach ($dataIsi as $val) 
        {   
          $tanggalTerima[] = date('d-m-Y',strtotime($val->d_tbdt_date_received));
        }
        
        return response()->json([
            'status' => 'sukses',
            'header' => $dataHeader,
            'isi' => $dataIsi,
            'tanggalTerima' => $tanggalTerima
        ]);
    }

    public function getEditOrder($id)
    {
      $dataHeader = d_purchasing::join('d_supplier','d_purchasing.s_id','=','d_supplier.s_id')
                ->join('d_mem','d_purchasing.d_pcs_staff','=','d_mem.m_id')
                ->select('d_purchasing.*', 'd_supplier.s_company', 'd_supplier.s_name', 'd_mem.m_name', 'd_mem.m_id')
                ->where('d_pcs_id', '=', $id)
                ->orderBy('d_pcs_date_created', 'DESC')
                ->get();

      $statusLabel = $dataHeader[0]->d_pcs_status;
      if ($statusLabel == "WT") 
      {
        $spanTxt = 'Waiting';
        $spanClass = 'label-default';
      }
      elseif ($statusLabel == "DE")
      {
        $spanTxt = 'Dapat Diedit';
        $spanClass = 'label-warning';
      }
      elseif ($statusLabel == "CF")
      {
        $spanTxt = 'Di setujui';
        $spanClass = 'label-info';
      }
      else
      {
        $spanTxt = 'Barang telah diterima';
        $spanClass = 'label-success';
      }

      $dataIsi = d_purchasing_dt::join('m_item', 'd_purchasing_dt.i_id', '=', 'm_item.i_id')
                ->join('m_satuan', 'd_purchasing_dt.d_pcsdt_sat', '=', 'm_satuan.m_sid')
                ->select('d_purchasing_dt.*', 'm_item.*', 'm_satuan.m_sname', 'm_satuan.m_sid')
                ->where('d_purchasing_dt.d_pcs_id', '=', $id)
                ->orderBy('d_purchasing_dt.d_pcsdt_created', 'DESC')
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
        'spanTxt' => $spanTxt,
        'spanClass' => $spanClass
      ]);
    }

    public function getDataForm($id)
    {
      $dataHeader = DB::table('d_purchasingplan')
                    ->select('d_supplier.s_id', 'd_supplier.s_company')
                    ->join('d_supplier', 'd_purchasingplan.d_pcsp_sup', '=', 'd_supplier.s_id')
                    ->where('d_purchasingplan.d_pcsp_id', '=', $id)
                    ->get();

      $dataIsi = DB::table('d_purchasingplan_dt')
            ->select('d_purchasingplan_dt.*', 'm_item.i_name', 'm_item.i_code', 'm_item.i_sat1', 'm_item.i_id', 'm_satuan.m_sname', 'm_satuan.m_sid')
            ->leftJoin('m_item','d_purchasingplan_dt.d_pcspdt_item','=','m_item.i_id')
            ->leftJoin('m_satuan','d_purchasingplan_dt.d_pcspdt_sat','=','m_satuan.m_sid')
            ->where('d_purchasingplan_dt.d_pcspdt_idplan', '=', $id)
            ->where('d_purchasingplan_dt.d_pcspdt_ispo', '=', "FALSE")
            ->where('d_purchasingplan_dt.d_pcspdt_isconfirm', '=', "TRUE")
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
            'data_header' => $dataHeader,
            'data_isi' => $dataIsi,
            'data_stok' => $dataStok['val_stok'],
            'data_satuan' => $dataStok['txt_satuan'],
        ]);
    }

    public function simpanPo(Request $request)
    {
      //dd($request->all());
      $totalGross = $this->konvertRp($request->totalGross);
      $replaceCharDisc = (int)str_replace("%","",$request->diskonHarga);
      $replaceCharPPN = (int)str_replace("%","",$request->ppnHarga);
      $diskonPotHarga = $this->konvertRp($request->potonganHarga);
      $discValue = $totalGross * $replaceCharDisc / 100;

      DB::beginTransaction();
      try {
        
          //insert to table d_purchasing
          $dataHeader = new d_purchasing;
          $dataHeader->d_pcsp_id = $request->cariKodePlan;
          $dataHeader->s_id = $request->cariSup;
          $dataHeader->d_pcs_code = $request->kodePo;
          $dataHeader->d_pcs_staff = $request->idStaff;
          $dataHeader->d_pcs_method = $request->methodBayar;
          $dataHeader->d_pcs_total_gross = $totalGross;
          $dataHeader->d_pcs_discount = $diskonPotHarga;
          $dataHeader->d_pcs_disc_percent = $replaceCharDisc;
          $dataHeader->d_pcs_disc_value = $discValue;
          $dataHeader->d_pcs_tax_percent = $replaceCharPPN;
          if (isset($request->apdTgl)) {
            $dataHeader->d_pcs_duedate = date('Y-m-d',strtotime($request->apdTgl));
          }
          $dataHeader->d_pcs_tax_value = ($totalGross - $diskonPotHarga - $discValue) * $replaceCharPPN / 100;
          $dataHeader->d_pcs_total_net = $this->konvertRp($request->totalNett);
          $dataHeader->d_pcs_sisapayment = $this->konvertRp($request->totalNett);
          $dataHeader->d_pcs_date_created = date('Y-m-d',strtotime($request->tanggal));
          $dataHeader->save(); 
        
        //get last lastId then insert id to d_purchasing_dt
        $lastId = d_purchasing::select('d_pcs_id')->max('d_pcs_id');
        if ($lastId == 0 || $lastId == '') 
        {
          $lastId  = 1;
        }  

        //variabel untuk hitung array field
        $hitung_field = count($request->fieldItemId);

        //update pada tabel d_purchasingplan_dt column
        for ($i=0; $i < $hitung_field; $i++) 
        { 
          DB::table('d_purchasingplan_dt')
          ->where('d_pcspdt_id', $request->fieldidPlanDt[$i])
          ->update(['d_pcspdt_ispo' => 'TRUE', 'd_pcspdt_poid' => $lastId]);
        }

        //insert data isi
        for ($i=0; $i < $hitung_field; $i++) 
        {
          $old_str = [".", ","];
          $new_str = ["", "."];
          $dataIsi = new d_purchasing_dt;
          $dataIsi->d_pcs_id = $lastId;
          $dataIsi->i_id = $request->fieldItemId[$i];
          $dataIsi->d_pcsdt_sid = $request->cariSup;
          $dataIsi->d_pcsdt_sat = $request->fieldIdSatuan[$i];
          $dataIsi->d_pcsdt_idpdt = $request->fieldidPlanDt[$i];
          $dataIsi->d_pcsdt_qty = $request->fieldQty[$i];
          $dataIsi->d_pcsdt_price = str_replace($old_str, $new_str, $request->fieldHarga[$i]);
          $dataIsi->d_pcsdt_prevcost = str_replace($old_str, $new_str, $request->fieldHargaPrev[$i]);
          $dataIsi->d_pcsdt_total = str_replace($old_str, $new_str, $request->fieldHargaTotal[$i]);
          $dataIsi->d_pcsdt_created = Carbon::now();
          $dataIsi->save();
        } 
        
      DB::commit();
      return response()->json([
            'status' => 'sukses',
            'pesan' => 'Data Order Pembelian Berhasil Disimpan'
        ]);
      } 
      catch (\Exception $e) 
      {
        //dd($e);
        DB::rollback();
        return response()->json([
            'status' => 'gagal',
            'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
        ]);
      }
    }

    public function updateDataOrder(Request $request)
    {
      //dd($request->all());
      $totalGross = $this->konvertRp($request->totalGrossEdit);
      $replaceCharDisc = (int)str_replace("%","",$request->diskonHargaEdit);
      $replaceCharPPN = (int)str_replace("%","",$request->ppnHargaEdit);
      $diskonPotHarga = $this->konvertRp($request->potonganHargaEdit);
      $discValue = $totalGross * $replaceCharDisc / 100;
      DB::beginTransaction();
      try {
        //update to table d_purchasing
        $purchasing = d_purchasing::find($request->idPurchaseEdit);
        $purchasing->d_pcs_staff = Auth::User()->m_id;
        $purchasing->d_pcs_total_gross = $totalGross;
        $purchasing->d_pcs_discount = $diskonPotHarga;
        $purchasing->d_pcs_disc_percent = $replaceCharDisc;
        $purchasing->d_pcs_disc_value = $discValue;
        $purchasing->d_pcs_tax_percent = $replaceCharPPN;
        $purchasing->d_pcs_tax_value = ($totalGross - $diskonPotHarga - $discValue) * $replaceCharPPN / 100;
        $purchasing->d_pcs_total_net = $this->konvertRp($request->totalNettEdit);
        $purchasing->d_pcs_sisapayment = $this->konvertRp($request->totalNettEdit);
        $purchasing->d_pcs_updated = Carbon::now('Asia/Jakarta');
        $purchasing->save();
        
        //update to table d_purchasing_dt
        $hitung_field_edit = count($request->fieldIdPurchaseDt);
        $old_str = [".", ","];
        $new_str = ["", "."];
        for ($i=0; $i < $hitung_field_edit; $i++) 
        {
          $purchasingdt = d_purchasing_dt::find($request->fieldIdPurchaseDt[$i]);
          $purchasingdt->d_pcsdt_price = str_replace($old_str, $new_str, $request->fieldHarga[$i]);
          $purchasingdt->d_pcsdt_total = str_replace($old_str, $new_str, $request->fieldHargaTotal[$i]);
          $purchasingdt->d_pcsdt_updated = Carbon::now('Asia/Jakarta');
          $purchasingdt->save();
        } 
        
      DB::commit();
      return response()->json([
            'status' => 'sukses',
            'pesan' => 'Data Order Pembelian Berhasil Diupdate'
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

    public function deleteDataOrder(Request $request)
    {
      //dd($request->all());
      DB::beginTransaction();
      try {
        //update d_purchasingplan_dt ispo
        DB::table('d_purchasingplan_dt')
            ->where('d_pcspdt_poid', $request->idPo)
            ->where('d_pcspdt_ispo', "TRUE")
            ->update(['d_pcspdt_ispo' => "FALSE", 'd_pcspdt_poid' => "0"]);

        //delete row table d_purchasing_dt
        $deleteOrderDt = d_purchasing_dt::where('d_pcs_id', $request->idPo)->delete();
        //delete row table d_purchasing
        $deleteOrder = d_purchasing::where('d_pcs_id', $request->idPo)->delete();

        DB::commit();
        return response()->json([
            'status' => 'sukses',
            'pesan' => 'Data Order Pembelian Berhasil Dihapus'
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
      return (int)str_replace(',', '.', $value);
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
      }

      $data = array('val_stok' => $stok, 'txt_satuan' => $satuan);
      return $data;
    }
    
    public function print($id)
    {

      $dataHeader = d_purchasing::join('d_supplier','d_purchasing.s_id','=','d_supplier.s_id')
                ->join('d_mem','d_purchasing.d_pcs_staff','=','d_mem.m_id')
                ->select('d_purchasing.*', 'd_supplier.s_company', 'd_supplier.s_name','d_mem.m_id','d_mem.m_name', DB::raw('SUM(d_purchasing.d_pcs_disc_percent) * SUM(d_purchasing.d_pcs_total_gross) as disc_total'))
                ->where('d_pcs_id', '=', $id)
                ->orderBy('d_pcs_date_created', 'DESC')
                ->get()->toArray();

      $dataIsi = d_purchasing_dt::join('m_item', 'd_purchasing_dt.i_id', '=', 'm_item.i_id')
                ->join('m_satuan', 'd_purchasing_dt.d_pcsdt_sat', '=', 'm_satuan.m_sid')
                ->select('d_purchasing_dt.d_pcsdt_id',
                         'd_purchasing_dt.d_pcs_id',
                         'd_purchasing_dt.i_id',
                         'm_item.i_id',
                         'm_item.i_name',
                         'm_item.i_code',
                         'm_item.i_sat1',
                         'm_satuan.m_sname',
                         'm_satuan.m_sid',
                         'd_purchasing_dt.d_pcsdt_prevcost',
                         'd_purchasing_dt.d_pcsdt_qty',
                         'd_purchasing_dt.d_pcsdt_price',
                         'd_purchasing_dt.d_pcsdt_total'
                )
                ->where('d_purchasing_dt.d_pcs_id', '=', $id)
                ->orderBy('d_purchasing_dt.d_pcsdt_created', 'DESC')
                ->get()->toArray();
      
      foreach ($dataIsi as $val) 
      {
          //cek item type
          $itemType[] = DB::table('m_item')->select('i_type', 'i_id')->where('i_id','=', $val['i_id'])->first();
          //get satuan utama
          $sat1[] = $val['i_sat1'];
      }

      //variabel untuk count array
      $counter = 0;
      //ambil value stok by item type
      $dataStok = $this->getStokByType($itemType, $sat1, $counter);
      $dataStokQty = array_chunk($dataStok['val_stok'], 10);
      $dataStokTxt = array_chunk($dataStok['txt_satuan'], 10);
      $dataIsi = array_chunk($dataIsi, 10);

      // return $dataStok;

      return view('purchasing/orderpembelian/print', compact('dataHeader', 'dataIsi', 'dataStokQty', 'dataStokTxt'));
    }
}
