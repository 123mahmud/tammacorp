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
use App\m_item;
use App\d_sales_returnsb;
use App\lib\mutasi;


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
            } elseif ($data->dsr_status == "FN")
            {
              return '<div class="text-center">
                            <span class="label label-green">Selesai</span>
                        </div>';
            }
        })

    ->editColumn('dsr_method', function ($data)  {
            if ($data->dsr_method == "TB")
            {
                return 'Tukar Barang';
            }
            elseif ($data->dsr_method == "PN")
            {
                return 'Pemotongan Nota';
            }
             elseif ($data->dsr_method == "SB")
            {
                return 'Salah Barang';
            }
             elseif ($data->dsr_method == "SA")
            {
                return 'Salah Alamat';
            }
             elseif ($data->dsr_method == "KB")
            {
                return 'Kelebihan Barang';
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
      if ($data->dsr_method == 'SB') {

        if ($data->dsr_status == "WT"){
          return  '<div class="text-center">
                      <button type="button"
                          class="btn btn-success fa fa-eye btn-sm"
                          title="detail"
                          data-toggle="modal"
                          onclick="lihatDetailSB('.$data->dsr_id.')"
                          data-target="#myItemSB">
                      </button>
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
                            onclick="lihatDetailSB('.$data->dsr_id.')"
                            data-target="#myItemSB">
                        </button>
                        <a  onclick="distroyNota()"
                            class="btn btn-danger btn-sm"
                            title="Hapus">
                            <i class="fa fa-trash-o"></i></a>
                      </div>';
          }else{
            if ($data->dsr_status_terima == 'WT'){
              return '<div class="text-center">
                        <button type="button"
                            class="btn btn-success fa fa-eye btn-sm"
                            title="detail"
                            data-toggle="modal"
                            onclick="lihatDetailSB('.$data->dsr_id.')"
                            data-target="#myItemSB">
                        </button>
                        <button type="button"
                            class="btn btn-success fa fa-check btn-sm"
                            title="Terima Barang"
                            data-toggle="modal"
                            onclick="lihatDetailTerimaSB('.$data->dsr_id.')"
                            data-target="#myItemTerimaSB">
                        </button>
                      </div>';
            }else{
              return '<div class="text-center">
                        <button type="button"
                            class="btn btn-success fa fa-eye btn-sm"
                            title="detail"
                            data-toggle="modal"
                            onclick="lihatDetailSB('.$data->dsr_id.')"
                            data-target="#myItemSB">
                        </button>
                      </div>';
            }
            
         }

      }else{

        if ($data->dsr_status == "WT"){
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
      $sup = d_sales::
        where(function ($query){
          $query->where('s_channel', '=', 'RT')
                ->where('s_status', '=', 'FN');
        })
        ->orWhere(function ($query){
          $query->where('s_channel', '=', 'GR')
                ->where('s_status', '=', 'RC');
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
    else
    {
      $sup = d_sales::
        where(function ($query){
          $query->where('s_channel', '=', 'RT')
                ->where('s_status', '=', 'FN');
        })
        ->orWhere(function ($query){
          $query->where('s_channel', '=', 'GR')
                ->where('s_status', '=', 'RC');
        })
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
                            's_channel',
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

      if ($metode == 'SB') {
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
            'dsr_disc_vpercent' => $this->konvertRp($request->total_percent),
            'dsr_disc_value' => $this->konvertRp($request->total_value),
            'dsr_net' =>  $this->konvertRp($request->s_net),
            'dsr_status' => 'WT',
            'dsr_status_terima' => 'WT',
            'dsr_created' => Carbon::now()
          ]);

        for ($i=0; $i < count($request->i_id); $i++) { 

            d_sales_returndt::create([
              'dsrdt_idsr' => $dsr_id,
              'dsrdt_smdt' => $i + 1,
              'dsrdt_item' => $request->i_id[$i],
              'dsrdt_qty' => $request->sd_qty[$i],
              'dsrdt_price' => ($this->konvertRp($request->sd_price[$i])),
              'dsrdt_disc_percent' => $request->sd_disc_percent[$i],
              'dsrdt_disc_vpercent' => $request->value_disc_percent[$i],
              'dsrdt_disc_value' => ($this->konvertRp($request->sd_disc[$i])) * $request->sd_qty_return[$i],
              'dsrdt_hasil' => ($this->konvertRp($request->sd_total[$i]))
            ]);
        }

        for ($i=0; $i < count($request->kode_itemsb); $i++) { 
          d_sales_returnsb::create([
            'dsrs_sr' => $dsr_id,
            'dsrs_detailid' => $i + 1,
            'dsrs_item' => $request->kode_itemsb[$i],
            'dsrs_qty' => $request->sd_qtysb[$i],
            'dsrs_created' => Carbon::now()
          ]);
        }

      }else{

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
          'dsr_disc_vpercent' => $this->konvertRp($request->total_percent),
          'dsr_disc_value' => $this->konvertRp($request->total_value),
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
              'dsrdt_disc_vpercentreturn' =>  ($this->konvertRp($request->sd_return[$i])) * $request->sd_disc_percent[$i] / 100 ,
              'dsrdt_disc_value' => ($this->konvertRp($request->sd_disc[$i])) * $request->sd_qty_return[$i],
              'dsrdt_return_price' => ($this->konvertRp($request->sd_return[$i])) - (($this->konvertRp($request->sd_disc[$i])) * $request->sd_qty_return[$i]) - (($this->konvertRp($request->sd_return[$i])) * $request->sd_disc_percent[$i] / 100),
              'dsrdt_hasil' => ($this->konvertRp($request->sd_total[$i]))
            ]);
        }
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

  public function detailSB(Request $request){
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

    $dataSB = d_sales_returnsb::select('i_id',
                                        'i_name',
                                        'dsrs_qty',
                                        'm_sname')
      ->join('m_item','m_item.i_id','=','dsrs_item')
      ->join('m_satuan','m_satuan.m_sid','=','i_sat1')
      ->get();
      // dd($data);

    return view('penjualan.manajemenreturn.detail-item-sb',compact('data','dataSB'));
  }

  public function detailTerimaSB(Request $request){
    $dataSB = d_sales_returnsb::select('i_id',
                                    'i_name',
                                    'dsrs_qty',
                                    'm_sname',
                                    'dsr_id',
                                    'dsr_status_terima')
      ->where('dsrs_sr',$request->x)
      ->join('d_sales_return','d_sales_return.dsr_id','=','dsrs_sr')
      ->join('m_item','m_item.i_id','=','dsrs_item')
      ->join('m_satuan','m_satuan.m_sid','=','i_sat1')
      ->get();
      // dd($dataSB);
    return view('penjualan.manajemenreturn.detail-item-TerimaSB',compact('dataSB'));
  }

  public function konvertRp($value){

    $value = str_replace(['Rp', '\\', '.', ' '], '', $value);
    return str_replace(',', '.', $value);

    }

  public function storeReturn($id){
    DB::beginTransaction();
    try {
    $data = d_sales_return::select('*')
      ->where('dsr_id',$id)
      ->first();
    $sales = d_sales::where('s_id',$data->dsr_sid)
      ->join('d_sales_payment','d_sales_payment.sp_sales','=','s_id')
      ->first();
    $cek = d_sales_returndt::select('*')
      ->where('dsrdt_idsr',$data->dsr_id)->get();
    // dd($sales);
    if ($data->dsr_method == 'PN') {
      if ($data->dsr_jenis_return == 'BR') {
        // dd($cek);
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
           // dd($data);
           $sisa = $sales->sp_nominal - $data->dsr_net;
           
           $jSisa = 0;
            if ($sisa <= 0) {
              $jSisa = 0-($sisa);
            }
            // dd($data->dsr_sid);
          d_sales::where('s_id',$data->dsr_sid)
            ->update([
              's_gross' => $data->dsr_sgross,
              's_disc_percent' => $data->dsr_disc_vpercent,
              's_disc_value' => $data->dsr_disc_value,
              's_net' => $data->dsr_net,
              's_sisa' => $jSisa,
              ]);

          d_sales_return::where('dsr_id',$id)
            ->update([
              'dsr_status' => 'FN'
            ]);

         }

          if ($cek[$i]->dsrdt_disc_value != 0.00) {
            d_sales_dt::where('sd_sales',$data->dsr_sid)
            ->where('sd_detailid',$i+1)
            ->update([
              'sd_item' => $cek[$i]->dsrdt_item,
              'sd_qty' => $cek[$i]->dsrdt_qty - $cek[$i]->dsrdt_qty_confirm,
              'sd_price' => $cek[$i]->dsrdt_price,
              'sd_disc_percent' => $cek[$i]->dsrdt_disc_percent,
              'sd_disc_vpercent' => $cek[$i]->dsrdt_disc_vpercent,
              'sd_disc_value' =>($cek[$i]->dsrdt_disc_value / $cek[$i]->dsrdt_qty_confirm) * ($cek[$i]->dsrdt_qty - $cek[$i]->dsrdt_qty_confirm),
              'sd_total' => $cek[$i]->dsrdt_hasil
              ]);
          }else{
            d_sales_dt::where('sd_sales',$data->dsr_sid)
            ->where('sd_detailid',$i+1)
            ->update([
              'sd_item' => $cek[$i]->dsrdt_item,
              'sd_qty' => $cek[$i]->dsrdt_qty - $cek[$i]->dsrdt_qty_confirm,
              'sd_price' => $cek[$i]->dsrdt_price,
              'sd_disc_percent' => $cek[$i]->dsrdt_disc_percent,
              'sd_disc_vpercent' => $cek[$i]->dsrdt_disc_vpercent,
              'sd_disc_value' =>$cek[$i]->dsrdt_disc_value,
              'sd_total' => $cek[$i]->dsrdt_hasil
              ]);
          }

        }
        
      }else{

      if ($data->dsr_type_sales == 'GR') {
        // dd($cek);
        for ($i=0; $i <count($cek) ; $i++) {
          if ($cek[$i]->dsrdt_qty_confirm != 0) {
            $stockGrosir = d_stock::where('s_item',$cek[$i]->dsrdt_item)
                ->where('s_comp',2)
                ->where('s_position',2)
                ->first();

            $tambahStock = (int)$stockGrosir->s_qty + $cek[$i]->dsrdt_qty_confirm;
            // dd($cek[$i]->dsrdt_qty_confirm);
            // dd($tambahStock);
            $stockGrosir->update([
              's_qty' => $tambahStock,
            ]);

            $sm_detailid = d_stock_mutation::select('sm_detailid')
              ->where('sm_stock',$stockGrosir->s_id)
              ->max('sm_detailid')+1;
            //dd($sm_detailid);
            d_stock_mutation::create([
                    'sm_stock' =>  $stockGrosir->s_id,
                    'sm_detailid' => $sm_detailid,
                    'sm_date' => Carbon::now(),
                    'sm_comp' => 2,
                    'sm_position' => 2,
                    'sm_mutcat' => 9,
                    'sm_item' => $cek[$i]->dsrdt_item,
                    'sm_qty' => $cek[$i]->dsrdt_qty_confirm,
                    'sm_qty_sisa' => $cek[$i]->dsrdt_qty_confirm,
                    'sm_detail' => 'PENAMBAHAN',
                    'sm_reff' => $data->dsr_code,
                    'sm_insert' => Carbon::now()
                ]);
          }

           $sisa = $sales->sp_nominal - $data->dsr_net;
           
           $jSisa = 0;
            if ($sisa <= 0) {
              $jSisa = 0-($sisa);
            }
            // dd($jSisa);
          d_sales::where('s_id',$data->dsr_sid)
            ->update([
              's_gross' => $data->dsr_sgross,
              's_disc_percent' => $data->dsr_disc_vpercent,
              's_disc_value' => $data->dsr_disc_value,
              's_net' => $data->dsr_net,
              's_sisa' => $jSisa,
              ]);

          d_sales_return::where('dsr_id',$id)
            ->update([
              'dsr_status' => 'FN'
            ]);

         
          if ($cek[$i]->dsrdt_disc_value != 0.00) {
            d_sales_dt::where('sd_sales',$data->dsr_sid)
            ->where('sd_detailid',$i+1)
            ->update([
              'sd_item' => $cek[$i]->dsrdt_item,
              'sd_qty' => $cek[$i]->dsrdt_qty - $cek[$i]->dsrdt_qty_confirm,
              'sd_price' => $cek[$i]->dsrdt_price,
              'sd_disc_percent' => $cek[$i]->dsrdt_disc_percent,
              'sd_disc_vpercent' => $cek[$i]->dsrdt_disc_vpercent,
              'sd_disc_value' =>($cek[$i]->dsrdt_disc_value / $cek[$i]->dsrdt_qty_confirm) * ($cek[$i]->dsrdt_qty - $cek[$i]->dsrdt_qty_confirm),
              'sd_total' => $cek[$i]->dsrdt_hasil
              ]);

          }else{

            d_sales_dt::where('sd_sales',$data->dsr_sid)
            ->where('sd_detailid',$i+1)
            ->update([
              'sd_item' => $cek[$i]->dsrdt_item,
              'sd_qty' => $cek[$i]->dsrdt_qty - $cek[$i]->dsrdt_qty_confirm,
              'sd_price' => $cek[$i]->dsrdt_price,
              'sd_disc_percent' => $cek[$i]->dsrdt_disc_percent,
              'sd_disc_vpercent' => $cek[$i]->dsrdt_disc_vpercent,
              'sd_disc_value' =>$cek[$i]->dsrdt_disc_value,
              'sd_total' => $cek[$i]->dsrdt_hasil
              ]);
          }
        }

      }else{

        for ($i=0; $i <count($cek) ; $i++) {
          if ($cek[$i]->dsrdt_qty_confirm != 0) {
            $stockGrosir = d_stock::where('s_item',$cek[$i]->dsrdt_item)
                ->where('s_comp',1)
                ->where('s_position',1)
                ->first();

            $tambahStock = (int)$stockGrosir->s_qty + $cek[$i]->dsrdt_qty_confirm;
            // dd($cek[$i]->dsrdt_qty_confirm);
            // dd($tambahStock);
            $stockGrosir->update([
              's_qty' => $tambahStock,
            ]);

            $sm_detailid = d_stock_mutation::select('sm_detailid')
              ->where('sm_stock',$stockGrosir->s_id)
              ->max('sm_detailid')+1;
            //dd($sm_detailid);
            d_stock_mutation::create([
                    'sm_stock' =>  $stockGrosir->s_id,
                    'sm_detailid' => $sm_detailid,
                    'sm_date' => Carbon::now(),
                    'sm_comp' => 1,
                    'sm_position' => 1,
                    'sm_mutcat' => 9,
                    'sm_item' => $cek[$i]->dsrdt_item,
                    'sm_qty' => $cek[$i]->dsrdt_qty_confirm,
                    'sm_qty_sisa' => $cek[$i]->dsrdt_qty_confirm,
                    'sm_detail' => 'PENAMBAHAN',
                    'sm_reff' => $data->dsr_code,
                    'sm_insert' => Carbon::now()
                ]);
          }

           $sisa = $sales->sp_nominal - $data->dsr_net;
           
           $jSisa = 0;
            if ($sisa <= 0) {
              $jSisa = 0-($sisa);
            }
            // dd($jSisa);
          d_sales::where('s_id',$data->dsr_sid)
            ->update([
              's_gross' => $data->dsr_sgross,
              's_disc_percent' => $data->dsr_disc_vpercent,
              's_disc_value' => $data->dsr_disc_value,
              's_net' => $data->dsr_net,
              's_sisa' => $jSisa,
              ]);

          d_sales_return::where('dsr_id',$id)
              ->update([
                'dsr_status' => 'FN'
              ]);

          if ($cek[$i]->dsrdt_disc_value != 0.00) {
            d_sales_dt::where('sd_sales',$data->dsr_sid)
            ->where('sd_detailid',$i+1)
            ->update([
              'sd_item' => $cek[$i]->dsrdt_item,
              'sd_qty' => $cek[$i]->dsrdt_qty - $cek[$i]->dsrdt_qty_confirm,
              'sd_price' => $cek[$i]->dsrdt_price,
              'sd_disc_percent' => $cek[$i]->dsrdt_disc_percent,
              'sd_disc_vpercent' => $cek[$i]->dsrdt_disc_vpercent,
              'sd_disc_value' =>($cek[$i]->dsrdt_disc_value / $cek[$i]->dsrdt_qty_confirm) * ($cek[$i]->dsrdt_qty - $cek[$i]->dsrdt_qty_confirm),
              'sd_total' => $cek[$i]->dsrdt_hasil
              ]);

          }else{

            d_sales_dt::where('sd_sales',$data->dsr_sid)
            ->where('sd_detailid',$i+1)
            ->update([
              'sd_item' => $cek[$i]->dsrdt_item,
              'sd_qty' => $cek[$i]->dsrdt_qty - $cek[$i]->dsrdt_qty_confirm,
              'sd_price' => $cek[$i]->dsrdt_price,
              'sd_disc_percent' => $cek[$i]->dsrdt_disc_percent,
              'sd_disc_vpercent' => $cek[$i]->dsrdt_disc_vpercent,
              'sd_disc_value' =>$cek[$i]->dsrdt_disc_value,
              'sd_total' => $cek[$i]->dsrdt_hasil
              ]);
          }
        }
      }

      }

    }else  if ($data->dsr_method == 'TB') {
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

              if ($data->dsr_type_sales == 'GR') {

                $stockGrosir = d_stock::where('s_item',$cek[$i]->dsrdt_item)
                ->where('s_comp',2)
                ->where('s_position',2)
                ->first();

                $tambahStock = (int)$stockGrosir->s_qty - $cek[$i]->dsrdt_qty_confirm;
                // dd($cek[$i]->dsrdt_qty_confirm);
                // dd($tambahStock);
                $stockGrosir->update([
                  's_qty' => $tambahStock,
                ]);

                $sm_detailid = d_stock_mutation::select('sm_detailid')
                  ->where('sm_stock',$stockGrosir->s_id)
                  ->max('sm_detailid')+1;
                //dd($sm_detailid);
                d_stock_mutation::create([
                        'sm_stock' =>  $stockGrosir->s_id,
                        'sm_detailid' => $sm_detailid,
                        'sm_date' => Carbon::now(),
                        'sm_comp' => 2,
                        'sm_position' => 2,
                        'sm_mutcat' => 13,
                        'sm_item' => $cek[$i]->dsrdt_item,
                        'sm_qty' => $cek[$i]->dsrdt_qty_confirm,
                        'sm_qty_sisa' => $cek[$i]->dsrdt_qty_confirm,
                        'sm_detail' => 'PENGURANGAN',
                        'sm_reff' => $data->dsr_code,
                        'sm_insert' => Carbon::now()
                    ]);

              }else{

                $stockRetail = d_stock::where('s_item',$cek[$i]->dsrdt_item)
                ->where('s_comp',1)
                ->where('s_position',1)
                ->first();

                $tambahStock = (int)$stockRetail->s_qty - $cek[$i]->dsrdt_qty_confirm;
                // dd($cek[$i]->dsrdt_qty_confirm);
                // dd($tambahStock);
                $stockRetail->update([
                  's_qty' => $tambahStock,
                ]);

                $sm_detailid = d_stock_mutation::select('sm_detailid')
                  ->where('sm_stock',$stockRetail->s_id)
                  ->max('sm_detailid')+1;
                //dd($sm_detailid);
                d_stock_mutation::create([
                        'sm_stock' =>  $stockRetail->s_id,
                        'sm_detailid' => $sm_detailid,
                        'sm_date' => Carbon::now(),
                        'sm_comp' => 2,
                        'sm_position' => 2,
                        'sm_mutcat' => 13,
                        'sm_item' => $cek[$i]->dsrdt_item,
                        'sm_qty' => $cek[$i]->dsrdt_qty_confirm,
                        'sm_qty_sisa' => $cek[$i]->dsrdt_qty_confirm,
                        'sm_detail' => 'PENGURANGAN',
                        'sm_reff' => $data->dsr_code,
                        'sm_insert' => Carbon::now()
                    ]);
              }

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

              if ($data->dsr_type_sales == 'GR') {

                $stockGrosir = d_stock::where('s_item',$cek[$i]->dsrdt_item)
                ->where('s_comp',2)
                ->where('s_position',2)
                ->first();

                $tambahStock = (int)$stockGrosir->s_qty - $cek[$i]->dsrdt_qty_confirm;
                // dd($cek[$i]->dsrdt_qty_confirm);
                // dd($tambahStock);
                $stockGrosir->update([
                  's_qty' => $tambahStock,
                ]);

                $sm_detailid = d_stock_mutation::select('sm_detailid')
                  ->where('sm_stock',$stockGrosir->s_id)
                  ->max('sm_detailid')+1;
                //dd($sm_detailid);
                d_stock_mutation::create([
                        'sm_stock' =>  $stockGrosir->s_id,
                        'sm_detailid' => $sm_detailid,
                        'sm_date' => Carbon::now(),
                        'sm_comp' => 2,
                        'sm_position' => 2,
                        'sm_mutcat' => 9,
                        'sm_item' => $cek[$i]->dsrdt_item,
                        'sm_qty' => $cek[$i]->dsrdt_qty_confirm,
                        'sm_qty_sisa' => $cek[$i]->dsrdt_qty_confirm,
                        'sm_detail' => 'PENAMBAHAN',
                        'sm_reff' => $data->dsr_code,
                        'sm_insert' => Carbon::now()
                    ]);

              }else{

                $stockRetail = d_stock::where('s_item',$cek[$i]->dsrdt_item)
                ->where('s_comp',1)
                ->where('s_position',1)
                ->first();

                $tambahStock = (int)$stockRetail->s_qty - $cek[$i]->dsrdt_qty_confirm;
                // dd($cek[$i]->dsrdt_qty_confirm);
                // dd($tambahStock);
                $stockRetail->update([
                  's_qty' => $tambahStock,
                ]);

                $sm_detailid = d_stock_mutation::select('sm_detailid')
                  ->where('sm_stock',$stockRetail->s_id)
                  ->max('sm_detailid')+1;
                //dd($sm_detailid);
                d_stock_mutation::create([
                        'sm_stock' =>  $stockRetail->s_id,
                        'sm_detailid' => $sm_detailid,
                        'sm_date' => Carbon::now(),
                        'sm_comp' => 2,
                        'sm_position' => 2,
                        'sm_mutcat' => 9,
                        'sm_item' => $cek[$i]->dsrdt_item,
                        'sm_qty' => $cek[$i]->dsrdt_qty_confirm,
                        'sm_qty_sisa' => $cek[$i]->dsrdt_qty_confirm,
                        'sm_detail' => 'PENAMBAHAN',
                        'sm_reff' => $data->dsr_code,
                        'sm_insert' => Carbon::now()
                    ]);
              }

         }

         d_sales_return::where('dsr_id',$id)
            ->update([
              'dsr_status' => 'FN'
            ]);
         // dd($data);
         $sisa = $sales->sp_nominal - $data->dsr_net;
         
         $jSisa = 0;
          if ($sisa <= 0) {
            $jSisa = 0-($sisa);
          }

       }

      }
    }else if ($data->dsr_method == 'SB') {
      $cek = d_sales_return::where('dsr_id',$id)->first();

      if ($cek->dsr_type_sales == 'GR') {
        $sb = d_sales_returnsb::where('dsrs_sr',$id)->get();

        for ($i=0; $i < count($sb); $i++) { 
          $stockGrosir = d_stock::where('s_item',$sb[$i]->dsrs_item)
            ->where('s_comp',2)
            ->where('s_position',2)
            ->first();

          if(mutasi::mutasiStok(  $sb[$i]->dsrs_item,
                                  $sb[$i]->dsrs_qty,
                                  $comp=2,
                                  $position=2,
                                  $flag=10,
                                  $cek->dsr_code)){}
        }

      }else{
        $sb = d_sales_returnsb::where('dsrs_sr',$id)->get();

        for ($i=0; $i < count($sb); $i++) { 
          $stockGrosir = d_stock::where('s_item',$sb[$i]->dsrs_item)
            ->where('s_comp',1)
            ->where('s_position',1)
            ->first();

          if(mutasi::mutasiStok(  $sb[$i]->dsrs_item,
                                  $sb[$i]->dsrs_qty,
                                  $comp=1,
                                  $position=1,
                                  $flag=10,
                                  $cek->dsr_code)){}
        }
      }

      d_sales_return::where('dsr_id',$id)
        ->update([
          'dsr_status' => 'FN'
        ]);

      d_sales_return::where('dsr_id',$id)
        ->update([
          'dsr_status_terima' => 'WT'
        ]);
      

    }else if ($data->dsr_method == 'SA') {
      # code...
    }elseif ($data->dsr_method == 'KB') {
      # code...
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

  public function printreturn($id){
    $dataCus = d_sales_return::select( 'c_name',
                              'c_address',
                              'c_region',
                              'dsr_date',
                              'dsr_code')
        ->where('dsr_id',$id)
        ->join('d_sales','d_sales.s_id','=','dsr_sid')
        ->join('m_customer','c_id','=','s_customer')
        ->first();
    
    $dataItem = d_sales_return::select(
                                  'dsr_price_return',
                                  'dsr_sgross',
                                  'dsr_disc_value',
                                  'dsr_net',
                                  'i_code',
                                  'i_name',
                                  'dsrdt_qty',
                                  'dsrdt_qty_confirm',
                                  'm_sname',
                                  'dsrdt_price',
                                  'dsrdt_disc_percent',
                                  'dsrdt_disc_value',
                                  'dsrdt_disc_vpercent',
                                  'dsrdt_return_price',
                                  'dsrdt_hasil',
                                  'dsrdt_disc_vpercentreturn'
                                  )
      ->join('d_sales_returndt','d_sales_returndt.dsrdt_idsr','=','dsr_id')
      ->join('m_item','m_item.i_id','=','dsrdt_item')
      ->join('m_satuan','m_satuan.m_sid','=','i_sat1')
      ->where('dsr_id',$id)
      ->get();
    $result = 0;
    $totalRetur = 0;
    $totalDiscount = 0;
    foreach ($dataItem as $item) {
      if ($item->dsrdt_qty_confirm != 0) {
        $retur[] = $item;
        $result += $item->dsrdt_hasil;
        $totalRetur += $item->dsrdt_price;
        $totalDiscount += $item->dsrdt_disc_vpercentreturn + $item->dsrdt_disc_value;
      }
    }

    $subTotal = $totalRetur - $totalDiscount;


    return view('penjualan.manajemenreturn.print.print_return_penjualan',compact('dataCus','retur','result','totalRetur','totalDiscount','subTotal'));
  }

  public function printfaktur($id){
    $retur = d_sales_return::where('dsr_id',$id)->first();
    $sales = d_sales::select( 'c_name',
                              'c_address',
                              's_date',
                              's_note')
      ->join('m_customer','c_id','=','s_customer')
      ->where('s_id', $retur->dsr_sid)
      ->first();
    // dd($sales);

    $data_chunk = DB::table('d_sales_dt')->select( 'i_code',
                                'i_name',
                                'm_sname',
                                'sd_price',
                                'sd_total',
                                'sd_disc_value',
                                'sd_qty',
                                'sd_disc_percent')
      ->join('m_item','i_id','=','sd_item')
      ->join('m_satuan','m_satuan.m_sid','=','i_sat1')
      ->where('sd_sales', $retur->dsr_sid)->get()->toArray();

      $data = array_chunk($data_chunk, 12);
      // return $chunk;
      // return $data;

      $dataTotal = d_sales_dt::select(DB::raw('SUM(sd_total) as total'))
      ->join('m_item','i_id','=','sd_item')
      ->where('sd_sales', $retur->dsr_sid)->get();


      return view('penjualan.manajemenreturn.print.print_faktur', compact('data', 'dataTotal', 'sales'));
  }

  public function setName(Request $request, $type){
    $term = $request->term;
    $results = array();
    if ($type == 'GR') {
      $queries = m_item::join('d_stock','d_stock.s_item','=','i_id')
      ->join('m_satuan','m_satuan.m_sid','=','i_sat1')
      ->where('s_comp',2)
      ->where('s_position',2)
      ->where('i_type', '=', DB::raw("'BP'"))
      ->where('i_name', 'like', DB::raw('"%'.$request->term.'%"'))        
      ->orWhere('i_type', '=', DB::raw("'BJ'"))
      ->where('i_name', 'like', DB::raw('"%'.$request->term.'%"')) 
      ->where('i_isactive','TRUE')      
      ->take(25)->get();
      // dd($queries);
      if ($queries == null) {
        $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
      } else {
        foreach ($queries as $query) {
          $results[] = [ 'id' => $query->i_id,
                         'label' => $query->i_code .' - '. $query->i_name,
                         'harga' => $query->m_psell1,
                         'kode' => $query->i_id,
                         'nama' => $query->i_name,
                         'satuan' => $query->m_sname,
                         's_qty' =>$query->s_qty
                       ];
        }
      }
    }else{

    $queries = m_item::join('d_stock','d_stock.s_item','=','i_id')
      ->join('m_satuan','m_satuan.m_sid','=','i_sat1')
      ->where('s_comp',1)
      ->where('s_position',1)
      ->where('i_type', '=', DB::raw("'BP'"))
      ->where('i_name', 'like', DB::raw('"%'.$request->term.'%"'))        
      ->orWhere('i_type', '=', DB::raw("'BJ'"))
      ->where('i_name', 'like', DB::raw('"%'.$request->term.'%"')) 
      ->where('i_isactive','TRUE')      
      ->take(25)->get();
      // dd($queries);
      if ($queries == null) {
        $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
      } else {
        foreach ($queries as $query) {
          $results[] = [ 'id' => $query->i_id,
                         'label' => $query->i_code .' - '. $query->i_name,
                         'harga' => $query->m_psell1,
                         'kode' => $query->i_id,
                         'nama' => $query->i_name,
                         'satuan' => $query->m_sname,
                         's_qty' =>$query->s_qty
                       ];
        }
      }
    }

    return Response::json($results);
  }

  public function simpanPenerimaanSB(Request $request, $id){
    // dd($request->all());
    DB::beginTransaction();
    try {
      $cek = d_sales_return::where('dsr_id',$id)
        ->first();

      if ($cek->dsr_type_sales == 'GR') {
        $cekItem = d_sales_returnsb::where('dsrs_sr',$id)
          ->get();
        for ($i=0; $i <count($cekItem) ; $i++) { 
          $stockGrosir = d_stock::where('s_item',$cekItem[$i]->dsrs_item)
            ->where('s_comp',2)
            ->where('s_position',2)
            ->first();

          $stockUpdate = $stockGrosir->s_qty + $cekItem[$i]->dsrs_qty;
          $stockGrosir->update([
            's_qty' => $stockUpdate
          ]);;

          $sm_detailid = d_stock_mutation::select('sm_detailid')
              ->where('sm_stock',$stockGrosir->s_id)
              ->max('sm_detailid')+1;
            //dd($sm_detailid);
            d_stock_mutation::create([
                    'sm_stock' =>  $stockGrosir->s_id,
                    'sm_detailid' => $sm_detailid,
                    'sm_date' => Carbon::now(),
                    'sm_comp' => 2,
                    'sm_position' => 2,
                    'sm_mutcat' => 9,
                    'sm_item' => $cekItem[$i]->dsrs_item,
                    'sm_qty' => $cekItem[$i]->dsrs_qty,
                    'sm_qty_sisa' => $cekItem[$i]->dsrs_qty,
                    'sm_detail' => 'PENAMBAHAN',
                    'sm_reff' => $cek->dsr_code,
                    'sm_insert' => Carbon::now()
                ]);

        }
        // dd($stockUpdate);
      }else{
        $cekItem = d_sales_returnsb::where('dsrs_sr',$id)
          ->get();
        for ($i=0; $i <count($cekItem) ; $i++) { 
          $stockRetail = d_stock::where('s_item',$cekItem[$i]->dsrs_item)
            ->where('s_comp',1)
            ->where('s_position',1)
            ->first();

          $stockUpdate = $stockRetail->s_qty + $cekItem[$i]->dsrs_qty;
          $stockRetail->update([
            's_qty' => $stockUpdate
          ]);;

          $sm_detailid = d_stock_mutation::select('sm_detailid')
              ->where('sm_stock',$stockRetail->s_id)
              ->max('sm_detailid')+1;
            //dd($sm_detailid);
            d_stock_mutation::create([
                    'sm_stock' =>  $stockRetail->s_id,
                    'sm_detailid' => $sm_detailid,
                    'sm_date' => Carbon::now(),
                    'sm_comp' => 1,
                    'sm_position' => 1,
                    'sm_mutcat' => 9,
                    'sm_item' => $cekItem[$i]->dsrs_item,
                    'sm_qty' => $cekItem[$i]->dsrs_qty,
                    'sm_qty_sisa' => $cekItem[$i]->dsrs_qty,
                    'sm_detail' => 'PENAMBAHAN',
                    'sm_reff' => $cek->dsr_code,
                    'sm_insert' => Carbon::now()
                ]);
      }
    }

    d_sales_return::where('dsr_id',$id)
    ->update([
      'dsr_status_terima' => 'TR',
      'dsr_resi' => $request->resi
    ]);

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
}
