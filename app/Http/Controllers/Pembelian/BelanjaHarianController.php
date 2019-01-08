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
use App\d_purchasingharian;
use App\d_purchasingharian_dt;

class BelanjaHarianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function belanja()
    {
      $tgl2 = date("d-m-Y");
      $tgl1 = date('d-m-Y', strtotime("-30 day"));

      $y = substr($tgl1, -4);
      $m = substr($tgl1, -7,-5);
      $d = substr($tgl1,0,2);
       $tanggal1 = $y.'-'.$m.'-'.$d;

      $y2 = substr($tgl2, -4);
      $m2 = substr($tgl2, -7,-5);
      $d2 = substr($tgl2,0,2);
      $tanggal2 = $y2.'-'.$m2.'-'.$d2;

      $waiting = d_purchasingharian::join('d_mem','d_purchasingharian.d_pcsh_staff','=','d_mem.m_id')
            ->select('d_purchasingharian.*', 'd_mem.m_name', 'd_mem.m_id')
            ->where('d_pcsh_status','WT')
            ->whereBetween('d_purchasingharian.d_pcsh_date', [$tanggal1, $tanggal2])
            ->count();

      $confirm = d_purchasingharian::join('d_mem','d_purchasingharian.d_pcsh_staff','=','d_mem.m_id')
            ->select('d_purchasingharian.*', 'd_mem.m_name', 'd_mem.m_id')
            ->where('d_pcsh_status','CF')
            ->whereBetween('d_purchasingharian.d_pcsh_date', [$tanggal1, $tanggal2])
            ->count();

      $dapat_edit = d_purchasingharian::join('d_mem','d_purchasingharian.d_pcsh_staff','=','d_mem.m_id')
            ->select('d_purchasingharian.*', 'd_mem.m_name', 'd_mem.m_id')
            ->where('d_pcsh_status','DE')
            ->whereBetween('d_purchasingharian.d_pcsh_date', [$tanggal1, $tanggal2])
            ->count();

      $received = d_purchasingharian::join('d_mem','d_purchasingharian.d_pcsh_staff','=','d_mem.m_id')
            ->select('d_purchasingharian.*', 'd_mem.m_name', 'd_mem.m_id')
            ->where('d_pcsh_status','RC')
            ->whereBetween('d_purchasingharian.d_pcsh_date', [$tanggal1, $tanggal2])
            ->count();

      $revisi = d_purchasingharian::join('d_mem','d_purchasingharian.d_pcsh_staff','=','d_mem.m_id')
            ->select('d_purchasingharian.*', 'd_mem.m_name', 'd_mem.m_id')
            ->where('d_pcsh_status','RV')
            ->whereBetween('d_purchasingharian.d_pcsh_date', [$tanggal1, $tanggal2])
            ->count();

      return view('/purchasing/belanjaharian/index',compact('waiting','confirm','dapat_edit','received','revisi'));
    }

    public function getBelanjaByTglspan($tgl1,$tgl2)
    {
      $y = substr($tgl1, -4);
      $m = substr($tgl1, -7,-5);
      $d = substr($tgl1,0,2);
       $tanggal1 = $y.'-'.$m.'-'.$d;

      $y2 = substr($tgl2, -4);
      $m2 = substr($tgl2, -7,-5);
      $d2 = substr($tgl2,0,2);
      $tanggal2 = $y2.'-'.$m2.'-'.$d2;

      $waiting = d_purchasingharian::join('d_mem','d_purchasingharian.d_pcsh_staff','=','d_mem.m_id')
            ->select('d_purchasingharian.*', 'd_mem.m_name', 'd_mem.m_id')
            ->where('d_pcsh_status','WT')
            ->whereBetween('d_purchasingharian.d_pcsh_date', [$tanggal1, $tanggal2])
            ->count();

      $confirm = d_purchasingharian::join('d_mem','d_purchasingharian.d_pcsh_staff','=','d_mem.m_id')
            ->select('d_purchasingharian.*', 'd_mem.m_name', 'd_mem.m_id')
            ->where('d_pcsh_status','CF')
            ->whereBetween('d_purchasingharian.d_pcsh_date', [$tanggal1, $tanggal2])
            ->count();

      $dapat_edit = d_purchasingharian::join('d_mem','d_purchasingharian.d_pcsh_staff','=','d_mem.m_id')
            ->select('d_purchasingharian.*', 'd_mem.m_name', 'd_mem.m_id')
            ->where('d_pcsh_status','DE')
            ->whereBetween('d_purchasingharian.d_pcsh_date', [$tanggal1, $tanggal2])
            ->count();

      $received = d_purchasingharian::join('d_mem','d_purchasingharian.d_pcsh_staff','=','d_mem.m_id')
            ->select('d_purchasingharian.*', 'd_mem.m_name', 'd_mem.m_id')
            ->where('d_pcsh_status','RC')
            ->whereBetween('d_purchasingharian.d_pcsh_date', [$tanggal1, $tanggal2])
            ->count();

      $revisi = d_purchasingharian::join('d_mem','d_purchasingharian.d_pcsh_staff','=','d_mem.m_id')
            ->select('d_purchasingharian.*', 'd_mem.m_name', 'd_mem.m_id')
            ->where('d_pcsh_status','RV')
            ->whereBetween('d_purchasingharian.d_pcsh_date', [$tanggal1, $tanggal2])
            ->count();

      return response()->json(['waiting'=>$waiting,'confirm'=>$confirm,'dapat_edit'=>$dapat_edit,'received'=>$received,'revisi'=>$revisi]);
    }

    public function tambah_belanja()
    {
      //code order
      $query = DB::select(DB::raw("SELECT MAX(RIGHT(d_pcsh_id,4)) as kode_max from d_purchasingharian WHERE DATE_FORMAT(d_pcsh_date, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));
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

      $codePH = "PH-".date('ym')."-".$kd;
      $staff['nama'] = Auth::user()->m_name;
      $staff['id'] = Auth::User()->m_id;
      return view ('/purchasing/belanjaharian/tambah_belanja',compact('codePH', 'staff'));
    }

    public function autocompleteBarang(Request $request)
    {
      $term = $request->term;
      $results = array();
      $queries = DB::table('m_item')
        ->where('i_name', 'LIKE', '%'.$term.'%')
        ->where('i_type', '=', 'BL')
        ->take(5)->get();
      
      if ($queries == null) 
      {
        $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
      } 
      else 
      {
        foreach ($queries as $val) 
        {
          if ($val->i_type == "BL") //brg lain2
          {
            //ambil stok berdasarkan type barang
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '2' AND s_position = '2' limit 1) ,'0') as qtyStok"));
            $stok = $query[0]->qtyStok;
          }

          //get prev cost
          $idItem = $val->i_id;
          $prevCost = DB::table('d_stock_mutation')
                    // ->select(DB::raw('MAX(sm_hpp) as hargaPrev'))
                    ->select('sm_hpp')
                    ->where('sm_item', '=', $idItem)
                    ->where('sm_mutcat', '=', "15")
                    ->orderBy('sm_date', 'desc')
                    ->limit(1)
                    ->get();

          //dd($prevCost);
          $hargaLalu = "";
          foreach ($prevCost as $value) 
          {
            $hargaLalu = $value->sm_hpp;
          }

          //get data txt satuan
          $txtSat1 = DB::table('m_satuan')->select('m_sname', 'm_sid')->where('m_sid','=', $val->i_sat1)->first();
          $txtSat2 = DB::table('m_satuan')->select('m_sname', 'm_sid')->where('m_sid','=', $val->i_sat2)->first();
          $txtSat3 = DB::table('m_satuan')->select('m_sname', 'm_sid')->where('m_sid','=', $val->i_sat3)->first();

          $results[] = [ 'id' => $val->i_id,
                         'label' => $val->i_code .'  '.$val->i_name,
                         'stok' => $stok,
                         'sat' => [$val->i_sat1, $val->i_sat2, $val->i_sat3],
                         'satTxt' => [$txtSat1->m_sname, $txtSat2->m_sname, $txtSat3->m_sname],
                         'prevCost' => 'Rp. '.number_format((int)$hargaLalu,2,",",".")
                       ];
        }
      }
    
      return Response::json($results);
    }

    public function simpanDataBelanja(Request $request)
    {
      //dd($request->all());
      DB::beginTransaction();
      try {
        //insert to table d_purchasingharian
        $dataHeader = new d_purchasingharian;
        $dataHeader->d_pcsh_code = $request->kodeNota;
        $dataHeader->d_pcsh_date = date('Y-m-d',strtotime($request->tanggalBeli));
        $dataHeader->d_pcsh_peminta = strtoupper($request->divisiPeminta);
        $dataHeader->d_pcsh_keperluan = strtoupper($request->keperluan);
        $dataHeader->d_pcsh_totalprice = $this->konvertRp($request->totalBiaya);
        $dataHeader->d_pcsh_staff = $request->idStaff;
        $dataHeader->d_pcsh_created = Carbon::now();
        $dataHeader->save();
        
        //get last lastId then insert id to d_purchasingharian_dt
        $lastId = d_purchasingharian::select('d_pcsh_id')->max('d_pcsh_id');
        if ($lastId == 0 || $lastId == '') 
        {
          $lastId  = 1;
        }  

        //variabel untuk hitung array field
        $hitung_field = count($request->fieldIpItem);

        //insert data isi
        for ($i=0; $i < $hitung_field; $i++) 
        {
          $dataIsi = new d_purchasingharian_dt;
          $dataIsi->d_pcshdt_pcshid = $lastId;
          $dataIsi->d_pcshdt_item = $request->fieldIpItem[$i];
          $dataIsi->d_pcshdt_sat = $request->fieldIpSatId[$i];
          $dataIsi->d_pcshdt_qty = $request->fieldIpQty[$i];
          $dataIsi->d_pcshdt_price = $this->konvertRp($request->fieldIpHarga[$i]);
          $dataIsi->d_pcshdt_pricetotal = $this->konvertRp($request->fieldIpHargaTot[$i]);
          $dataIsi->d_pcshdt_created = Carbon::now();
          $dataIsi->save();
        } 
        
      DB::commit();
      return response()->json([
            'status' => 'sukses',
            'pesan' => 'Data Belanja Berhasil Disimpan'
        ]);
      } 
      catch (\Exception $e) 
      {
        DB::rollback();
        return response()->json([
            'status' => 'gagal',
            'pesan' => $e
        ]);
      }
    }

    public function simpanDataBarang(Request $request)
    {
      //dd($request->all());
      DB::beginTransaction();
      try 
      {
        $tanggal = date("Y-m-d h:i:s");
        $data_item = DB::table('m_item')
            ->insert([
                'i_code'=>$request->kode_barang,
                'i_type' => $request->typeId,
                'i_code_group'=> $request->code_group,
                'i_name'=> $request->nama,
                'i_sat1'=>$request->satuan1,
                'i_sat_isi1'=> $request->isi_sat1,
                'i_sat2'=>$request->satuan2,
                'i_sat_isi2'=> $request->isi_sat2,
                'i_sat3'=>$request->satuan3,
                'i_sat_isi3'=> $request->isi_sat3,
                'i_det'=>$request->detail,
                'i_insert'=>$tanggal
            ]);

        //-----insert m_price------//
        $get_itemid = DB::table('m_item')->select('i_id')->where('i_code','=', $request->kode_barang)->first();
        $data_price = DB::table('m_price')
            ->insert([
                'm_pitem' => $get_itemid->i_id,
                'm_pbuy1' => str_replace(',', '', $request->hargaBeli1),
                'm_pbuy2' => str_replace(',', '', $request->hargaBeli2),
                'm_pbuy3' => str_replace(',', '', $request->hargaBeli3),
                'm_pcreated' => $tanggal
            ]);

        //-----update/insert d_stock------//
        //cek ada tidaknya record pada tabel
        $rows = DB::table('d_stock')->select('s_id')
                ->where('s_comp', '2')
                ->where('s_position', '2')
                ->where('s_item', $get_itemid->i_id)
                ->exists();
   
        if($rows !== FALSE) //jika terdapat record, maka lakukan update
        {
            //update stok minimum
            $update = DB::table('d_stock')
                ->where('s_comp', '2')
                ->where('s_position', '2')
                ->where('s_item', $get_itemid->i_id)
                ->update(['s_qty_min' => $request->min_stock]);
        }
        else //jika tidak ada record, maka lakukan insert
        {
            //get last id
            $id_stock = DB::table('d_stock')->max('s_id') + 1;
            //insert value ke tbl d_stock
            DB::table('d_stock')->insert([
                's_id' => $id_stock,
                's_comp' => '2',
                's_position' => '2',
                's_item' => $get_itemid->i_id,
                's_qty' => 0,
                's_qty_min' => $request->min_stock,
            ]);
        } 
    
        DB::commit();
        return response()->json([
          'status' => 'sukses',
          'pesan' => 'Data Master Barang Berhasil Disimpan'
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

    public function simpanDataSatuan(Request $request)
    {
      DB::beginTransaction();
      try {
        //insert to table d_supplier
        DB::table('m_satuan')
          ->insert([
            'm_scode' => $request->fkodeSat,
            'm_sname' => strtoupper($request->fnamaSat),
            'm_sdetname' => strtoupper($request->fketeranganSat),
            'm_screate' => Carbon::now()
          ]);
        
      DB::commit();
      return response()->json([
            'status' => 'sukses',
            'pesan' => 'Data Master Satuan Berhasil Ditambahkan'
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

    public function getDetailBelanja($id)
    {
        $dataHeader = d_purchasingharian::join('d_mem','d_purchasingharian.d_pcsh_staff','=','d_mem.m_id')
                ->select('d_purchasingharian.*', 'd_mem.m_name', 'd_mem.m_id')
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

        foreach ($dataHeader as $val) 
        {
            $data = array(
                'hargaTotalBeli' => 'Rp. '.number_format($val->d_pcsh_totalprice,2,",","."),
                'tanggalBeli' => date('Y-m-d',strtotime($val->d_pcsh_date))
            );
        }

        $dataIsi = d_purchasingharian_dt::join('m_item', 'd_purchasingharian_dt.d_pcshdt_item', '=', 'm_item.i_id')
                ->join('m_satuan', 'd_purchasingharian_dt.d_pcshdt_sat', '=', 'm_satuan.m_sid')
                ->select('d_purchasingharian_dt.*', 'm_item.*', 'm_satuan.m_sname', 'm_satuan.m_sid')
                ->where('d_purchasingharian_dt.d_pcshdt_pcshid', '=', $id)
                ->orderBy('d_purchasingharian_dt.d_pcshdt_created', 'DESC')
                ->get();
        
        return response()->json([
            'status' => 'sukses',
            'header' => $dataHeader,
            'header2' => $data,
            'data_isi' => $dataIsi,
            'spanTxt' => $spanTxt,
            'spanClass' => $spanClass,
        ]);
    }

    public function getEditBelanja($id)
    {
      $dataHeader = d_purchasingharian::join('d_mem','d_purchasingharian.d_pcsh_staff','=','d_mem.m_id')
                ->select('d_purchasingharian.*','d_mem.m_id','d_mem.m_name')
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
      elseif ($statusLabel == "CF")
      {
        $spanTxt = 'Di setujui';
        $spanClass = 'label-success';
      }
      else
      {
        $spanTxt = 'Barang telah diterima';
        $spanClass = 'label-success';
      }

      $dataIsi = d_purchasingharian_dt::join('m_item', 'd_purchasingharian_dt.d_pcshdt_item', '=', 'm_item.i_id')
                ->join('m_satuan', 'd_purchasingharian_dt.d_pcshdt_sat', '=', 'm_satuan.m_sid')
                ->select('d_purchasingharian_dt.*', 'm_item.*', 'm_satuan.m_sname', 'm_satuan.m_sid')
                ->where('d_purchasingharian_dt.d_pcshdt_pcshid', '=', $id)
                ->orderBy('d_purchasingharian_dt.d_pcshdt_created', 'DESC')
                ->get();

      $fieldTanggal = date('d-m-Y',strtotime($dataHeader[0]->d_pcsh_date));

      return response()->json([
        'status' => 'sukses',
        'header' => $dataHeader,
        'tanggal' =>$fieldTanggal,
        'data_isi' => $dataIsi,
        'spanTxt' => $spanTxt,
        'spanClass' => $spanClass
      ]);
    }

    public function updateDataBelanja(Request $request)
    {
      //dd($request->all());
      DB::beginTransaction();
      try {
        //update to table d_purchasingharian
        $pharian = d_purchasingharian::find($request->idBelanjaEdit);
        $pharian->d_pcsh_date = date('Y-m-d',strtotime($request->tanggalBeliEdit));
        $pharian->d_pcsh_peminta = strtoupper($request->pemintaEdit);
        $pharian->d_pcsh_keperluan = strtoupper($request->keperluanEdit);
        $pharian->d_pcsh_staff = $request->idStaffEdit;
        $pharian->d_pcsh_totalprice = $this->konvertRp($request->totalBiayaEdit);
        $pharian->d_pcsh_updated = Carbon::now();
        $pharian->save();
        
        //update to table d_purchasingharian_dt
        $hitung_field_edit = count($request->fieldIpIdDetailEdit);
        for ($i=0; $i < $hitung_field_edit; $i++) 
        {
          $phariandt = d_purchasingharian_dt::find($request->fieldIpIdDetailEdit[$i]);
          $phariandt->d_pcshdt_qty = $request->fieldIpQtyEdit[$i];
          $phariandt->d_pcshdt_price = $this->konvertRp($request->fieldIpHargaEdit[$i]);
          $phariandt->d_pcshdt_pricetotal = $this->konvertRp($request->fieldIpHargaTotalEdit[$i]);
          $phariandt->d_pcshdt_updated = Carbon::now();
          $phariandt->save();
        } 
        
      DB::commit();
      return response()->json([
            'status' => 'sukses',
            'pesan' => 'Data Belanja Harian Berhasil Diupdate'
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

    public function deleteDataBelanja(Request $request)
    {
      //dd($request->all());
      DB::beginTransaction();
      try {
        //delete row table d_purchasingharian_dt
        $deleteBelanjaDt = d_purchasingharian_dt::where('d_pcshdt_pcshid', $request->idBeli)->delete();
        //delete row table d_purchasingharian
        $deleteBelanja = d_purchasingharian::where('d_pcsh_id', $request->idBeli)->delete();

        DB::commit();
        return response()->json([
            'status' => 'sukses',
            'pesan' => 'Data Belanja Harian Berhasil Dihapus'
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

    public function getBelanjaByTgl($tgl1, $tgl2)
    {
      $y = substr($tgl1, -4);
      $m = substr($tgl1, -7,-5);
      $d = substr($tgl1,0,2);
       $tanggal1 = $y.'-'.$m.'-'.$d;

      $y2 = substr($tgl2, -4);
      $m2 = substr($tgl2, -7,-5);
      $d2 = substr($tgl2,0,2);
      $tanggal2 = $y2.'-'.$m2.'-'.$d2;
      
      $data = d_purchasingharian::join('d_mem','d_purchasingharian.d_pcsh_staff','=','d_mem.m_id')
            ->select('d_purchasingharian.*', 'd_mem.m_name', 'd_mem.m_id')
            ->whereBetween('d_purchasingharian.d_pcsh_date', [$tanggal1, $tanggal2])
            ->orderBy('d_pcsh_created', 'DESC')
            ->get();

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
      ->editColumn('tglBeli', function ($data) 
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
      ->editColumn('hargaTotal', function ($data) 
      {
        return 'Rp. '.number_format($data->d_pcsh_totalprice,2,",",".");
      })
      ->addColumn('action', function($data)
      {
        if ($data->d_pcsh_status == "WT") 
        {
          return '<div class="text-center">
                      <button class="btn btn-sm btn-success" title="Detail"
                          onclick=detailBeliHarian("'.$data->d_pcsh_id.'")><i class="fa fa-eye"></i> 
                      </button>
                      <button class="btn btn-sm btn-warning" title="Edit"
                          onclick=editBeliHarian("'.$data->d_pcsh_id.'")><i class="glyphicon glyphicon-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" title="Delete"
                          onclick=deleteBeliHarian("'.$data->d_pcsh_id.'")><i class="glyphicon glyphicon-trash"></i>
                      </button>
                  </div>'; 
        }
        elseif ($data->d_pcs_status == "DE") 
        {
          return '<div class="text-center">
                      <button class="btn btn-sm btn-success" title="Detail"
                          onclick=detailBeliHarian("'.$data->d_pcsh_id.'")><i class="fa fa-eye"></i> 
                      </button>
                      <button class="btn btn-sm btn-warning" title="Edit"
                          onclick=editBeliHarian("'.$data->d_pcsh_id.'")><i class="glyphicon glyphicon-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" title="Delete"
                          onclick=deleteBeliHarian("'.$data->d_pcsh_id.'") disabled><i class="glyphicon glyphicon-trash"></i>
                      </button>
                  </div>'; 
        }
        else
        {
          return '<div class="text-center">
                      <button class="btn btn-sm btn-success" title="Detail"
                          onclick=detailBeliHarian("'.$data->d_pcsh_id.'")><i class="fa fa-eye"></i> 
                      </button>
                      <button class="btn btn-sm btn-warning" title="Edit"
                          onclick=editBeliHarian("'.$data->d_pcsh_id.'") disabled><i class="glyphicon glyphicon-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" title="Delete"
                          onclick=deleteBeliHarian("'.$data->d_pcsh_id.'") disabled><i class="glyphicon glyphicon-trash"></i>
                      </button>
                  </div>'; 
        }
        
      })
      ->rawColumns(['status', 'action'])
      ->make(true);
    }

    public function getDataMasterBarang()
    {
      $satuan  = DB::table('m_satuan')->where('m_isactive','TRUE')->get();
      $group  = DB::table('m_group')->where('m_isactive','TRUE')->get();

      return response()->json([
        'status' => 'sukses',
        'satuan' => $satuan,
        'group' => $group
      ]);
    }

    public function getDataKodeSatuan()
    {
      $kode = DB::table('m_satuan')->max('m_sid');
        if ($kode == null) {
          $kode = 1;
        }else{
          $kode +=1;
        }
        $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);
        $nota = 'ST-'.$kode;
        return response()->json([
          'kode' => $nota
        ]);
    }

    public function konvertRp($value)
    {
      $value = str_replace(['Rp', '\\', '.', ' '], '', $value);
      return (int)str_replace(',', '.', $value);
    }

    public function print($id)
    {
      $dataHeader = d_purchasingharian::join('d_mem','d_purchasingharian.d_pcsh_staff','=','d_mem.m_id')
                ->select('d_purchasingharian.*', 'd_mem.m_name', 'd_mem.m_id')
                ->where('d_pcsh_id', '=', $id)
                ->orderBy('d_pcsh_created', 'DESC')
                ->get()->toArray();

      $dataList = d_purchasingharian_dt::join('m_item', 'd_purchasingharian_dt.d_pcshdt_item', '=', 'm_item.i_id')
                ->join('m_satuan', 'd_purchasingharian_dt.d_pcshdt_sat', '=', 'm_satuan.m_sid')
                ->select('d_purchasingharian_dt.*', 'm_item.*', 'm_satuan.m_sname', 'm_satuan.m_sid')
                ->where('d_purchasingharian_dt.d_pcshdt_pcshid', '=', $id)
                ->orderBy('d_purchasingharian_dt.d_pcshdt_created', 'DESC')
                ->get()->toArray();

      $ambilHitungTotal = d_purchasingharian_dt::join('m_item', 'd_purchasingharian_dt.d_pcshdt_item', '=', 'm_item.i_id')
                ->join('m_satuan', 'd_purchasingharian_dt.d_pcshdt_sat', '=', 'm_satuan.m_sid')
                ->select(DB::raw('SUM(d_pcshdt_pricetotal) as total_totalharga'))
                ->where('d_purchasingharian_dt.d_pcshdt_pcshid', '=', $id)
                ->orderBy('d_purchasingharian_dt.d_pcshdt_created', 'DESC')
                ->get();

      $dataIsi = array_chunk($dataList, 7);

      $tanggal = with(new Carbon($dataHeader[0]['d_pcsh_date']))->format('d M Y');

      // return $dataHeader;
      // return $dataIsi;

      foreach ($ambilHitungTotal as $key => $hitungTotal) {
        {{$hitungTotal->total_totalharga;}}
      }

      return view('purchasing/belanjaharian/print', compact('dataHeader', 'dataIsi', 'hitungTotal', 'tanggal'));
    }
}
