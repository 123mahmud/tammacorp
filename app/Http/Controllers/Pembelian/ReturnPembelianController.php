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
use App\d_purchasingreturn;
use App\d_purchasingreturn_dt;
use App\d_stock;
use App\d_stock_mutation;
use App\lib\mutasi;

class ReturnPembelianController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
    return view('/purchasing/returnpembelian/index');
  }

  public function getReturnByTgl($tgl1, $tgl2)
  {
    $y = substr($tgl1, -4);
    $m = substr($tgl1, -7,-5);
    $d = substr($tgl1,0,2);
     $tanggal1 = $y.'-'.$m.'-'.$d;

    $y2 = substr($tgl2, -4);
    $m2 = substr($tgl2, -7,-5);
    $d2 = substr($tgl2,0,2);
    $tanggal2 = $y2.'-'.$m2.'-'.$d2;

    $data = d_purchasingreturn::join('d_purchasing','d_purchasingreturn.d_pcsr_pcsid','=','d_purchasing.d_pcs_id')
          ->join('d_supplier','d_purchasingreturn.d_pcsr_supid','=','d_supplier.s_id')
          ->join('d_mem','d_purchasingreturn.d_pcs_staff','=','d_mem.m_id')
          ->select('d_purchasingreturn.*', 'd_supplier.s_id', 'd_supplier.s_company', 'd_purchasing.d_pcs_id', 'd_purchasing.d_pcs_code', 'd_mem.m_id', 'd_mem.m_name')
          ->whereBetween('d_pcsr_datecreated', [$tanggal1, $tanggal2])
          ->orderBy('d_pcsr_created', 'DESC')
          ->get();

    return DataTables::of($data)
    ->addIndexColumn()
    ->editColumn('status', function ($data)
    {
      if ($data->d_pcsr_status == "WT") 
      {
        return '<span class="label label-default">Waiting</span>';
      }
      elseif ($data->d_pcsr_status == "CF") 
      {
        return '<span class="label label-info">Disetujui</span>';
      }
      elseif ($data->d_pcsr_status == "DE") 
      {
        return '<span class="label label-warning">Dapat Diedit</span>';
      }
      else
      {
        return '<span class="label label-success">Diterima</span>';
      }
    })
    ->editColumn('metode', function ($data)
    {
      if ($data->d_pcsr_method == "TK") 
      {
        return 'Tukar Barang';
      }
      elseif ($data->d_pcsr_method == "PN") 
      {
        return 'Potong Nota';
      }
    })
    ->editColumn('tglBuat', function ($data) 
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
    ->editColumn('hargaTotal', function ($data) 
    {
      return 'Rp. '.number_format($data->d_pcsr_pricetotal,2,",",".");
    })
    ->addColumn('action', function($data)
    {
      if ($data->d_pcsr_status == "WT") 
      {
        return '<div class="text-center">
                    <button class="btn btn-sm btn-success" title="Detail"
                        onclick=detailReturPembelian("'.$data->d_pcsr_id.'")><i class="fa fa-eye"></i> 
                    </button>
                    <button class="btn btn-sm btn-warning" title="Edit"
                        onclick=editReturPembelian("'.$data->d_pcsr_id.'")><i class="glyphicon glyphicon-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" title="Delete"
                        onclick=deleteReturPembelian("'.$data->d_pcsr_id.'")><i class="glyphicon glyphicon-trash"></i>
                    </button>
                </div>'; 
      }
      elseif ($data->d_pcsr_status == "DE") 
      {
        return '<div class="text-center">
                    <button class="btn btn-sm btn-success" title="Detail"
                        onclick=detailReturPembelian("'.$data->d_pcsr_id.'")><i class="fa fa-eye"></i> 
                    </button>
                    <button class="btn btn-sm btn-warning" title="Edit"
                        onclick=editReturPembelian("'.$data->d_pcsr_id.'")><i class="glyphicon glyphicon-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" title="Delete"
                        onclick=deleteReturPembelian("'.$data->d_pcsr_id.'") disabled><i class="glyphicon glyphicon-trash"></i>
                    </button>
                </div>'; 
      }
      else
      {
        return '<div class="text-center">
                    <button class="btn btn-sm btn-success" title="Detail"
                        onclick=detailReturPembelian("'.$data->d_pcsr_id.'")><i class="fa fa-eye"></i> 
                    </button>
                    <button class="btn btn-sm btn-warning" title="Edit"
                        onclick=editReturPembelian("'.$data->d_pcsr_id.'") disabled><i class="glyphicon glyphicon-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" title="Delete"
                        onclick=deleteReturPembelian("'.$data->d_pcsr_id.'") disabled><i class="glyphicon glyphicon-trash"></i>
                    </button>
                </div>'; 
      }
    })
    ->rawColumns(['status', 'action'])
    ->make(true);
  }

  public function getDataDetail($id, $type="all")
  {
    $dataHeader = d_purchasingreturn::join('d_purchasing','d_purchasingreturn.d_pcsr_pcsid','=','d_purchasing.d_pcs_id')
          ->join('d_supplier','d_purchasingreturn.d_pcsr_supid','=','d_supplier.s_id')
          ->join('d_mem', 'd_purchasingreturn.d_pcs_staff', '=', 'd_mem.m_id')
          ->select('d_purchasingreturn.*', 'd_supplier.s_id', 'd_supplier.s_company', 'd_purchasing.d_pcs_id', 'd_purchasing.d_pcs_total_net', 'd_purchasing.d_pcs_code', 'd_mem.m_name', 'd_mem.m_id')
          ->where('d_purchasingreturn.d_pcsr_id', '=', $id)
          ->orderBy('d_pcsr_created', 'DESC')
          ->get();

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

    $metodeReturn = $dataHeader[0]->d_pcsr_method;
    if ($metodeReturn == "PN") 
    {
      $lblMethod = 'Potong nota';
    }
    else
    {
      $lblMethod = 'Tukar barang';
    }

    foreach ($dataHeader as $val) 
    {
        $data = array(
          'hargaTotalReturn' => 'Rp. '.number_format($val->d_pcsr_pricetotal,2,",","."),
          'hargaTotalResult' => 'Rp. '.number_format($val->d_pcsr_priceresult,2,",","."),
          'tanggalReturn' => date('d-m-Y',strtotime($val->d_pcsr_datecreated))
        );
    }

    $dataIsi = d_purchasingreturn_dt::join('d_purchasingreturn', 'd_purchasingreturn_dt.d_pcsrdt_idpcsr', '=', 'd_purchasingreturn.d_pcsr_id')
            ->join('m_item', 'd_purchasingreturn_dt.d_pcsrdt_item', '=', 'm_item.i_id')
            ->join('m_satuan', 'd_purchasingreturn_dt.d_pcsrdt_sat', '=', 'm_satuan.m_sid')
            ->select('d_purchasingreturn_dt.*', 'm_item.*', 'd_purchasingreturn.d_pcsr_code', 'm_satuan.m_sid', 'm_satuan.m_sname')
            ->where('d_purchasingreturn_dt.d_pcsrdt_idpcsr', '=', $id)
            ->orderBy('d_purchasingreturn_dt.d_pcsrdt_created', 'DESC')
            ->get();
    
    //cek item type untuk hitung stok
    foreach ($dataIsi as $val) 
    {
      $itemType[] = DB::table('m_item')->select('i_type', 'i_id')->where('i_id','=', $val->i_id)->first();
      //get satuan utama
      $sat1[] = $val->i_sat1;
    }

    //variabel untuk count array
    $counter = 0;
    //ambil value stok by item type
    $dataStok = $this->getStokByType($itemType, $sat1, $counter);
    //auth
    $staff['nama'] = Auth::user()->m_name;
    $staff['id'] = Auth::User()->m_id;

    return response()->json([
        'status' => 'sukses',
        'header' => $dataHeader,
        'header2' => $data,
        'data_isi' => $dataIsi,
        'spanTxt' => $spanTxt,
        'spanClass' => $spanClass,
        'lblMethod' => $lblMethod,
        'data_stok' => $dataStok['val_stok'],
        'data_satuan' => $dataStok['txt_satuan'],
        'staff' => $staff
    ]);
  }

  public function getListRevisiByTgl($tgl1, $tgl2, $tampil)
  {
      $y = substr($tgl1, -4);
      $m = substr($tgl1, -7,-5);
      $d = substr($tgl1,0,2);
      $tanggal1 = $y.'-'.$m.'-'.$d;

      $y2 = substr($tgl2, -4);
      $m2 = substr($tgl2, -7,-5);
      $d2 = substr($tgl2,0,2);
      $tanggal2 = $y2.'-'.$m2.'-'.$d2;

      if ($tampil == 'revisied') { $indexStatus = "RV"; } elseif ($tampil == 'received') { $indexStatus = "RC"; }

      $data = d_purchasing::join('d_supplier','d_purchasing.s_id','=','d_supplier.s_id')
            ->join('d_mem','d_purchasing.d_pcs_staff','=','d_mem.m_id')
            ->select('d_pcs_date_created','d_pcs_id', 'd_pcsp_id','d_pcs_code','s_company','d_pcs_method','d_pcs_total_net','d_pcs_date_received','d_pcs_status','d_mem.m_id','d_mem.m_name')
            ->where('d_purchasing.d_pcs_status','=',$indexStatus)
            ->whereBetween('d_purchasing.d_pcs_date_created', [$tanggal1, $tanggal2])
            ->orderBy('d_pcs_date_created', 'DESC')
            ->get();

      return DataTables::of($data)
      ->addIndexColumn()
      ->editColumn('status', function ($data)
        {
        if ($data->d_pcs_status == "RC") 
        {
          return '<span class="label label-default">Diterima</span>';
        }
        elseif ($data->d_pcs_status == "RV") 
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
      ->editColumn('hargaTotalNet', function ($data) 
      {
        return 'Rp. '.number_format($data->d_pcs_total_net,0,",",".");
      })
      ->addColumn('action', function($data)
      {
        if ($data->d_pcs_status == "RV") 
        {
          return '<div class="text-center">
                    <button class="btn btn-sm btn-success" title="Detail"
                        onclick=detailPoRev("'.$data->d_pcs_id.'")><i class="fa fa-eye"></i> 
                    </button>
                  </div>'; 
        }
        elseif ($data->d_pcs_status == "RC") 
        {
          return '<div class="text-center">
                    <button class="btn btn-sm btn-success" title="Detail"
                        onclick=detailPoRev("'.$data->d_pcs_id.'") disabled><i class="fa fa-eye"></i> 
                    </button>
                  </div>'; 
        } 
      })
      ->rawColumns(['status', 'action'])
      ->make(true);
  }

  public function tambahReturn()
  {
    //code order
    $query = DB::select(DB::raw("SELECT MAX(RIGHT(d_pcsr_code,5)) as kode_max from d_purchasingreturn WHERE DATE_FORMAT(d_pcsr_created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));
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

    $codeRP = "RTR-".date('ym')."-".$kd;
    $staff['nama'] = Auth::user()->m_name;
    $staff['id'] = Auth::User()->m_id;
    return view ('/purchasing/returnpembelian/tambah-return',compact('codeRP', 'staff'));
  }

  public function lookupDataPembelian(Request $request)
  {
    $formatted_tags = array();
    $term = trim($request->q);
    if (empty($term)) {
      $sup = DB::table('d_purchasing')->where('d_pcs_status','=','RC')->orderBy('d_pcs_code', 'DESC')->limit(5)->get();
      foreach ($sup as $val) {
          $formatted_tags[] = ['id' => $val->d_pcs_id, 'text' => $val->d_pcs_code];
      }
      return Response::json($formatted_tags);
    }
    else
    {
      $sup = DB::table('d_purchasing')->where('d_pcs_status','=','RC')->orderBy('d_pcs_code', 'DESC')->where('d_pcs_code', 'LIKE', '%'.$term.'%')->limit(5)->get();
      foreach ($sup as $val) {
          $formatted_tags[] = ['id' => $val->d_pcs_id, 'text' => $val->d_pcs_code];
      }

      return Response::json($formatted_tags);  
    }
  }

  public function getDataForm($id)
  {
    $dataHeader = DB::table('d_purchasing')
                    ->select('d_purchasing.*', 'd_supplier.s_company', 'd_supplier.s_name', 'd_supplier.s_id')
                    ->join('d_supplier','d_purchasing.s_id','=','d_supplier.s_id')
                    ->where('d_pcs_id', '=', $id)
                    ->get();

    $dataIsi = DB::table('d_purchasing_dt')
                  ->select('d_purchasing_dt.*', 'm_item.i_name', 'm_item.i_code', 'm_item.i_sat1', 'm_item.i_id', 'm_satuan.m_sname', 'm_satuan.m_sid')
                  ->leftJoin('m_item','d_purchasing_dt.i_id','=','m_item.i_id')
                  ->leftJoin('m_satuan','d_purchasing_dt.d_pcsdt_sat','=','m_satuan.m_sid')
                  ->where('d_purchasing_dt.d_pcs_id', '=', $id)
                  // ->where('d_purchasing_dt.d_pcsdt_isconfirm', '=', "TRUE")
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

  public function simpanDataReturn(Request $request)
  {
    // dd($request->all());
    DB::beginTransaction();
    try {      

      $err = true; $acc = []; $total = 0;

      foreach($request->fieldItemId as $acc_key => $data){
          $cek = DB::table('m_item')
              ->join('m_group', 'm_group.m_gcode', '=', 'm_item.i_code_group')
              ->where('i_id', $data)
              ->select('m_group.m_akun_persediaan', 'm_group.m_gid')
              ->first();

          if(!$cek){
              $err = false;
          }else{
              $acc[$acc_key] = [
                  'td_acc'    => $cek->m_akun_persediaan,
                  'td_posisi' => 'K',
                  'value'     => $request->fieldHargaTotalRaw[$acc_key]
              ];

              $total += $request->fieldHargaTotalRaw[$acc_key];
          }
      }

      if(!$err){
          return response()->json([
              'status' => 'gagal',
              'pesan'  => 'Tidak Bisa Melakukan Jurnal Pada Penerimaan Ini Karena Salah Satu Dari Item Belum Berelasi Dengan Akun Persediaan.'
          ]);
      }

      $acc[count($acc)] = [
          'td_acc'    => '301.01',
          'td_posisi' => 'D',
          'value'     => $total
      ];

      //insert to table d_purchasingreturn
      $dataHeader = new d_purchasingreturn;
      $dataHeader->d_pcsr_pcsid = $request->cariNotaPurchase;
      $dataHeader->d_pcsr_supid = $request->idSup;
      $dataHeader->d_pcsr_code = $request->kodeReturn;
      $dataHeader->d_pcsr_method = $request->metodeReturn;
      $dataHeader->d_pcs_staff = $request->idStaff;
      $dataHeader->d_pcsr_datecreated = date('Y-m-d',strtotime($request->tanggal));
      $dataHeader->d_pcsr_pricetotal = $request->nilaiTotalReturnRaw;
      if ($request->metodeReturn == "PN") 
      {
        $dataHeader->d_pcsr_priceresult = $this->konvertRp($request->nilaiTotalNett) - $request->nilaiTotalReturnRaw;
      }
      elseif ($request->metodeReturn == "TK")
      {
        $dataHeader->d_pcsr_priceresult = $this->konvertRp($request->nilaiTotalNett);
      }
      $dataHeader->save();
      
      //get last lastId then insert id to d_purchasingreturn_dt
      $lastId = d_purchasingreturn::select('d_pcsr_id')->max('d_pcsr_id');
      if ($lastId == 0 || $lastId == '') 
      {
        $lastId  = 1;
      }  

      //variabel untuk hitung array field
      $hitung_field = count($request->fieldItemId);

      //update d_stock, insert d_stock_mutation & insert d_purchasingreturn_dt
      for ($i=0; $i < $hitung_field; $i++) 
      {
        //variabel u/ cek primary satuan
        $primary_sat = DB::table('m_item')->select('m_item.*')->where('i_id', $request->fieldItemId[$i])->first();
        
        //cek satuan primary, convert ke primary apabila beda satuan
        if ($primary_sat->i_sat1 == $request->fieldSatuanId[$i]) 
        {
          $hasilConvert = (int)$request->fieldQty[$i] * (int)$primary_sat->i_sat_isi1;
        }
        elseif ($primary_sat->i_sat2 == $request->fieldSatuanId[$i])
        {
          $hasilConvert = (int)$request->fieldQty[$i] * (int)$primary_sat->i_sat_isi2;
        }
        else
        {
          $hasilConvert = (int)$request->fieldQty[$i] * (int)$primary_sat->i_sat_isi3;
        }

        $grup = $this->getGroupGudang($request->fieldItemId[$i]);

        //get id d_stock
        $dstock_id = DB::table('d_stock')
          ->select('s_id')
          ->where('s_item', $request->fieldItemId[$i])
          ->where('s_comp', $grup)
          ->where('s_position', $grup)
          ->first();

        if(mutasi::mutasiStok(
          $request->fieldItemId[$i], //item id
          $hasilConvert, //qty hasil convert satuan terpilih -> satuan primary 
          $comp = $grup, //posisi gudang berdasarkan type item
          $position = $grup, //posisi gudang berdasarkan type item
          $flag = 13, //sm mutcat
          $request->kodeReturn
        )) {}

        //insert d_purchasingreturn_dt
        $dataIsi = new d_purchasingreturn_dt;
        $dataIsi->d_pcsrdt_idpcsr = $lastId;
        $dataIsi->d_pcsrdt_item = $request->fieldItemId[$i];
        $dataIsi->d_pcsrdt_sat = $request->fieldSatuanId[$i];
        $dataIsi->d_pcsrdt_qty = $request->fieldQty[$i];
        $dataIsi->d_pcsrdt_price = $request->fieldHargaRaw[$i];
        $dataIsi->d_pcsrdt_pricetotal = $request->fieldHargaTotalRaw[$i];
        $dataIsi->d_pcsrdt_created = Carbon::now();
        $dataIsi->save();
      }//end loop for

      //update status po RC -> RV (Revisied) dan update tanggal buat
      DB::table('d_purchasing')
              ->where('d_pcs_id', $request->cariNotaPurchase)
              ->update([
                'd_pcs_status' => 'RV',
                'd_pcs_date_created' => date('Y-m-d',strtotime(Carbon::now()))
              ]);

      $pcs = DB::table('d_purchasing')
              ->where('d_pcs_id', $request->cariNotaPurchase)
              ->select('d_pcs_code')->first();

      DB::commit();

    } 
    catch (\Exception $e) 
    {
      DB::rollback();
      return response()->json([
          'status' => 'gagal',
          'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
      ]);
    }

    $state_jurnal = _initiateJournal_self_detail($request->kodeReturn, 'MM', date('Y-m-d', strtotime($request->tanggal)), 'Pemotongan Nota Dari '.$request->namaSup.' Atas Nomor '.$pcs->d_pcs_code, $acc);

    return response()->json([
        'status' => 'sukses',
        'pesan' => 'Data Return Pembelian Berhasil Disimpan'
    ]);
  }

  public function updateDataReturn(Request $request)
  {
    // dd($request->all());
    DB::beginTransaction();
    try {

      $err = true; $acc = []; $total = 0;

      foreach($request->fieldIdItem as $acc_key => $data){
          $cek = DB::table('m_item')
              ->join('m_group', 'm_group.m_gcode', '=', 'm_item.i_code_group')
              ->where('i_id', $data)
              ->select('m_group.m_akun_persediaan', 'm_group.m_gid')
              ->first();

          if(!$cek){
              $err = false;
          }else{
              $acc[$acc_key] = [
                  'td_acc'    => $cek->m_akun_persediaan,
                  'td_posisi' => 'K',
                  'value'     => $request->fieldHargaTotalRaw[$acc_key]
              ];

              $total += $request->fieldHargaTotalRaw[$acc_key];
          }
      }

      if(!$err){
          return response()->json([
              'status' => 'gagal',
              'pesan'  => 'Tidak Bisa Melakukan Jurnal Pada Penerimaan Ini Karena Salah Satu Dari Item Belum Berelasi Dengan Akun Persediaan.'
          ]);
      }

      $acc[count($acc)] = [
          'td_acc'    => '301.01',
          'td_posisi' => 'D',
          'value'     => $total
      ];

      //update to table d_purchasingreturn
      $data_header = d_purchasingreturn::find($request->idReturn);
      $data_header->d_pcsr_dateupdated = date('Y-m-d',strtotime(Carbon::now()));
      $data_header->d_pcsr_updated = Carbon::now();
      $data_header->d_pcsr_pricetotal = $request->priceTotalRaw;
      if ($request->methodReturn == "PN") 
      {
        $data_header->d_pcsr_priceresult = $request->priceTotalNett - $request->priceTotalRaw;
      }
      else
      {
        $data_header->d_pcsr_priceresult = $request->priceTotalNett;
      }
      $data_header->save();

      //variabel untuk cek jumlah field
      $hitung_field_edit = count($request->fieldIdItem);
      for ($i=0; $i < $hitung_field_edit; $i++) 
      {
        //variabel u/ cek primary satuan
        $primary_sat = DB::table('m_item')->select('m_item.*')->where('i_id', $request->fieldIdItem[$i])->first();        
        //konversi stok setelah update
        if ($primary_sat->i_sat1 == $request->fieldSatuanId[$i]) 
        {
          $hasilConvert = (int)$request->fieldQty[$i] * (int)$primary_sat->i_sat_isi1;
          $hasilConvertLalu = (int)$request->fieldQtyLalu[$i] * (int)$primary_sat->i_sat_isi1;
          $hasilSelisih = $hasilConvert - $hasilConvertLalu;
        }
        elseif ($primary_sat->i_sat2 == $request->fieldSatuanId[$i])
        {
          $hasilConvert = (int)$request->fieldQty[$i] * (int)$primary_sat->i_sat_isi2;
          $hasilConvertLalu = (int)$request->fieldQtyLalu[$i] * (int)$primary_sat->i_sat_isi2;
          $hasilSelisih = $hasilConvert - $hasilConvertLalu;
        }
        else
        {
          $hasilConvert = (int)$request->fieldQty[$i] * (int)$primary_sat->i_sat_isi3;
          $hasilConvertLalu = (int)$request->fieldQtyLalu[$i] * (int)$primary_sat->i_sat_isi3;
          $hasilSelisih = $hasilConvert - $hasilConvertLalu;
        }

        $grup = $this->getGroupGudang($request->fieldIdItem[$i]);
        //update d_stock
        if(mutasi::updateMutasi(
          $request->fieldIdItem[$i], //item id
          $hasilSelisih, //qty hasil convert satuan terpilih -> satuan primary 
          $comp = $grup, //posisi gudang berdasarkan type item
          $position = $grup, //posisi gudang berdasarkan type item
          $flag = 13, //sm mutcat
          $request->codeReturn
        )) {}

        //update to table d_purchasingreturn_dt
        $data_isi = d_purchasingreturn_dt::find($request->fieldIdDt[$i]);
        $data_isi->d_pcsrdt_qty = $request->fieldQty[$i];
        $data_isi->d_pcsrdt_price = $request->fieldHargaRaw[$i];
        $data_isi->d_pcsrdt_pricetotal = $request->fieldHargaTotalRaw[$i];
        $data_isi->d_pcsrdt_updated = Carbon::now();
        $data_isi->save();
      } 
      
    DB::commit();
    } 
    catch (\Exception $e) 
    {
      DB::rollback();
      return response()->json([
          'status' => 'gagal',
          'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
      ]);
    }

    $jrn = DB::table('d_jurnal')->where('jurnal_ref', $request->codeReturn)->select('*')->first();

    $state_jurnal = _updateJournal_self_detail($request->codeReturn, 'MM', $jrn->tanggal_jurnal, $jrn->keterangan, $acc);

    return response()->json([
          'status' => 'sukses',
          'pesan' => 'Data Retur Pembelian Berhasil Diupdate'
      ]);
  }

  public function getDetailRevisi($id)
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
      else if ($statusLabel == "RC") 
      {
        $spanTxt = 'Barang telah diterima';
        $spanClass = 'label-success';
      }
      else 
      {
        $spanTxt = 'PO revisi';
        $spanClass = 'label-warning';
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

  public function ubahStatusPo(Request $request)
  {
    //dd($request->all());
    DB::beginTransaction();
    try 
    {   
        $tanggal = date("Y-m-d h:i:s");
        
        //update d_purchasing
        $update = DB::table('d_purchasing')
            ->where('d_pcs_id','=',$request->id)
            ->update([
                'd_pcs_updated' => $tanggal,
                'd_pcs_status' => 'RC'
            ]);

        if ($update) 
        {
          $pesan = 'Status PO telah diubah menjadi Telah Diterima';
        }else{
          $pesan = 'Status PO gagal diubah';
        }

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

  public function deleteDataReturn(Request $request)
  {
    // dd($request->all());
    DB::beginTransaction();
    try {
      //ambil code d_purchasingreturn
      $code_retur = d_purchasingreturn::select('d_pcsr_code','d_pcsr_pcsid')->where('d_pcsr_id', $request->id)->first();
      //ambil data pakai d_stock_mutation 
      $data_sm = DB::table('d_stock_mutation')->where('sm_reff', $code_retur->d_pcsr_code)->orderBy('sm_stock','ASC')
                  ->orderBy('sm_detailid','ASC')->get();
      // return json_encode($code_retur);
      foreach ($data_sm as $value) 
      {
        //array variabel u/ simpan data stok mutasi
        $sm_stock[] = $value->sm_stock;
        $sm_detailid[] = $value->sm_detailid;
        $sm_item[] = $value->sm_item;
        $sm_qty[] = $value->sm_qty;
        $sm_hpp[] = $value->sm_hpp;
        $sm_comp[] = $value->sm_comp;
        $sm_pos[] = $value->sm_position;
      }

      for ($i=0; $i < count($sm_stock); $i++) 
      { 
        //cari id & s_qty d_stock
        $q_dstock = DB::table('d_stock')
                    ->select('s_id', 's_qty')
                    ->where('s_item', $sm_item[$i])
                    ->where('s_comp', $sm_comp[$i])
                    ->where('s_position', $sm_pos[$i])
                    ->first();

        //kembalikan stok sebelum retur
        $stokAkhir = abs($sm_qty[$i]) + (int)$q_dstock->s_qty;
        // update d_stock
        DB::table('d_stock')
          ->where('s_id', $sm_stock[$i])
          ->update(['s_qty' => $stokAkhir]);

        //ambil data penerimaan d_stock_mutation 
        $data_sm_masuk = d_stock_mutation::where('sm_qty_used','>',0)
                            ->where('sm_stock', $sm_stock[$i])
                            ->where('sm_item', $sm_item[$i])
                            ->where('sm_comp', $sm_comp[$i])
                            ->where('sm_position', $sm_pos[$i])
                            ->where('sm_hpp', $sm_hpp[$i])
                            ->orderBy('sm_stock','ASC')
                            ->orderBy('sm_detailid','ASC')
                            ->get();

        $qtyPakai = abs($sm_qty[$i]);
        for ($j=0; $j <count($data_sm_masuk); $j++) 
        { 
          if ($qtyPakai <= $data_sm_masuk[$j]->sm_qty_used) 
          {
            $qty_awal = (int)$data_sm_masuk[$j]->sm_qty_used - (int)$qtyPakai;
            $qty_sisa = (int)$data_sm_masuk[$j]->sm_qty_sisa + (int)$qtyPakai;
            // update d_stock_mutation
            DB::table('d_stock_mutation')
              ->where('sm_stock', '=', $data_sm_masuk[$j]->sm_stock)
              ->where('sm_detailid', $data_sm_masuk[$j]->sm_detailid)
              ->update(array(
                  'sm_qty_used' => $qty_awal,
                  'sm_qty_sisa' => $qty_sisa
              ));
            $j = count($data_sm_masuk);
          }
          elseif ($qtyPakai > $data_sm_masuk[$j]->sm_qty_used)
          {
            $selisih = (int)$qtyPakai - (int)$data_sm_masuk[$j]->sm_qty_used;
            $qty_awal = (int)$data_sm_masuk[$j]->sm_qty_used - ((int)$qtyPakai - (int)$selisih);
            $qty_sisa = (int)$data_sm_masuk[$j]->sm_qty_sisa + ((int)$qtyPakai - (int)$selisih);
            $qtyPakai = $selisih;
            // update d_stock_mutation
            DB::table('d_stock_mutation')
              ->where('sm_stock', '=', $data_sm_masuk[$j]->sm_stock)
              ->where('sm_detailid', $data_sm_masuk[$j]->sm_detailid)
              ->update(array(
                  'sm_qty_used' => $qty_awal,
                  'sm_qty_sisa' => $qty_sisa
              ));
          }
        }

        //delete row table d_stock_mutation
        DB::table('d_stock_mutation')
          ->where('sm_stock', '=', $sm_stock[$i])
          ->where('sm_detailid', '=', $sm_detailid[$i])
          ->delete();

        _delete_jurnal($code_retur->d_pcsr_code);
      }

      //get id purchase and update status po RV -> RC (Received)
      $idPurchase = d_purchasingreturn::select('d_pcsr_pcsid')->where('d_pcsr_id', $request->id)->first();
      DB::table('d_purchasing')->where('d_pcs_id', $idPurchase->d_pcsr_pcsid)->update(['d_pcs_status' => 'RC']);
      //delete row table d_purchasingreturn_dt
      $deleteReturnDt = d_purchasingreturn_dt::where('d_pcsrdt_idpcsr', $request->id)->delete();
      //delete row table d_purchasingreturn
      $deleteReturn = d_purchasingreturn::where('d_pcsr_id', $request->id)->delete();
    
      DB::commit();
      return response()->json([
          'status' => 'sukses',
          'pesan' => 'Data Retur Pembelian Berhasil Dihapus'
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

  public function getGroupGudang($id_item)
  {
    $typeBrg = DB::table('m_item')->select('i_type')->where('i_id','=', $id_item)->first();
    if ($typeBrg->i_type == "BB") 
    {
      $idGroupGdg = '3';
    } 
    elseif ($typeBrg->i_type == "BJ") 
    {
      $idGroupGdg = '2';
    }
    return $idGroupGdg;
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

}
