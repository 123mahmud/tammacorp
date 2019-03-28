<?php

namespace App\Http\Controllers\Inventory;

use App\m_item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Response;
use App\Http\Requests;
use App\d_gudangcabang;
use App\d_stock;
use App\d_opname;
use App\d_stock_mutation;
use App\d_opnamedt;
use App\lib\mutasi;
use Auth;
use DataTables;
use URL;

class stockOpnameController extends Controller
{
    public function index()
    {
        $data = d_gudangcabang::
          where(function($q) {
              $q->where('cg_gudang', '!=','GC')
                ->where('cg_gudang', '!=','GS')
                ->where('cg_gudang', '!=','GJ');
          })
          ->get();
        $staff['nama'] = Auth::user()->m_name;
        $staff['id'] = Auth::User()->m_id;

        return view('inventory.stockopname.index', compact('data','staff'));
    }

    public function tableOpname(Request $request, $comp, $position)
    {
      $term = $request->term;
      $results = array();
      $queries = d_stock::
        select('i_id',
               'i_code',
               'i_name',
               'm_sname',
               's_qty',
               'm_sid')
        ->where('m_item.i_name', 'LIKE', '%'.$term.'%')
        ->where('s_comp',$comp)
        ->where('s_comp',$position)
        ->where('i_isactive','TRUE')
        ->join('m_item','i_id','=','s_item')
        ->join('m_satuan','m_sid','=','i_sat1')
        ->orderBy('i_name', 'asc')
        ->take(25)->get();

      if ($queries == null) {
        $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
      } else {
        foreach ($queries as $query)
        {
          $results[] = [  'id' => $query->i_id,
                          'label' => $query->i_code .' - '.$query->i_name,
                          'i_code' => $query->i_code,
                          'i_name' => $query->i_name,
                          's_qtykw' => number_format($query->s_qty,2,'.',','),
                          's_qty' => $query->s_qty,
                          'm_sname' => $query->m_sname,
                          'm_sid' => $query->m_sid,
                      ];
        }
      }

    return Response::json($results);

    }


   public function history($tgl1, $tgl2, $jenis, $gudang){
      $y = substr($tgl1, -4);
      $m = substr($tgl1, -7,-5);
      $d = substr($tgl1,0,2);
       $tgll = $y.'-'.$m.'-'.$d;

      $y2 = substr($tgl2, -4);
      $m2 = substr($tgl2, -7,-5);
      $d2 = substr($tgl2,0,2);
        $tgl2 = $y2.'-'.$m2.'-'.$d2;
        $tgl2 = date('Y-m-d',strtotime($tgl2 . "+1 days"));

      $opname = d_opname::select(
            'o_id',
            'o_insert',
            'o_nota',
            'u1.cg_cabang as comp',
            'o_confirm',
            'o_status',
            'm_username')
        ->join('d_gudangcabang as u1', 'd_opname.o_comp', '=', 'u1.cg_id')
        ->join('d_mem','d_mem.m_id','=','d_opname.o_staff')
        ->where('o_insert','>=',$tgll)
        ->where('o_insert','<=',$tgl2)
        ->where('o_status',$jenis)
        ->where('o_comp',$gudang)
        ->get();

      return DataTables::of($opname)
      ->editColumn('date', function ($data) {
        return date('d M Y', strtotime($data->o_insert)).' : '.substr($data->o_insert, 10, 18);;

      })

      ->editColumn('status', function ($data) 
      {
         if ($data->o_status == 'LP') 
         {
            return '<span class="label label-default">Reporting</span>';
         }
         else
         {
            if ($data->o_confirm == "WT") 
            { 
               return '<span class="label label-default">Waiting</span>'; 
            }
            else if ($data->o_confirm == "AP") 
            { 
               return '<span class="label label-primary">Aprrove</span>'; 
            }
            else if ($data->o_confirm == "CL") 
            {
               return '<span class="label label-info">Final</span>'; 
            }
         }
         
      })

      ->addColumn('action', function($data)
      {
         if ($data->o_status == "LP")
         {
            return  '<div class="text-center">
                    <button type="button"
                        style="margin-left:5px;" 
                        class="btn btn-info fa fa-folder-open-o"
                        title="Detail"
                        type="button"
                        data-toggle="modal"
                        data-target="#myModalView"
                        onclick="OpnameDet('."'".$data->o_id."'".')"
                    </button>
                    <button type="button"
                        style="margin-left:5px;" 
                        class="btn btn-warning fa fa-pencil-square-o"
                        title="Edit"
                        type="button"
                        onclick="EditOpname('."'".$data->o_id."'".')"
                    </button>
                    <button type="button"
                        style="margin-left:5px;" 
                        class="btn btn-danger fa fa-trash-o"
                        title="Hapus"
                        type="button"
                        onclick="deleteOp('."'".$data->o_id."'".')"
                    </button>
                </div>';
         }
         else if (($data->o_status == "MS"))
         {
            if ($data->o_confirm == "WT") 
            {
               return  '<div class="text-center">
                    <button type="button"
                        style="margin-left:5px;" 
                        class="btn btn-info fa fa-folder-open-o"
                        title="Detail"
                        type="button"
                        data-toggle="modal"
                        data-target="#myModalView"
                        onclick="OpnameDet('."'".$data->o_id."'".')"
                    </button>
                    <button type="button"
                        style="margin-left:5px;" 
                        class="btn btn-warning fa fa-pencil-square-o"
                        title="Edit"
                        type="button"
                        onclick="EditOpname('."'".$data->o_id."'".')"
                    </button>
                    <button type="button"
                        style="margin-left:5px;" 
                        class="btn btn-danger fa fa-trash-o"
                        title="Hapus"
                        type="button"
                        onclick="deleteOp('."'".$data->o_id."'".')"
                    </button>
                </div>';
            }
            else if ($data->o_confirm == "AP") 
            {
               return  '<div class="text-center">
                    <button type="button"
                        style="margin-left:5px;" 
                        class="btn btn-info fa fa-folder-open-o"
                        title="Detail"
                        type="button"
                        data-toggle="modal"
                        data-target="#myModalView"
                        onclick="OpnameDet('."'".$data->o_id."'".')"
                    </button>
                    <button type="button"
                        style="margin-left:5px;" 
                        class="btn btn-warning fa fa-pencil-square-o"
                        title="Edit"
                        type="button"
                        onclick="EditOpname('."'".$data->o_id."'".')"
                    </button>
                </div>';
            }
            else if ($data->o_confirm == "CL") 
            {
               return  '<div class="text-center">
                    <button type="button"
                        style="margin-left:5px;" 
                        class="btn btn-info fa fa-folder-open-o"
                        title="Detail"
                        type="button"
                        data-toggle="modal"
                        data-target="#myModalView"
                        onclick="OpnameDet('."'".$data->o_id."'".')"
                    </button>
                </div>';
            }
            
         }
        
      })

      ->rawColumns(['date','action','status'])
      ->make(true);

    }

    public function getOPname(Request $request){
      $data = d_opnamedt::select( 'i_code',
                            'i_type',
                            'i_name',
                            'od_opname',
                            'od_system',
                            'od_opname',
                            'od_real',
                              'm_sname')
        ->where('od_ido',$request->x)
        ->join('m_item','i_id','=','od_item')
        ->join('m_satuan','m_sid','=','od_satuan')
        ->get();

      return view('inventory.stockopname.detail-opname',compact('data'));

    }

   public function print_stockopname($id){
      $data = d_opnamedt::select( 'i_code',
                            'i_type',
                            'i_name',
                            'od_system',
                            'od_real',
                            'od_opname',
                            'm_sname',
                            'o_nota',
                            'u1.cg_cabang as comp',
                            'm_name')
        ->where('od_ido',$id)
        ->join('d_opname','d_opname.o_id','=','od_ido')
        ->join('d_gudangcabang as u1', 'd_opname.o_comp', '=', 'u1.cg_id')
        ->join('m_item','i_id','=','od_item')
        ->join('m_satuan','m_sid','=','i_sat1')
        ->join('d_mem','d_mem.m_id','=','o_staff')
        ->get();
        // dd($data);
      return view('inventory.stockopname.print_stockopname',compact('data'));
   }

   public function saveOpnameLaporan(Request $request)
   {
      DB::beginTransaction();
      try {
         $o_id = d_opname::max('o_id') + 1;
         //nota
         $year = carbon::now()->format('y');
         $month = carbon::now()->format('m');
         $date = carbon::now()->format('d');
         $nota = 'OD'  . $year . $month . $date . $o_id;
         //end Nota
         d_opname::insert([
             'o_id' => $o_id,
             'o_nota' => $nota,
             'o_staff' => $request->o_staff,
             'o_comp' => $request->o_comp,
             'o_status' => 'LP',
             'o_insert' => Carbon::now()
         ]);

         for ($i=0; $i < count($request->i_id); $i++) 
         {
            d_opnamedt::insert([
               'od_ido' => $o_id,
               'od_idodt' => $i+1,
               'od_item' => $request->i_id[$i],
               'od_system' => str_replace(",","",$request->qty[$i]),
               'od_real' => str_replace(",","",$request->real[$i]),
               'od_opname' => str_replace(",","",$request->opname[$i]),
               'od_satuan' => $request->satuan_id[$i]
            ]);
         }

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

   public function hapusLapOpname($id)
   {
      DB::beginTransaction();
      try {
         $nota = d_opname::select('o_nota')->where('o_id',$id)->first();
         $o_id = d_opname::where('o_id',$id)->delete();

         DB::commit();
         return response()->json([
                'status' => 'sukses',
                'nota' => $nota->o_nota
            ]);
         } catch (\Exception $e) {
         DB::rollback();
         return response()->json([
              'status' => 'gagal',
              'data' => $e
            ]);
         }
   }

   public function editLaporan($id)
   {
      $dataIsi = d_opname::select('o_nota',
                                 'o_id',
                                 'i_id',
                                 'i_code',
                                 'i_name',
                                 'i_sat1',
                                 'cg_id',
                                 'cg_cabang',
                                 'od_real',
                                 'm_sname',
                                 'o_confirm'
                                 )
         ->join('d_opnamedt','d_opnamedt.od_ido','=','d_opname.o_id')
         ->join('m_item','m_item.i_id','=','d_opnamedt.od_item')
         ->join('d_gudangcabang','d_gudangcabang.cg_id','=','d_opname.o_comp')
         ->join('m_satuan','m_satuan.m_sid','=','m_item.i_sat1')
         ->where('o_id',$id)
         ->get();

      foreach ($dataIsi as $val) 
      {
          //cek item type
          $itemType[] = DB::table('m_item')->select('i_type', 'i_id')->where('i_id','=', $val['i_id'])->first();
          //get satuan utama
          $sat1[] = $val['i_sat1'];
      }
      // dd($dataIsi);

      $counter = 0;
      $gudang = $dataIsi[0]->cg_id;

      $dataStok = $this->getStokByType($itemType, $sat1, $counter, $gudang);
      $staff['nama'] = Auth::user()->m_name;
      $staff['id'] = Auth::User()->m_id;
      $dataItem = array(   'data_isi' => $dataIsi, 
                           'data_stok' => $dataStok['val_stok'], 
                           'data_satuan' => $dataStok['txt_satuan']
                  );
      // dd($dataStokQty);
      return view('inventory.stockopname.edit-daftar-laporan', compact('dataIsi','dataItem','staff'));
   }

   public function getStokByType($arrItemType, $arrSatuan, $counter, $gudang)
   {
      foreach ($arrItemType as $val) 
      {
         if ($val->i_type == "BJ") //brg jual
         {
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '$gudang' AND s_position = '$gudang' limit 1) ,'0') as qtyStok"));
            $satUtama = DB::table('m_item')
               ->select('m_satuan.m_sname')
               ->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')
               ->where('m_item.i_sat1', '=', $arrSatuan[$counter])
               ->first();

            $stok[] = $query[0];
            $satuan[] = $satUtama->m_sname;
            $counter++;
         }
         elseif ($val->i_type == "BB") //bahan baku
         {
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '$gudang' AND s_position = '$gudang' limit 1) ,'0') as qtyStok"));
            $satUtama = DB::table('m_item')->select('m_satuan.m_sname')
               ->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')
               ->where('m_item.i_sat1', '=', $arrSatuan[$counter])
               ->first();

            $stok[] = $query[0];
            $satuan[] = $satUtama->m_sname;
            $counter++;
         }
      }

      $data = array('val_stok' => $stok, 'txt_satuan' => $satuan);
      return $data;
   }

   function updateStock(Request $request, $id)
   {
      // dd($request->all());
      DB::beginTransaction();
        try {
      $total_opname = 0;
      $akun_first = [];
      $err = true;
      d_opname::where('o_id',$id)
         ->update([
          'o_staff' => $request->o_staff,
          'o_status' => 'MS',
          'o_confirm' => 'CL',
          'o_update' => Carbon::now()
      ]);

      d_opnamedt::where('od_ido',$id)->delete();

      for ($i=0; $i < count($request->i_id); $i++) {

          $total_opname += str_replace(",","",$request->opname[$i]);

          $cek = DB::table('m_item')
                ->join('m_group', 'm_group.m_gcode', '=', 'm_item.i_code_group')
                ->join('m_price', 'm_price.m_pitem', '=', 'm_item.i_id')
                ->where('i_id', $request->i_id[$i])
                ->select('m_group.m_akun_penjualan', 'm_group.m_akun_persediaan', 'm_group.m_akun_beban', 'm_group.m_gid', 'm_price.m_hpp')
                ->first();

          $cek2 = DB::table('d_akun')->where('id_akun', $cek->m_akun_persediaan)->first();

          // return json_encode($cek2);

          if(!$cek || !$cek->m_akun_persediaan || !$cek2){
              $err = false;
          }else{
              if(array_key_exists($cek->m_akun_persediaan, $akun_first)){
                  $akun_first[$cek->m_akun_persediaan] = [
                      'td_acc'    => $cek->m_akun_persediaan,
                      'value'     => $akun_first[$cek->m_akun_persediaan]['value'] + (str_replace(",","",$request->opname[$i]) * $cek->m_hpp)
                  ];
              }else{
                  $akun_first[$cek->m_akun_persediaan] = [
                      'td_acc'    => $cek->m_akun_persediaan,
                      'value'     => (str_replace(",","",$request->opname[$i]) * $cek->m_hpp)
                  ];
              }
          }

          d_opnamedt::insert([
            'od_ido' => $id,
            'od_idodt' => $i+1,
            'od_item' => $request->i_id[$i],
            'od_system' => str_replace(",","",$request->qty[$i]),
            'od_real' => str_replace(",","",$request->real[$i]),
            'od_opname' => str_replace(",","",$request->opname[$i]),
            'od_satuan' => $request->satuan_id[$i],
          ]);

          $cek = d_stock::select('s_id','s_qty')
                ->where('s_item', $request->i_id[$i])
                ->where('s_comp', $request->o_comp)
                ->where('s_position', $request->o_comp)
                ->first();

          $hasil = $cek->s_qty + str_replace(",","",$request->opname[$i]);
          // dd($hasil);
          $sm_detailid = d_stock_mutation::select('sm_detailid')
            ->where('sm_item', $request->i_id[$i])
            ->where('sm_comp', $request->o_comp)
            ->where('sm_position', $request->o_comp)
            ->max('sm_detailid')+1;

          if ( str_replace(",","",$request->opname[$i]) <= 0) {//+
            if(mutasi::mutasiStok(  $request->i_id[$i],
                                    - str_replace(",","",$request->opname[$i]),
                                    $comp=$request->o_comp,
                                    $position=$request->o_comp,
                                    $flag=7,
                                    $request->o_nota)){}
          } else {//-
            $cek->update([
              's_qty' => $hasil
            ]);
            dd($hasil);
            d_stock_mutation::create([
              'sm_stock' => $cek->s_id,
              'sm_detailid' => $sm_detailid,
              'sm_date' => Carbon::now(),
              'sm_comp' => $request->o_comp,
              'sm_position' => $request->o_comp,
              'sm_mutcat' => 7,
              'sm_item' => $request->i_id[$i],
              'sm_qty' => str_replace(",","",$request->opname[$i]),
              'sm_qty_used' => 0,
              'sm_qty_sisa' => str_replace(",","",$request->opname[$i]),
              'sm_qty_expired' => 0,
              'sm_detail' => 'PENAMBAHAN',
              'sm_reff' => $request->o_nota,
              'sm_insert' => Carbon::now()
            ]);
          }
      }

      if(!$err){
          return response()->json([
              'status' => 'gagal',
              'pesan'  => 'Tidak Bisa Melakukan Jurnal Pada Penerimaan Ini Karena Salah Satu Dari Item Belum Berelasi Dengan Akun Penjualan.'
          ]);
      }

      $akun = []; $selisih = 0;

      foreach ($akun_first as $key => $data) {

          $akun[$key] = [
              'td_acc'    => $data['td_acc'],
              'td_posisi' => ($data['value'] < 0) ? 'K' : 'D',
              'value'     => str_replace('-', '', $data['value'])
          ];

          $selisih += $data['value'];

      }

      $akun['551.12'] = [
          'td_acc'    => '551.12',
          'td_posisi' => ($selisih < 0) ? 'D' : 'K',
          'value'     => str_replace('-', '', $selisih)
      ];

      DB::commit();
      
      } catch (\Exception $e) {
      DB::rollback();
      return response()->json([
        'status' => 'gagal',
        'data' => $e
        ]);
      }

      // return json_encode($o_id);

      $jurnal = DB::table('d_jurnal')
                    ->where('jurnal_ref', $id)
                    ->where('keterangan', 'like', 'Stok Opname%')->first();

      if(!$jurnal && jurnal_setting()->allow_jurnal_to_execute){
        $state_jurnal = _initiateJournal_self_detail("opname-".$id, 'MM', date('Y-m-d'), 'Stok Opname Tanggal '.date('d/m/Y'), array_merge($akun));
      }

      return response()->json([
          'status' => 'sukses',
          'nota' => $request->o_nota
        ]);
   }

   function updateOpname(Request $request, $id)
   {
      DB::beginTransaction();
         try {
         $total_opname = 0;
         $akun_first = [];
         $err = true;
         d_opname::where('o_id',$id)
            ->update([
             'o_staff' => $request->o_staff,
             'o_update' => Carbon::now()
         ]);

         d_opnamedt::where('od_ido',$id)->delete();

         for ($i=0; $i < count($request->i_id); $i++) 
         {
             d_opnamedt::insert([
               'od_ido' => $id,
               'od_idodt' => $i+1,
               'od_item' => $request->i_id[$i],
               'od_system' => str_replace(",","",$request->qty[$i]),
               'od_real' => str_replace(",","",$request->real[$i]),
               'od_opname' => str_replace(",","",$request->opname[$i]),
               'od_satuan' => $request->satuan_id[$i],
             ]);
         }

      DB::commit();
      return response()->json([
             'status' => 'sukses',
             'nota' => $request->o_nota
         ]);
      } catch (\Exception $e) {
      DB::rollback();
      return response()->json([
           'status' => 'gagal',
           'data' => $e
         ]);
      }
   }

   function simpanPengajuan(Request $request)
   {
      DB::beginTransaction();
      try {
         $o_id = d_opname::max('o_id') + 1;
         //nota
         $year = carbon::now()->format('y');
         $month = carbon::now()->format('m');
         $date = carbon::now()->format('d');
         $nota = 'OD'  . $year . $month . $date . $o_id;
         //end Nota
         d_opname::insert([
             'o_id' => $o_id,
             'o_nota' => $nota,
             'o_staff' => $request->o_staff,
             'o_comp' => $request->o_comp,
             'o_status' => 'MS',
             'o_insert' => Carbon::now()
         ]);

         for ($i=0; $i < count($request->i_id); $i++) 
         {
            d_opnamedt::insert([
               'od_ido' => $o_id,
               'od_idodt' => $i+1,
               'od_item' => $request->i_id[$i],
               'od_system' => str_replace(",","",$request->qty[$i]),
               'od_real' => str_replace(",","",$request->real[$i]),
               'od_opname' => str_replace(",","",$request->opname[$i]),
               'od_satuan' => $request->satuan_id[$i]
            ]);
         }

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

   public function tableConfirm($tgl1, $tgl2, $gudang)
   {
      $y = substr($tgl1, -4);
      $m = substr($tgl1, -7,-5);
      $d = substr($tgl1,0,2);
       $tgll = $y.'-'.$m.'-'.$d;

      $y2 = substr($tgl2, -4);
      $m2 = substr($tgl2, -7,-5);
      $d2 = substr($tgl2,0,2);
        $tgl2 = $y2.'-'.$m2.'-'.$d2;
        $tgl2 = date('Y-m-d',strtotime($tgl2 . "+1 days"));

      $opname = d_opname::select(
            'o_id',
            'o_insert',
            'o_nota',
            'u1.cg_cabang as comp',
            'o_confirm',
            'o_status',
            'm_username')
        ->join('d_gudangcabang as u1', 'd_opname.o_comp', '=', 'u1.cg_id')
        ->join('d_mem','d_mem.m_id','=','d_opname.o_staff')
        ->where('o_insert','>=',$tgll)
        ->where('o_insert','<=',$tgl2)
        ->where('o_status','MS')
        ->where('o_comp',$gudang)
        ->get();


      return DataTables::of($opname)
      ->editColumn('date', function ($data) {
        return date('d M Y', strtotime($data->o_insert)).' : '.substr($data->o_insert, 10, 18);;

      })

      ->editColumn('status', function ($data) {
         if ($data->o_confirm == "WT") 
         { 
            return '<span class="label label-default">Waiting</span>'; 
         }
         else if ($data->o_confirm == "AP") 
         { 
            return '<span class="label label-primary">Aprrove</span>'; 
         }
         else if ($data->o_confirm == "CL") 
         {
            return '<span class="label label-info">Final</span>'; 
         }
      })

      ->addColumn('action', function($data){
            if ($data->o_confirm == "WT") 
            {
               return  '<div class="text-center">
                    <button type="button"
                        style="margin-left:5px;" 
                        class="btn btn-warning fa fa-pencil-square-o"
                        title="Edit"
                        type="button"
                        data-toggle="modal"
                        data-target="#myModalConfirm"
                        onclick="ubahStatusConfirm('."'".$data->o_id."'".')"
                    </button>
                </div>';
            }
            else if ($data->o_confirm == "AP") 
            {
               return  '<div class="text-center">
                    <button type="button"
                        style="margin-left:5px;" 
                        class="btn btn-warning fa fa-pencil-square-o"
                        title="Edit"
                        type="button"
                        data-toggle="modal"
                        data-target="#myModalConfirm"
                        onclick="ubahStatusConfirm('."'".$data->o_id."'".')"
                    </button>
                </div>';
            }
            else if ($data->o_confirm == "CL") 
            {
               return  '<div class="text-center">
                    <button type="button"
                        style="margin-left:5px;" 
                        class="btn btn-warning fa fa-pencil-square-o"
                        title="Edit"
                        type="button"
                        data-toggle="modal"
                        data-target="#myModalConfirm"
                        onclick="ubahStatusConfirm('."'".$data->o_id."'".')"
                    </button>
                </div>';
            }

      })

      ->rawColumns(['date','action','status'])
      ->make(true);
   }

   public function getConfirm(Request $request)
   {
      $data = d_opnamedt::select( 'i_code',
                                 'i_type',
                                 'i_name',
                                 'od_opname',
                                 'od_system',
                                 'od_opname',
                                 'od_real',
                                 'm_sname')
        ->where('od_ido',$request->x)
        ->join('m_item','i_id','=','od_item')
        ->join('m_satuan','m_sid','=','od_satuan')
        ->get();

      $status = d_opname::select('o_id',
                                 'o_confirm')
         ->where('o_id',$request->x)
         ->first();

      return view('inventory.stockopname.detail-opname-confirm',compact('data','status'));
   }

   public function updateStatusConfirm(Request $request, $id)
   {
      DB::beginTransaction();
         try {
         $data = d_opname::where('o_id',$id)
            ->update([
             'o_confirm' => $request->x,
             'o_update' => Carbon::now()
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

      // function saveOpname(Request $request){
   //    dd($request->all());
   //    // return json_encode($request->all());
   //    DB::beginTransaction();
   //      try {
   //    $o_id = d_opname::max('o_id') + 1;
   //    //nota
   //    $year = carbon::now()->format('y');
   //    $month = carbon::now()->format('m');
   //    $date = carbon::now()->format('d');
   //    $nota = 'OD'  . $year . $month . $date . $o_id;
   //    $total_opname = 0;
   //    $akun_first = [];
   //    $err = true;
   //    //end Nota
   //    d_opname::insert([
   //        'o_id' => $o_id,
   //        'o_nota' => $nota,
   //        'o_staff' => $request->o_staff,
   //        'o_comp' => $request->o_comp,
   //        'o_insert' => Carbon::now()
   //    ]);

   //    for ($i=0; $i < count($request->i_id); $i++) {

   //        $total_opname += $request->opname[$i];

   //        $cek = DB::table('m_item')
   //              ->join('m_group', 'm_group.m_gcode', '=', 'm_item.i_code_group')
   //              ->join('m_price', 'm_price.m_pitem', '=', 'm_item.i_id')
   //              ->where('i_id', $request->i_id[$i])
   //              ->select('m_group.m_akun_penjualan', 'm_group.m_akun_persediaan', 'm_group.m_akun_beban', 'm_group.m_gid', 'm_price.m_hpp')
   //              ->first();

   //        $cek2 = DB::table('d_akun')->where('id_akun', $cek->m_akun_persediaan)->first();

   //        // return json_encode($cek2);

   //        if(!$cek || !$cek->m_akun_persediaan || !$cek2){
   //            $err = false;
   //        }else{
   //            if(array_key_exists($cek->m_akun_persediaan, $akun_first)){
   //                $akun_first[$cek->m_akun_persediaan] = [
   //                    'td_acc'    => $cek->m_akun_persediaan,
   //                    'value'     => $akun_first[$cek->m_akun_persediaan]['value'] + ($request->opname[$i] * $cek->m_hpp)
   //                ];
   //            }else{
   //                $akun_first[$cek->m_akun_persediaan] = [
   //                    'td_acc'    => $cek->m_akun_persediaan,
   //                    'value'     => ($request->opname[$i] * $cek->m_hpp)
   //                ];
   //            }
   //        }

   //        d_opnamedt::insert([
   //          'od_ido' => $o_id,
   //          'od_idodt' => $i+1,
   //          'od_item' => $request->i_id[$i],
   //          'od_opname' => $request->opname[$i]
   //        ]);

   //        $cek = d_stock::select('s_id','s_qty')
   //              ->where('s_item', $request->i_id[$i])
   //              ->where('s_comp', $request->o_comp)
   //              ->where('s_position', $request->o_position)
   //              ->first();

   //        $hasil = $cek->s_qty + $request->opname[$i];

   //        $sm_detailid = d_stock_mutation::select('sm_detailid')
   //          ->where('sm_item', $request->i_id[$i])
   //          ->where('sm_comp', $request->o_comp)
   //          ->where('sm_position', $request->o_position)
   //          ->max('sm_detailid')+1;

   //        if ( $request->opname[$i] <= 0) {//+
   //          if(mutasi::mutasiStok(  $request->i_id[$i],
   //                                  - $request->opname[$i],
   //                                  $comp=$request->o_comp,
   //                                  $position=$request->o_position,
   //                                  $flag=7,
   //                                  $nota)){}
   //        } else {//-
   //          $cek->update([
   //            's_qty' => $hasil
   //          ]);

   //          d_stock_mutation::create([
   //            'sm_stock' => $cek->s_id,
   //            'sm_detailid' => $sm_detailid,
   //            'sm_date' => Carbon::now(),
   //            'sm_comp' => $request->o_comp,
   //            'sm_position' => $request->o_position,
   //            'sm_mutcat' => 7,
   //            'sm_item' => $request->i_id[$i],
   //            'sm_qty' => $request->opname[$i],
   //            'sm_qty_used' => 0,
   //            'sm_qty_sisa' => $request->opname[$i],
   //            'sm_qty_expired' => 0,
   //            'sm_detail' => 'PENAMBAHAN',
   //            'sm_reff' => $nota,
   //            'sm_insert' => Carbon::now()
   //          ]);
   //        }
   //    }

   //    if(!$err){
   //        return response()->json([
   //            'status' => 'gagal',
   //            'pesan'  => 'Tidak Bisa Melakukan Jurnal Pada Penerimaan Ini Karena Salah Satu Dari Item Belum Berelasi Dengan Akun Penjualan.'
   //        ]);
   //    }

   //    $akun = []; $selisih = 0;

   //    foreach ($akun_first as $key => $data) {

   //        $akun[$key] = [
   //            'td_acc'    => $data['td_acc'],
   //            'td_posisi' => ($data['value'] < 0) ? 'K' : 'D',
   //            'value'     => str_replace('-', '', $data['value'])
   //        ];

   //        $selisih += $data['value'];

   //    }

   //    $akun['551.12'] = [
   //        'td_acc'    => '551.12',
   //        'td_posisi' => ($selisih < 0) ? 'D' : 'K',
   //        'value'     => str_replace('-', '', $selisih)
   //    ];

   //    $nota = d_opname::where('o_id',$o_id)
   //        ->first();

   //    DB::commit();
      
   //    } catch (\Exception $e) {
   //    DB::rollback();
   //    return response()->json([
   //      'status' => 'gagal',
   //      'data' => $e
   //      ]);
   //    }

   //    // return json_encode($o_id);

   //    $jurnal = DB::table('d_jurnal')
   //                  ->where('jurnal_ref', $o_id)
   //                  ->where('keterangan', 'like', 'Stok Opname%')->first();

   //    if(!$jurnal && jurnal_setting()->allow_jurnal_to_execute){
   //      $state_jurnal = _initiateJournal_self_detail("opname-".$o_id, 'MM', date('Y-m-d'), 'Stok Opname Tanggal '.date('d/m/Y'), array_merge($akun));
   //    }

   //    return response()->json([
   //        'status' => 'sukses',
   //        'nota' => $nota
   //      ]);
   // }


}
