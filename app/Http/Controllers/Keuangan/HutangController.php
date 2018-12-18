<?php   

namespace App\Http\Controllers\Keuangan;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Response;
use DB;
use DataTables;
use App\d_purchasing;
use App\d_purchasing_dt;
use App\d_purchasingharian;
use App\d_purchasingharian_dt;
use App\d_terima_pembelian;
use App\d_terima_pembelian_dt;
use App\m_customer;
use App\d_sales;

class HutangController extends Controller
{

  public function __construct()
  {
      $this->middleware('auth');
  }

  public function hutang()
  {
    $customer = m_customer::select('c_id','c_name')
      ->get();

    $supplier = DB::table('d_supplier')->select('s_id','s_company')
      ->get();

    return view('/keuangan/l_hutangpiutang/index',compact('customer','supplier'));
  }

  public function getHutangByTgl($tgl1, $tgl2)
  {
      $y = substr($tgl1, -4);
      $m = substr($tgl1, -7,-5);
      $d = substr($tgl1,0,2);
       $tanggal1 = $y.'-'.$m.'-'.$d;

      $y2 = substr($tgl2, -4);
      $m2 = substr($tgl2, -7,-5);
      $d2 = substr($tgl2,0,2);
      $tanggal2 = $y2.'-'.$m2.'-'.$d2;

      $data = DB::table('d_purchasing')
                ->leftJoin('d_supplier', 'd_purchasing.s_id', '=', 'd_supplier.s_id')
                ->select('d_purchasing.*', 'd_supplier.s_id', 'd_supplier.s_company')
                ->where('d_pcs_status', '=', "CF")
                ->where('d_pcs_sisapayment', '>', 0)
                ->whereBetween('d_pcs_date_created', [$tanggal1, $tanggal2])
                ->orderBy('d_pcs_date_created', 'DESC')
                ->get();

      return DataTables::of($data)
      ->addIndexColumn()
      ->editColumn('tglPo', function ($data) 
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
      ->editColumn('tglSelesai', function ($data) 
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
        return '<div class="text-center">
                    <button class="btn btn-sm btn-success" title="Detail"
                        onclick=detailHutangBeli("'.$data->d_pcs_id.'")><i class="fa fa-eye"></i> 
                    </button>
                </div>';
      })
      ->rawColumns(['action'])
      ->make(true);
  }

  public function getDetailHutangBeli($id)
  {
    $dataHeader = d_purchasing::join('d_supplier','d_purchasing.s_id','=','d_supplier.s_id')
        ->select('d_purchasing.*', 'd_supplier.s_company')
        ->where('d_purchasing.d_pcs_id', '=', $id)
        ->get();

    $idPurchaseDt = d_purchasing_dt::select('d_pcsdt_id')->where('d_pcs_id', $dataHeader[0]->d_pcs_id)->get();

    for ($i=0; $i < count($idPurchaseDt); $i++) 
    { 
      $data = d_terima_pembelian_dt::join('d_terima_pembelian', 'd_terima_pembelian_dt.d_tbdt_idtb', '=', 'd_terima_pembelian.d_tb_id')
        ->join('m_item', 'd_terima_pembelian_dt.d_tbdt_item', '=', 'm_item.i_id')
        ->join('m_satuan', 'd_terima_pembelian_dt.d_tbdt_sat', '=', 'm_satuan.m_sid')
        ->select('m_item.i_name', 'm_item.i_code', 'm_item.i_id', 'm_item.i_sat1', 'm_satuan.m_sname', 'd_terima_pembelian_dt.d_tbdt_qty', 'd_terima_pembelian.d_tb_code', 'd_terima_pembelian_dt.d_tbdt_date_received', 'd_terima_pembelian.d_tb_date', 'd_terima_pembelian_dt.d_tbdt_price', 'd_terima_pembelian_dt.d_tbdt_pricetotal')
        ->where('d_terima_pembelian_dt.d_tbdt_idpcsdt', '=', $idPurchaseDt[$i]->d_pcsdt_id)
        ->orderBy('d_terima_pembelian_dt.d_tbdt_date_received', 'ASC')
        ->get();

        foreach ($data as $val) { $dataIsi[] = $val; }
    }

    foreach ($dataIsi as $val) 
    {   
      $tanggalTerima[] = date('d-m-Y',strtotime($val->d_tbdt_date_received));
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
        'isi' => $dataIsi,
        'tanggalTerima' => $tanggalTerima,
        'data_stok' => $dataStok['val_stok'],
        'data_satuan' => $dataStok['txt_satuan']
    ]);
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

  public function cariCus(Request $request){
    $formatted_tags = array();
    $term = trim($request->q);
    if (empty($term)) {
    $sup = m_customer::select('s_id','c_id','c_name')
        ->leftJoin('d_sales','d_sales.s_customer','=','c_id')
        ->limit(50)
        ->get();
    // dd($sup);
      foreach ($sup as $val) {
          $formatted_tags[] = [ 'id' => $val->s_id, 
                                'text' => $val->c_name ];
      }
      return Response::json($formatted_tags);

    }else{

     $sup = m_customer::select('s_id','c_id','c_name')
        ->leftJoin('d_sales','d_sales.s_customer','=','c_id')
        ->where(function ($b) use ($term) {
              $b->orWhere('c_name', 'LIKE', '%'.$term.'%');
          })
        ->limit(50)
        ->get();
    // dd($sup);
      foreach ($sup as $val) {
          $formatted_tags[] = [ 'id' => $val->s_id, 
                                'text' => $val->c_name ];
      }
      return Response::json($formatted_tags);
    }
  }

  public function laporanHutang(Request $request){
    // $durasi        = $request->durasi_1_arus_kas_bulan."-01";
    // $durasi_before = date('Y-m-d', strtotime('-1 months', strtotime($durasi)));
    // $durasi_end    = date('Y-m-d', strtotime('+1 months', strtotime($durasi)));
        $y = substr($request->periode1, -4);
        $m = substr($request->periode1, -7, -5);
        $d = substr($request->periode1, 0, 2);
        $tanggal1 = $y . '-' . $m . '-' . $d;

        $y2 = substr($request->periode2, -4);
        $m2 = substr($request->periode2, -7, -5);
        $d2 = substr($request->periode2, 0, 2);
        $tanggal2 = $y2 . '-' . $m2 . '-' . $d2;
    if ($request->cus == 'all') {
      $hutang = d_sales::select('c_name','c_code','c_type','c_region','c_hp1','c_hp2','c_region','c_address','s_sisa','s_jatuh_tempo')
        ->join('m_customer','m_customer.c_id','=','s_customer')
        ->where('s_channel','GR')
        ->where('s_sisa','!=','0.00')
        ->whereBetween('s_jatuh_tempo', [$tanggal1, $tanggal2])
        ->get();
    }else{
      $hutang = d_sales::select('c_name','c_code','c_type','c_region','c_hp1','c_hp2','c_region','c_address','s_sisa')
        ->join('m_customer','m_customer.c_id','=','s_customer')
        ->where('s_channel','GR')
        ->where('s_sisa','!=','0.00')
        ->where('s_customer',$request->cus)
        ->whereBetween('s_jatuh_tempo', [$tanggal1, $tanggal2])
        ->get();
    }
    return view('keuangan.l_hutangpiutang.laporan_hutang',compact('hutang'));
  }

  public function laporanPiutang(Request $request){
        //dd($request->all());
        $y = substr($request->periode1, -4);
        $m = substr($request->periode1, -7, -5);
        $d = substr($request->periode1, 0, 2);
        $tanggal3 = $y . '-' . $m . '-' . $d;

        $y2 = substr($request->periode2, -4);
        $m2 = substr($request->periode2, -7, -5);
        $d2 = substr($request->periode2, 0, 2);
        $tanggal4 = $y2 . '-' . $m2 . '-' . $d2;
        if ($request->cus == 'all') {
          $piutang = d_purchasing::join('d_supplier','d_supplier.s_id','=','d_purchasing.s_id')
            ->where('d_pcs_sisapayment','!=','0.00')
            ->whereBetween('d_pcs_duedate', [$tanggal3, $tanggal4])
            ->get();
        }else{
          $piutang = d_purchasing::join('d_supplier','d_supplier.s_id','=','d_purchasing.s_id')
            ->where('d_pcs_sisapayment','!=','0.00')
            ->where('d_purchasing.s_id',$request->cus)
            ->whereBetween('d_pcs_duedate', [$tanggal3, $tanggal4])
            ->get();
        }



    return view('keuangan.l_hutangpiutang.laporan_piutang',compact('piutang'));
  }

}