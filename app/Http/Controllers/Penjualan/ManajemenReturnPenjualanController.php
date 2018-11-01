<?php

namespace App\Http\Controllers\Penjualan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Carbon\Carbon;
use DataTables;
use Response;
use URL;
use DB;
use App\d_sales_return;
use App\d_sales_returndt;
use App\d_sales_dt;
use App\d_sales;
use App\d_stock;
use App\d_stock_mutation;


class ManajemenReturnPenjualanController extends Controller
{

  public function newreturn(){
    

    return view('penjualan.manajemenreturn.return-pembelian');
  }

  public function tabel(){
    $return = d_sales_return::all();

    return DataTables::of($return)

    ->editColumn('dsr_date', function ($data) {
       return date('d M Y', strtotime($data->dsr_date));
    })

    ->editColumn('dsr_type_sales', function ($data)  {
            if ($data->dsr_type_sales == "RT")
            {
                return 'Retail';
            }
            elseif ($data->dsr_type_sales == "GR")
            {
                return 'Grosir';
            }
        })

    ->editColumn('dsr_status', function ($data)  {
            if ($data->dsr_status == "WT")
            {
                return '<div class="text-center">
                          <span class="label label-yellow">Waiting</span>
                        </div>';
            }
            elseif ($data->dsr_status == "TL")
            {
                return '<div class="text-center">
                            <span class="label label-red">Di Tolak</span>
                        </div>';
            } elseif ($data->dsr_status == "TR")
            {
                return '<div class="text-center">
                            <span class="label label-blue">Di Setujui</span>
                        </div>';
            }
        })

    ->editColumn('dsr_method', function ($data)  {
            if ($data->dsr_method == "TK")
            {
                return 'Tukar Barang';
            }
            elseif ($data->dsr_method == "PN")
            {
                return 'Pemotongan Nota';
            }
        })

    ->editColumn('dsr_jenis_return', function ($data)  {
            if ($data->dsr_jenis_return == "BR")
            {
                return 'Barang Rusak';
            }
            elseif ($data->dsr_jenis_return == "KB")
            {
                return 'Kelebihan Barang';
            }
        })

    ->addColumn('action', function($data){
        if ($data->dsr_status == "WT"){
          return  '<div class="text-center">
                      <button type="button"
                          class="btn btn-success fa fa-eye btn-sm"
                          title="detail"
                          data-toggle="modal"
                          onclick="lihatDetail('.$data->dsr_id.')"
                          data-target="#myItem">
                      </button>
                      <a href=""
                          class="btn btn-warning btn-sm"
                          title="Edit">
                          <i class="fa fa-pencil"></i>
                      </a>
                      <a  onclick="distroyNota()"
                          class="btn btn-danger btn-sm"
                          title="Hapus">
                          <i class="fa fa-trash-o"></i></a>
                    </div>';
          }elseif ($data->dsr_status == "TL") {
            return  '<div class="text-center">
                        <button type="button"
                            class="btn btn-success fa fa-eye btn-sm"
                            title="detail"
                            data-toggle="modal"
                            onclick="lihatDetail('.$data->dsr_id.')"
                            data-target="#myItem">
                        </button>
                        <a  onclick="distroyNota()"
                            class="btn btn-danger btn-sm"
                            title="Hapus">
                            <i class="fa fa-trash-o"></i></a>
                      </div>';
          }else{
            return '<div class="text-center">
                        <button type="button"
                            class="btn btn-success fa fa-eye btn-sm"
                            title="detail"
                            data-toggle="modal"
                            onclick="lihatDetail('.$data->dsr_id.')"
                            data-target="#myItem">
                        </button>
                      </div>';
          }
         
          })
    ->rawColumns(['dsr_date','dsr_status','dsr_method','dsr_jenis_return','action'])
    ->make(true);
  }

  public function cariNotaSales(Request $request){
    // dd($requests->all());
  	$formatted_tags = array();
    $term = trim($request->q);
    if (empty($term)) {
      $sup = d_sales::where('s_status','=','FN')
        ->limit(50)
        ->get();
      foreach ($sup as $val) {
          $formatted_tags[] = [ 'id' => $val->s_id, 
                                'text' => $val->s_note .'-'. 
                                          $val->s_channel .'-'.
                                          date('d M Y', strtotime($val->s_date))];
      }
      return Response::json($formatted_tags);
    }
    else
    {
      $sup = d_sales::where('s_status','=','FN')
        ->where(function ($b) use ($term) {
                $b->orWhere('s_note', 'LIKE', '%'.$term.'%')
                  ->orWhere('s_channel', 'LIKE', '%'.$term.'%')
                  ->orWhere('s_date', 'LIKE', '%'.$term.'%');
            })
        ->limit(50)
        ->get();
      foreach ($sup as $val) {
          $formatted_tags[] = [ 'id' => $val->s_id, 
                                'text' => $val->s_note .'-'. 
                                          $val->s_channel .'-'.
                                          date('d M Y', strtotime($val->s_date))];
      }

      return Response::json($formatted_tags);  
    }

  }

  public function getNota($id){
    $data = d_sales::select('c_name',
                            'c_hp1',
                            'c_hp2',
                            'c_address',
                            'c_type',
                            's_gross',
                            's_disc_percent',
                            's_disc_value',
                            's_net',
                            'pm_name')
      ->join('m_customer','c_id','=','s_customer')
      ->join('d_sales_dt','sd_sales','=','s_id')
      ->join('m_item','i_id','=','sd_item')
      ->join('d_sales_payment','sp_sales','=','s_id')
      ->join('m_paymentmethod','pm_id','=','sp_paymentid')
      ->where('s_id',$id)
      ->get();

      return Response::json($data);
  }

  public function tabelPotNota($id){
    $data = d_sales_dt::select('*')
      ->join('m_item','i_id','=','sd_item')
      ->join('m_satuan','m_satuan.m_sid','=','i_sat1')
      ->where('sd_sales',$id)
      ->get();

    return DataTables::of($data)
    ->editColumn('i_name', function ($data) {
      return '<input  name="i_name[]" readonly 
                      class="form-control text-right" 
                      value="'.$data->i_name.'">
              <input  name="i_id[]" readonly 
                      type="hidden"
                      class="form-control text-right" 
                      value="'.$data->i_id.'">';
    })
    ->editColumn('sd_qty', function ($data) {
      return '<input  name="sd_qty[]" readonly 
                      class="form-control text-right qty-item" 
                      value="'.$data->sd_qty.'">';
    })
    ->editColumn('sd_qty_return', function ($data) {
      return '<input  name="sd_qty_return[]"  
                      class="form-control text-right qtyreturn" 
                      value="0"
                      type="text"
                      onkeyup="qtyReturn(this, event);autoJumlahNet();">
              <input  name="sd_qty-return[]"  
                      class="form-control text-right qty-return"
                      style="display:none" 
                      value="0">';
    })
    ->editColumn('sd_price', function ($data) {
      return '<input name="sd_price[]" readonly 
                    class="form-control text-right harga-item" 
                    value="Rp. '.number_format($data->sd_price,2,',','.').'">';
    })
    ->editColumn('sd_disc_percent', function ($data) {
      if ($data->sd_disc_percent == 0 && $data->sd_disc_value == 0.00) {
        return '<div class="input-group">
                <input  name="sd_disc_percent[]" 
                        class="form-control text-right dPersen-item discpercent" 
                        value="'.$data->sd_disc_percent.'" 
                        onkeyup="discpercent(this, event);autoJumlahDiskon()">
                        <span class="input-group-addon" id="basic-addon1">%</span>
              </div>
                <input  name="value_disc_percent[]" 
                        class="form-control value-persen totalPersen" 
                        style="display:none"
                        value="'.(int)$data->sd_disc_vpercent.'">';
      }else if ($data->sd_disc_percent == 0) {
        return '<div class="input-group">
                <input  name="sd_disc_percent[]" 
                        class="form-control text-right dPersen-item discpercent" 
                        value="'.$data->sd_disc_percent.'" 
                        readonly
                        onkeyup="discpercent(this, event);autoJumlahDiskon()">
                        <span class="input-group-addon" id="basic-addon1">%</span>
              </div>
                <input  name="value_disc_percent[]" 
                        class="form-control value-persen totalPersen" 
                        style="display:none"
                        value="'.(int)$data->sd_disc_vpercent.'">';
      }else{
        return '<div class="input-group">
                <input  name="sd_disc_percent[]" 
                        class="form-control text-right dPersen-item discpercent" 
                        value="'.$data->sd_disc_percent.'" 
                        onkeyup="discpercent(this, event);autoJumlahDiskon()">
                        <span class="input-group-addon" id="basic-addon1">%</span>
              </div>
                <input  name="value_disc_percent[]" 
                        class="form-control value-persen totalPersen" 
                        style="display:none"
                        value="'.(int)$data->sd_disc_vpercent.'">';
      }
      
    })
    ->editColumn('sd_disc_value', function ($data) {
      if ($data->sd_disc_value == 0.00 && $data->sd_disc_percent == 0) {
        return '<input  name="sd_disc[]" 
                      type="text"
                      class="form-control text-right field_harga discvalue dValue-item" 
                      onkeyup="discvalue(this, event);autoJumlahDiskon()"
                      value="Rp. '.number_format($data->sd_disc_value / $data->sd_qty,2,',','.').'">
                <input  name="sd_disc_value[]" 
                      type="text"
                      style="display:none"
                      class="form-control text-right sd_disc_value totalPersen" 
                      value="'.(int)$data->sd_disc_value.'">';

      }else if($data->sd_disc_value == 0.00 ) {
        return '<input  name="sd_disc[]" 
                      type="text"
                      class="form-control text-right field_harga discvalue dValue-item" 
                      onkeyup="discvalue(this, event);autoJumlahDiskon()"
                      readonly
                      value="Rp. '.number_format($data->sd_disc_value / $data->sd_qty,2,',','.').'">
                <input  name="sd_disc_value[]" 
                      type="text"
                      style="display:none"
                      class="form-control text-right sd_disc_value totalPersen"
                      value="'.(int)$data->sd_disc_value.'">';

      }else{
        return '<input  name="sd_disc[]" 
                      type="text"
                      class="form-control text-right field_harga discvalue dValue-item" 
                      onkeyup="discvalue(this, event);autoJumlahDiskon()"
                      value="Rp. '.number_format($data->sd_disc_value / $data->sd_qty,2,',','.').'">
                <input  name="sd_disc_value[]" 
                      type="text"
                      style="display:none"
                      class="form-control text-right sd_disc_value totalPersen" 
                      value="'.(int)$data->sd_disc_value.'">';
      }
      
    })
    ->editColumn('sd_return', function ($data) {
      return '<input  name="sd_return[]" readonly 
                      class="form-control text-right hasilReturn" 
                      value="0">';
    })
    ->editColumn('sd_total', function ($data) {
      return '<input  name="sd_total[]" readonly 
                      class="form-control text-right totalHarga totalNet" 
                      value="Rp. '.number_format($data->sd_total,2,',','.').'">';
    })
    ->rawColumns([  'i_name',
                    'sd_qty',
                    'sd_qty_return',
                    'sd_price',
                    'sd_disc_percent',
                    'sd_disc_value',
                    'sd_return',
                    'sd_total'])
    ->make(true);
  }

  public function store($metode, Request $request){
  // dd($request->all());
  DB::beginTransaction();
    try {
      //nota
      $year = carbon::now()->format('y');
      $month = carbon::now()->format('m');
      $date = carbon::now()->format('d');
      $dsr_id = d_sales_return::select('dsr_id')->max('dsr_id');
      if ($dsr_id <= 0 || $dsr_id <= '') {
        $dsr_id  = 1;
      }else{
        $dsr_id += 1;
      }
      $notaReturn = 'XX'  . $year . $month . $date . $dsr_id .'-R';
      //end nota
      $sales = d_sales::where('s_id',$request->id_sales)
        ->first();
      $dsr_id = d_sales_return::select('dsr_id')->max('dsr_id')+1;
      // dd($dsr_id);
      d_sales_return::create([
        'dsr_id' => $dsr_id,
        'dsr_sid' => $sales->s_id,
        'dsr_cus' => $sales->s_customer,
        'dsr_code' => $notaReturn,
        'dsr_method' => $metode,
        'dsr_jenis_return' => $request->jenis_return,
        'dsr_type_sales' => $sales->s_channel,
        'dsr_date' => $sales->s_date,
        'dsr_price_return' => $this->konvertRp($request->t_return),
        'dsr_sgross' => $this->konvertRp($request->s_gross),
        'dsr_disc_value' => $this->konvertRp($request->total_diskon),
        'dsr_net' =>  $this->konvertRp($request->s_net),
        'dsr_status' => 'WT',
        'dsr_created' => Carbon::now()
      ]);

    for ($i=0; $i < count($request->i_id); $i++) { 
        d_sales_returndt::create([
          'dsrdt_idsr' => $dsr_id,
          'dsrdt_smdt' => $i + 1,
          'dsrdt_item' => $request->i_id[$i],
          'dsrdt_qty' => $request->sd_qty[$i],
          'dsrdt_qty_confirm' => $request->sd_qty_return[$i],
          'dsrdt_price' => ($this->konvertRp($request->sd_price[$i])),
          'dsrdt_disc_percent' => $request->sd_disc_percent[$i],
          'dsrdt_disc_vpercent' => $request->value_disc_percent[$i],
          'dsrdt_disc_value' => ($this->konvertRp($request->sd_disc[$i])),
          'dsrdt_return_price' => ($this->konvertRp($request->sd_return[$i])),
          'dsrdt_hasil' => ($this->konvertRp($request->sd_total[$i]))
        ]);
    }


  DB::commit();
    return response()->json([
          'status' => 'sukses'
      ]);
    } catch (\Exception $e) {
    DB::rollback();
    return response()->json([
        'status' => 'gagal',
        'data' => $e
      ]);
    }
  }

  public function detail(Request $request){
    $data = d_sales_return::select('c_name',
                                  's_note',
                                  'dsr_price_return',
                                  'dsr_sgross',
                                  'dsr_disc_value',
                                  'dsr_net',
                                  'i_name',
                                  'dsrdt_qty',
                                  'dsrdt_qty_confirm',
                                  'm_sname',
                                  'dsrdt_price',
                                  'dsrdt_disc_percent',
                                  'dsrdt_disc_value',
                                  'dsrdt_return_price',
                                  'dsrdt_hasil',
                                  'dsr_status',
                                  'dsr_id')
      ->join('m_customer','m_customer.c_id','=','dsr_cus')
      ->join('d_sales','d_sales.s_id','=','dsr_sid')
      ->join('d_sales_returndt','d_sales_returndt.dsrdt_idsr','=','dsr_id')
      ->join('m_item','m_item.i_id','=','dsrdt_item')
      ->join('m_satuan','m_satuan.m_sid','=','i_sat1')
      ->where('dsr_id',$request->x)
      ->get();
      // dd($data);

    return view('penjualan.manajemenreturn.detail-item',compact('data'));
  }

  public function konvertRp($value){

    $value = str_replace(['Rp', '\\', '.', ' '], '', $value);
    return str_replace(',', '.', $value);

    }

  public function storeReturn($id){
    $data = d_sales_return::select('dsr_code','dsr_id','dsr_method','dsr_jenis_return')
      ->where('dsr_id',$id)
      ->first();
    if ($data->dsr_method == 'PN') {
      if ($data->dsr_jenis_return == 'BR') {
        $cek = d_sales_returndt::select('dsrdt_item',
                                        'dsrdt_qty_confirm')
          ->where('dsrdt_idsr',$data->dsr_id)->get();
       
        for ($i=0; $i <count($cek) ; $i++) {
          if ($cek[$i]->dsrdt_qty_confirm != 0) {
             $coba[] = $cek[$i];
             $stockRusak = d_stock::where('s_item',$cek[$i]->dsrdt_item)
                ->where('s_comp',8)
                ->where('s_position',8)
                ->first();
              if ($stockRusak == null) {
                $s_id = d_stock::select('s_id')->max('s_id')+1;
                d_stock::create([
                    's_id' => $s_id,
                    's_comp' => 8,
                    's_position' => 8,
                    's_item' => $cek[$i]->dsrdt_item,
                    's_qty' => $cek[$i]->dsrdt_qty_confirm
                  ]);
                d_stock_mutation::create([
                    'sm_stock' =>  $s_id,
                    'sm_detailid' => 1,
                    'sm_date' => Carbon::now(),
                    'sm_comp' => 8,
                    'sm_position' => 8,
                    'sm_mutcat' => 4,
                    'sm_item' => $cek[$i]->dsrdt_item,
                    'sm_qty' => $cek[$i]->dsrdt_qty_confirm,
                    'sm_qty_sisa' => $cek[$i]->dsrdt_qty_confirm,
                    'sm_detail' => 'PENAMBAHAN',
                    'sm_reff' => $data->dsr_code,
                    'sm_insert' => Carbon::now()
                ]);
              }else{
            $tambahStock = (int)$stockRusak->s_qty + $cek[$i]->dsrdt_qty_confirm;
            // dd($cek[$i]->dsrdt_qty_confirm);
            $stockRusak->update([
              's_qty' => $tambahStock,
            ]);
            $sm_detailid = d_stock_mutation::select('sm_detailid')
              ->where('sm_stock',$stockRusak->s_id)
              ->max('sm_detailid')+1;
            // dd($sm_detailid);
            d_stock_mutation::create([
                    'sm_stock' =>  $stockRusak->s_id,
                    'sm_detailid' => $sm_detailid,
                    'sm_date' => Carbon::now(),
                    'sm_comp' => 8,
                    'sm_position' => 8,
                    'sm_mutcat' => 4,
                    'sm_item' => $cek[$i]->dsrdt_item,
                    'sm_qty' => $cek[$i]->dsrdt_qty_confirm,
                    'sm_qty_sisa' => $cek[$i]->dsrdt_qty_confirm,
                    'sm_detail' => 'PENAMBAHAN',
                    'sm_reff' => $data->dsr_code,
                    'sm_insert' => Carbon::now()
                ]);
           }
         }
        }
        
      }else{
        dd($requests->all());
        for ($i=0; $i <count($cek) ; $i++) {
          if ($cek[$i]->dsrdt_qty_confirm != 0) {
            $stockGrosir = d_stock::where('s_item',$cek[$i]->dsrdt_item)
                ->where('s_comp',2)
                ->where('s_position',2)
                ->first();
            $tambahStock = (int)$stockGrosir->s_qty + $cek[$i]->dsrdt_qty_confirm;
            // dd($cek[$i]->dsrdt_qty_confirm);
            $stockGrosir->update([
              's_qty' => $tambahStock,
            ]);
            $sm_detailid = d_stock_mutation::select('sm_detailid')
              ->where('sm_stock',$stockGrosir->s_id)
              ->max('sm_detailid')+1;
            // dd($sm_detailid);
            d_stock_mutation::create([
                    'sm_stock' =>  $stockGrosir->s_id,
                    'sm_detailid' => $sm_detailid,
                    'sm_date' => Carbon::now(),
                    'sm_comp' => 2,
                    'sm_position' => 2,
                    'sm_mutcat' => 4,
                    'sm_item' => $cek[$i]->dsrdt_item,
                    'sm_qty' => $cek[$i]->dsrdt_qty_confirm,
                    'sm_qty_sisa' => $cek[$i]->dsrdt_qty_confirm,
                    'sm_detail' => 'PENAMBAHAN',
                    'sm_reff' => $data->dsr_code,
                    'sm_insert' => Carbon::now()
                ]);
          }
        }
        
      }
    }else{
      return 'b';
    }
  }
}
