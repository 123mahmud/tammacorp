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
use App\d_spk;
use App\spk_formula;

class RencanaBahanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
      return view('purchasing/rencanabahanbaku/bahan');
    }

    public function getRencanaByTgl($tgl1, $tgl2, $tampil)
    {
      $y = substr($tgl1, -4);
      $m = substr($tgl1, -7,-5);
      $d = substr($tgl1,0,2);
       $tanggal1 = $y.'-'.$m.'-'.$d;

      $y2 = substr($tgl2, -4);
      $m2 = substr($tgl2, -7,-5);
      $d2 = substr($tgl2,0,2);
      $tanggal2 = $y2.'-'.$m2.'-'.$d2;

      if ($tampil == 'notyet') 
      {
        $spk_is_po = "FALSE";
      }else 
      {
        $spk_is_po = "TRUE";
      }
      
      $dataHeader = d_spk::join('m_item','d_spk.spk_item','=','m_item.i_id')
                ->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')
                ->select('d_spk.*', 'm_item.i_id', 'm_item.i_name','m_item.i_code', 'm_item.i_sat1')
                ->where('d_spk.spk_status', '=', 'DR')
                ->where('d_spk.spk_ispo', '=', $spk_is_po)
                ->whereBetween('d_spk.spk_date', [$tanggal1, $tanggal2])
                ->orderBy('d_spk.spk_date', 'DESC')
                ->get();
      
      if (count($dataHeader) > 0) 
      {
        foreach ($dataHeader as $val) 
        {
          //cek item type
          $itemType[] = DB::table('m_item')->select('i_type', 'i_id')->where('i_id','=', $val->i_id)->first();
          //get satuan utama
          $sat1[] = $val->i_sat1;
        }

        $counter = 0;
        for ($i=0; $i <count($itemType); $i++) 
        { 
          if ($itemType[$i]->i_type == "BJ") //brg jual
          {
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '".$itemType[$i]->i_id."' AND s_comp = '2' AND s_position = '2' limit 1) ,'0') as qtyStok"));
            $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')->select('m_satuan.m_sname')->where('m_item.i_sat1', '=', $sat1[$counter])->first();

            $data['stok'][$i] = $query[0]->qtyStok;
            $data['satuan'][$i] = $satUtama->m_sname;
            $counter++;
          }
          elseif ($itemType[$i]->i_type == "BB") //bahan baku
          {
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '".$itemType[$i]->i_id."' AND s_comp = '3' AND s_position = '3' limit 1) ,'0') as qtyStok"));
            $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')->select('m_satuan.m_sname')->where('m_item.i_sat1', '=', $sat1[$counter])->first();

            $data['stok'][$i] = $query[0]->qtyStok;
            $data['satuan'][$i] = $satUtama->m_sname;
            $counter++;
          }
          elseif ($itemType[$i]->i_type == "BP") //bahan baku
          {
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '".$itemType[$i]->i_id."' AND s_comp = '6' AND s_position = '6' limit 1) ,'0') as qtyStok"));
            $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')->select('m_satuan.m_sname')->where('m_item.i_sat1', '=', $sat1[$counter])->first();

            $data['stok'][$i] = $query[0]->qtyStok;
            $data['satuan'][$i] = $satUtama->m_sname;
            $counter++;
          }
        }

        for ($j=0; $j < count($dataHeader); $j++) 
        { 
          $dataHeader[$j]['stok'] = $data['stok'][$j];
          $dataHeader[$j]['satuan'] = $data['satuan'][$j];
        }
      }

      return DataTables::of($dataHeader)
      ->addIndexColumn()
      ->editColumn('tglSpk', function ($data) 
      {
        if ($data->spk_date == null) 
        {
            return '-';
        }
        else 
        {
            return $data->spk_date ? with(new Carbon($data->spk_date))->format('d M Y') : '';
        }
      })
      ->editColumn('stok', function ($data) 
      {
        return $data->stok.' '.$data->satuan;
      })
      ->addColumn('action', function($data)
      {
        if ($data->spk_ispo == "TRUE") 
        {
         return '<div class="text-center">
                  <button class="btn btn-sm btn-success" title="Detail"
                      onclick=detailRencana("'.$data->spk_id.'")><i class="fa fa-eye"></i> 
                  </button>
                  <button class="btn btn-danger btn-sm" title="Ubah status belum PO"
                    onclick=gantiStatus("'.$data->spk_id.'","done")><i class="glyphicon glyphicon-remove"></i>
                  </button>';
        }
        else
        {
          return '<div class="text-center">
                  <button class="btn btn-sm btn-success" title="Detail"
                      onclick=detailRencana("'.$data->spk_id.'")><i class="fa fa-eye"></i> 
                  </button>
                  <button class="btn btn-info btn-sm" title="Ubah status sudah PO" 
                    onclick=gantiStatus("'.$data->spk_id.'","notyet")><i class="glyphicon glyphicon-ok"></i>
                  </button>';
        }
      })
      ->rawColumns(['status', 'action'])
      ->make(true);
    }

    public function getDetailRencana($id)
    {
       $dataHeader = d_spk::join('m_item','d_spk.spk_item','=','m_item.i_id')
                ->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')
                ->join('d_productplan', 'd_spk.spk_ref', '=', 'd_productplan.pp_id')
                ->select('d_spk.*', 'm_item.i_id', 'm_item.i_name','m_item.i_code', 'm_item.i_sat1', 'd_productplan.pp_qty')
                ->where('d_spk.spk_id', '=', $id)
                ->where('d_spk.spk_status', '=', 'DR')
                ->orderBy('d_spk.spk_date', 'DESC')
                ->get();

        // foreach ($dataHeader as $val) 
        // {
        //   $data = array(
        //       'hargaBruto' => 'Rp. '.number_format($val->d_pcs_total_gross,2,",","."),
        //       'nilaiDiskon' => 'Rp. '.number_format($val->d_pcs_discount + $val->d_pcs_disc_value,2,",","."),
        //       'nilaiPajak' => 'Rp. '.number_format($val->d_pcs_tax_value,2,",","."),
        //       'hargaNet' => 'Rp. '.number_format($val->d_pcs_total_net,2,",",".")
        //   );
        // }

        $dataIsi = spk_formula::join('d_spk', 'spk_formula.fr_spk', '=', 'd_spk.spk_id')
                ->join('m_item', 'spk_formula.fr_formula', '=', 'm_item.i_id')
                ->join('m_satuan', 'spk_formula.fr_scale', '=', 'm_satuan.m_sid')
                ->select('spk_formula.*',
                         'd_spk.*',
                         'm_item.*',
                         'm_satuan.*'
                )
                ->where('spk_formula.fr_spk', '=', $id)
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
        ]);
    }

    public function ubahStatus(Request $request)
    {
      //dd($request->all());
      DB::beginTransaction();
      try 
      {
        $tanggal = date("Y-m-d h:i:s");
        if ($request->isPO == 'done') {
            $status = 'FALSE';
            $pesan = 'Data SPK dirubah status menjadi BELUM PO';
        }else{
            $status = 'TRUE';
            $pesan = 'Data SPK dirubah status menjadi SUDAH PO';
        }
        
        //update d_spk
        DB::table('d_spk')
            ->where('spk_id','=',$request->id)
            ->update([
                'spk_ispo' => $status,
                'spk_update' => $tanggal
            ]);

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
        elseif ($val->i_type == "BP") //bahan baku
        {
          $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '6' AND s_position = '6' limit 1) ,'0') as qtyStok"));
          $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')->select('m_satuan.m_sname')->where('m_item.i_sat1', '=', $arrSatuan[$counter])->first();

          $stok[] = $query[0];
          $satuan[] = $satUtama->m_sname;
          $counter++;
        }
      }

      $data = array('val_stok' => $stok, 'txt_satuan' => $satuan);
      return $data;
    }

    public function konvertRp($value)
    {
      $value = str_replace(['Rp', '\\', '.', ' '], '', $value);
      return (int)str_replace(',', '.', $value);
    }
}
