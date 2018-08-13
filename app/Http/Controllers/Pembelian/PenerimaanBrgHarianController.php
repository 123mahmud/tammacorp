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
use App\d_terima_bharian;
use App\d_terima_bharian_dt;

class PenerimaanBrgHarianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('purchasing/p_bharian/index');
    }

    public function lookupDataBelanja(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term)) 
        {
            $purchase = DB::table('d_purchasingharian_dt')
                ->join('d_purchasingharian', 'd_purchasingharian_dt.d_pcshdt_pcshid', '=', 'd_purchasingharian.d_pcsh_id')
                ->select('d_purchasingharian_dt.d_pcshdt_pcshid', 'd_purchasingharian.d_pcsh_code')
                ->where('d_purchasingharian_dt.d_pcshdt_isreceived','=','FALSE')
                ->where('d_purchasingharian_dt.d_pcshdt_isconfirm','=','TRUE')
                ->orderBy('d_pcsh_code', 'DESC')->limit(5)->groupBy('d_pcshdt_pcshid')->get();
            foreach ($purchase as $val) 
            {
                $formatted_tags[] = ['id' => $val->d_pcshdt_pcshid, 'text' => $val->d_pcsh_code];
            }
            return Response::json($formatted_tags);
        }
        else
        {
            $purchase = DB::table('d_purchasingharian_dt')
                ->join('d_purchasingharian', 'd_purchasingharian_dt.d_pcshdt_pcshid', '=', 'd_purchasingharian.d_pcsh_id')
                ->select('d_purchasingharian_dt.d_pcshdt_pcshid', 'd_purchasingharian.d_pcsh_code')
                ->where('d_purchasingharian_dt.d_pcsh_code', 'LIKE', '%'.$term.'%')
                ->where('d_purchasingharian_dt.d_pcshdt_isreceived','=','FALSE')
                ->where('d_purchasingharian_dt.d_pcshdt_isconfirm','=','TRUE')
                ->orderBy('d_pcsh_code', 'DESC')->limit(5)->groupBy('d_pcshdt_pcshid')->get();

            foreach ($purchase as $val) 
            {
                $formatted_tags[] = ['id' => $val->d_pcshdt_pcshid, 'text' => $val->d_pcsh_code];
            }

          return Response::json($formatted_tags);  
        }
    }

    public function getDataForm($id)
    { 
        $dataHeader = DB::table('d_purchasingharian')
                    ->select('d_purchasingharian.*', 'd_supplier.s_company', 'd_supplier.s_name', 'd_supplier.s_id')
                    ->join('d_supplier','d_purchasingharian.d_pcsh_supid','=','d_supplier.s_id')
                    ->where('d_purchasingharian.d_pcsh_id', '=', $id)
                    ->get();

        $dataIsi = DB::table('d_purchasingharian_dt')
                  ->select('d_purchasingharian_dt.*', 'm_item.i_name', 'm_item.i_code', 'm_item.i_sat1', 'm_item.i_id', 'm_satuan.m_sname', 'm_satuan.m_sid')
                  ->leftJoin('m_item','d_purchasingharian_dt.d_pcshdt_item','=','m_item.i_id')
                  ->leftJoin('m_satuan','d_purchasingharian_dt.d_pcshdt_sat','=','m_satuan.m_sid')
                  ->where('d_purchasingharian_dt.d_pcshdt_pcshid', '=', $id)
                  ->where('d_purchasingharian_dt.d_pcshdt_isreceived', '=', "FALSE")
                  ->get();

        foreach ($dataHeader as $val) 
        {
          $data = array(
            'hargaTotal' => 'Rp. '.number_format($val->d_pcsh_totalprice,2,",",".")
          );
        }

        foreach ($dataIsi as $val) 
        {
          //cek item type
          $itemType[] = DB::table('m_item')->select('i_type', 'i_id')->where('i_id','=', $val->i_id)->first();
          //get satuan utama
          $sat1[] = $val->i_sat1;
          //get qty purchase
          $qtyBelanja[] = $val->d_pcshdt_qtyconfirm;
          //get id purchaseharian_dt
          $idBelanjaDt[] = $val->d_pcshdt_id; 
        }

        for ($z=0; $z < count($qtyBelanja); $z++) 
        {   
            //variabel untuk menyimpan penjumlahan array qty penerimaan
            $hasil_qty_rcv = 0;
            //get data qty received
            $qtyRcv = DB::select(DB::raw("SELECT IFNULL(sum(d_tbhdt_qty), 0) as zz FROM d_terima_bharian_dt where d_tbhdt_idpcshdt = '".$idBelanjaDt[$z]."'"));
            
            foreach ($qtyRcv as $nilai) 
            {
                $hasil_qty_rcv = (int)$nilai->zz;
            }

            $qtyRemain[] = $qtyBelanja[$z] - $hasil_qty_rcv;
        }
        
        //variabel untuk count array
        $counter = 0;
        //ambil value stok by item type
        $dataStok = $this->getStokByType($itemType, $sat1, $counter);

        return response()->json([
            'status' => 'sukses',
            'data_header' => $dataHeader,
            'data_qty' => $qtyRemain,
            'data_isi' => $dataIsi,
            'data2' => $data,
            'data_stok' => $dataStok['val_stok'],
            'data_satuan' => $dataStok['txt_satuan'],
        ]);
    }

    public function simpanPenerimaan(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {
            //code penerimaan
            $kode = $this->kodePenerimaanAuto();
            //insert to table d_terimapembelian
            $dataHeader = new d_terima_bharian;
            $dataHeader->d_tbh_phid = $request->headNotaBelanja;
            $dataHeader->d_tbh_sup = $request->headSupplierId;
            $dataHeader->d_tbh_code = $kode;
            $dataHeader->d_tbh_staff = $request->headStaffId;
            $dataHeader->d_tbh_noreff = $request->headNotaTxt;
            $dataHeader->d_tbh_totalnett = $this->konvertRp($request->headTotalTerima);
            $dataHeader->d_tbh_date = date('Y-m-d',strtotime($request->headTglTerima));
            $dataHeader->d_tbh_created = Carbon::now();
            $dataHeader->save();
                  
            //get last lastId then insert id to d_terimapembelian_dt
            $lastId = d_terima_bharian::select('d_tbh_id')->max('d_tbh_id');
            if ($lastId == 0 || $lastId == '') 
            {
                $lastId  = 1;
            }  

            //variabel untuk hitung array field
            $hitung_field = count($request->fieldItemId);

            //update d_stock, insert d_stock_mutation & insert d_terima_bharian_dt
            for ($i=0; $i < $hitung_field; $i++) 
            {
                //variabel u/ cek primary satuan
                $primary_sat = DB::table('m_item')->select('m_item.*')->where('i_id', $request->fieldItemId[$i])->first();
        
                //cek satuan primary, convert ke primary apabila beda satuan
                if ($primary_sat->i_sat1 == $request->fieldSatuanId[$i]) 
                {
                  $hasilConvert = (int)$request->fieldQtyterima[$i] * (int)$primary_sat->i_sat_isi1;
                }
                elseif ($primary_sat->i_sat2 == $request->fieldSatuanId[$i])
                {
                  $hasilConvert = (int)$request->fieldQtyterima[$i] * (int)$primary_sat->i_sat_isi2;
                }
                else
                {
                  $hasilConvert = (int)$request->fieldQtyterima[$i] * (int)$primary_sat->i_sat_isi3;
                }

                $grup = $this->getGroupGudang($request->fieldItemId[$i]);
                $stokAkhir = (int)$request->fieldStokVal[$i] + (int)$hasilConvert;

                //update stock akhir d_stock
                DB::table('d_stock')
                  ->where('s_item', $request->fieldItemId[$i])
                  ->where('s_comp', $grup)
                  ->where('s_position', $grup)
                  ->update(['s_qty' => $stokAkhir]);

                //get id d_stock
                $dstock_id = DB::table('d_stock')
                  ->select('s_id')
                  ->where('s_item', $request->fieldItemId[$i])
                  ->where('s_comp', $grup)
                  ->where('s_position', $grup)
                  ->first();

                //get last id stock_mutation
                $lastIdSm = DB::select(DB::raw("SELECT IFNULL((SELECT sm_detailid FROM d_stock_mutation where sm_stock = '$dstock_id->s_id' ORDER BY sm_detailid DESC LIMIT 1) ,'0') as zz"));
                if ($lastIdSm[0]->zz == 0 || $lastIdSm[0]->zz == '0')
                {
                  $hasil_id = 1;
                }
                else
                {
                  $hasil_id = (int)$lastIdSm[0]->zz + 1;
                }

                //insert to d_stock_mutation
                DB::table('d_stock_mutation')->insert([
                  'sm_stock' => $dstock_id->s_id,
                  'sm_detailid' => $hasil_id,
                  'sm_date' => Carbon::now(),
                  'sm_comp' => $grup,
                  'sm_position' => $grup,
                  'sm_mutcat' => '15',
                  'sm_item' => $request->fieldItemId[$i],
                  'sm_qty' => $hasilConvert,
                  'sm_qty_used' => '0',
                  'sm_qty_expired' => '0',
                  'sm_qty_sisa' => $hasilConvert,
                  'sm_detail' => "PENAMBAHAN",
                  'sm_hpp' => $request->fieldHargaTotalRaw[$i],
                  'sm_sell' => '0',
                  'sm_reff' => $request->headNotaTxt,
                  'sm_insert' => Carbon::now(),
                ]);

                //insert d_terima_bharian_dt
                $dataIsi = new d_terima_bharian_dt;
                $dataIsi->d_tbhdt_idtbh = $lastId;
                $dataIsi->d_tbhdt_smdetail = $hasil_id;
                $dataIsi->d_tbhdt_item = $request->fieldItemId[$i];
                $dataIsi->d_tbhdt_sat = $request->fieldSatuanId[$i];
                $dataIsi->d_tbhdt_idpcshdt = $request->fieldIdPharianDet[$i];
                $dataIsi->d_tbhdt_qty = $request->fieldQtyterima[$i];
                $dataIsi->d_tbhdt_price = $request->fieldHargaRaw[$i];
                $dataIsi->d_tbhdt_pricetotal = $request->fieldHargaTotalRaw[$i];
                $dataIsi->d_tbhdt_date_received = date('Y-m-d',strtotime($request->headTglTerima));
                $dataIsi->d_tbhdt_created = Carbon::now();
                $dataIsi->save();

                //update isrecieved d_terima_bharian_dt jika qty == terima
                $qtyRcv = DB::select(DB::raw("SELECT IFNULL(sum(d_tbhdt_qty), 0) as aa FROM d_terima_bharian_dt where d_tbhdt_idpcshdt = '".$request->fieldIdPharianDet[$i]."'"));
                $qtyPcs = DB::select(DB::raw("SELECT IFNULL(sum(d_pcshdt_qtyconfirm), 0) as bb FROM d_purchasingharian_dt where d_pcshdt_id = '".$request->fieldIdPharianDet[$i]."'"));

                if ($qtyRcv[0]->aa == $qtyPcs[0]->bb) 
                {
                   DB::table('d_purchasingharian_dt')
                      ->where('d_pcshdt_id', $request->fieldIdPharianDet[$i])
                      ->update(['d_pcshdt_isreceived' => 'TRUE']);
                }
            }

            //cek pada table purchasingharian_dt, jika isreceived semua tbl header ubah status ke RC
            $this->cek_status_purchasing($request->headNotaBelanja);
            
            DB::commit();
            return response()->json([
                'status' => 'sukses',
                'pesan' => 'Data Penerimaan Belanja Harian Berhasil Disimpan'
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

    public function kodePenerimaanAuto()
    {
        $query = DB::select(DB::raw("SELECT MAX(RIGHT(d_tbh_code,4)) as kode_max from d_terima_bharian WHERE DATE_FORMAT(d_tbh_created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));
        $kd = "";

        if(count($query)>0)
        {
          foreach($query as $k)
          {
            $tmp = ((int)$k->kode_max)+1;
            $kd = sprintf("%04s", $tmp);
          }
        }
        else
        {
          $kd = "0001";
        }

        return $codeTerimaBeli = "IPH-".date('myd')."-".$kd;
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
        elseif ($typeBrg->i_type == "BL") 
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
            elseif ($val->i_type == "BL") //barang Lain-lain
            {
                $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '2' AND s_position = '2' limit 1) ,'0') as qtyStok"));
                $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')->select('m_satuan.m_sname')->where('m_item.i_sat1', '=', $arrSatuan[$counter])->first();

                $stok[] = $query[0];
                $satuan[] = $satUtama->m_sname;
                $counter++;
            }
        }

        $data = array('val_stok' => $stok, 'txt_satuan' => $satuan);
        return $data;
    }

    public function cek_status_purchasing($id)
    {
      //tanggal sekarang
      $tgl = Carbon::today()->toDateString();
      //cek pada table purchasingdt, jika isreceived semua tbl header ubah status ke RC
      $data_dt = DB::table('d_purchasing_dt')->select('d_pcsdt_isreceived')->where('d_pcs_id', '=', $id)->get();

      foreach ($data_dt as $x) { $data_status[] = $x->d_pcsdt_isreceived; }

      if (!in_array("FALSE", $data_status, TRUE)) 
      {
        DB::table('d_purchasing')->where('d_pcs_id', $id)->update(['d_pcs_status' => 'RC', 'd_pcs_date_received' => $tgl]);
      }
    }

    // =====================================================================================================================

    public function getDatatableIndex()
    {
        $data = d_terima_pembelian::join('d_purchasing','d_terima_pembelian.d_tb_pid','=','d_purchasing.d_pcs_id')
                ->join('d_supplier','d_terima_pembelian.d_tb_sup','=','d_supplier.s_id')
                ->join('d_mem','d_terima_pembelian.d_tb_staff','=','d_mem.m_id')
                ->select('d_terima_pembelian.*', 'd_supplier.s_id', 'd_supplier.s_company', 'd_purchasing.d_pcs_id', 'd_purchasing.d_pcs_code', 'd_purchasing.d_pcs_date_created', 'd_mem.m_name')
                ->orderBy('d_tb_created', 'DESC')
                ->get();
        //dd($data);    
        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('tglBuat', function ($data) 
        {
            if ($data->d_tb_created == null) 
            {
                return '-';
            }
            else 
            {
                return $data->d_tb_created ? with(new Carbon($data->d_tb_created))->format('d M Y') : '';
            }
        })
        ->editColumn('hargaTotal', function ($data) 
        {
          return 'Rp. '.number_format($data->d_tb_totalnett,2,",",".");
        })
        ->addColumn('action', function($data)
        {
          
            return '<div class="text-center">
                        <button class="btn btn-sm btn-success" title="Detail"
                            onclick=detailPenerimaan("'.$data->d_tb_id.'")><i class="fa fa-eye"></i> 
                        </button>
                        <button class="btn btn-sm btn-danger" title="Delete"
                            onclick=deletePenerimaan("'.$data->d_tb_id.'")><i class="glyphicon glyphicon-trash"></i>
                        </button>
                    </div>';
        })
        ->rawColumns(['status', 'action'])
        ->make(true);
    }

    public function getDataDetail($id)
    {
        $dataHeader = d_terima_pembelian::join('d_purchasing','d_terima_pembelian.d_tb_pid','=','d_purchasing.d_pcs_id')
            ->join('d_supplier','d_terima_pembelian.d_tb_sup','=','d_supplier.s_id')
            ->join('d_mem','d_terima_pembelian.d_tb_staff','=','d_mem.m_id')
            ->select('d_terima_pembelian.*', 'd_supplier.s_id', 'd_supplier.s_company', 'd_purchasing.*', 'd_mem.m_name')
            ->where('d_terima_pembelian.d_tb_id', '=', $id)
            ->orderBy('d_tb_created', 'DESC')
            ->get();

        foreach ($dataHeader as $val) 
        {   $total_disc = (int)$val->d_pcs_discount + (int)$val->d_pcs_disc_value;
            $data = array(
                /*'hargaTotBeliGross' => 'Rp. '.number_format($val->d_pcs_total_gross,2,",","."),
                'hargaTotBeliDisc' => 'Rp. '.number_format($total_disc,2,",","."),
                'hargaTotBeliTax' => 'Rp. '.number_format($val->d_pcs_tax_value,2,",","."),
                'hargaTotBeliNett' => 'Rp. '.number_format($val->d_pcs_total_net,2,",","."),
                'hargaTotalTerimaNett' => 'Rp. '.number_format($val->d_tb_totalnett,2,",","."),*/
                'tanggalTerima' => date('d-m-Y',strtotime($val->d_tb_date))
            );
        }

        $dataIsi = d_terima_pembelian_dt::join('d_terima_pembelian', 'd_terima_pembelian_dt.d_tbdt_idtb', '=', 'd_terima_pembelian.d_tb_id')
                ->join('m_item', 'd_terima_pembelian_dt.d_tbdt_item', '=', 'm_item.i_id')
                ->join('m_satuan', 'd_terima_pembelian_dt.d_tbdt_sat', '=', 'm_satuan.m_sid')
                ->join('d_purchasing_dt', 'd_terima_pembelian_dt.d_tbdt_idpcsdt', '=', 'd_purchasing_dt.d_pcsdt_id')
                ->select('d_terima_pembelian_dt.*', 'm_item.*', 'd_terima_pembelian.d_tb_code', 'm_satuan.m_sid', 'm_satuan.m_sname', 'd_purchasing_dt.d_pcsdt_qtyconfirm')
                ->where('d_terima_pembelian_dt.d_tbdt_idtb', '=', $id)
                ->orderBy('d_terima_pembelian_dt.d_tbdt_created', 'DESC')
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

        return response()->json([
            'status' => 'sukses',
            'header' => $dataHeader,
            'header2' => $data,
            'data_isi' => $dataIsi,
            'data_stok' => $dataStok['val_stok'],
            'data_satuan' => $dataStok['txt_satuan'],
        ]);
    }

    public function getPenerimaanPeritem($id)
    {
        $dataHeader = d_purchasing_dt::join('d_purchasing','d_purchasing_dt.d_pcs_id','=','d_purchasing.d_pcs_id')
            ->join('d_supplier','d_purchasing_dt.d_pcsdt_sid','=','d_supplier.s_id')
            ->select('d_purchasing.d_pcs_code', 'd_purchasing_dt.d_pcsdt_qty', 'd_purchasing.d_pcs_date_created', 'd_supplier.s_company')
            ->where('d_purchasing_dt.d_pcsdt_id', '=', $id)
            ->get();

        $dataIsi = d_terima_pembelian_dt::join('d_terima_pembelian', 'd_terima_pembelian_dt.d_tbdt_idtb', '=', 'd_terima_pembelian.d_tb_id')
            ->join('m_item', 'd_terima_pembelian_dt.d_tbdt_item', '=', 'm_item.i_id')
            ->join('m_satuan', 'd_terima_pembelian_dt.d_tbdt_sat', '=', 'm_satuan.m_sid')
            ->select('m_item.i_name', 'm_item.i_code', 'm_satuan.m_sname', 'd_terima_pembelian_dt.d_tbdt_qty', 'd_terima_pembelian.d_tb_code', 'd_terima_pembelian_dt.d_tbdt_date_received', 'd_terima_pembelian.d_tb_date')
            ->where('d_terima_pembelian_dt.d_tbdt_idpcsdt', '=', $id)
            ->orderBy('d_terima_pembelian_dt.d_tbdt_date_received', 'ASC')
            ->get();

        foreach ($dataIsi as $val) 
        {   
          $tanggalTerima[] = date('d-m-Y',strtotime($val->d_tbdt_date_received));
        }
        
        return response()->json([
            'status' => 'sukses',
            'header' => $dataHeader,
            'isi' => $dataIsi,
            'tanggalTerima' => $tanggalTerima
        ]);
    }

    public function deletePenerimaan(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try {
          //cari item & qty d_terimapembelian_dt
          $query = DB::table('d_terima_pembelian_dt')->select('d_tbdt_item', 'd_tbdt_qty', 'd_tbdt_smdetail', 'd_tbdt_sat', 'd_tbdt_idpcsdt')->where('d_tbdt_idtb', $request->id)->get();

          //cari id_purchasing & update status ke CF
          $query2 = DB::table('d_terima_pembelian')->select('d_tb_id','d_tb_pid')->where('d_tb_id', $request->id)->first(); 
          //update status purchasing to CF = "CONFIRMED"
          DB::table('d_purchasing')->where('d_pcs_id', $query2->d_tb_pid)->update(['d_pcs_status' => 'CF']);

          foreach ($query as $value) 
          {
            //array variabel item m_item
            $item[] = $value->d_tbdt_item;
            //array variabel qty return
            $qty_terima[] = $value->d_tbdt_qty;
            //array variabel sm_detailid
            $id_smdetail[] = $value->d_tbdt_smdetail;
            //array variabel satuanid
            $id_satuan[] = $value->d_tbdt_sat;
            //array variabel id_purchasedt
            $id_purchasedt[] = $value->d_tbdt_idpcsdt;
          }

          $hitung_row = count($item);
          for ($i=0; $i < $hitung_row; $i++) 
          { 
            $grup = $this->getGroupGudang($item[$i]);
            //cari id & s_qty d_stock
            $q_dstock = DB::table('d_stock')
              ->select('s_id', 's_qty')
              ->where('s_item', $item[$i])
              ->where('s_comp', $grup)
              ->where('s_position', $grup)
              ->first();
            //array variabel id_stock (d_stock)
            $id_stock[] = $q_dstock->s_id;
            //array variabel qty_stock (d_stock)
            $qty_stock[] = $q_dstock->s_qty;
          }

          for ($i=0; $i < $hitung_row ; $i++) 
          {
            //variabel u/ cek primary satuan
            $primary_sat = DB::table('m_item')->select('m_item.*')->where('i_id', $item[$i])->first();
            //konversi qty
            if ($primary_sat->i_sat1 == $id_satuan[$i]) 
            {
              $hasilConvert = (int)$qty_terima[$i] * (int)$primary_sat->i_sat_isi1;
            }
            elseif ($primary_sat->i_sat2 == $id_satuan[$i])
            {
              $hasilConvert = (int)$qty_terima[$i] * (int)$primary_sat->i_sat_isi2;
            }
            else
            {
              $hasilConvert = (int)$qty_terima[$i] * (int)$primary_sat->i_sat_isi3;
            }

            $grup2 = $this->getGroupGudang($item[$i]);
            //kembalikan stok sebelum penerimaan
            $stokAkhir = (int)$qty_stock[$i] - (int)$hasilConvert;
            // update d_stock
            DB::table('d_stock')
              ->where('s_id', $id_stock[$i])
              ->update(['s_qty' => $stokAkhir]);

            //delete row table d_stock_mutation
            DB::table('d_stock_mutation')
              ->where('sm_stock', '=', $id_stock[$i])
              ->where('sm_detailid', '=', $id_smdetail[$i])
              ->delete();

            //update status to false
            DB::table('d_purchasing_dt')
                      ->where('d_pcsdt_id', $id_purchasedt[$i])
                      ->update(['d_pcsdt_isreceived' => 'FALSE']); 
          }

          //delete row table d_terima_pembelian_dt
          d_terima_pembelian_dt::where('d_tbdt_idtb', $request->id)->delete();
          //delete row table d_terima_pembelian
          d_terima_pembelian::where('d_tb_id', $request->id)->delete();
          //cek pada table purchasingdt, jika isreceived semua tbl header ubah status ke RC
          $this->cek_status_purchasing($query2->d_tb_pid);
          
          DB::commit();
          return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Penerimaan Berhasil Dihapus'
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

    

    

    public function getListWaitingByTgl($tgl1, $tgl2)
    {
        $y = substr($tgl1, -4);
        $m = substr($tgl1, -7,-5);
        $d = substr($tgl1,0,2);
         $tanggal1 = $y.'-'.$m.'-'.$d;

        $y2 = substr($tgl2, -4);
        $m2 = substr($tgl2, -7,-5);
        $d2 = substr($tgl2,0,2);
        $tanggal2 = $y2.'-'.$m2.'-'.$d2;

        $data = DB::table('d_purchasing_dt')
                  ->select('d_purchasing_dt.*','d_purchasing.d_pcs_date_created','d_purchasing.d_pcs_code','m_item.i_name','m_item.i_code','m_item.i_sat1','m_item.i_id','d_supplier.s_company','m_satuan.m_sname','m_satuan.m_sid')
                  ->leftJoin('d_purchasing','d_purchasing_dt.d_pcs_id','=','d_purchasing.d_pcs_id')
                  ->leftJoin('m_item','d_purchasing_dt.i_id','=','m_item.i_id')
                  ->leftJoin('m_satuan','d_purchasing_dt.d_pcsdt_sat','=','m_satuan.m_sid')
                  ->leftJoin('d_supplier','d_purchasing_dt.d_pcsdt_sid','=','d_supplier.s_id')                  
                  ->where('d_purchasing_dt.d_pcsdt_isreceived', '=', "FALSE")
                  ->whereBetween('d_purchasing.d_pcs_date_created', [$tanggal1, $tanggal2])
                  ->orderBy('d_purchasing.d_pcs_date_created', 'DESC')
                  ->get();

        for ($z=0; $z < count($data); $z++) 
        {   
          //variabel untuk menyimpan penjumlahan array qty penerimaan
          $hasil_qty_rcv = 0;
          //get data qty received
          $qtyRcv = DB::select(DB::raw("SELECT IFNULL(sum(d_tbdt_qty), 0) as zz FROM d_terima_pembelian_dt where d_tbdt_idpcsdt = '".$data[$z]->d_pcsdt_id."'"));
          
          foreach ($qtyRcv as $nilai) 
          {
            $hasil_qty_rcv = (int)$nilai->zz;
          }
          //create new object properties and assign value
          $data[$z]->qty_remain = $data[$z]->d_pcsdt_qtyconfirm - $hasil_qty_rcv;
        }

        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('status', function ($data)
        {
          if ($data->d_pcsdt_isreceived == "FALSE") 
          {
            return '<span class="label label-info">Belum Diterima</span>';
          }
          elseif ($data->d_pcsdt_isreceived == "TRUE") 
          {
            return '<span class="label label-success">Disetujui</span>';
          }
        })
        ->editColumn('tglBuat', function ($data) 
        {
            if ($data->d_pcsdt_created == null) 
            {
                return '-';
            }
            else 
            {
                return $data->d_pcsdt_created ? with(new Carbon($data->d_pcsdt_created))->format('d M Y') : '';
            }
        })
        ->rawColumns(['status'])
        ->make(true);
    }

    public function getListReceivedByTgl($tgl1, $tgl2)
    {
        $y = substr($tgl1, -4);
        $m = substr($tgl1, -7,-5);
        $d = substr($tgl1,0,2);
         $tanggal1 = $y.'-'.$m.'-'.$d;

        $y2 = substr($tgl2, -4);
        $m2 = substr($tgl2, -7,-5);
        $d2 = substr($tgl2,0,2);
        $tanggal2 = $y2.'-'.$m2.'-'.$d2;

        $data = DB::table('d_purchasing_dt')
                  ->select('d_purchasing_dt.*','d_purchasing.d_pcs_date_created','d_purchasing.d_pcs_code','m_item.i_name','m_item.i_code','m_item.i_sat1','m_item.i_id','d_supplier.s_company','m_satuan.m_sname','m_satuan.m_sid')
                  ->leftJoin('d_purchasing','d_purchasing_dt.d_pcs_id','=','d_purchasing.d_pcs_id')
                  ->leftJoin('m_item','d_purchasing_dt.i_id','=','m_item.i_id')
                  ->leftJoin('m_satuan','d_purchasing_dt.d_pcsdt_sat','=','m_satuan.m_sid')
                  ->leftJoin('d_supplier','d_purchasing_dt.d_pcsdt_sid','=','d_supplier.s_id')                  
                  ->where('d_purchasing_dt.d_pcsdt_isreceived', '=', "TRUE")
                  ->whereBetween('d_purchasing.d_pcs_date_created', [$tanggal1, $tanggal2])
                  ->orderBy('d_purchasing.d_pcs_date_created', 'DESC')
                  ->get();

        for ($z=0; $z < count($data); $z++) 
        {   
          //variabel untuk menyimpan penjumlahan array qty penerimaan
          $hasil_qty_rcv = 0;
          //get data qty received
          $qtyRcv = DB::select(DB::raw("SELECT IFNULL(sum(d_tbdt_qty), 0) as zz FROM d_terima_pembelian_dt where d_tbdt_idpcsdt = '".$data[$z]->d_pcsdt_id."'"));
          
          foreach ($qtyRcv as $nilai) 
          {
            $hasil_qty_rcv = (int)$nilai->zz;
          }
          //create new object properties and assign value
          $data[$z]->qty_received = $hasil_qty_rcv;
        }

        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('status', function ($data)
        {
          if ($data->d_pcsdt_isreceived == "FALSE") 
          {
            return '<span class="label label-info">Belum Diterima</span>';
          }
          elseif ($data->d_pcsdt_isreceived == "TRUE") 
          {
            return '<span class="label label-success">Diterima</span>';
          }
        })
        ->editColumn('tglBuat', function ($data) 
        {
          if ($data->d_pcsdt_created == null) 
          {
              return '-';
          }
          else 
          {
              return $data->d_pcsdt_created ? with(new Carbon($data->d_pcsdt_created))->format('d M Y') : '';
          }
        })
        ->addColumn('action', function($data)
        {
          return '<div class="text-center">
                      <button class="btn btn-sm btn-success" title="Detail"
                          onclick=detailListReceived("'.$data->d_pcsdt_id.'")><i class="fa fa-eye"></i> 
                      </button>
                  </div>';
        })
        ->rawColumns(['status','action'])
        ->make(true);
    }

    

    

    public function print($id)
    {

        $dataHeader = d_terima_pembelian::join('d_purchasing','d_terima_pembelian.d_tb_pid','=','d_purchasing.d_pcs_id')
            ->join('d_supplier','d_terima_pembelian.d_tb_sup','=','d_supplier.s_id')
            ->join('d_mem','d_terima_pembelian.d_tb_staff','=','d_mem.m_id')
            ->select('d_terima_pembelian.*', 'd_supplier.s_id', 'd_supplier.s_name', 'd_supplier.s_company', 'd_purchasing.*', 'd_mem.m_name')
            ->where('d_terima_pembelian.d_tb_id', '=', $id)
            ->orderBy('d_tb_created', 'DESC')
            ->get()->toArray();

        $dataIsi = d_terima_pembelian_dt::join('d_terima_pembelian', 'd_terima_pembelian_dt.d_tbdt_idtb', '=', 'd_terima_pembelian.d_tb_id')
                ->join('m_item', 'd_terima_pembelian_dt.d_tbdt_item', '=', 'm_item.i_id')
                ->join('m_satuan', 'd_terima_pembelian_dt.d_tbdt_sat', '=', 'm_satuan.m_sid')
                ->join('d_purchasing_dt', 'd_terima_pembelian_dt.d_tbdt_idpcsdt', '=', 'd_purchasing_dt.d_pcsdt_id')
                ->select('d_terima_pembelian_dt.*', 'm_item.*', 'd_terima_pembelian.d_tb_code', 'm_satuan.m_sid', 'm_satuan.m_sname', 'd_purchasing_dt.d_pcsdt_qtyconfirm')
                ->where('d_terima_pembelian_dt.d_tbdt_idtb', '=', $id)
                ->orderBy('d_terima_pembelian_dt.d_tbdt_created', 'DESC')
                ->get()->toArray();

        foreach ($dataIsi as $val) 
        {
          $itemType[] = DB::table('m_item')->select('i_type', 'i_id')->where('i_id','=', $val['i_id'])->first();
          //get satuan utama
          $sat1[] = $val['i_sat1'];
        }

        //variabel untuk count array
        $counter = 0;
        //ambil value stok by item type
        $dataStok = $this->getStokByType($itemType, $sat1, $counter);

        $val_stock = [];
        $txt_satuan = [];

        $val_stock = array_chunk($dataStok['val_stok'], 14);
        $txt_satuan = array_chunk($dataStok['txt_satuan'], 14);

        // return $val_stock;
        // return $txt_satuan;

        


        $dataIsi = array_chunk($dataIsi, 14);
           
        return view('inventory.p_suplier.print', compact('dataHeader', 'dataIsi', 'val_stock', 'txt_satuan'));
    }

    // ============================================================================================================== //
}