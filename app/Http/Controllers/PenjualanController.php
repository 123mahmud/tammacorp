<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use app\Customer;
use Carbon\carbon;
use DB;
use Yajra\DataTables\DataTables;

class PenjualanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function harga()
    {
        return view('/penjualan/manajemenharga/index');
    }

    public function promosi()
    {
        return view('/penjualan/manajemenpromosi/promosi');
    }

    public function promosi2()
    {
        return view('/penjualan/broadcastpromosi/promosi2');
    }

    public function rencana()
    {
        return view('/penjualan/rencanapenjualan/rencana');
    }

    public function monitoringorder()
    {
        return view('/penjualan/monitoringorder/index');
    }

    public function retail()
    {

        $year = carbon::now()->format('y');
        $month = carbon::now()->format('m');

             //select max dari um_id dari table d_uangmuka
        $maxid = DB::Table('customer')->select('id_cus_ut')->max('id_cus_ut');

        //untuk +1 nilai yang ada,, jika kosong maka maxid = 1 , 

        if ($maxid <= 0 || $maxid <= '') {
          $maxid  = 1;
        }else{
          $maxid += 1;
        }
        
        //jika kurang dari 100 maka maxid mimiliki 00 didepannya
        if ($maxid < 100) {
          $maxid = '00'.$maxid;
        }
           $id_cust = 'CUS' . $month . $year . '/' . 'C001' . '/' .  $maxid;   
            return view('/penjualan/POSretail/retail', compact('id_cust'));
    }

    public function grosir()
    {
         $year = carbon::now()->format('y');
        $month = carbon::now()->format('m');

             //select max dari um_id dari table d_uangmuka
        $maxid = DB::Table('customer')->select('id_cus_ut')->max('id_cus_ut');

        //untuk +1 nilai yang ada,, jika kosong maka maxid = 1 , 

        if ($maxid <= 0 || $maxid <= '') {
          $maxid  = 1;
        }else{
          $maxid += 1;
        }
        
        //jika kurang dari 100 maka maxid mimiliki 00 didepannya
        if ($maxid < 100) {
          $maxid = '00'.$maxid;
        }
           $id_cust = 'CUS' . $month . $year . '/' . 'C001' . '/' .  $maxid;   
            return view('/penjualan/POSgrosir/grosir', compact('id_cust'));
        
    }

    public function r_penjualan()
    {
        return view('/penjualan/manajemenreturn/index');
    }

    public function progress()
    {
        return view('/penjualan/monitorprogress/progress');
    }
      public function mutasi()
    {
      return view('/penjualan/mutasistok/index');
    }
    public function tambah_promosi2()
    {
      return view('/penjualan/broadcastpromosi/tambah_promosi2');
    }

    public function dataMonitor(Request $request, $id)
    {
        $tanggal = $request->tanggal;
        if ($id == 'Semua') 
        {
            $data = DB::table('d_sales')
            ->join('d_sales_dt', 's_id', '=', 'sd_sales')
            ->join('m_item', 'i_id', '=', 'sd_item')
            ->join('m_satuan', 'm_sid', '=', 'i_sat1')
            ->join('m_customer', 'c_id', '=', 's_customer')
            ->where('d_sales.s_status', '!=', "DR")
            ->where('d_sales.s_status', '!=', "PR")
            ->select('c_name', DB::raw('date_format(s_date, "%d/%m/%Y") as s_date'), 'i_name', 'sd_qty', 'sd_total', 's_note','sd_price','sd_disc_value','sd_disc_vpercent');

            if ($tanggal == 'sekarang')
            {
                $data = $data->whereDate('s_date', '=', DB::raw('now()'))
                    ->get();
            } 
            else 
            {
                $start = $request->start;
                $end = $request->end;
                $customer = $request->customer;
                $barang = $request->barang;
                if ($start == 'awal' && $end == 'akhir' && $customer == 'semua' && $barang == 'semua'){
                    $data = $data->get();
                } elseif ($start != 'awal' && $end == 'akhir' && $customer == 'semua' && $barang == 'semua'){
                    $start = Carbon::createFromFormat('d-m-Y', $start)->format('Y-m-d');
                    $data = $data->whereDate('s_date', '>=', $start)->get();
                } elseif ($start == 'awal' && $end != 'akhir' && $customer == 'semua' && $barang == 'semua'){
                    $end = Carbon::createFromFormat('d-m-Y', $end)->format('Y-m-d');
                    $data = $data->whereDate('s_date', '<=', $end)->get();
                } elseif ($start == 'awal' && $end == 'akhir' && $customer != 'semua' && $barang == 'semua'){
                    $data = $data->where('s_customer', '=', $customer)->get();
                } elseif ($start == 'awal' && $end == 'akhir' && $customer == 'semua' && $barang != 'semua'){
                    $data = $data->where('sd_item', '=', $barang)->get();
                } elseif ($start != 'awal' && $end != 'akhir' && $customer == 'semua' && $barang == 'semua'){
                    $start = Carbon::createFromFormat('d-m-Y', $start)->format('Y-m-d');
                    $end = Carbon::createFromFormat('d-m-Y', $end)->format('Y-m-d');
                    $data = $data->whereDate('s_date', '<=', $end)->whereDate('s_date', '>=', $start)->get();
                } elseif ($start == 'awal' && $end != 'akhir' && $customer != 'semua' && $barang == 'semua'){
                    $end = Carbon::createFromFormat('d-m-Y', $end)->format('Y-m-d');
                    $data = $data->whereDate('s_date', '<=', $end)->where('s_customer', '=', $customer)->get();
                } elseif ($start == 'awal' && $end == 'akhir' && $customer != 'semua' && $barang != 'semua'){
                    $data = $data->where('s_customer', '=', $customer)->where('sd_item', '=', $barang)->get();
                } elseif ($start != 'awal' && $end == 'akhir' && $customer == 'semua' && $barang != 'semua'){
                    $start = Carbon::createFromFormat('d-m-Y', $start)->format('Y-m-d');
                    $data = $data->whereDate('s_date', '>=', $start)->where('sd_item', '=', $barang)->get();
                } elseif ($start != 'awal' && $end != 'akhir' && $customer != 'semua' && $barang == 'semua'){
                    $start = Carbon::createFromFormat('d-m-Y', $start)->format('Y-m-d');
                    $end = Carbon::createFromFormat('d-m-Y', $end)->format('Y-m-d');
                    $data = $data->whereDate('s_date', '>=', $start)
                        ->whereDate('s_date', '<=', $end)
                        ->where('s_customer', '=', $customer)
                        ->get();
                } elseif ($start == 'awal' && $end != 'akhir' && $customer != 'semua' && $barang != 'semua'){
                    $end = Carbon::createFromFormat('d-m-Y', $end)->format('Y-m-d');
                    $data = $data->whereDate('s_date', '<=', $end)
                        ->where('s_customer', '=', $customer)
                        ->where('sd_item', '=', $barang)
                        ->get();
                } elseif ($start != 'awal' && $end == 'akhir' && $customer != 'semua' && $barang != 'semua'){
                    $start = Carbon::createFromFormat('d-m-Y', $start)->format('Y-m-d');
                    $data = $data->whereDate('s_date', '>=', $start)
                        ->where('s_customer', '=', $customer)
                        ->where('sd_item', '=', $barang)
                        ->get();
                } elseif ($start != 'awal' && $end != 'akhir' && $customer == 'semua' && $barang != 'semua'){
                    $end = Carbon::createFromFormat('d-m-Y', $end)->format('Y-m-d');
                    $start = Carbon::createFromFormat('d-m-Y', $start)->format('Y-m-d');
                    $data = $data->whereDate('s_date', '<=', $end)
                        ->whereDate('s_date', '>=', $start)
                        ->where('sd_item', '=', $barang)
                        ->get();
                } elseif ($start != 'awal' && $end != 'akhir' && $customer != 'semua' && $barang != 'semua'){
                    $end = Carbon::createFromFormat('d-m-Y', $end)->format('Y-m-d');
                    $start = Carbon::createFromFormat('d-m-Y', $start)->format('Y-m-d');
                    $data = $data->whereDate('s_date', '<=', $end)
                        ->whereDate('s_date', '>=', $start)
                        ->where('sd_item', '=', $barang)
                        ->where('s_customer', '=', $customer)
                        ->get();
                }
            }
        }
        else if ($id == 'Grosir') 
        {
            
            $data = DB::table('d_sales')
            ->join('d_sales_dt', 's_id', '=', 'sd_sales')
            ->join('m_item', 'i_id', '=', 'sd_item')
            ->join('m_satuan', 'm_sid', '=', 'i_sat1')
            ->join('m_customer', 'c_id', '=', 's_customer')
            ->where('s_channel','GR')
            ->where('s_status','!=','DR')
            ->where('s_status','!=',"PR")
            ->select('c_name', DB::raw('date_format(s_date, "%d/%m/%Y") as s_date'), 'i_name', 'sd_qty', 'sd_total', 's_note','sd_price','sd_disc_value','sd_disc_vpercent');

            if ($tanggal == 'sekarang')
            {
                $data = $data->whereDate('s_date', '=', DB::raw('now()'))
                    ->get();
            } 
            else 
            {
                $start = $request->start;
                $end = $request->end;
                $customer = $request->customer;
                $barang = $request->barang;
                if ($start == 'awal' && $end == 'akhir' && $customer == 'semua' && $barang == 'semua'){
                    $data = $data->get();
                } elseif ($start != 'awal' && $end == 'akhir' && $customer == 'semua' && $barang == 'semua'){
                    $start = Carbon::createFromFormat('d-m-Y', $start)->format('Y-m-d');
                    $data = $data->whereDate('s_date', '>=', $start)->get();
                } elseif ($start == 'awal' && $end != 'akhir' && $customer == 'semua' && $barang == 'semua'){
                    $end = Carbon::createFromFormat('d-m-Y', $end)->format('Y-m-d');
                    $data = $data->whereDate('s_date', '<=', $end)->get();
                } elseif ($start == 'awal' && $end == 'akhir' && $customer != 'semua' && $barang == 'semua'){
                    $data = $data->where('s_customer', '=', $customer)->get();
                } elseif ($start == 'awal' && $end == 'akhir' && $customer == 'semua' && $barang != 'semua'){
                    $data = $data->where('sd_item', '=', $barang)->get();
                } elseif ($start != 'awal' && $end != 'akhir' && $customer == 'semua' && $barang == 'semua'){
                    $start = Carbon::createFromFormat('d-m-Y', $start)->format('Y-m-d');
                    $end = Carbon::createFromFormat('d-m-Y', $end)->format('Y-m-d');
                    $data = $data->whereDate('s_date', '<=', $end)->whereDate('s_date', '>=', $start)->get();
                } elseif ($start == 'awal' && $end != 'akhir' && $customer != 'semua' && $barang == 'semua'){
                    $end = Carbon::createFromFormat('d-m-Y', $end)->format('Y-m-d');
                    $data = $data->whereDate('s_date', '<=', $end)->where('s_customer', '=', $customer)->get();
                } elseif ($start == 'awal' && $end == 'akhir' && $customer != 'semua' && $barang != 'semua'){
                    $data = $data->where('s_customer', '=', $customer)->where('sd_item', '=', $barang)->get();
                } elseif ($start != 'awal' && $end == 'akhir' && $customer == 'semua' && $barang != 'semua'){
                    $start = Carbon::createFromFormat('d-m-Y', $start)->format('Y-m-d');
                    $data = $data->whereDate('s_date', '>=', $start)->where('sd_item', '=', $barang)->get();
                } elseif ($start != 'awal' && $end != 'akhir' && $customer != 'semua' && $barang == 'semua'){
                    $start = Carbon::createFromFormat('d-m-Y', $start)->format('Y-m-d');
                    $end = Carbon::createFromFormat('d-m-Y', $end)->format('Y-m-d');
                    $data = $data->whereDate('s_date', '>=', $start)
                        ->whereDate('s_date', '<=', $end)
                        ->where('s_customer', '=', $customer)
                        ->get();
                } elseif ($start == 'awal' && $end != 'akhir' && $customer != 'semua' && $barang != 'semua'){
                    $end = Carbon::createFromFormat('d-m-Y', $end)->format('Y-m-d');
                    $data = $data->whereDate('s_date', '<=', $end)
                        ->where('s_customer', '=', $customer)
                        ->where('sd_item', '=', $barang)
                        ->get();
                } elseif ($start != 'awal' && $end == 'akhir' && $customer != 'semua' && $barang != 'semua'){
                    $start = Carbon::createFromFormat('d-m-Y', $start)->format('Y-m-d');
                    $data = $data->whereDate('s_date', '>=', $start)
                        ->where('s_customer', '=', $customer)
                        ->where('sd_item', '=', $barang)
                        ->get();
                } elseif ($start != 'awal' && $end != 'akhir' && $customer == 'semua' && $barang != 'semua'){
                    $end = Carbon::createFromFormat('d-m-Y', $end)->format('Y-m-d');
                    $start = Carbon::createFromFormat('d-m-Y', $start)->format('Y-m-d');
                    $data = $data->whereDate('s_date', '<=', $end)
                        ->whereDate('s_date', '>=', $start)
                        ->where('sd_item', '=', $barang)
                        ->get();
                } elseif ($start != 'awal' && $end != 'akhir' && $customer != 'semua' && $barang != 'semua'){
                    $end = Carbon::createFromFormat('d-m-Y', $end)->format('Y-m-d');
                    $start = Carbon::createFromFormat('d-m-Y', $start)->format('Y-m-d');
                    $data = $data->whereDate('s_date', '<=', $end)
                        ->whereDate('s_date', '>=', $start)
                        ->where('sd_item', '=', $barang)
                        ->where('s_customer', '=', $customer)
                        ->get();
                }
            }
        }
        else
        {

            $data = DB::table('d_sales')
            ->join('d_sales_dt', 's_id', '=', 'sd_sales')
            ->join('m_item', 'i_id', '=', 'sd_item')
            ->join('m_satuan', 'm_sid', '=', 'i_sat1')
            ->join('m_customer', 'c_id', '=', 's_customer')
            ->where('s_channel','RT')
            ->where('s_status','FN')
            ->select('c_name', DB::raw('date_format(s_date, "%d/%m/%Y") as s_date'), 'i_name', 'sd_qty', 'sd_total', 's_note','sd_price','sd_disc_value','sd_disc_vpercent');

            if ($tanggal == 'sekarang')
            {
                $data = $data->whereDate('s_date', '=', DB::raw('now()'))
                    ->get();
            } 
            else 
            {
                $start = $request->start;
                $end = $request->end;
                $customer = $request->customer;
                $barang = $request->barang;
                if ($start == 'awal' && $end == 'akhir' && $customer == 'semua' && $barang == 'semua'){
                    $data = $data->get();
                } elseif ($start != 'awal' && $end == 'akhir' && $customer == 'semua' && $barang == 'semua'){
                    $start = Carbon::createFromFormat('d-m-Y', $start)->format('Y-m-d');
                    $data = $data->whereDate('s_date', '>=', $start)->get();
                } elseif ($start == 'awal' && $end != 'akhir' && $customer == 'semua' && $barang == 'semua'){
                    $end = Carbon::createFromFormat('d-m-Y', $end)->format('Y-m-d');
                    $data = $data->whereDate('s_date', '<=', $end)->get();
                } elseif ($start == 'awal' && $end == 'akhir' && $customer != 'semua' && $barang == 'semua'){
                    $data = $data->where('s_customer', '=', $customer)->get();
                } elseif ($start == 'awal' && $end == 'akhir' && $customer == 'semua' && $barang != 'semua'){
                    $data = $data->where('sd_item', '=', $barang)->get();
                } elseif ($start != 'awal' && $end != 'akhir' && $customer == 'semua' && $barang == 'semua'){
                    $start = Carbon::createFromFormat('d-m-Y', $start)->format('Y-m-d');
                    $end = Carbon::createFromFormat('d-m-Y', $end)->format('Y-m-d');
                    $data = $data->whereDate('s_date', '<=', $end)->whereDate('s_date', '>=', $start)->get();
                } elseif ($start == 'awal' && $end != 'akhir' && $customer != 'semua' && $barang == 'semua'){
                    $end = Carbon::createFromFormat('d-m-Y', $end)->format('Y-m-d');
                    $data = $data->whereDate('s_date', '<=', $end)->where('s_customer', '=', $customer)->get();
                } elseif ($start == 'awal' && $end == 'akhir' && $customer != 'semua' && $barang != 'semua'){
                    $data = $data->where('s_customer', '=', $customer)->where('sd_item', '=', $barang)->get();
                } elseif ($start != 'awal' && $end == 'akhir' && $customer == 'semua' && $barang != 'semua'){
                    $start = Carbon::createFromFormat('d-m-Y', $start)->format('Y-m-d');
                    $data = $data->whereDate('s_date', '>=', $start)->where('sd_item', '=', $barang)->get();
                } elseif ($start != 'awal' && $end != 'akhir' && $customer != 'semua' && $barang == 'semua'){
                    $start = Carbon::createFromFormat('d-m-Y', $start)->format('Y-m-d');
                    $end = Carbon::createFromFormat('d-m-Y', $end)->format('Y-m-d');
                    $data = $data->whereDate('s_date', '>=', $start)
                        ->whereDate('s_date', '<=', $end)
                        ->where('s_customer', '=', $customer)
                        ->get();
                } elseif ($start == 'awal' && $end != 'akhir' && $customer != 'semua' && $barang != 'semua'){
                    $end = Carbon::createFromFormat('d-m-Y', $end)->format('Y-m-d');
                    $data = $data->whereDate('s_date', '<=', $end)
                        ->where('s_customer', '=', $customer)
                        ->where('sd_item', '=', $barang)
                        ->get();
                } elseif ($start != 'awal' && $end == 'akhir' && $customer != 'semua' && $barang != 'semua'){
                    $start = Carbon::createFromFormat('d-m-Y', $start)->format('Y-m-d');
                    $data = $data->whereDate('s_date', '>=', $start)
                        ->where('s_customer', '=', $customer)
                        ->where('sd_item', '=', $barang)
                        ->get();
                } elseif ($start != 'awal' && $end != 'akhir' && $customer == 'semua' && $barang != 'semua'){
                    $end = Carbon::createFromFormat('d-m-Y', $end)->format('Y-m-d');
                    $start = Carbon::createFromFormat('d-m-Y', $start)->format('Y-m-d');
                    $data = $data->whereDate('s_date', '<=', $end)
                        ->whereDate('s_date', '>=', $start)
                        ->where('sd_item', '=', $barang)
                        ->get();
                } elseif ($start != 'awal' && $end != 'akhir' && $customer != 'semua' && $barang != 'semua'){
                    $end = Carbon::createFromFormat('d-m-Y', $end)->format('Y-m-d');
                    $start = Carbon::createFromFormat('d-m-Y', $start)->format('Y-m-d');
                    $data = $data->whereDate('s_date', '<=', $end)
                        ->whereDate('s_date', '>=', $start)
                        ->where('sd_item', '=', $barang)
                        ->where('s_customer', '=', $customer)
                        ->get();
                }
            }
        }
        
        

        return DataTables::of($data)
            ->addColumn('s_date', function ($data)
            {
                return date('d M Y', strtotime($data->s_date));
            })
            ->addColumn('Harga', function ($data)
            {
                return '<div>
                          <span class="pull-right">
                            '.number_format( $data->sd_price ,2,',','.').'
                          </span>
                        </div>';
            })
            ->editColumn('sd_disc_value', function ($data)
            {
                return '<div>
                          <span class="pull-right">
                            '.number_format( $data->sd_disc_value / $data->sd_qty ,2,',','.').'
                          </span>
                        </div>';
            })
            ->editColumn('sd_disc_vpercent', function ($data)
            {
                return '<div>
                          <span class="pull-right">
                            '.number_format( $data->sd_disc_vpercent ,2,',','.').'
                          </span>
                        </div>';
            })
            ->addColumn('Dpp', function ($data)
            {
                return '<div>
                          <span class="pull-right">
                            0,00
                          </span>
                        </div>';
            })
            ->addColumn('Ppn', function ($data)
            {
                return '<div>
                          <span class="pull-right">
                            0,00
                          </span>
                        </div>';
            })
            ->addColumn('sd_total', function ($data)
            {
                return '<div>
                          <span class="pull-right">
                            '.number_format( $data->sd_total ,2,',','.').'
                          </span>
                        </div>';
            })
            ->rawColumns(['s_date','sd_total','Harga','sd_disc_value','sd_disc_vpercent','Dpp','Ppn'])
            ->make(true);
    }

    public function getItem(Request $request)
    {
        dd($request);
    }
}
