<?php

namespace App\Http\Controllers\Penjualan;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\d_stock_mutation;
use App\d_stock;
use App\d_sales;
use App\m_customer;
use App\d_sales_payment;
use App\d_sales_dt;
use App\m_item_price;
use DataTables;
use App\lib\mutasi;
use URL;
use PDF;

class POSGrosirController extends Controller
{
  public function grosir(){
      $dataPayment = DB::table('m_paymentmethod')->get();
      $ket = 'create';

      $tgl2 = date("d-m-Y");
      $tgl1 = date('d-m-Y', strtotime("-3 day"));

      $y = substr($tgl1, -4);
      $m = substr($tgl1, -7,-5);
      $d = substr($tgl1,0,2);
      $tgll = $y.'-'.$m.'-'.$d;

      $y2 = substr($tgl2, -4);
      $m2 = substr($tgl2, -7,-5);
      $d2 = substr($tgl2,0,2);
      $tgl2 = $y2.'-'.$m2.'-'.$d2;

    $detalis_draft = DB::table('d_sales')
        ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
        ->where('s_channel','GR')
        ->where('s_status','DR')
        ->where('s_date','>=',$tgll)
        ->where('s_date','<=',$tgl2)
        ->count();

    $detalis_progress = DB::table('d_sales')
        ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
        ->where('s_channel','GR')
        ->where('s_status','PR')
        ->where('s_date','>=',$tgll)
        ->where('s_date','<=',$tgl2)
        ->count();

    $detalis_final = DB::table('d_sales')
        ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
        ->where('s_channel','GR')
        ->where('s_status','FN')
        ->where('s_date','>=',$tgll)
        ->where('s_date','<=',$tgl2)
        ->count();

    $detalis_packing = DB::table('d_sales')
        ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
        ->where('s_channel','GR')
        ->where('s_status','PC')
        ->where('s_date','>=',$tgll)
        ->where('s_date','<=',$tgl2)
        ->count();

    $detalis_sending = DB::table('d_sales')
        ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
        ->where('s_channel','GR')
        ->where('s_status','SN')
        ->where('s_date','>=',$tgll)
        ->where('s_date','<=',$tgl2)
        ->count();

    $detalis_received = DB::table('d_sales')
        ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
        ->where('s_channel','GR')
        ->where('s_status','RC')
        ->where('s_date','>=',$tgll)
        ->where('s_date','<=',$tgl2)
        ->count();

    return view('/penjualan/POSgrosir/index',compact('dataPayment','ket','detalis_draft','detalis_progress','detalis_final','detalis_packing','detalis_sending','detalis_received'));
  }
  public function getTanggalnoapenjualan($tgl1,$tgl2)
  {
      $y = substr($tgl1, -4);
      $m = substr($tgl1, -7,-5);
      $d = substr($tgl1,0,2);
      $tgll = $y.'-'.$m.'-'.$d;

      $y2 = substr($tgl2, -4);
      $m2 = substr($tgl2, -7,-5);
      $d2 = substr($tgl2,0,2);
      $tgl2 = $y2.'-'.$m2.'-'.$d2;

    $detalis_draft = DB::table('d_sales')
        ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
        ->where('s_channel','GR')
        ->where('s_status','DR')
        ->where('s_date','>=',$tgll)
        ->where('s_date','<=',$tgl2)
        ->count();

    $detalis_progress = DB::table('d_sales')
        ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
        ->where('s_channel','GR')
        ->where('s_status','PR')
        ->where('s_date','>=',$tgll)
        ->where('s_date','<=',$tgl2)
        ->count();

    $detalis_final = DB::table('d_sales')
        ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
        ->where('s_channel','GR')
        ->where('s_status','FN')
        ->where('s_date','>=',$tgll)
        ->where('s_date','<=',$tgl2)
        ->count();

    $detalis_packing = DB::table('d_sales')
        ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
        ->where('s_channel','GR')
        ->where('s_status','PC')
        ->where('s_date','>=',$tgll)
        ->where('s_date','<=',$tgl2)
        ->count();

    $detalis_sending = DB::table('d_sales')
        ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
        ->where('s_channel','GR')
        ->where('s_status','SN')
        ->where('s_date','>=',$tgll)
        ->where('s_date','<=',$tgl2)
        ->count();

    $detalis_received = DB::table('d_sales')
        ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
        ->where('s_channel','GR')
        ->where('s_status','RC')
        ->where('s_date','>=',$tgll)
        ->where('s_date','<=',$tgl2)
        ->count();

        return response()->json(['detalis_draft'=>$detalis_draft,'detalis_progress'=>$detalis_progress,'detalis_final'=>$detalis_final,'detalis_packing'=>$detalis_packing,'detalis_sending'=>$detalis_sending,'detalis_received'=>$detalis_received]);
  }

  public function edit_sales($id){
      $tgl2 = date("d-m-Y");
      $tgl1 = date('d-m-Y', strtotime("-3 day"));

      $y = substr($tgl1, -4);
      $m = substr($tgl1, -7,-5);
      $d = substr($tgl1,0,2);
      $tgll = $y.'-'.$m.'-'.$d;

      $y2 = substr($tgl2, -4);
      $m2 = substr($tgl2, -7,-5);
      $d2 = substr($tgl2,0,2);
      $tgl2 = $y2.'-'.$m2.'-'.$d2;
    $detalis_draft = DB::table('d_sales')
        ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
        ->where('s_channel','GR')
        ->where('s_status','DR')
        ->where('s_date','>=',$tgll)
        ->where('s_date','<=',$tgl2)
        ->count();

    $detalis_progress = DB::table('d_sales')
        ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
        ->where('s_channel','GR')
        ->where('s_status','PR')
        ->where('s_date','>=',$tgll)
        ->where('s_date','<=',$tgl2)
        ->count();

    $detalis_final = DB::table('d_sales')
        ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
        ->where('s_channel','GR')
        ->where('s_status','FN')
        ->where('s_date','>=',$tgll)
        ->where('s_date','<=',$tgl2)
        ->count();

    $detalis_packing = DB::table('d_sales')
        ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
        ->where('s_channel','GR')
        ->where('s_status','PC')
        ->where('s_date','>=',$tgll)
        ->where('s_date','<=',$tgl2)
        ->count();

    $detalis_sending = DB::table('d_sales')
        ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
        ->where('s_channel','GR')
        ->where('s_status','SN')
        ->where('s_date','>=',$tgll)
        ->where('s_date','<=',$tgl2)
        ->count();

    $detalis_received = DB::table('d_sales')
        ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
        ->where('s_channel','GR')
        ->where('s_status','RC')
        ->where('s_date','>=',$tgll)
        ->where('s_date','<=',$tgl2)
        ->count();
      $edit = d_sales::select('c_name',
                              's_customer',
                              'c_address',
                              'c_hp1',
                              'c_hp2',
                              'c_class',
                              's_note',
                              'd_sales.s_id as sales_id',
                              's_gross',
                              's_net',
                              's_disc_value',
                              'i_name',
                              'sd_sales',
                              'sd_detailid',
                              'i_id',
                              'i_name',
                              'i_type',
                              'sd_qty',
                              's_qty',
                              'i_sat1',
                              'm_psell1',
                              'm_psell2',
                              'm_psell3',
                              'sd_disc_percent',
                              'sd_disc_value',
                              'sd_total',
                              's_status',
                              'm_sname',
                              'sd_price',
                              'sd_disc_vpercent',
                              'sp_sales',
                              'sp_method',
                              'sp_nominal')
        ->join('m_customer', 'm_customer.c_id', '=' , 'd_sales.s_customer')
        ->join('d_sales_dt','d_sales_dt.sd_sales','=','d_sales.s_id')
        ->join('m_item','m_item.i_id','=','d_sales_dt.sd_item')
        ->join('m_price','m_price.m_pitem', '=','d_sales_dt.sd_item')
        ->join('m_satuan','m_satuan.m_sid','=','i_sat1')
        ->leftJoin('d_sales_payment','d_sales.s_id','=','sp_sales')
        ->leftjoin('d_stock',function($join){
          $join->on('i_id', '=', 's_item');
          $join->on('s_comp', '=', 's_position');
          $join->on('s_comp', '=',DB::raw("'2'"));
        })
        ->where('d_sales.s_id',$id)
        ->get();
      $dataPayment = DB::table('m_paymentmethod')->get();
      $ket = 'edit';
      // dd($edit);
    return view('/penjualan/POSgrosir/index',compact('edit','dataPayment','ket','detalis_draft','detalis_progress','detalis_final','detalis_packing','detalis_sending','detalis_received'));
  }

  public function detail(Request $request){
    $detalis = DB::table('d_sales_dt')
      ->select( 'i_name',
                'sd_qty',
                'm_sname',
                'm_psell1',
                'm_psell2',
                'm_psell3',
                'sd_price',
                'sd_disc_percent',
                'sd_disc_value',
                'sd_total')
      ->join('d_sales', 'd_sales_dt.sd_sales', '=', 'd_sales.s_id' )
      ->join('m_item', 'm_item.i_id', '=' , 'd_sales_dt.sd_item')
      ->join('m_price','m_price.m_pitem', '=','d_sales_dt.sd_item')
      ->join('m_satuan','m_satuan.m_sid','=','i_sat1')
      ->where('sd_sales','=',$request->x)
      ->get();

  return view('/penjualan/POSgrosir/NotaPenjualan.detail',compact('detalis'));
  }

  public function autocomplete(Request $request){
    $term = $request->term;

    $results = array();

    $queries = DB::table('m_customer')
      ->where('m_customer.c_name', 'LIKE', '%'.$term.'%')
      ->take(25)->get();

    if ($queries == null) {
      $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
    } else {
      foreach ($queries as $query)
      {
        $results[] = [  'id' => $query->c_id,
                        'label' => $query->c_name .'  '.$query->c_address,
                        'alamat' => $query->c_address.' '.$query->c_hp ];
      }
    }

  return Response::json($results);
  }

  public function autocompleteitem(Request $request, $id){
    $term = $request->term;
    $results = array();
    if ($id == 'A') {
      $queries = DB::select('select i_id, i_code,i_name,m_psell1,m_sname,s_qty,i_type
                            from m_item left join d_stock on i_id = s_item
                            join m_price on i_id = m_pitem
                            join m_satuan on m_sid = i_sat1
                            where ( i_name like "%'.$term.'%" or i_code like "%'.$term.'%" )
                            and ( i_type = "BP" or i_type = "BJ" )
                            and ( s_comp = 2 and s_position = 2 or s_comp is null or s_position is null )
                            and (i_isactive = "TRUE")
                            limit 50');

      if ($queries == null) {
        $results[] = [ 'i_id' => null, 'label' =>'tidak di temukan data terkait'];
      } else {
        foreach ($queries as $query)
        {
          $results[] = [ 'id' => $query->i_id,
                         'label' => $query->i_code .' - '. $query->i_name,
                         'harga' => $query->m_psell1,
                         'kode' => $query->i_id,
                         'nama' => $query->i_name,
                         'satuan' => $query->m_sname,
                         's_qty'=>$query->s_qty,
                         's_qtycon'=>number_format( $query->s_qty ,0,',','.'),
                         'i_type'=>$query->i_type
                       ];
        }
      }
    }else if ($id == 'B') {
      $queries = DB::select('select i_id, i_code,i_name,m_psell2,m_sname,s_qty,i_type
                            from m_item left join d_stock on i_id = s_item
                            join m_price on i_id = m_pitem
                            join m_satuan on m_sid = i_sat1
                            where ( i_name like "%'.$term.'%" or i_code like "%'.$term.'%" )
                            and ( i_type = "BP" or i_type = "BJ" )
                            and ( s_comp = 2 and s_position = 2 or s_comp is null or s_position is null )
                            and (i_isactive = "TRUE")
                            limit 50');

      if ($queries == null) {
        $results[] = [ 'i_id' => null, 'label' =>'tidak di temukan data terkait'];
      } else {
        foreach ($queries as $query)
        {
          $results[] = [ 'id' => $query->i_id,
                         'label' => $query->i_code .' - '. $query->i_name,
                         'harga' => $query->m_psell2,
                         'kode' => $query->i_id,
                         'nama' => $query->i_name,
                         'satuan' => $query->m_sname,
                         's_qty'=>$query->s_qty,
                         's_qtycon'=>number_format( $query->s_qty ,0,',','.'),
                         'i_type'=>$query->i_type
                       ];
        }
      }
    }else{
      $queries = DB::select('select i_id, i_code,i_name,m_psell3,m_sname,s_qty,i_type,i_isactive
                            from m_item left join d_stock on i_id = s_item
                            join m_price on i_id = m_pitem
                            join m_satuan on m_sid = i_sat1
                            where ( i_name like "%'.$term.'%" or i_code like "%'.$term.'%" )
                            and ( i_type = "BP" or i_type = "BJ" )
                            and ( s_comp = 2 and s_position = 2 or s_comp is null or s_position is null )
                            and (i_isactive = "TRUE")
                            limit 50');

      if ($queries == null) {
        $results[] = [ 'i_id' => null, 'label' =>'tidak di temukan data terkait'];
      } else {
        foreach ($queries as $query)
        {
          $results[] = [ 'id' => $query->i_id,
                         'label' => $query->i_code .' - '. $query->i_name,
                         'harga' => $query->m_psell3,
                         'kode' => $query->i_id,
                         'nama' => $query->i_name,
                         'satuan' => $query->m_sname,
                         's_qty'=>$query->s_qty,
                         's_qtycon'=>number_format( $query->s_qty ,0,',','.'),
                         'i_type'=>$query->i_type
                       ];
        }
      }
    }

    return Response::json($results);
  }

  public function sal_save_draft(Request $request){
    
    // return json_encode($request->all());

    DB::beginTransaction();
        try {
    $s_id = d_sales::max('s_id') + 1;
    //nota fatkur
    $year = carbon::now()->format('y');
    $month = carbon::now()->format('m');
    $date = carbon::now()->format('d');

    $idfatkur = DB::Table('d_sales')->select('s_id')->max('s_id');

    if ($idfatkur <= 0 || $idfatkur <= '') {
      $idfatkur  = 1;
    }else{
      $idfatkur += 1;
    }

    $fatkur = 'XX'  . $year . $month . $date . $idfatkur;
    //end nota fatkur
    d_sales::insert([
            's_id' =>$s_id,
            's_channel' => 'GR',
            's_date' => date('Y-m-d',strtotime($request->s_date)),
            's_note' => $fatkur,
            's_staff' => $request->s_staff,
            's_customer' => $request->id_cus,
            's_disc_percent' => $request->s_disc_percent,
            's_disc_value' => ($this->konvertRp($request->totalDiscount)),
            's_gross' => ($this->konvertRp($request->s_gross)),
            's_tax' => $request->s_pajak,
            's_net' => ($this->konvertRp($request->s_net)),
            's_status' => 'DR',
            's_insert' => Carbon::now()
          ]);

    for ($i=0; $i < count($request->kode_item); $i++) {

      $d_sales_dt = d_sales_dt::insert([
              'sd_sales' => $s_id,
              'sd_detailid' => $i+1,
              'sd_item' => $request->kode_item[$i],
              'sd_qty' => $request->sd_qty[$i],
              'sd_price' => ($this->konvertRp($request->harga_item[$i])),
              'sd_disc_percent' => $request->sd_disc_percent[$i],
              'sd_disc_vpercent' => $request->totalValuePercent[$i],
              'sd_disc_value' => ($this->konvertRp($request->totaldiscvalue[$i])),
              'sd_total' => ($this->konvertRp($request->hasil[$i]))
            ]);
    }

    $nota = d_sales::where('s_id',$s_id)
        ->first();
  DB::commit();
  return response()->json([
        'status' => 'sukses',
        'nota' => $nota
      ]);
    } catch (\Exception $e) {
  DB::rollback();
  return response()->json([
      'status' => 'gagal',
      'data' => $e
      ]);
    }
  }

  public function sal_save_onProgres(Request $request){
    // dd($request->all());
    DB::beginTransaction();
          try {
        //sisa
    $s_kembalianP = $this->konvertRp($request->s_kembalianP);
    $sisa = 0;
    if ($s_kembalianP <= 0) {
      $sisa = 0-($s_kembalianP);
    }
    //end sisa
    $s_id = d_sales::max('s_id') + 1;
    //nota fatkur
    $year = carbon::now()->format('y');
    $month = carbon::now()->format('m');
    $date = carbon::now()->format('d');

    $idfatkur = DB::Table('d_sales')->select('s_id')->max('s_id');

    if ($idfatkur <= 0 || $idfatkur <= '') {
      $idfatkur  = 1;
    }else{
      $idfatkur += 1;
    }

    $fatkur = 'XX'  . $year . $month . $date . $idfatkur;

    $err = true;
    $akun_beban = []; $akun_persediaan = [];

      if(jurnal_setting()->allow_jurnal_to_execute){
        $method = DB::table('m_paymentmethod')->where('pm_id', $request->sp_method[0])->first();
        $akun[$method->pm_coa_code] = [
            'td_acc'    => ($method) ? $method->pm_coa_code : null,
            'td_posisi' => 'D',
            'value'     => $this->konvertRp($request->totPembayaranDP)
        ];

        $akun['310.01'] = [
            'td_acc'    => '310.01',
            'td_posisi' => 'K',
            'value'     =>  $this->konvertRp($request->totPembayaranDP),
            'cashflow'  => '3'
        ];

      // start jurnal

        if(!$err){
            return response()->json([
                'status' => 'gagal',
                'pesan'  => 'Tidak Bisa Melakukan Jurnal Pada Penerimaan Ini Karena Salah Satu Dari Item Belum Berelasi Dengan Akun Penjualan.'
            ]);
        }
      }

      // return json_encode(array_merge($akun));

    //end nota fatkur
    $sisaPagu = $request->s_sisa_pagu;
    $sNet = ($this->konvertRp($request->s_net));
    $bayar = ($this->konvertRp($request->sp_nominal[1]));
    $hitung = $sNet - $bayar;
    if ($hitung > $sisaPagu) 
    {
       $customer = DB::table('d_sales')
          ->insert([
            's_id' =>$s_id,
            's_channel' =>'GR',
            's_date' =>date('Y-m-d',strtotime($request->s_date)),
            's_note' =>$fatkur,
            's_staff' =>$request->s_staff,
            's_customer' => $request->id_cus,
            's_disc_percent' => $request->s_disc_percent,
            's_disc_value' => $request->s_disc_value,
            's_gross' => ($this->konvertRp($request->s_gross)),
            's_tax' => $request->s_pajak,
            's_net' => ($this->konvertRp($request->s_net)),
            's_sisa' => $sisa,
            's_status' => 'PPN',
            's_insert' => Carbon::now(),
            's_update' => $request->s_update
        ]);
    }
    else
    {
      $customer = DB::table('d_sales')
          ->insert([
            's_id' =>$s_id,
            's_channel' =>'GR',
            's_date' =>date('Y-m-d',strtotime($request->s_date)),
            's_note' =>$fatkur,
            's_staff' =>$request->s_staff,
            's_customer' => $request->id_cus,
            's_disc_percent' => $request->s_disc_percent,
            's_disc_value' => $request->s_disc_value,
            's_gross' => ($this->konvertRp($request->s_gross)),
            's_tax' => $request->s_pajak,
            's_net' => ($this->konvertRp($request->s_net)),
            's_sisa' => $sisa,
            's_status' => 'PR',
            's_insert' => Carbon::now(),
            's_update' => $request->s_update
        ]);
    }
    

    $s_id = DB::table('d_sales')->max('s_id');

    for ($i=0; $i < count($request->kode_item); $i++) {

      DB::table('d_sales_dt')
      ->insert([
          'sd_sales'=>$s_id,
          'sd_detailid'=>$i+1,
          'sd_item'=>$request->kode_item[$i],
          'sd_qty'=>$request->sd_qty[$i],
          'sd_price'=>($this->konvertRp($request->harga_item[$i])),
          'sd_total'=>($this->konvertRp($request->hasil[$i])),
          'sd_disc_percent'=>$request->sd_disc_percent[$i],
          'sd_disc_vpercent' => $request->totalValuePercent[$i],
          'sd_disc_value'=> ($this->konvertRp($request->totaldiscvalue[$i])),
          'sd_total' => ($this->konvertRp($request->hasil[$i]))

      ]);
    }

      DB::table('d_sales_payment')
      ->insert([
          'sp_sales' => $s_id,
          'sp_paymentid' => 1,
          'sp_method' => $request->sp_methodDP,
          'sp_nominal' => ($this->konvertRp($request->totPembayaranDP))
      ]);

    $nota = d_sales::where('s_id',$s_id)
        ->first();
  DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      return response()->json([
          'status' => 'gagal',
          'data' => $e
          ]);
    }

    if ($hitung > $sisaPagu) 
    {

    }
    else
    {
      $customer = DB::table('m_customer')->where('c_id', $request->id_cus)->first();
      $cust = ($customer) ? $customer->c_name : 'Tidak Diketahui';

      if($request->sp_method[0] == '1'){
        $state = 'KM';
        $sts = 'Cash';
      }
      else if($request->sp_method[0] > '1' && $request->sp_method[0] < '6'){
        $state = 'BM';
        $sts = 'Transfer';
      }

      $jurnal = DB::table('d_jurnal')->where('jurnal_ref', $fatkur)->where('keterangan', 'like', 'Uang Muka Penjualan%')->first();

      if(!$jurnal && jurnal_setting()->allow_jurnal_to_execute){
        $state_jurnal = _initiateJournal_self_detail($fatkur, $state, date('Y-m-d',strtotime($request->s_date)), 'Uang Muka Penjualan Atas '.$cust.' '.date('d/m/Y', strtotime($request->s_date)), array_merge($akun));
      }
    }

      // return $state_jurnal;

      return response()->json([
          'status' => 'sukses',
          'nota' => $nota
        ]);
  }

  public function sal_save_final(Request $request){
    // return json_encode($request->all());
    // dd($request->all());
    DB::beginTransaction();
            try {
    //sisa
    $s_kembalianF = $this->konvertRp($request->s_kembalianF);
    $sisa = 0;
    if ($s_kembalianF <= 0) {
      $sisa = 0-($s_kembalianF);
    }
    //end sisa

    //tgl jt
    $tglJT = $request->s_jatuh_tempo;
    $y2 = substr($tglJT, -4);
    $m2 = substr($tglJT, -7,-5);
    $d2 = substr($tglJT,0,2);
      $tglJT = $y2.'-'.$m2.'-'.$d2;
    //tgl jt
    $s_id = d_sales::max('s_id') + 1;
    //nota fatkur
    $year = carbon::now()->format('y');
    $month = carbon::now()->format('m');
    $date = carbon::now()->format('d');

    $idfatkur = DB::Table('d_sales')->select('s_id')->max('s_id');

    if ($idfatkur <= 0 || $idfatkur <= '') {
      $idfatkur  = 1;
    }else{
      $idfatkur += 1;
    }

    $fatkur = 'XX'  . $year . $month . $date . $idfatkur;

    $err = true;
    $akun_beban = []; $akun_persediaan = [];

      if(jurnal_setting()->allow_jurnal_to_execute){
        $method = DB::table('m_paymentmethod')->where('pm_id', $request->sp_method[0])->first();
        $akun[$method->pm_coa_code] = [
            'td_acc'    => ($method) ? $method->pm_coa_code : null,
            'td_posisi' => 'D',
            'value'     => $this->konvertRp($request->sp_nominal[0])
        ];

        $akun['310.01'] = [
            'td_acc'    => '310.01',
            'td_posisi' => 'K',
            'value'     =>  $this->konvertRp($request->sp_nominal[0]),
            'cashflow'  => '3'
        ];

      // start jurnal

        if(!$err){
            return response()->json([
                'status' => 'gagal',
                'pesan'  => 'Tidak Bisa Melakukan Jurnal Pada Penerimaan Ini Karena Salah Satu Dari Item Belum Berelasi Dengan Akun Penjualan.'
            ]);
        }
      }

      // return json_encode(array_merge($akun));
      $sisaPagu = $request->s_sisa_pagu;
      $sNet = ($this->konvertRp($request->s_net));
      $bayar = ($this->konvertRp($request->sp_nominal[0]));
      $hitung = $sNet - $bayar;
      if ($hitung > $sisaPagu) 
      {
        $customer = DB::table('d_sales')
        ->insert([
          's_id' => $s_id,
          's_channel' => 'GR',
          's_date' => date('Y-m-d',strtotime($request->s_date)),
          's_note' => $fatkur,
          's_staff' => $request->s_staff,
          's_customer' => $request->id_cus,
          's_gross' => ($this->konvertRp($request->s_gross)),
          's_disc_percent' => ($this->konvertRp($request->s_disc_percent)),
          's_disc_value' => ($this->konvertRp($request->s_disc_value)),
          's_tax' => $request->s_pajak,
          's_net' => ($this->konvertRp($request->s_net)),
          's_tax' => $request->s_pajak,
          's_jatuh_tempo' => $tglJT,
          's_sisa' => $sisa,
          's_status' => 'FPN',
          's_insert' => Carbon::now(),
          's_update' => $request->s_update
        ]);
      }
      else
      {
        $customer = DB::table('d_sales')
        ->insert([
          's_id' => $s_id,
          's_channel' => 'GR',
          's_date' => date('Y-m-d',strtotime($request->s_date)),
          's_note' => $fatkur,
          's_staff' => $request->s_staff,
          's_customer' => $request->id_cus,
          's_gross' => ($this->konvertRp($request->s_gross)),
          's_disc_percent' => ($this->konvertRp($request->s_disc_percent)),
          's_disc_value' => ($this->konvertRp($request->s_disc_value)),
          's_tax' => $request->s_pajak,
          's_net' => ($this->konvertRp($request->s_net)),
          's_tax' => $request->s_pajak,
          's_jatuh_tempo' => $tglJT,
          's_sisa' => $sisa,
          's_status' => 'FN',
          's_insert' => Carbon::now(),
          's_update' => $request->s_update
        ]);
      }
    // end nota fatkur
    

    $s_id = DB::table('d_sales')->max('s_id');

    for ($i=0; $i < count($request->kode_item); $i++) {

      $d_sales_dt = DB::table('d_sales_dt')
          ->insert([
            'sd_sales' => $s_id,
            'sd_detailid' => $i+1,
            'sd_item' => $request->kode_item[$i],
            'sd_qty' => $request->sd_qty[$i],
            'sd_price' => ($this->konvertRp($request->harga_item[$i])),
            'sd_disc_percent' => $request->sd_disc_percent[$i],
            'sd_disc_vpercent' => $request->totalValuePercent[$i],
            'sd_disc_value' => ($this->konvertRp($request->totaldiscvalue[$i])),
            'sd_total' => ($this->konvertRp($request->hasil[$i]))
        ]);
      }

        for ($i=0; $i < count($request->sp_method); $i++) {

          DB::table('d_sales_payment')
          ->insert([
              'sp_sales' => $s_id,
              'sp_paymentid' => $i+1,
              'sp_method' => $request->sp_method[$i],
              'sp_nominal' => ($this->konvertRp($request->sp_nominal[$i]))
          ]);
        }

      $nota = d_sales::where('s_id',$s_id)
        ->first();
    DB::commit();
      } catch (\Exception $e) {
    DB::rollback();
    return response()->json([
        'status' => 'gagal',
        'data' => $e
        ]);
      }
      if ( $hitung > $sisaPagu ) 
      {

      }
      else
      {
        $customer = DB::table('m_customer')->where('c_id', $request->id_cus)->first();
        $cust = ($customer) ? $customer->c_name : 'Tidak Diketahui';

        if($request->sp_method[0] == '1'){
          $state = 'KM';
          $sts = 'Cash';
        }
        else if($request->sp_method[0] > '1' && $request->sp_method[0] < '6'){
          $state = 'BM';
          $sts = 'Transfer';
        }

        $jurnal = DB::table('d_jurnal')->where('jurnal_ref', $fatkur)->where('keterangan', 'like', 'Uang Muka Penjualan%')->first();

        if(!$jurnal && jurnal_setting()->allow_jurnal_to_execute){
          $state_jurnal = _initiateJournal_self_detail($fatkur, $state, date('Y-m-d',strtotime($request->s_date)), 'Uang Muka Penjualan Atas '.$cust.' '.date('d/m/Y', strtotime($request->s_date)), array_merge($akun));
        }
      }
      // return $state_jurnal;

      return response()->json([
          'status' => 'sukses',
          'nota' => $nota
        ]);
  }

  public function sal_save_finalUpdate(Request $request){
    // dd($request->all());
    DB::beginTransaction();
    try {
    //tgl jt
    $tglJT = $request->s_jatuh_tempo;
    $y2 = substr($tglJT, -4);
    $m2 = substr($tglJT, -7,-5);
    $d2 = substr($tglJT,0,2);
      $tglJT = $y2.'-'.$m2.'-'.$d2;
    //tgl jt
    $s_id = $request->s_id;
    $kodeItem = $request->kode_item;
    $qtyItem = $request->sd_qty;
    $m = d_sales::where('s_id',$s_id)->first();
    // dd($m->s_status);
     if ($m->s_status == 'DR' || $m->s_status == 'PR') {
        d_sales::where('s_id',$s_id)
          ->update([
            's_channel' => 'GR',
            's_date' => date('Y-m-d',strtotime($request->s_date)),
            's_note' => $request->s_nota,
            's_staff' => $request->s_staff,
            's_customer' => $request->id_cus,
            's_disc_percent' => ($this->konvertRp($request->s_disc_percent)),
            's_disc_value' => ($this->konvertRp($request->s_disc_value)),
            's_gross' => ($this->konvertRp($request->s_gross)),
            's_jatuh_tempo' => $tglJT,
            's_tax' => $request->s_pajak,
            's_net' => ($this->konvertRp($request->s_net)),
            's_status' => "FN",
            's_insert' => Carbon::now(),
            's_update' => $request->s_update
          ]);

          d_sales_dt::where('sd_sales',$s_id)->delete();

          for ($i=0; $i < count($kodeItem); $i++) {

            $d_sales_dt = d_sales_dt::insert([
              'sd_sales' => $s_id,
              'sd_detailid' => $i + 1,
              'sd_item' => $kodeItem[$i],
              'sd_qty' => $qtyItem[$i],
              'sd_price' => ($this->konvertRp($request->harga_item[$i])),
              'sd_disc_percent' => $request->sd_disc_percent[$i],
              'sd_disc_vpercent' => $request->totalValuePercent[$i],
              'sd_disc_value' => ($this->konvertRp($request->totaldiscvalue[$i])),
              'sd_total' => ($this->konvertRp($request->hasil[$i]))
            ]);
          }

          DB::table('d_sales_payment')
            ->where('sp_sales', $s_id)->delete();

        for ($i=0; $i < count($request->sp_method); $i++) {

            DB::table('d_sales_payment')
              ->insert([
                  'sp_sales' => $s_id,
                  'sp_paymentid' => $i+1,
                  'sp_method' => $request->sp_method[$i],
                  'sp_nominal' => ($this->konvertRp($request->sp_nominal[$i]))
              ]);
            }
        }

      $nota = d_sales::where('s_id',$s_id)
        ->first();
    DB::commit();
    return response()->json([
          'status' => 'sukses',
          'nota' => $nota
      ]);
    } catch (\Exception $e) {
    DB::rollback();
    return response()->json([
        'status' => 'gagal',
        'data' => $e
      ]);
    }

  }

  public function sal_save_onProgresUpdate(Request $request){
    // dd($request->all());
    DB::beginTransaction();
    try {
    $s_id = $request->s_id;
    $kodeItem = $request->kode_item;
    $qtyItem = $request->sd_qty;
    $m = d_sales::where('s_id', $s_id)->first();

      d_sales::where('s_id', $s_id)
        ->update([
          's_channel' =>'GR',
          's_date' =>date('Y-m-d',strtotime($request->s_date)),
          's_note' =>$request->s_nota,
          's_staff' =>$request->s_staff,
          's_customer' => $request->id_cus,
          's_disc_percent' => $request->s_disc_percent,
          's_disc_value' => $request->s_disc_value,
          's_gross' => ($this->konvertRp($request->s_gross)),
          's_tax' => $request->s_pajak,
          's_net' => ($this->konvertRp($request->s_net)),
          's_status' => 'PR',
          's_insert' => Carbon::now(),
          's_update' => $request->s_update
        ]);

      d_sales_dt::where('sd_sales', $s_id)->delete();

      for ($i=0; $i < count($kodeItem); $i++) {

        $d_sales_dt = d_sales_dt::insert([
          'sd_sales' => $s_id,
          'sd_detailid' => $i + 1,
          'sd_item' => $kodeItem[$i],
          'sd_qty' => $qtyItem[$i],
          'sd_price' => ($this->konvertRp($request->harga_item[$i])),
          'sd_disc_percent' => $request->sd_disc_percent[$i],
          'sd_disc_vpercent' => $request->totalValuePercent[$i],
          'sd_disc_value' => ($this->konvertRp($request->totaldiscvalue[$i])),
          'sd_total' => ($this->konvertRp($request->hasil[$i]))
        ]);
      }

      DB::table('d_sales_payment')
        ->where('sp_sales', $s_id)->delete();

      DB::table('d_sales_payment')
      ->insert([
          'sp_sales' => $s_id,
          'sp_paymentid' => 1,
          'sp_method' => $request->sp_methodDP,
          'sp_nominal' => ($this->konvertRp($request->totPembayaranDP))
      ]);

      $nota = d_sales::where('s_id',$s_id)
        ->first();
    DB::commit();
    return response()->json([
          'status' => 'sukses',
          'nota' => $nota
        ]);
      } catch (\Exception $e) {
    DB::rollback();
    return response()->json([
        'status' => 'gagal',
        'data' => $e
        ]);
      }
    }

  public function distroy($id){
       DB::table('d_sales')->where('s_id',$id)->where('s_status','DR')->delete();

     return redirect('/penjualan/POSgrosir/index');
    }

  public function konvertRp($value){
    $value = str_replace(['Rp', '\\', '.', ' '], '', $value);
    return str_replace(',', '.', $value);
  }

  public function tambahItemReq(Request $request){
      return DB::transaction(function() use ($request)
      {

      for ($i=0; $i < count($request->kodeItemReq); $i++)
        {
            $stokGrosir = DB::table('d_stock')
                ->where('s_comp','7')
                ->where('s_position','7')
                ->where('s_item',$request->kodeItemReq[$i])->first();

            $s_id= DB::table('d_stock')->max('s_id');

            DB::table('d_stock')
            ->insert([
                's_id'=>$s_id+1,
                's_comp'=>'9',
                's_position'=>'7',
                's_item'=>$request->kodeItemReq[$i],
                's_qty'=>$request->tambahItemReq[$i],
                // 's_insert' => $request->s_insert[$i],
                // 's_update' => $request->s_update[$i]
            ]);

            DB::table('d_transferitem_dt')
              ->update([
                    'tidt_id'=>$request->rd_request[$i],
                    'tidt_detail'=>$request->rd_detail[$i],
                    'tidt_item'=>$request->rd_item[$i],
                    'tidt_qty'=>$request->rd_qty[$i],
                    'tidt_qty_appr'=>$request->tambahItemReq[$i]
              ]);

            $stokBaru = $stokGrosir->s_qty - $request->tambahItemReq[$i];

            DB::table("d_stock")
              ->where('s_comp','7')
              ->where('s_position','7')
              ->where("s_id", $stokGrosir->s_id)
              ->update(['s_qty' => $stokBaru]);
          }
    });
    }

  function getTanggal($tgl1,$tgl2,$tampil='semua')
  {
    $y = substr($tgl1, -4);
    $m = substr($tgl1, -7,-5);
    $d = substr($tgl1,0,2);
     $tgll = $y.'-'.$m.'-'.$d;

    $y2 = substr($tgl2, -4);
    $m2 = substr($tgl2, -7,-5);
    $d2 = substr($tgl2,0,2);
      $tgl2 = $y2.'-'.$m2.'-'.$d2;

    if ($tampil == 'semua') {
      $detalis = DB::table('d_sales')
        ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
        ->where('s_channel','GR')
        ->where('s_date','>=',$tgll)
        ->where('s_date','<=',$tgl2)
        ->get();
    }elseif ($tampil == 'draft') {
      $detalis = DB::table('d_sales')
        ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
        ->where('s_channel','GR')
        ->where('s_status','DR')
        ->where('s_date','>=',$tgll)
        ->where('s_date','<=',$tgl2)
        ->get();
    }elseif ($tampil == 'progress') {
      $detalis = DB::table('d_sales')
        ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
        ->where('s_channel','GR')
        ->where('s_status','PR')
        ->where('s_date','>=',$tgll)
        ->where('s_date','<=',$tgl2)
        ->get();
    }elseif ($tampil == 'final'){
        $detalis = DB::table('d_sales')
          ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
          ->where('s_channel','GR')
          ->where('s_status','FN')
          ->where('s_date','>=',$tgll)
          ->where('s_date','<=',$tgl2)
          ->get();
    }elseif ($tampil == 'packing'){
        $detalis = DB::table('d_sales')
          ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
          ->where('s_channel','GR')
          ->where('s_status','PC')
          ->where('s_date','>=',$tgll)
          ->where('s_date','<=',$tgl2)
          ->get();
    }elseif ($tampil == 'sending'){
        $detalis = DB::table('d_sales')
          ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
          ->where('s_channel','GR')
          ->where('s_status','SN')
          ->where('s_date','>=',$tgll)
          ->where('s_date','<=',$tgl2)
          ->get();
    }elseif ($tampil == 'received'){
        $detalis = DB::table('d_sales')
          ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
          ->where('s_channel','GR')
          ->where('s_status','RC')
          ->where('s_date','>=',$tgll)
          ->where('s_date','<=',$tgl2)
          ->get();
    }elseif ($tampil == 'FPN'){
        $detalis = DB::table('d_sales')
          ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
          ->where('s_channel','GR')
          ->where('s_status','FPN')
          ->where('s_date','>=',$tgll)
          ->where('s_date','<=',$tgl2)
          ->get();
    }elseif ($tampil == 'PPN'){
        $detalis = DB::table('d_sales')
          ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
          ->where('s_channel','GR')
          ->where('s_status','PPN')
          ->where('s_date','>=',$tgll)
          ->where('s_date','<=',$tgl2)
          ->get();
    }

    //return view('/penjualan/POSgrosir/NotaPenjualan.dt_notaJual',compact('detalis'));
    return DataTables::of($detalis)
      ->addIndexColumn()
      ->editColumn('sDate', function ($data)
      {
          return date('d M Y', strtotime($data->s_date));
      })
      ->editColumn('sGross', function ($data)
        {
            return '<div>Rp.
                      <span class="pull-right">
                        '.number_format( $data->s_net ,2,',','.').'
                      </span>
                    </div>';
        })
      ->editColumn('status', function ($data)
      {
          if ($data->s_status == "DR") { return '<span class="label label-default">Draft</span>'; }
          elseif ($data->s_status == "WA") { return '<span class="label label-primary">Waiting</span>'; }
          elseif ($data->s_status == "PR") { return '<span class="label label-orange">Progress</span>'; }
          elseif ($data->s_status == "FN") { return '<span class="label label-success">Final</span>'; }
          elseif ($data->s_status == "PC") { return '<span class="label label-dark">Packing</span>'; }
          elseif ($data->s_status == "SN") { return '<span class="label label-danger">Sending</span>'; }
          elseif ($data->s_status == "RC") { return '<span class="label label-info">Received</span>'; }
          elseif ($data->s_status == "FPN") { return '<span class="label label-default">Final Pending</span>'; }
          elseif ($data->s_status == "PPN") { return '<span class="label label-default">Progress Pending</span>'; }
      })
      ->addColumn('action', function($data)
      {
        if ($data->s_status == 'FN' || $data->s_status == 'SN' || $data->s_status == 'PC')
        {
          return '<div class="text-center">
                    <button
                      type="button"
                      class="btn btn-success btn-sm glyphicon glyphicon-check"
                      title="Ubah Status"
                      data-toggle="modal"
                      onclick="ubahStatus('."'".$data->s_id."'".','."'".$data->s_status."'".')"
                      data-target="#modalStatus">
                    </button>
                  </div>';
        }
        else
        {
         return '<div class="text-center">
          
                  </div>';
        }
      })
      ->addColumn('action2', function($data)
      {
        if ($data->s_status == 'FN') { $attr = 'disabled'; } else { $attr = ''; };
        $linkEdit = URL::to('/penjualan/POSgrosir/grosir/edit_sales/'.$data->s_id);
        if ($data->s_status == 'FN' || $data->s_status == 'SN' || $data->s_status == 'PC' || $data->s_status == 'RC' || $data->s_status == 'FPN' || $data->s_status == 'PPN')
        {
          return '<div class="text-center">
                    <button type="button"
                      class="btn btn-success fa fa-eye btn-sm"
                      title="detail"
                      data-toggle="modal"
                      onclick="lihatDetail('."'".$data->s_id."'".')"
                      data-target="#myItem">
                    </button>

                  </div>';
        }
        else if ($data->s_status == 'PR') 
        {
           return '<div class="text-center">
                    <button type="button"
                      class="btn btn-success fa fa-eye btn-sm"
                      title="detail"
                      data-toggle="modal"
                      onclick="lihatDetail('."'".$data->s_id."'".')"
                      data-target="#myItem">
                    </button>
                    <a href="'.$linkEdit.'"
                      class="btn btn-warning btn-sm"
                      title="Edit" '.$attr.'>
                      <i class="fa fa-pencil"></i>
                    </a>
                  </div>';
        }
        else
        {
          return '<div class="text-center">
                    <button type="button"
                      class="btn btn-success fa fa-eye btn-sm"
                      title="detail"
                      data-toggle="modal"
                      onclick="lihatDetail('."'".$data->s_id."'".')"
                      data-target="#myItem">
                    </button>
                    <a href="'.$linkEdit.'"
                      class="btn btn-warning btn-sm"
                      title="Edit" '.$attr.'>
                      <i class="fa fa-pencil"></i>
                    </a>
                    <a onclick="distroyNota('.$data->s_id.')"
                      class="btn btn-danger btn-sm"
                      title="Hapus" '.$attr.'>
                      <i class="fa fa-trash-o"></i>
                    </a>
                  </div>';
        }

      })
      //inisisai column status agar kode html digenerate ketika ditampilkan
      ->rawColumns(['action', 'action2','sGross','status'])
      ->make(true);
  }

  function getTanggalJual($tgl1,$tgl2){
    $y = substr($tgl1, -4);
    $m = substr($tgl1, -7,-5);
    $d = substr($tgl1,0,2);
    $tgll = $y.'-'.$m.'-'.$d;

    $y2 = substr($tgl2, -4);
    $m2 = substr($tgl2, -7,-5);
    $d2 = substr($tgl2,0,2);
    $tgl2 = $y2.'-'.$m2.'-'.$d2;

    $leagues = d_sales_dt::select('sd_item',
                                  's_date',
                                  'i_name',
                                  'm_gname',
                                  'i_type',
                                  'i_code',
                                  DB::raw("sum(sd_qty) as jumlah"))
      ->join('m_item', 'm_item.i_id', '=' , 'd_sales_dt.sd_item')
      ->join('m_group','m_group.m_gcode','=','m_item.i_code_group')
      ->join('d_sales', 'd_sales.s_id', '=' , 'd_sales_dt.sd_sales')
      ->where('s_channel','GR')
      ->where(function($status){
          $status ->orWhere('s_status','FN')
                  ->orWhere('s_status','PC')
                  ->orWhere('s_status','SN')
                  ->orWhere('s_status','RC');
      })

      ->where('s_date','>=',$tgll)
      ->where('s_date','<=',$tgl2)
      ->groupBy('sd_item','i_name')
      ->get();

    //return view('/penjualan/POSgrosir/ItemPenjualan.Data_JualGrosir',compact('leagues'));
    return DataTables::of($leagues)
      ->addIndexColumn()
      ->editColumn('sDate', function ($data)
        {
          return date('d M Y', strtotime($data->s_date));
        })
      ->editColumn('type', function ($data)
        {
          if ($data->i_type == "BJ") { return 'Barang Jual'; }
          elseif ($data->i_type == "BP") { return 'Barang Produksi'; }
        })
      ->make(true);
  }

  public function PayMethode(Request $request){
    $paymethode=DB::table('m_paymentmethod')
      ->select('pm_id','pm_name')
      //->where('pm_id','!=',$request->data0)
      ->get();
    $data = array();
    foreach ($paymethode as $value) {
      $data[] = (array) $value;
    }
    for ($j=0; $j<count($data); $j++) {
      for($i=0; $i<$request->length; $i++){
        if($data[$j]['pm_id'] == $request->{'data'.$i})
          $data[$j]['pm_id']=0;
      }
    }
    $idx=0;
    foreach ($data as $key) {
      if($key['pm_id'] == 0){
        unset($data[$idx]);
      }
      $idx++;
    }

    $data2 = array();
    foreach ($data as $key => $value) {
      $data2[] = (array) $value;
    }
    echo json_encode($data2);
  }

  public function setBarcode(Request $request){
    $data = DB::table('m_item')
        ->select( 'i_id',
                  'i_code',
                  'i_name',
                  'm_psell1',
                  'i_sat1',
                  's_qty')
        ->join('d_stock','d_stock.s_item','=','m_item.i_id')
        ->join('m_price','m_price.m_pitem','=','m_item.i_id')
        ->where('s_comp','2')
        ->where('s_position','2')
        ->where('i_code', 'like', '%'.$request->code.'%')
        ->get();

    return Response::json($data);
  }

  public function statusMove(Request $request){
    $sales = DB::Table('d_sales')
      ->where('s_id',$request->id)
      ->first();

    $response ='';
    if($request->status == 'SN'){
      $response = '<input type="text" class="hide" name="idSales" id="idSales" value="'.$sales->s_id.'">
                    <input type="text" class="hide" name="oldStatus" id="oldStatus" value="'.$sales->s_status.'">
                    <select id="setStatus" style="width: 100%; " class="pull-right">
                           <option value="RC">Received</option>
                    </select>

                    <div class="input-group">
                      <input type="hidden" name="resi" placeholder="Masukan Nomor Resi" style="width: 100%;" class="form-control input-sm" id="resi" value="'.$sales->s_resi.'">
                    </div>';
    }elseif($request->status == 'PC'){
      $response = '<input type="text" class="hide" name="idSales" id="idSales" value="'.$sales->s_id.'">
                    <input type="text" class="hide" name="oldStatus" id="oldStatus" value="'.$sales->s_status.'">
                      
                    <select id="setStatus" style="width: 100%;margin-bottom:15px;"  class="pull-right">
                           <option value="SN">Sending</option>
                           <option value="RC">Received</option>
                    </select>

                    <div class="input-group" style="width: 100%;margin-bottom:15px;">
                      <span class="input-group-addon">Resi</span>
                      <input type="text" name="resi" placeholder="Masukan Nomor Resi" style="width: 100%;" class="form-control input-sm" id="resi">
                    </div>

                    <div class="input-group">
                      <span class="input-group-addon">Ongkos</span>
                      <input type="text" name="ongkir" placeholder="Masukan Ongkos Resi" style="width: 100%;" class="form-control input-sm text-right" id="ongkir">
                    </div>';
    }else{
      $response = '<input type="text" class="hide" name="idSales" id="idSales" value="'.$sales->s_id.'">
                    <input type="text" class="hide" name="oldStatus" id="oldStatus" value="'.$sales->s_status.'">
                    <select id="setStatus" style="width: 100%; " class="pull-right">
                           <option value="PC">Packing</option>
                           <option value="SN">Sending</option>
                           <option value="RC">Received</option>
                    </select>';
    }
    return $response;
  }

  public function changeStatus(Request $request){
    DB::beginTransaction();
      try {

        $sales = DB::table('d_sales')->where('s_id', $request->id)->first();

        if(!$sales){
          return response()->json([
            'status' => 'gagal',
            'data' => 'Data Sales Tidak Bisa Ditemukan.'
            ]);
        }

        $sales_dt = DB::table('d_sales_dt')->where('sd_sales', $sales->s_id)->get();
        // return json_encode($sales);

      $err = true;
      $akun_beban = []; $akun_persediaan = [];
      $um = $sales->s_net - $sales->s_sisa;
      $disc = $sales->s_gross - $sales->s_net;

      if(jurnal_setting()->allow_jurnal_to_execute){
        if($um > 0){
          $akun['310.01'] = [
              'td_acc'    => '310.01',
              'td_posisi' => 'D',
              'value'     => $um
          ]; // Uang Muka Penjualan
        }

        if($sales->s_sisa > 0){
          $akun['110.01'] = [
              'td_acc'    => '110.01',
              'td_posisi' => 'D',
              'value'     => $sales->s_sisa
          ]; // Piutang Usaha
        }

        if($disc > 0){
          $akun['501.01'] = [
              'td_acc'    => '501.01',
              'td_posisi' => 'D',
              'value'     => $disc
          ]; // Diskon Penjualan
        }

        // return json_encode($akun);

      // start jurnal

        foreach($sales_dt as $acc_key => $data){
            $cek = DB::table('m_item')
                ->join('m_group', 'm_group.m_gcode', '=', 'm_item.i_code_group')
                ->join('m_price', 'm_price.m_pitem', '=', 'm_item.i_id')
                ->where('i_id', $data->sd_item)
                ->select('m_group.m_akun_penjualan', 'm_group.m_akun_persediaan', 'm_group.m_akun_beban', 'm_group.m_gid', 'm_price.m_hpp')
                ->first();

            $cek2 = DB::table('d_akun')->where('id_akun', $cek->m_akun_penjualan)->first();

            // return json_encode($cek);

            if(!$cek || !$cek->m_akun_penjualan || !$cek->m_akun_persediaan || !$cek->m_akun_beban || !$cek2){
                $err = false;
            }else{
                if(!array_key_exists($cek->m_akun_penjualan, $akun)){
                    $akun[$cek->m_akun_penjualan] = [
                        'td_acc'    => $cek->m_akun_penjualan,
                        'td_posisi' => 'K',
                        'value'     => $sales->s_gross
                    ];
                }

                if(array_key_exists($cek->m_akun_beban, $akun_beban)){
                    $akun_beban[$cek->m_akun_beban] = [
                        'td_acc'    => $cek->m_akun_beban,
                        'td_posisi' => 'D',
                        'value'     => $akun_beban[$cek->m_akun_beban]['value'] + ($cek->m_hpp * $data->sd_qty)
                    ];
                }else{
                    $akun_beban[$cek->m_akun_beban] = [
                        'td_acc'    => $cek->m_akun_beban,
                        'td_posisi' => 'D',
                        'value'     => ($cek->m_hpp * $data->sd_qty)
                    ];
                }

                if(array_key_exists($cek->m_akun_persediaan, $akun_persediaan)){
                    $akun_persediaan[$cek->m_akun_persediaan] = [
                        'td_acc'    => $cek->m_akun_persediaan,
                        'td_posisi' => 'K',
                        'value'     => $akun_persediaan[$cek->m_akun_persediaan]['value'] + ($cek->m_hpp * $data->sd_qty)
                    ];
                }else{
                    $akun_persediaan[$cek->m_akun_persediaan] = [
                        'td_acc'    => $cek->m_akun_persediaan,
                        'td_posisi' => 'K',
                        'value'     => ($cek->m_hpp * $data->sd_qty)
                    ];
                }
            }
        }

        if(!$err){
            return response()->json([
                'status' => 'gagal',
                'pesan'  => 'Tidak Bisa Melakukan Jurnal Pada Penerimaan Ini Karena Salah Satu Dari Item Belum Berelasi Dengan Akun Penjualan.'
            ]);
        }
      }
      $ongkir = $request->ongkir;
      if ($ongkir == null) {
        $ongkir = 0;
      }
      // return json_encode(array_merge($akun));
      $update = DB::Table('d_sales')
        ->where('s_id',$request->id)
        ->update([
          's_status' => $request->status,
          's_resi' => $request->resi,
          's_ongkir' => str_replace(',', '',  $ongkir),
          's_net' => DB::raw('s_net + '.str_replace(',', '',  $ongkir))
        ]);

      $nota = d_sales::select('s_note')
        ->where('s_id',$request->id)
        ->first();

      $salesDt = DB::Table('d_sales_dt')
        ->where('sd_sales',$request->id)
        ->get();
      if(count($salesDt) > 0){
        // dd($salesDt);
        if($request->status == 'PC'){
          foreach ($salesDt as $value) {

            $maxid = DB::Table('d_stock')->select('s_id')->max('s_id')+1;

            $cek = d_stock::select('s_id','s_qty')
              ->where('s_item',$value->sd_item)
              ->where('s_comp','4')
              ->where('s_position','2')
              ->first();

            if(mutasi::mutasiStok(  $value->sd_item,
                                    $value->sd_qty,
                                    $comp=2,
                                    $position=2,
                                    $flag=1,
                                    $nota->s_note)){}

            if ($cek == null) {
              d_stock::insert([
                's_id'      => $maxid,
                's_comp'    => 4,
                's_position'=> 2,
                's_item'    => $value->sd_item,
                's_qty'     => $value->sd_qty,
                's_insert'  => Carbon::now(),
                's_update'  => Carbon::now()
              ]);

              d_stock_mutation::create([
                'sm_stock' => $maxid,
                'sm_detailid' =>1,
                'sm_date' => Carbon::now(),
                'sm_comp' => 4,
                'sm_position' => 2,
                'sm_mutcat' => 1,
                'sm_item' => $value->sd_item,
                'sm_qty' => $value->sd_qty,
                'sm_qty_used' => 0,
                'sm_qty_sisa' => $value->sd_qty,
                'sm_qty_expired' => 0,
                'sm_detail' => 'PACKING',
                'sm_reff' => $nota->s_note,
                'sm_insert' => Carbon::now()
              ]);

            }else{

              $hasil = $cek->s_qty + $value->sd_qty;
              $cek->update([
                's_qty'     => $hasil
              ]);

              $sm_detailid = d_stock_mutation::select('sm_detailid')
                ->where('sm_item',$value->sd_item)
                ->where('sm_comp','4')
                ->where('sm_position','2')
                ->max('sm_detailid')+1;

              d_stock_mutation::create([
                'sm_stock' => $cek->s_id,
                'sm_detailid' => $sm_detailid,
                'sm_date' => Carbon::now(),
                'sm_comp' => 4,
                'sm_position' => 2,
                'sm_mutcat' => 1,
                'sm_item' => $value->sd_item,
                'sm_qty' => $value->sd_qty,
                'sm_qty_used' => 0,
                'sm_qty_sisa' => $value->sd_qty,
                'sm_qty_expired' => 0,
                'sm_detail' => 'PACKING',
                'sm_reff' => $nota->s_note,
                'sm_insert' => Carbon::now()
              ]);

            }


          }
        }
        if($request->status == 'SN' && $request->oldStatus != 'PC'){
          // dd($request->all());
          foreach ($salesDt as $value) {

            $maxid = DB::Table('d_stock')->select('s_id')->max('s_id')+1;

            if(mutasi::mutasiStok(  $value->sd_item,
                                    $value->sd_qty,
                                    $comp=2,
                                    $position=2,
                                    $flag=1,
                                    $nota->s_note)){}

            $cek = d_stock::select('s_id','s_qty')
              ->where('s_item',$value->sd_item)
              ->where('s_comp','4')
              ->where('s_position','5')
              ->first();

            if ($cek == null) {
              d_stock::insert([
                's_id'      => $maxid,
                's_comp'    => 4,
                's_position'=> 5,
                's_item'    => $value->sd_item,
                's_qty'     => $value->sd_qty,
                's_insert'  => Carbon::now(),
                's_update'  => Carbon::now()
              ]);

              d_stock_mutation::create([
                'sm_stock' => $maxid,
                'sm_detailid' =>1,
                'sm_date' => Carbon::now(),
                'sm_comp' => 4,
                'sm_position' => 5,
                'sm_mutcat' => 1,
                'sm_item' => $value->sd_item,
                'sm_qty' => $value->sd_qty,
                'sm_qty_used' => 0,
                'sm_qty_sisa' => $value->sd_qty,
                'sm_qty_expired' => 0,
                'sm_detail' => 'PENGIRIMAN',
                'sm_reff' => $nota->s_note,
                'sm_insert' => Carbon::now()
              ]);

            }else{

              $hasil = $cek->s_qty + $value->sd_qty;
              $cek->update([
                's_qty'     => $hasil
              ]);

              $sm_detailid = d_stock_mutation::select('sm_detailid')
                ->where('sm_item',$value->sd_item)
                ->where('sm_comp','4')
                ->where('sm_position','5')
                ->max('sm_detailid')+1;

              d_stock_mutation::create([
                'sm_stock' => $cek->s_id,
                'sm_detailid' => $sm_detailid,
                'sm_date' => Carbon::now(),
                'sm_comp' => 4,
                'sm_position' => 5,
                'sm_mutcat' => 1,
                'sm_item' => $value->sd_item,
                'sm_qty' => $value->sd_qty,
                'sm_qty_used' => 0,
                'sm_qty_sisa' => $value->sd_qty,
                'sm_qty_expired' => 0,
                'sm_detail' => 'PENGIRIMAN',
                'sm_reff' => $nota->s_note,
                'sm_insert' => Carbon::now()
              ]);

            }
          }
        }
        if($request->status == 'SN' && $request->oldStatus == 'PC'){
          // dd($request->all());
          foreach ($salesDt as $value) {

            $maxid = DB::Table('d_stock')->select('s_id')->max('s_id')+1;

            if(mutasi::mutasiStok(  $value->sd_item,
                                    $value->sd_qty,
                                    $comp=4,
                                    $position=2,
                                    $flag=1,
                                    $nota->s_note)){}

            $cek = d_stock::select('s_id','s_qty')
              ->where('s_item',$value->sd_item)
              ->where('s_comp','4')
              ->where('s_position','5')
              ->first();

            if ($cek == null) {
              d_stock::insert([
                's_id'      => $maxid,
                's_comp'    => 4,
                's_position'=> 5,
                's_item'    => $value->sd_item,
                's_qty'     => $value->sd_qty,
                's_insert'  => Carbon::now(),
                's_update'  => Carbon::now()
              ]);

              d_stock_mutation::create([
                'sm_stock' => $maxid,
                'sm_detailid' =>1,
                'sm_date' => Carbon::now(),
                'sm_comp' => 4,
                'sm_position' => 5,
                'sm_mutcat' => 1,
                'sm_item' => $value->sd_item,
                'sm_qty' => $value->sd_qty,
                'sm_qty_used' => 0,
                'sm_qty_sisa' => $value->sd_qty,
                'sm_qty_expired' => 0,
                'sm_detail' => 'PENGIRIMAN',
                'sm_reff' => $nota->s_note,
                'sm_insert' => Carbon::now()
              ]);

            }else{

              $hasil = $cek->s_qty + $value->sd_qty;
              $cek->update([
                's_qty'     => $hasil
              ]);

              $sm_detailid = d_stock_mutation::select('sm_detailid')
                ->where('sm_item',$value->sd_item)
                ->where('sm_comp','4')
                ->where('sm_position','5')
                ->max('sm_detailid')+1;

              d_stock_mutation::create([
                'sm_stock' => $cek->s_id,
                'sm_detailid' => $sm_detailid,
                'sm_date' => Carbon::now(),
                'sm_comp' => 4,
                'sm_position' => 5,
                'sm_mutcat' => 1,
                'sm_item' => $value->sd_item,
                'sm_qty' => $value->sd_qty,
                'sm_qty_used' => 0,
                'sm_qty_sisa' => $value->sd_qty,
                'sm_qty_expired' => 0,
                'sm_detail' => 'PENGIRIMAN',
                'sm_reff' => $nota->s_note,
                'sm_insert' => Carbon::now()
              ]);

            }
          }
        }
        if($request->status == 'RC'  && $request->oldStatus != 'SN' && $request->oldStatus != 'PC'){
          foreach ($salesDt as $value) {
            $maxid = DB::Table('d_stock')->select('s_id')->max('s_id')+1;

            if(mutasi::mutasiStok(  $value->sd_item,
                                    $value->sd_qty,
                                    $comp=2,
                                    $position=2,
                                    $flag=1,
                                    $nota->s_note)){}

            $cek = d_stock::select('s_id','s_qty')
              ->where('s_item',$value->sd_item)
              ->where('s_comp','4')
              ->where('s_position','4')
              ->first();


            if ($cek == null) {
              d_stock::insert([
                's_id'      => $maxid,
                's_comp'    => 4,
                's_position'=> 4,
                's_item'    => $value->sd_item,
                's_qty'     => $value->sd_qty,
                's_insert'  => Carbon::now(),
                's_update'  => Carbon::now()
              ]);

              d_stock_mutation::create([
                'sm_stock' => $maxid,
                'sm_detailid' =>1,
                'sm_date' => Carbon::now(),
                'sm_comp' => 4,
                'sm_position' => 4,
                'sm_mutcat' => 1,
                'sm_item' => $value->sd_item,
                'sm_qty' => $value->sd_qty,
                'sm_qty_used' => 0,
                'sm_qty_sisa' => $value->sd_qty,
                'sm_qty_expired' => 0,
                'sm_detail' => 'DI TERIMA',
                'sm_reff' => $nota->s_note,
                'sm_insert' => Carbon::now()
              ]);

            }else{

              $hasil = $cek->s_qty + $value->sd_qty;
              $cek->update([
                's_qty'     => $hasil
              ]);

              $sm_detailid = d_stock_mutation::select('sm_detailid')
                ->where('sm_item',$value->sd_item)
                ->where('sm_comp','4')
                ->where('sm_position','4')
                ->max('sm_detailid')+1;

              d_stock_mutation::create([
                'sm_stock' => $cek->s_id,
                'sm_detailid' => $sm_detailid,
                'sm_date' => Carbon::now(),
                'sm_comp' => 4,
                'sm_position' => 4,
                'sm_mutcat' => 1,
                'sm_item' => $value->sd_item,
                'sm_qty' => $value->sd_qty,
                'sm_qty_used' => 0,
                'sm_qty_sisa' => $value->sd_qty,
                'sm_qty_expired' => 0,
                'sm_detail' => 'DI TERIMA',
                'sm_reff' => $nota->s_note,
                'sm_insert' => Carbon::now()
              ]);

            }

          }
        }

        if($request->status == 'RC'  && $request->oldStatus == 'SN'){
          foreach ($salesDt as $value) {
            // dd($request->all());

            $maxid = DB::Table('d_stock')->select('s_id')->max('s_id')+1;

            if(mutasi::mutasiStok(  $value->sd_item,
                                    $value->sd_qty,
                                    $comp=4,
                                    $position=5,
                                    $flag=1,
                                    $nota->s_note)){}

            $cek = d_stock::select('s_id','s_qty')
              ->where('s_item',$value->sd_item)
              ->where('s_comp','4')
              ->where('s_position','4')
              ->first();


            if ($cek == null) {
              d_stock::insert([
                's_id'      => $maxid,
                's_comp'    => 4,
                's_position'=> 4,
                's_item'    => $value->sd_item,
                's_qty'     => $value->sd_qty,
                's_insert'  => Carbon::now(),
                's_update'  => Carbon::now()
              ]);

              d_stock_mutation::create([
                'sm_stock' => $maxid,
                'sm_detailid' =>1,
                'sm_date' => Carbon::now(),
                'sm_comp' => 4,
                'sm_position' => 4,
                'sm_mutcat' => 1,
                'sm_item' => $value->sd_item,
                'sm_qty' => $value->sd_qty,
                'sm_qty_used' => 0,
                'sm_qty_sisa' => $value->sd_qty,
                'sm_qty_expired' => 0,
                'sm_detail' => 'DI TERIMA',
                'sm_reff' => $nota->s_note,
                'sm_insert' => Carbon::now()
              ]);

            }else{

              $hasil = $cek->s_qty + $value->sd_qty;
              $cek->update([
                's_qty'     => $hasil
              ]);

              $sm_detailid = d_stock_mutation::select('sm_detailid')
                ->where('sm_item',$value->sd_item)
                ->where('sm_comp','4')
                ->where('sm_position','4')
                ->max('sm_detailid')+1;

              d_stock_mutation::create([
                'sm_stock' => $cek->s_id,
                'sm_detailid' => $sm_detailid,
                'sm_date' => Carbon::now(),
                'sm_comp' => 4,
                'sm_position' => 4,
                'sm_mutcat' => 1,
                'sm_item' => $value->sd_item,
                'sm_qty' => $value->sd_qty,
                'sm_qty_used' => 0,
                'sm_qty_sisa' => $value->sd_qty,
                'sm_qty_expired' => 0,
                'sm_detail' => 'DI TERIMA',
                'sm_reff' => $nota->s_note,
                'sm_insert' => Carbon::now()
              ]);

            }
          }
        }
        if($request->status == 'RC'  && $request->oldStatus == 'PC'){
          foreach ($salesDt as $value) {
            // dd($request->all());
            $maxid = DB::Table('d_stock')->select('s_id')->max('s_id')+1;

            if(mutasi::mutasiStok(  $value->sd_item,
                                    $value->sd_qty,
                                    $comp=4,
                                    $position=2,
                                    $flag=1,
                                    $nota->s_note)){}

            $cek = d_stock::select('s_id','s_qty')
              ->where('s_item',$value->sd_item)
              ->where('s_comp','4')
              ->where('s_position','4')
              ->first();


            if ($cek == null) {
              d_stock::insert([
                's_id'      => $maxid,
                's_comp'    => 4,
                's_position'=> 4,
                's_item'    => $value->sd_item,
                's_qty'     => $value->sd_qty,
                's_insert'  => Carbon::now(),
                's_update'  => Carbon::now()
              ]);

              d_stock_mutation::create([
                'sm_stock' => $maxid,
                'sm_detailid' =>1,
                'sm_date' => Carbon::now(),
                'sm_comp' => 4,
                'sm_position' => 4,
                'sm_mutcat' => 1,
                'sm_item' => $value->sd_item,
                'sm_qty' => $value->sd_qty,
                'sm_qty_used' => 0,
                'sm_qty_sisa' => $value->sd_qty,
                'sm_qty_expired' => 0,
                'sm_detail' => 'DI TERIMA',
                'sm_reff' => $nota->s_note,
                'sm_insert' => Carbon::now()
              ]);

            }else{

              $hasil = $cek->s_qty + $value->sd_qty;
              $cek->update([
                's_qty'     => $hasil
              ]);

              $sm_detailid = d_stock_mutation::select('sm_detailid')
                ->where('sm_item',$value->sd_item)
                ->where('sm_comp','4')
                ->where('sm_position','4')
                ->max('sm_detailid')+1;

              d_stock_mutation::create([
                'sm_stock' => $cek->s_id,
                'sm_detailid' => $sm_detailid,
                'sm_date' => Carbon::now(),
                'sm_comp' => 4,
                'sm_position' => 4,
                'sm_mutcat' => 1,
                'sm_item' => $value->sd_item,
                'sm_qty' => $value->sd_qty,
                'sm_qty_used' => 0,
                'sm_qty_sisa' => $value->sd_qty,
                'sm_qty_expired' => 0,
                'sm_detail' => 'DI TERIMA',
                'sm_reff' => $nota->s_note,
                'sm_insert' => Carbon::now()
              ]);

            }

          }
        }

      }
      DB::commit();
      } catch (Exception $e) {
    DB::rollback();
    return response()->json([
        'status' => 'gagal',
        'data' => $e
        ]);
      }

      $customer = DB::table('m_customer')->where('c_id', $sales->s_customer)->first();
      $cust = ($customer) ? $customer->c_name : 'Tidak Diketahui';
      $jurnal = DB::table('d_jurnal')
                    ->where('jurnal_ref', $sales->s_note)
                    ->where('keterangan', 'like', 'Penjualan Tamma Atas%')->first();

      // return json_encode($jurnal);

      if(!$jurnal && jurnal_setting()->allow_jurnal_to_execute){
        // return 'blabla';
        $state_jurnal = _initiateJournal_self_detail($sales->s_note, 'MM', date('Y-m-d'), 'Penjualan Tamma Atas '.$cust.' '.date('d/m/Y', strtotime($sales->s_date)), array_merge($akun));

        $state_jurnal = _initiateJournal_self_detail($sales->s_note, 'MM', date('Y-m-d'), 'Harga Pokok Penjualan Atas '.$cust.' '.date('d/m/Y', strtotime($sales->s_date)), array_merge($akun_beban, $akun_persediaan));
      }

      return response()->json([
          'status' => 'sukses',
          'nota' => $sales
        ]);
  }

  public function print($id){
    $sales = d_sales::select( 'c_name',
                              'c_address',
                              's_date',
                              's_note',
                              's_ongkir')
      ->join('m_customer','c_id','=','s_customer')
      ->where('s_id',$id)
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
      ->where('sd_sales',$id)->get()->toArray();

      $data = array_chunk($data_chunk, 12);
      // return $chunk;
      // return $data;

      $dataTotal = d_sales_dt::select(DB::raw('SUM(sd_total) as total'))
      ->join('m_item','i_id','=','sd_item')
      ->where('sd_sales',$id)->get();



      return view('penjualan.POSgrosir.print_faktur', compact('data', 'dataTotal', 'sales'));
  }

    public function print_pdf($id){
    $sales = d_sales::select( 'c_name',
                              'c_address',
                              's_date',
                              's_note')
      ->join('m_customer','c_id','=','s_customer')
      ->where('s_id',$id)
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
      ->where('sd_sales',$id)->get()->toArray();

      $data = array_chunk($data_chunk, 12);
      // return $chunk;
      // return $data;

      $dataTotal = d_sales_dt::select(DB::raw('SUM(sd_total) as total'))
      ->join('m_item','i_id','=','sd_item')
      ->where('sd_sales',$id)->get();

      $tgl = Carbon::now();

      $pdf = PDF::loadView('penjualan.POSgrosir.print_faktur_pdf', compact('data', 'dataTotal', 'sales'));
      return $pdf->download('faktur_grosir_'.$tgl.'.pdf');
      // return view('penjualan.POSgrosir.print_faktur', compact('data', 'dataTotal', 'sales'));
  }

  public function suratjalan(){
    return view('penjualan.POSgrosir.suratjalan');
  }

  public function lpacking(){
    return view('penjualan.POSgrosir.lpacking');
  }
  public function print_surat_jalan($id){
    $sales = d_sales::select( 'c_name',
                              'c_address',
                              's_date',
                              's_note')
      ->join('m_customer','c_id','=','s_customer')
      ->where('s_id',$id)
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
      ->join('m_satuan','m_satuan.m_sid','=','m_item.i_sat1')
      ->where('sd_sales',$id)->get()->toArray();

      $data = array_chunk($data_chunk, 12);

      $dataTotal = d_sales_dt::select(DB::raw('SUM(sd_qty) as total'))
      ->where('sd_sales',$id)->get();


      return view('penjualan.POSgrosir.print_surat_jalan', compact('data', 'dataTotal', 'sales'));
  }

  public function print_awas_barang_panas($id){
    $sales = d_sales::select( 'c_name',
                              'c_address',
                              'c_hp1',
                              'c_hp2')
      ->join('m_customer','c_id','=','s_customer')
      ->where('s_id',$id)
      ->first();


      return view('penjualan.POSretail.print_awas_barang_panas', compact('sales'));
  }

  public function printDP($id){
    $sales = d_sales::select( 'c_name',
                              'c_address',
                              's_date',
                              's_note',
                              'sp_nominal')
      ->join('m_customer','c_id','=','s_customer')
      ->join('d_sales_payment','sp_sales','=','s_id')
      ->where('s_id',$id)
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
      ->where('sd_sales',$id)->get()->toArray();

      $data = array_chunk($data_chunk, 12);
      // return $chunk;
      // return $data;

      $dataTotal = d_sales_dt::select(DB::raw('SUM(sd_total) as total'))
      ->join('m_item','i_id','=','sd_item')
      ->where('sd_sales',$id)->get();



      return view('penjualan.POSgrosir.printDp', compact('data', 'dataTotal', 'sales'));
  }

  public function setGroupPrice($id, $item){
    $cekGroup = m_customer::select('c_group')
      ->where('c_id',$id)
      ->first();
    
    if ($cekGroup->c_group == null) 
    {
      return Response::json('kosong');
    }
    else
    {
      $cekHarga = m_item_price::select('ip_price')
        ->where('ip_group',$cekGroup->c_group)
        ->where('ip_item',$item)
        ->first();
        if ($cekHarga == null) 
        {
          return Response::json('kosong');
        }
        else
        {
          return Response::json($cekHarga->ip_price);
        }

    }
  }

  public function setPaguCus($idCus)
  {
    $pagu = m_customer::select('c_pagu')
      ->where('c_id',$idCus)
      ->first();

    $cariSisa = d_sales::select('s_sisa')
      ->where('s_customer',$idCus)
      ->where('s_sisa','!=','0.00')
      ->get();
    $totalSisa = 0;
    for ($i=0; $i <count($cariSisa) ; $i++) 
    { 
      
      $totalSisa += $cariSisa[$i]->s_sisa;
    }
    $sisaPagu = $pagu->c_pagu - $totalSisa;
    $gabung = [
       $pagu->c_pagu,
       $sisaPagu
    ];

      return Response::json($gabung);
  }

  public function getPagu($tgl1, $tgl2)
  {
    $y = substr($tgl1, -4);
    $m = substr($tgl1, -7,-5);
    $d = substr($tgl1,0,2);
    $tgll = $y.'-'.$m.'-'.$d;

    $y2 = substr($tgl2, -4);
    $m2 = substr($tgl2, -7,-5);
    $d2 = substr($tgl2,0,2);
    $tgl2 = $y2.'-'.$m2.'-'.$d2;
      $detalis = DB::table('d_sales')
        ->join('m_customer','m_customer.c_id','=','d_sales.s_customer')
        ->where('s_channel','GR')
        ->where(function ($query) {
            $query->where('s_status','FPN')
                  ->orWhere('s_status','PPN');
        })
        ->where('s_date','>=',$tgll)
        ->where('s_date','<=',$tgl2)
        ->get();

    return DataTables::of($detalis)
      ->addIndexColumn()
      ->editColumn('sDate', function ($data)
      {
          return date('d M Y', strtotime($data->s_date));
      })
      ->editColumn('sGross', function ($data)
        {
            return '<div>Rp.
                      <span class="pull-right">
                        '.number_format( $data->s_net ,2,',','.').'
                      </span>
                    </div>';
        })
      ->editColumn('status', function ($data)
      {
          if ($data->s_status == "FPN") 
          { 
            return '<span class="label label-default">Final Pending</span>'; 
          }
          elseif ($data->s_status == "PPN") 
          { 
            return '<span class="label label-primary">Progress Pending</span>'; 
          }
      })
      ->addColumn('action', function($data)
      {
          return '<div class="text-center">
                    <button type="button"
                      class="btn btn-success fa fa-check-square"
                      title="Konfirmasi"
                      onclick="konfirmPagu('."'".$data->s_id."'".')"
                    </button>

                  </div>';
      })
      //inisisai column status agar kode html digenerate ketika ditampilkan
      ->rawColumns(['action','sGross','status'])
      ->make(true);
  }

  public function appPagu($id)
  {
    $cek = d_sales::select('s_status')
      ->where('s_id',$id)
      ->first();

    if ($cek->s_status == "FPN") 
    {
      d_sales::where('s_id',$id)
        ->update([
          's_status' => 'FN'
        ]);
    }
    else
    {
      d_sales::where('s_id',$id)
        ->update([
          's_status' => 'PR'
        ]);
    }
  }
}
