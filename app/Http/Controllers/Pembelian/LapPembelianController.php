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
use App\d_purchasingharian;
use App\d_purchasingharian_dt;

class LapPembelianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
      return view('purchasing/lap-pembelian/index');
    }

    public function get_laporan_by_tgl($tgl1, $tgl2)
    {
      $menit = Carbon::now('Asia/Jakarta')->format('H:i:s');
      //dd(Carbon::createFromFormat('Y-m-d H:i:s', $tgl2, 'Asia/Jakarta'));
      $tanggal1 = date('Y-m-d',strtotime($tgl1));
      $tanggal2 = date('Y-m-d',strtotime($tgl2));

      $data = d_purchasing::join('d_purchasing_dt', 'd_purchasing.d_pcs_id', '=', 'd_purchasing_dt.d_pcs_id')
              ->join('d_supplier','d_purchasing.s_id', '=', 'd_supplier.s_id')
              ->join('d_mem', 'd_purchasing.d_pcs_staff', '=', 'd_mem.m_id')
              ->select(
                  'd_purchasing.d_pcs_id', 'd_purchasing.d_pcs_method', 'd_pcs_code', 'd_mem.m_name', 's_company', 'd_pcs_date_created', 'd_pcs_total_net')
              ->where('d_purchasing.d_pcs_status', 'RC')
              ->whereBetween('d_purchasing.d_pcs_date_created', [$tanggal1, $tanggal2])
              ->groupBy('d_purchasing.d_pcs_id')
              ->orderBy('d_purchasing.d_pcs_id', 'ASC')
              ->get();
      //return response()->json($data);
      return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('nett', function ($data) 
        {
          return number_format($data->d_pcs_total_net,2,",",".");
        })
        ->editColumn('tglOrder', function ($data) 
        {
          if ($data->d_pcs_date_created == null) { 
            return '-'; 
          }
          else 
          {
            return $data->d_pcs_date_created ? with(new Carbon($data->d_pcs_date_created))->format('d M Y') : '';
          }
        })
        //->rawColumns(['action'])
        ->make(true);
    }

    public function get_bharian_by_tgl($tgl1, $tgl2)
    {
      $menit = Carbon::now('Asia/Jakarta')->format('H:i:s');
      //dd(Carbon::createFromFormat('Y-m-d H:i:s', $tgl2, 'Asia/Jakarta'));
      $tanggal1 = date('Y-m-d',strtotime($tgl1));
      $tanggal2 = date('Y-m-d',strtotime($tgl2));

      $data = d_purchasingharian::join('d_purchasingharian_dt', 'd_purchasingharian.d_pcsh_id', '=', 'd_purchasingharian_dt.d_pcshdt_pcshid')
              ->join('d_mem', 'd_purchasingharian.d_pcsh_staff', '=', 'd_mem.m_id')
              ->select(
                'd_purchasingharian.d_pcsh_id', 'd_pcsh_code', 'd_pcsh_date', 'd_mem.m_name', 'd_pcsh_peminta', 'd_pcsh_keperluan', 'd_pcsh_dateconfirm', 'd_pcsh_totalprice')
              ->where('d_purchasingharian.d_pcsh_status', 'CF')
              ->whereBetween('d_purchasingharian.d_pcsh_date', [$tanggal1, $tanggal2])
              ->groupBy('d_purchasingharian.d_pcsh_id')
              ->orderBy('d_purchasingharian.d_pcsh_id', 'ASC')
              ->get();
      //return response()->json($data);
      return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('nett', function ($data) 
        {
          return number_format($data->d_pcsh_totalprice,2,",",".");
        })
        ->editColumn('tglOrder', function ($data) 
        {
          if ($data->d_pcsh_date == null) { 
            return '-'; 
          }
          else 
          {
            return $data->d_pcsh_date ? with(new Carbon($data->d_pcsh_date))->format('d M Y') : '';
          }
        })
        //->rawColumns(['action'])
        ->make(true);
    }

    public function print_laporan_beli($tgl1, $tgl2)
    {
      $tanggal1 = date('Y-m-d',strtotime($tgl1));
      $tanggal2 = date('Y-m-d',strtotime($tgl2));

      $data = d_purchasing::join('d_purchasing_dt', 'd_purchasing.d_pcs_id', '=', 'd_purchasing_dt.d_pcs_id')
              ->join('d_supplier','d_purchasing.s_id', '=', 'd_supplier.s_id')
              ->join('d_mem', 'd_purchasing.d_pcs_staff', '=', 'd_mem.m_id')
              ->select(
                'd_purchasing.*',
                'd_mem.m_name',
                'd_supplier.s_id',
                'd_supplier.s_company'
              )
              ->where('d_purchasing.d_pcs_status', 'RC')
              ->whereBetween('d_purchasing.d_pcs_date_created', [$tanggal1, $tanggal2])
              ->groupBy('d_purchasing.d_pcs_id')
              ->orderBy('d_supplier.s_company', 'ASC')
              ->get()->toArray();

      $data_sum = d_purchasing::join('d_supplier','d_purchasing.s_id', '=', 'd_supplier.s_id')
                ->select( DB::raw('SUM(d_purchasing.d_pcs_total_gross) as tot_gross'), 
                          DB::raw('SUM(d_purchasing.d_pcs_disc_value) as tot_discval'),
                          DB::raw('SUM(d_purchasing.d_pcs_tax_value) as tot_ppn'),
                          DB::raw('SUM(d_purchasing.d_pcs_total_net) as tot_nett'))
                ->where('d_purchasing.d_pcs_status', 'RC')
                ->whereBetween('d_purchasing.d_pcs_date_created', [$tanggal1, $tanggal2])
                ->groupBy('d_purchasing.s_id')
                ->orderBy('d_supplier.s_company', 'ASC')
                ->get()->toArray();

      $data_sum_all = d_purchasing::join('d_supplier','d_purchasing.s_id', '=', 'd_supplier.s_id')
                ->select( DB::raw('SUM(d_purchasing.d_pcs_total_gross) as all_tot_gross'), 
                          DB::raw('SUM(d_purchasing.d_pcs_disc_value) as all_tot_discval'),
                          DB::raw('SUM(d_purchasing.d_pcs_tax_value) as all_tot_ppn'),
                          DB::raw('SUM(d_purchasing.d_pcs_total_net) as all_tot_nett'))
                ->where('d_purchasing.d_pcs_status', 'RC')
                ->whereBetween('d_purchasing.d_pcs_date_created', [$tanggal1, $tanggal2])
                ->orderBy('d_supplier.s_company', 'ASC')
                ->get()->toArray();

      $nama_array = [];

      for ($i=0; $i < count($data); $i++) { 
          $nama_array[$i] = $data[$i]['s_id'];
      }
      $nama_array = array_unique($nama_array);
      $nama_array = array_values($nama_array);
      
      $pembelian = [];

      for($j=0; $j < count($nama_array);$j++)
      {
        $array = array();
        $pembelian[$j] = $array;

        for ($k=0; $k < count($data); $k++) {
            if ($nama_array[$j] == $data[$k]['s_id']) {
                array_push($pembelian[$j], $data[$k]);
            }
        }
      }

      $parsing = [
        'data' => $data,
        'pembelian' => $pembelian,
        'tgl1' => $tanggal1,
        'tgl2' => $tanggal2,
        'data_sum' => $data_sum,
        'data_sum_all' => $data_sum_all,
      ];
      return view('purchasing/lap-pembelian/print-lap-po', $parsing);
    }

    public function print_laporan_bharian($tgl1, $tgl2)
    {
      $tanggal1 = date('Y-m-d',strtotime($tgl1));
      $tanggal2 = date('Y-m-d',strtotime($tgl2));

      $data = d_purchasingharian::join('d_purchasingharian_dt', 'd_purchasingharian.d_pcsh_id', '=', 'd_purchasingharian_dt.d_pcshdt_pcshid')
                ->join('d_mem', 'd_purchasingharian.d_pcsh_staff', '=', 'd_mem.m_id')
                ->select('d_purchasingharian.*', 'd_mem.m_name')
                ->where('d_purchasingharian.d_pcsh_status', 'CF')
                ->whereBetween('d_purchasingharian.d_pcsh_date', [$tanggal1, $tanggal2])
                ->groupBy('d_purchasingharian.d_pcsh_id')
                ->orderBy('d_purchasingharian.d_pcsh_id', 'ASC')
                ->get()->toArray();

      $data_sum_all = d_purchasingharian::select( 
                          DB::raw('SUM(d_purchasingharian.d_pcsh_totalprice) as tot_nett'))
                ->where('d_purchasingharian.d_pcsh_status', 'CF')
                ->whereBetween('d_purchasingharian.d_pcsh_date', [$tanggal1, $tanggal2])
                ->orderBy('d_purchasingharian.d_pcsh_id', 'ASC')
                ->get()->toArray();
      
      $nama_array = [];

      for ($i=0; $i < count($data); $i++) { 
          $nama_array[$i] = $data[$i]['d_pcsh_code'];
      }
      $nama_array = array_unique($nama_array);
      $nama_array = array_values($nama_array);
      
      $pembelian = [];

      for($j=0; $j < count($nama_array);$j++)
      {
        $array = array();
        $pembelian[$j] = $array;

        for ($k=0; $k < count($data); $k++) {
            if ($nama_array[$j] == $data[$k]['d_pcsh_code']) {
                array_push($pembelian[$j], $data[$k]);
            }
        }
      }

      $parsing = [
        'data' => $data,
        'pembelian' => $pembelian,
        'tgl1' => $tanggal1,
        'tgl2' => $tanggal2,
        'data_sum_all' => $data_sum_all,
      ];
      return view('purchasing/lap-pembelian/print-lap-belanjaharian', $parsing);
    }

    public function konvertRp($value)
    {
      $value = str_replace(['Rp', '\\', '.', ' '], '', $value);
      return (int)str_replace(',', '.', $value);
    }

    public function getLapSupplier($tgl1, $tgl2)
    {
      $tanggal1 = date('Y-m-d',strtotime($tgl1));
      $tanggal2 = date('Y-m-d',strtotime($tgl2));
      $pembelian = d_purchasing_dt::select('s_company',
                                            'd_pcs_date_created',
                                            'i_name',
                                            'd_pcsdt_price',
                                            'd_pcsdt_qtyconfirm',
                                            'm_sname')
        ->join('d_purchasing','d_purchasing.d_pcs_id','=','d_purchasing_dt.d_pcs_id')
        ->join('d_supplier','d_supplier.s_id','=','d_purchasing.s_id')
        ->join('m_item','m_item.i_id','=','d_purchasing_dt.i_id')
        ->join('m_satuan','m_satuan.m_sid','d_purchasing_dt.d_pcsdt_sat')
        ->whereBetween('d_pcs_date_created', [$tanggal1, $tanggal2])
        ->get();
        
        return DataTables::of($pembelian)
        ->addIndexColumn()
        ->editColumn('d_pcs_date_created', function ($data)
        {
            return date('d M Y', strtotime($data->d_pcs_date_created));
        })
        ->editColumn('d_pcsdt_qtyconfirm', function ($data)
        {
            return '<div>
                      <span class="pull-right">
                        '.number_format( $data->d_pcsdt_qtyconfirm ,0,',','.').'
                      </span>
                    </div>';
        })
        ->editColumn('d_pcsdt_price', function ($data)
        {
            return '<div>
                      <span class="pull-right">
                        '.number_format( $data->d_pcsdt_price ,2,',','.').'
                      </span>
                    </div>';
        })
        ->addColumn('total-harga', function ($data)
        {
            return '<div>
                      <span class="pull-right">
                        '.number_format( $data->d_pcsdt_price * $data->d_pcsdt_qtyconfirm ,2,',','.').'
                      </span>
                    </div>';
        })

        ->rawColumns(['d_pcs_date_created',
                      'd_pcsdt_qtyconfirm',
                      'd_pcsdt_price',
                      'total-harga'])
        ->make(true);
    }

    public function print_laporan_pembelian($tgl1, $tgl2)
    {
      $tanggal1 = date('Y-m-d',strtotime($tgl1));
      $tanggal2 = date('Y-m-d',strtotime($tgl2));
      $pembelian = d_purchasing_dt::select('s_company',
                                            'd_pcs_date_created',
                                            'i_name',
                                            'd_pcsdt_price',
                                            'd_pcsdt_qtyconfirm',
                                            'm_sname',
                                            'd_pcsdt_total')
        ->join('d_purchasing','d_purchasing.d_pcs_id','=','d_purchasing_dt.d_pcs_id')
        ->join('d_supplier','d_supplier.s_id','=','d_purchasing.s_id')
        ->join('m_item','m_item.i_id','=','d_purchasing_dt.i_id')
        ->join('m_satuan','m_satuan.m_sid','d_purchasing_dt.d_pcsdt_sat')
        ->whereBetween('d_pcs_date_created', [$tanggal1, $tanggal2])
        ->get();

      $totalPembelian = d_purchasing_dt::select((DB::raw('SUM(d_purchasing_dt.d_pcsdt_total) as total_pembelian')))
        ->join('d_purchasing','d_purchasing.d_pcs_id','=','d_purchasing_dt.d_pcs_id')
        ->join('d_supplier','d_supplier.s_id','=','d_purchasing.s_id')
        ->join('m_item','m_item.i_id','=','d_purchasing_dt.i_id')
        ->join('m_satuan','m_satuan.m_sid','d_purchasing_dt.d_pcsdt_sat')
        ->whereBetween('d_pcs_date_created', [$tanggal1, $tanggal2])
        ->get();
        // dd($totalPembelian);
        return view('purchasing/lap-pembelian/print-lap-belanjasupplier',compact('tgl1','tgl2','pembelian','totalPembelian'));

    }
}
