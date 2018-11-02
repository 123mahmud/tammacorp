<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Response;
use DB;
use DataTables;
use Auth;
use App\d_pakai_barang;
use App\d_pakai_barangdt;
use App\d_stock_mutation;
use App\d_gudangcabang;
use App\lib\mutasi;

class PemakaianBrgGdgController extends Controller
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
    
    public function barang()
    {
        return view('inventory/b_digunakan/index');
    }

    public function lookupDataGudang(Request $request)
    {
        $id_peg = Auth::user()->m_pegawai_id;
        if ($id_peg != null) {
            $d_peg = DB::table('m_pegawai_man')
                ->rightJoin('d_mem', 'm_pegawai_man.c_id', '=', 'd_mem.m_pegawai_id')
                ->select('c_divisi_id', 'c_jabatan_id', 'm_isadmin')
                ->where('c_id', $id_peg)->first();
        }else{
            $d_peg = DB::table('m_pegawai_man')
                ->rightJoin('d_mem', 'm_pegawai_man.c_id', '=', 'd_mem.m_pegawai_id')
                ->select('c_divisi_id', 'c_jabatan_id', 'm_isadmin')
                ->where('m_isadmin', 'Y')->first();
        }
    
        if ($d_peg->m_isadmin == 'Y') {
            $param = [1,2,3,4,5,6,7,8];
        }

        if ($d_peg->c_divisi_id == '5') {
            $param = [1,2,7,8];
        }elseif($d_peg->c_divisi_id == '4'){
            $param = [3,6];
        }

        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term)) 
        {
            for ($x=0; $x < count($param); $x++) { 
                $data[] = d_gudangcabang::select('cg_id', 'cg_cabang')->where('cg_id', '=', $param[$x])->first();
            }
            
            foreach ($data as $val) 
            {
                $formatted_tags[] = ['id' => $val->cg_id, 'text' => $val->cg_cabang];
            }
            return Response::json($formatted_tags);
        }
        else
        {
            for ($x=0; $x < count($param); $x++) { 
                $data[] = d_gudangcabang::select('cg_id', 'cg_cabang')->where('cg_cabang', 'LIKE', '%'.$term.'%')->where('cg_id', '=', $param[$x])->first();
            }
            
            foreach ($data as $val) 
            {
                if ($val != null) {
                    $formatted_tags[] = ['id' => $val->cg_id, 'text' => $val->cg_cabang];
                }
            }

          return Response::json($formatted_tags);  
        }
    }

    public function autocompleteBarang(Request $request)
    {
        //dd($request->all());
        $term = $request->term;
        $id_gdg = $request->id_gudang;
        $results = array();
        $queries = DB::table('m_item')
            ->join('d_stock', 'm_item.i_id', '=', 'd_stock.s_item')
            ->select('m_item.i_id',
                     'm_item.i_type',
                     'm_item.i_sat1',
                     'm_item.i_sat2',
                     'm_item.i_sat3',
                     'm_item.i_code',
                     'm_item.i_name',
                     'd_stock.s_id',
                     'd_stock.s_qty',
                     'd_stock.s_position',
                     'd_stock.s_comp')
            ->where('i_name', 'LIKE', '%'.$term.'%')
            ->where('d_stock.s_comp', '=', $id_gdg)
            ->where('d_stock.s_position', '=', $id_gdg)
            ->take(10)->get();
      
        if ($queries == null) 
        {
            $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
        } 
        else 
        {
            foreach ($queries as $val) 
            {
                //get data txt satuan
                $txtSat1 = DB::table('m_satuan')->select('m_sname', 'm_sid')->where('m_sid','=', $val->i_sat1)->first();
                $txtSat2 = DB::table('m_satuan')->select('m_sname', 'm_sid')->where('m_sid','=', $val->i_sat2)->first();
                $txtSat3 = DB::table('m_satuan')->select('m_sname', 'm_sid')->where('m_sid','=', $val->i_sat3)->first();

                $results[] = [  'id' => $val->i_id,
                                'label' => $val->i_code .'  '.$val->i_name,
                                'stok' => (int)$val->s_qty,
                                'sat' => [$val->i_sat1, $val->i_sat2, $val->i_sat3],
                                'satTxt' => [$txtSat1->m_sname, $txtSat2->m_sname, $txtSat3->m_sname],
                                's_comp' => $val->s_comp,
                                's_pos' => $val->s_position,
                            ];
            }
        }

      return Response::json($results);
    }

    public function getPemakaianByTgl($tgl1, $tgl2)
    {
        $y = substr($tgl1, -4);
        $m = substr($tgl1, -7,-5);
        $d = substr($tgl1,0,2);
        $tanggal1 = $y.'-'.$m.'-'.$d;

        $y2 = substr($tgl2, -4);
        $m2 = substr($tgl2, -7,-5);
        $d2 = substr($tgl2,0,2);
        $tanggal2 = $y2.'-'.$m2.'-'.$d2;

        $data = d_pakai_barang::join('d_gudangcabang','d_pakai_barang.d_pb_gdg','=','d_gudangcabang.cg_id')
              ->join('d_mem','d_pakai_barang.d_pb_staff','=','d_mem.m_id')
              ->select('d_pakai_barang.*', 'd_mem.m_id', 'd_mem.m_name', 'd_gudangcabang.cg_id', 'd_gudangcabang.cg_cabang')
              ->whereBetween('d_pb_date', [$tanggal1, $tanggal2])
              ->orderBy('d_pb_created', 'DESC')
              ->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('tglBuat', function ($data) 
        {
            if ($data->d_pb_date == null) 
            {
                return '-';
            }
            else 
            {
                return $data->d_pb_date ? with(new Carbon($data->d_pb_date))->format('d M Y') : '';
            }
        })
        ->addColumn('action', function($data)
        {
            return '<div class="text-center">
                        <button class="btn btn-sm btn-success" title="Detail"
                            onclick=detailPemakaian("'.$data->d_pb_id.'")><i class="fa fa-eye"></i> 
                        </button>
                        <button class="btn btn-sm btn-warning" title="Edit"
                            onclick=editPemakaian("'.$data->d_pb_id.'")><i class="glyphicon glyphicon-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" title="Delete"
                            onclick=deletePemakaian("'.$data->d_pb_id.'")><i class="glyphicon glyphicon-trash"></i>
                        </button>
                    </div>'; 
        })
        ->rawColumns(['status', 'action'])
        ->make(true);
    }

    public function getDataDetail($id)
    {
        $dataHeader = d_pakai_barang::join('d_gudangcabang','d_pakai_barang.d_pb_gdg','=','d_gudangcabang.cg_id')
              ->join('d_mem','d_pakai_barang.d_pb_staff','=','d_mem.m_id')
              ->select('d_pakai_barang.*', 'd_mem.m_id', 'd_mem.m_name', 'd_gudangcabang.cg_id', 'd_gudangcabang.cg_cabang')
              ->where('d_pakai_barang.d_pb_id', '=', $id)
              ->orderBy('d_pakai_barang.d_pb_created', 'DESC')
              ->get();
    
        $dataIsi = d_pakai_barangdt::join('d_pakai_barang', 'd_pakai_barangdt.d_pbdt_pbid', '=', 'd_pakai_barang.d_pb_id')
            ->join('m_item', 'd_pakai_barangdt.d_pbdt_item', '=', 'm_item.i_id')
            ->join('m_satuan', 'd_pakai_barangdt.d_pbdt_sat', '=', 'm_satuan.m_sid')
            ->select(
                'd_pakai_barangdt.d_pbdt_id',
                'd_pakai_barangdt.d_pbdt_pbid',
                'd_pakai_barangdt.d_pbdt_item',
                'd_pakai_barangdt.d_pbdt_sat',
                DB::raw('sum(d_pakai_barangdt.d_pbdt_qty) as qty_pakai'),
                DB::raw('sum(d_pakai_barangdt.d_pbdt_price) as harga_sat'),
                DB::raw('sum(d_pakai_barangdt.d_pbdt_pricetotal) as harga_tot'),
                'd_pakai_barangdt.d_pbdt_keterangan',
                'm_item.*',
                'd_pakai_barang.d_pb_code',
                'm_satuan.m_sid',
                'm_satuan.m_sname'
            )
            ->where('d_pakai_barangdt.d_pbdt_pbid', '=', $id)
            ->groupBy('d_pakai_barangdt.d_pbdt_item')
            ->orderBy('d_pakai_barangdt.d_pbdt_created', 'DESC')
            ->get();


        foreach ($dataHeader as $val) 
        {
            $data = array(
              'id_gdg' => $val->d_pb_gdg,
              'tgl_pakai' => date('d-m-Y',strtotime($val->d_pb_date))
            );
        }

        foreach ($dataIsi as $val2) 
        {
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val2->i_id' AND s_comp = '".$data['id_gdg']."' AND s_position = '".$data['id_gdg']."' limit 1) ,'0') as qtyStok"));
            $stok[] = (int)$query[0]->qtyStok;
            $txtSat1[] = DB::table('m_satuan')->select('m_sname', 'm_sid')->where('m_sid','=', $val2->i_sat1)->first();
        }
        //auth
        $staff['nama'] = Auth::user()->m_name;
        $staff['id'] = Auth::User()->m_id;
        
        return response()->json([
            'status' => 'sukses',
            'header' => $dataHeader,
            'header2' => $data,
            'stok' => $stok,
            'txtSat1' => $txtSat1,
            'data_isi' => $dataIsi,
            'staff' => $staff
        ]);
    }

    public function simpanDataPakai(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {
            $kode = $this->kodePemakaianAuto();
            //insert to table d_pakai_barang
            $dataHeader = new d_pakai_barang;
            $dataHeader->d_pb_code = $kode;
            $dataHeader->d_pb_date = date('Y-m-d',strtotime($request->headTglPakai));
            $dataHeader->d_pb_peminta = strtoupper($request->headPeminta);
            $dataHeader->d_pb_keperluan = strtoupper($request->headKeperluan);
            $dataHeader->d_pb_staff = $request->headStaffId;
            $dataHeader->d_pb_gdg = $request->headGudang;
            $dataHeader->d_pb_created = Carbon::now();
            $dataHeader->save();

            //get last lastId header
            $lastId = d_pakai_barang::select('d_pb_id')->max('d_pb_id');
            if ($lastId == 0 || $lastId == '') { $lastId  = 1; } 

            for ($i=0; $i < count($request->fieldIpItem); $i++) 
            { 
                //cari harga satuan n total dari d_stock mutation
                $data_sm =  d_stock_mutation::where('sm_item',$request->fieldIpItem[$i])
                                      ->where('sm_comp',$request->fieldIpScomp[$i])
                                      ->where('sm_position',$request->fieldIpSpos[$i])
                                      ->where('sm_qty_sisa', '>', 0)
                                      ->orderBy('sm_item','ASC')
                                      ->orderBy('sm_detailid','ASC')
                                      ->get();
                //variabel u/ cek primary satuan
                $primary_sat = DB::table('m_item')->select('m_item.*')->where('i_id', $request->fieldIpItem[$i])->first();
            
                //cek satuan primary, convert ke primary apabila beda satuan
                if ($primary_sat->i_sat1 == $request->fieldIpSatId[$i]) 
                {
                    $hasilConvert = (int)$request->fieldIpQty[$i] * (int)$primary_sat->i_sat_isi1;
                    $isiQty = $primary_sat->i_sat_isi1;
                    $flagMasterHarga = 1;
                }
                elseif ($primary_sat->i_sat2 == $request->fieldIpSatId[$i])
                {
                    $hasilConvert = (int)$request->fieldIpQty[$i] * (int)$primary_sat->i_sat_isi2;
                    $isiQty = $primary_sat->i_sat_isi2;
                    $flagMasterHarga = 2;
                }
                else
                {
                    $hasilConvert = (int)$request->fieldIpQty[$i] * (int)$primary_sat->i_sat_isi3;
                    $isiQty = $primary_sat->i_sat_isi3;
                    $flagMasterHarga = 3;
                }

                if (count($data_sm) > 0) 
                {
                    $qty_req = $hasilConvert;
                    for ($j=0; $j < count($data_sm); $j++) 
                    {
                        $qty_sisa = $data_sm[$j]->sm_qty_sisa;

                        if ($qty_req <= $qty_sisa) 
                        {
                            $h_satsm = $data_sm[$j]->sm_hpp;
                            // $h_satsm = $data_sm[$j]->sm_hpp / $data_sm[$j]->sm_qty;
                            $h_sat = $h_satsm * $isiQty;
                            $h_total = $h_sat * ($qty_req / $isiQty);

                            $dataIsi = new d_pakai_barangdt;
                            $dataIsi->d_pbdt_pbid = $lastId;
                            $dataIsi->d_pbdt_item = $request->fieldIpItem[$i];
                            $dataIsi->d_pbdt_sat = $request->fieldIpSatId[$i];
                            $dataIsi->d_pbdt_qty = $qty_req / $isiQty;
                            $dataIsi->d_pbdt_price = $h_sat;
                            $dataIsi->d_pbdt_pricetotal = $h_total;
                            $dataIsi->d_pbdt_keterangan = strtoupper($request->fieldIpKet[$i]);
                            $dataIsi->d_pbdt_created = Carbon::now();
                            $dataIsi->save();
                            $j = count($data_sm);
                        }
                        elseif ($qty_req > $qty_sisa) 
                        {
                            $h_satsm = $data_sm[$j]->sm_hpp;
                            //$h_satsm = $data_sm[$j]->sm_hpp / $data_sm[$j]->sm_qty;
                            $h_sat = $h_satsm * $isiQty;
                            $h_total = $h_sat * ($qty_sisa / $isiQty);
                            $qty_form = $qty_sisa / $isiQty; //qty yg diminta pada form 
                            $qty_req = $qty_req - $qty_sisa;
                            
                            $dataIsi = new d_pakai_barangdt;
                            $dataIsi->d_pbdt_pbid = $lastId;
                            $dataIsi->d_pbdt_item = $request->fieldIpItem[$i];
                            $dataIsi->d_pbdt_sat = $request->fieldIpSatId[$i];
                            $dataIsi->d_pbdt_qty = $qty_form;
                            $dataIsi->d_pbdt_price = $h_sat;
                            $dataIsi->d_pbdt_pricetotal = $h_total;
                            $dataIsi->d_pbdt_keterangan = strtoupper($request->fieldIpKet[$i]);
                            $dataIsi->d_pbdt_created = Carbon::now();
                            $dataIsi->save();
                        }
                    }   
                }
                else
                {
                    //ambil harga dari master
                    $harga_master = DB::table('m_price')
                                        ->select('m_pbuy1', 'm_pbuy2', 'm_pbuy3')
                                        ->where('m_pitem', $request->fieldIpItem[$i])->first();

                    if ($flagMasterHarga == 1) 
                    {
                        $dt_price = $harga_master->m_pbuy1;
                        $dt_pricetotal = $dt_price * $request->fieldIpQty[$i];
                    }
                    elseif ($flagMasterHarga == 2)
                    {
                        $dt_price = $harga_master->m_pbuy2;
                        $dt_pricetotal = $dt_price * $request->fieldIpQty[$i];   
                    }
                    else
                    {
                        $dt_price = $harga_master->m_pbuy3;
                        $dt_pricetotal = $dt_price * $request->fieldIpQty[$i];
                    }

                    $dataIsi = new d_pakai_barangdt;
                    $dataIsi->d_pbdt_pbid = $lastId;
                    $dataIsi->d_pbdt_item = $request->fieldIpItem[$i];
                    $dataIsi->d_pbdt_sat = $request->fieldIpSatId[$i];
                    $dataIsi->d_pbdt_qty = $request->fieldIpQty[$i];
                    $dataIsi->d_pbdt_price = $dt_price;
                    $dataIsi->d_pbdt_pricetotal = $dt_pricetotal;
                    $dataIsi->d_pbdt_keterangan = strtoupper($request->fieldIpKet[$i]);
                    $dataIsi->d_pbdt_created = Carbon::now();
                    $dataIsi->save();
                }

                if(mutasi::mutasiStok(
                    $request->fieldIpItem[$i], //item id
                    $hasilConvert, //qty hasil convert satuan terpilih -> satuan primary 
                    $comp = $request->fieldIpScomp[$i], //posisi gudang berdasarkan type item
                    $position = $request->fieldIpSpos[$i], //posisi gudang berdasarkan type item
                    $flag = 10, //sm mutcat
                    $kode //sm reff
                )) {}
            }//end loop for                

            DB::commit();
            return response()->json([
                'status' => 'sukses',
                'pesan' => 'Data Barang Digunakan Berhasil Disimpan'
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

    public function updateDataPakai(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try {
            //hapus to table d_pakai_barangdt
            d_pakai_barangdt::where('d_pbdt_pbid', $request->idPakaiEdit)->delete();

            //update to table d_pakaibarang
            $data_header = d_pakai_barang::find($request->idPakaiEdit);
            $data_header->d_pb_date = date('Y-m-d',strtotime(Carbon::now()));
            $data_header->d_pb_updated = Carbon::now();
            $data_header->d_pb_staff = $request->idStaffEdit;
            $data_header->save();

            //ambil data d_stock_mutation 
            $data_sm = DB::table('d_stock_mutation')
                    ->where('sm_reff', $request->codePakaiEdit)
                    ->orderBy('sm_stock','ASC')
                    ->orderBy('sm_detailid','ASC')
                    ->get();
            //dd($data_sm);
            foreach ($data_sm as $value) 
            {
                //array variabel u/ simpan data stok mutasi
                $sm_stock[] = $value->sm_stock;
                $sm_detailid[] = $value->sm_detailid;
                $sm_item[] = $value->sm_item;
                $sm_qty[] = $value->sm_qty;
                $sm_hpp[] = $value->sm_hpp;
                $sm_comp[] = $value->sm_comp;
                $sm_pos[] = $value->sm_position;
            }

            for ($i=0; $i < count($sm_stock); $i++) 
            {
                //cari id & s_qty d_stock
                $q_dstock = DB::table('d_stock')
                        ->select('s_id', 's_qty')
                        ->where('s_item', $sm_item[$i])
                        ->where('s_comp', $sm_comp[$i])
                        ->where('s_position', $sm_pos[$i])
                        ->first();
                //kembalikan stok sebelum pakai
                $stokAkhir = abs($sm_qty[$i]) + (int)$q_dstock->s_qty;
                // update d_stock
                DB::table('d_stock')
                    ->where('s_id', $sm_stock[$i])
                    ->update(['s_qty' => $stokAkhir]);

                //ambil data penerimaan d_stock_mutation 
                $data_sm_masuk = d_stock_mutation::where('sm_qty_used','>',0)
                                    ->where('sm_item', $sm_item[$i])
                                    ->where('sm_comp', $sm_comp[$i])
                                    ->where('sm_position', $sm_pos[$i])
                                    ->where('sm_hpp', $sm_hpp[$i])
                                    ->orderBy('sm_stock','ASC')
                                    ->orderBy('sm_detailid','ASC')
                                    ->get(); 

                $qtyPakai = abs($sm_qty[$i]);
                for ($z=0; $z <count($data_sm_masuk); $z++) 
                { 
                  if ($qtyPakai <= $data_sm_masuk[$z]->sm_qty_used) 
                  {
                    $qty_awal = (int)$data_sm_masuk[$z]->sm_qty_used - (int)$qtyPakai;
                    $qty_sisa = (int)$data_sm_masuk[$z]->sm_qty_sisa + (int)$qtyPakai;
                    // update d_stock_mutation
                    DB::table('d_stock_mutation')
                      ->where('sm_stock', '=', $data_sm_masuk[$z]->sm_stock)
                      ->where('sm_detailid', $data_sm_masuk[$z]->sm_detailid)
                      ->update(array(
                          'sm_qty_used' => $qty_awal,
                          'sm_qty_sisa' => $qty_sisa
                      ));
                    $z = count($data_sm_masuk);
                  }
                  elseif ($qtyPakai > $data_sm_masuk[$z]->sm_qty_used)
                  {
                    $selisih = (int)$qtyPakai - (int)$data_sm_masuk[$z]->sm_qty_used;
                    $qty_awal = (int)$data_sm_masuk[$z]->sm_qty_used - ((int)$qtyPakai - (int)$selisih);
                    $qty_sisa = (int)$data_sm_masuk[$z]->sm_qty_sisa + ((int)$qtyPakai - (int)$selisih);
                    $qtyPakai = $selisih;
                    // update d_stock_mutation
                    DB::table('d_stock_mutation')
                      ->where('sm_stock', '=', $data_sm_masuk[$z]->sm_stock)
                      ->where('sm_detailid', $data_sm_masuk[$z]->sm_detailid)
                      ->update(array(
                          'sm_qty_used' => $qty_awal,
                          'sm_qty_sisa' => $qty_sisa
                      ));
                  }
                }

               /* // for ($j=0; $j <count($data_sm_masuk); $j++) 
                // { 
                    if (abs($sm_qty[$i]) <= $data_sm_masuk->sm_qty_used) 
                    {
                        $qty_awal = (int)$data_sm_masuk->sm_qty_used + (int)$sm_qty[$i];
                        $qty_sisa = (int)$data_sm_masuk->sm_qty_sisa - (int)$sm_qty[$i];
                        // update d_stock_mutation
                        DB::table('d_stock_mutation')
                            ->where('sm_stock', '=', $data_sm_masuk->sm_stock)
                            ->where('sm_detailid', $data_sm_masuk->sm_detailid)
                            ->update(array(
                                'sm_qty_used' => $qty_awal,
                                'sm_qty_sisa' => $qty_sisa
                            ));
                    }
                // }*/

                //delete row table d_stock_mutation
                DB::table('d_stock_mutation')
                  ->where('sm_stock', '=', $sm_stock[$i])
                  ->where('sm_detailid', '=', $sm_detailid[$i])
                  ->delete();
            }

            //add data pada d_pakai_barang
            for ($j=0; $j < count($request->fieldEditItem); $j++) 
            {
                //cari harga satuan n total dari d_stock mutation
                $data_sm2 =  d_stock_mutation::where('sm_item',$request->fieldEditItem[$j])
                                ->where('sm_comp',$request->fieldEditScomp[$j])
                                ->where('sm_position',$request->fieldEditSpos[$j])
                                ->where('sm_qty_sisa', '>', 0)
                                ->orderBy('sm_item','ASC')
                                ->orderBy('sm_detailid','ASC')
                                ->get();
                //variabel u/ cek primary satuan
                $primary_sat = DB::table('m_item')->select('m_item.*')->where('i_id', $request->fieldEditItem[$j])->first();
                //cek satuan primary, convert ke primary apabila beda satuan
                if ($primary_sat->i_sat1 == $request->fieldEditSatId[$j]) 
                {
                    $hasilConvert = (int)$request->fieldEditQty[$j] * (int)$primary_sat->i_sat_isi1;
                    $isiQty = $primary_sat->i_sat_isi1;
                    $flagMasterHarga = 1;
                }
                elseif ($primary_sat->i_sat2 == $request->fieldEditSatId[$j])
                {
                    $hasilConvert = (int)$request->fieldEditQty[$j] * (int)$primary_sat->i_sat_isi2;
                    $isiQty = $primary_sat->i_sat_isi2;
                    $flagMasterHarga = 2;
                }
                else
                {
                    $hasilConvert = (int)$request->fieldEditQty[$j] * (int)$primary_sat->i_sat_isi3;
                    $isiQty = $primary_sat->i_sat_isi3;
                    $flagMasterHarga = 3;
                }

                if (count($data_sm2) > 0) 
                {
                    $qty_req = $hasilConvert;
                    for ($k=0; $k < count($data_sm2); $k++) 
                    {
                        $qty_sisa = $data_sm2[$k]->sm_qty_sisa;
                        if ($qty_req <= $qty_sisa) 
                        {
                            $h_satsm = $data_sm2[$k]->sm_hpp;
                            //$h_satsm = $data_sm2[$k]->sm_hpp / $data_sm2[$k]->sm_qty;
                            $h_sat = $h_satsm * $isiQty;
                            $h_total = $h_sat * ($qty_req / $isiQty);

                            $dataIsi = new d_pakai_barangdt;
                            $dataIsi->d_pbdt_pbid = $request->idPakaiEdit;
                            $dataIsi->d_pbdt_item = $request->fieldEditItem[$j];
                            $dataIsi->d_pbdt_sat = $request->fieldEditSatId[$j];
                            $dataIsi->d_pbdt_qty = $qty_req / $isiQty;
                            $dataIsi->d_pbdt_price = $h_sat;
                            $dataIsi->d_pbdt_pricetotal = $h_total;
                            $dataIsi->d_pbdt_keterangan = strtoupper($request->fieldEditKet[$j]);
                            $dataIsi->d_pbdt_created = Carbon::now();
                            $dataIsi->save();
                            $k = count($data_sm2);
                        }
                        elseif ($qty_req > $qty_sisa) 
                        {
                            $h_satsm = $data_sm2[$k]->sm_hpp;
                            //$h_satsm = $data_sm2[$k]->sm_hpp / $data_sm2[$k]->sm_qty;
                            $h_sat = $h_satsm * $isiQty;
                            $h_total = $h_sat * ($qty_sisa / $isiQty);
                            $qty_form = $qty_sisa / $isiQty; //qty yg diminta pada form 
                            $qty_req = $qty_req - $qty_sisa;
                            
                            $dataIsi = new d_pakai_barangdt;
                            $dataIsi->d_pbdt_pbid = $request->idPakaiEdit;
                            $dataIsi->d_pbdt_item = $request->fieldEditItem[$j];
                            $dataIsi->d_pbdt_sat = $request->fieldEditSatId[$j];
                            $dataIsi->d_pbdt_qty = $qty_form;
                            $dataIsi->d_pbdt_price = $h_sat;
                            $dataIsi->d_pbdt_pricetotal = $h_total;
                            $dataIsi->d_pbdt_keterangan = strtoupper($request->fieldEditKet[$j]);
                            $dataIsi->d_pbdt_created = Carbon::now();
                            $dataIsi->save();
                        }
                    }   
                }
                else
                {
                    //ambil harga dari master
                    $harga_master = DB::table('m_price')
                                        ->select('m_pbuy1', 'm_pbuy2', 'm_pbuy3')
                                        ->where('m_pitem', $request->fieldEditItem[$j])->first();

                    if ($flagMasterHarga == 1) 
                    {
                        $dt_price = $harga_master->m_pbuy1;
                        $dt_pricetotal = $dt_price * $request->fieldEditQty[$j];
                    }
                    elseif ($flagMasterHarga == 2)
                    {
                        $dt_price = $harga_master->m_pbuy2;
                        $dt_pricetotal = $dt_price * $request->fieldEditQty[$j];   
                    }
                    else
                    {
                        $dt_price = $harga_master->m_pbuy3;
                        $dt_pricetotal = $dt_price * $request->fieldEditQty[$j];
                    }

                    $dataIsi = new d_pakai_barangdt;
                    $dataIsi->d_pbdt_pbid = $request->idPakaiEdit;
                    $dataIsi->d_pbdt_item = $request->fieldEditItem[$j];
                    $dataIsi->d_pbdt_sat = $request->fieldEditSatId[$j];
                    $dataIsi->d_pbdt_qty = $request->fieldEditQty[$j];
                    $dataIsi->d_pbdt_price = $dt_price;
                    $dataIsi->d_pbdt_pricetotal = $dt_pricetotal;
                    $dataIsi->d_pbdt_keterangan = strtoupper($request->fieldEditKet[$j]);
                    $dataIsi->d_pbdt_created = Carbon::now();
                    $dataIsi->save();
                }

                if(mutasi::mutasiStok(
                    $request->fieldEditItem[$j], //item id
                    $hasilConvert, //qty hasil convert satuan terpilih -> satuan primary 
                    $comp = $request->fieldEditScomp[$j], //posisi gudang berdasarkan type item
                    $position = $request->fieldEditSpos[$j], //posisi gudang berdasarkan type item
                    $flag = 10, //sm mutcat
                    $request->codePakaiEdit //sm reff
                )) {}
            }//end loop for2

            DB::commit();
            return response()->json([
                'status' => 'sukses',
                'pesan' => 'Data Pemakaian Barang Berhasil Diupdate'
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

    public function deleteDataPakai(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try {
            //ambil code d_pakai_barang
            $code_pakai = d_pakai_barang::select('d_pb_code')->where('d_pb_id', $request->id)->first();
            //ambil data pakai d_stock_mutation 
            $data_sm = DB::table('d_stock_mutation')->where('sm_reff', $code_pakai->d_pb_code)->orderBy('sm_stock','ASC')
                        ->orderBy('sm_detailid','ASC')->get();
            //dd($data_sm);
            foreach ($data_sm as $value) 
            {
                //array variabel u/ simpan data stok mutasi
                $sm_stock[] = $value->sm_stock;
                $sm_detailid[] = $value->sm_detailid;
                $sm_item[] = $value->sm_item;
                $sm_qty[] = $value->sm_qty;
                $sm_hpp[] = $value->sm_hpp;
                $sm_comp[] = $value->sm_comp;
                $sm_pos[] = $value->sm_position;
            }

            for ($i=0; $i < count($sm_stock); $i++) 
            { 
                //cari id & s_qty d_stock
                $q_dstock = DB::table('d_stock')
                            ->select('s_id', 's_qty')
                            ->where('s_item', $sm_item[$i])
                            ->where('s_comp', $sm_comp[$i])
                            ->where('s_position', $sm_pos[$i])
                            ->first();

                //kembalikan stok sebelum pakai
                $stokAkhir = abs($sm_qty[$i]) + (int)$q_dstock->s_qty;
                // update d_stock
                DB::table('d_stock')
                    ->where('s_id', $sm_stock[$i])
                    ->update(['s_qty' => $stokAkhir]);

                //ambil data penerimaan d_stock_mutation 
                $data_sm_masuk = d_stock_mutation::where('sm_qty_used','>',0)
                                    ->where('sm_stock', $sm_stock[$i])
                                    ->where('sm_item', $sm_item[$i])
                                    ->where('sm_comp', $sm_comp[$i])
                                    ->where('sm_position', $sm_pos[$i])
                                    ->where('sm_hpp', $sm_hpp[$i])
                                    ->orderBy('sm_stock','ASC')
                                    ->orderBy('sm_detailid','ASC')
                                    ->get();

                $qtyPakai = abs($sm_qty[$i]);
                for ($j=0; $j <count($data_sm_masuk); $j++) 
                { 
                  if ($qtyPakai <= $data_sm_masuk[$j]->sm_qty_used) 
                  {
                    $qty_awal = (int)$data_sm_masuk[$j]->sm_qty_used - (int)$qtyPakai;
                    $qty_sisa = (int)$data_sm_masuk[$j]->sm_qty_sisa + (int)$qtyPakai;
                    // update d_stock_mutation
                    DB::table('d_stock_mutation')
                      ->where('sm_stock', '=', $data_sm_masuk[$j]->sm_stock)
                      ->where('sm_detailid', $data_sm_masuk[$j]->sm_detailid)
                      ->update(array(
                          'sm_qty_used' => $qty_awal,
                          'sm_qty_sisa' => $qty_sisa
                      ));
                    $j = count($data_sm_masuk);
                  }
                  elseif ($qtyPakai > $data_sm_masuk[$j]->sm_qty_used)
                  {
                    $selisih = (int)$qtyPakai - (int)$data_sm_masuk[$j]->sm_qty_used;
                    $qty_awal = (int)$data_sm_masuk[$j]->sm_qty_used - ((int)$qtyPakai - (int)$selisih);
                    $qty_sisa = (int)$data_sm_masuk[$j]->sm_qty_sisa + ((int)$qtyPakai - (int)$selisih);
                    $qtyPakai = $selisih;
                    // update d_stock_mutation
                    DB::table('d_stock_mutation')
                      ->where('sm_stock', '=', $data_sm_masuk[$j]->sm_stock)
                      ->where('sm_detailid', $data_sm_masuk[$j]->sm_detailid)
                      ->update(array(
                          'sm_qty_used' => $qty_awal,
                          'sm_qty_sisa' => $qty_sisa
                      ));
                  }
                }

                //delete row table d_stock_mutation
                DB::table('d_stock_mutation')
                  ->where('sm_stock', '=', $sm_stock[$i])
                  ->where('sm_detailid', '=', $sm_detailid[$i])
                  ->delete();
            }

            //delete row table d_pakai_barangdt
            d_pakai_barangdt::where('d_pbdt_pbid', $request->id)->delete();
            //delete row table d_pakai_barang
            d_pakai_barang::where('d_pb_id', $request->id)->delete();
    
            DB::commit();
            return response()->json([
                'status' => 'sukses',
                'pesan' => 'Data Pemakaian Barang Berhasil Dihapus'
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

    public function kodePemakaianAuto()
    {
        $query = DB::select(DB::raw("SELECT MAX(RIGHT(d_pb_code,5)) as kode_max from d_pakai_barang WHERE DATE_FORMAT(d_pb_created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));
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

        return $codePakaiBrg = "PBG-".date('ym')."-".$kd;
    }

    public function printSuratJalan($id)
    {
        $dataHeader = d_pakai_barang::join('d_gudangcabang','d_pakai_barang.d_pb_gdg','=','d_gudangcabang.cg_id')
              ->join('d_mem','d_pakai_barang.d_pb_staff','=','d_mem.m_id')
              ->select('d_pakai_barang.*', 'd_mem.m_id', 'd_mem.m_name', 'd_gudangcabang.cg_id', 'd_gudangcabang.cg_cabang')
              ->where('d_pakai_barang.d_pb_id', '=', $id)
              ->orderBy('d_pakai_barang.d_pb_created', 'DESC')
              ->get()->toArray();

        //dd($dataHeader[0]['d_pb_gdg']);
        $dataIsi = d_pakai_barangdt::join('d_pakai_barang', 'd_pakai_barangdt.d_pbdt_pbid', '=', 'd_pakai_barang.d_pb_id')
            ->join('m_item', 'd_pakai_barangdt.d_pbdt_item', '=', 'm_item.i_id')
            ->join('m_satuan', 'd_pakai_barangdt.d_pbdt_sat', '=', 'm_satuan.m_sid')
            ->select(
                'd_pakai_barangdt.d_pbdt_id',
                'd_pakai_barangdt.d_pbdt_pbid',
                'd_pakai_barangdt.d_pbdt_item',
                'd_pakai_barangdt.d_pbdt_sat',
                DB::raw('sum(d_pakai_barangdt.d_pbdt_qty) as qty_pakai'),
                DB::raw('sum(d_pakai_barangdt.d_pbdt_price) as harga_sat'),
                DB::raw('sum(d_pakai_barangdt.d_pbdt_pricetotal) as harga_tot'),
                'd_pakai_barangdt.d_pbdt_keterangan',
                'm_item.*',
                'd_pakai_barang.d_pb_code',
                'm_satuan.m_sid',
                'm_satuan.m_sname'
            )
            ->where('d_pakai_barangdt.d_pbdt_pbid', '=', $id)
            ->groupBy('d_pakai_barangdt.d_pbdt_item')
            ->orderBy('d_pakai_barangdt.d_pbdt_created', 'DESC')
            ->get()->toArray();

        /*foreach ($dataHeader as $val) 
        {*/
            $data = array(
              'id_gdg' => $dataHeader[0]['d_pb_gdg'],
              'tgl_pakai' => date('d-m-Y',strtotime($dataHeader[0]['d_pb_date']))
            );
        /*}*/

        for ($i=0; $i <count($dataIsi); $i++) 
        { 
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '".$dataIsi[$i]['i_id']."' AND s_comp = '".$data['id_gdg']."' AND s_position = '".$data['id_gdg']."' limit 1) ,'0') as qtyStok"));
            $stok[] = (int)$query[0]->qtyStok;
            $txtSat1[] = DB::table('m_satuan')->select('m_sname', 'm_sid')->where('m_sid','=', $dataIsi[$i]['i_sat1'])->first();
        }

        $val_stock = [];
        $txt_satuan = [];

        $val_stock = array_chunk($stok, 14);
        $txt_satuan = array_chunk($txtSat1, 14);
        $dataIsi = array_chunk($dataIsi, 14);
        //dd($dataIsi, $val_stock, $txt_satuan);
           
        return view('inventory.b_digunakan.print', compact('dataHeader', 'dataIsi', 'val_stock', 'txt_satuan'));
    }

    public function getHistoryByTgl($tgl1, $tgl2, $tampil)
    {
        $y = substr($tgl1, -4);
        $m = substr($tgl1, -7,-5);
        $d = substr($tgl1,0,2);
        $tanggal1 = $y.'-'.$m.'-'.$d;

        $y2 = substr($tgl2, -4);
        $m2 = substr($tgl2, -7,-5);
        $d2 = substr($tgl2,0,2);
        $tanggal2 = $y2.'-'.$m2.'-'.$d2;

        $data = d_pakai_barangdt::select('d_pakai_barangdt.*', 'd_pakai_barang.*', 'm_item.i_name', 'm_satuan.m_sname', DB::raw('sum(d_pakai_barangdt.d_pbdt_qty) as qty_pakai'))
            ->leftJoin('d_pakai_barang','d_pakai_barangdt.d_pbdt_pbid','=','d_pakai_barang.d_pb_id')
            ->leftJoin('m_item','d_pakai_barangdt.d_pbdt_item','=','m_item.i_id')
            ->leftJoin('m_satuan','d_pakai_barangdt.d_pbdt_sat','=','m_satuan.m_sid')
            ->where('d_pakai_barang.d_pb_gdg', '=', $tampil)
            ->whereBetween('d_pakai_barang.d_pb_date', [$tanggal1, $tanggal2])
            ->groupBy('d_pakai_barangdt.d_pbdt_pbid')
            ->groupBy('d_pakai_barangdt.d_pbdt_item')
            ->orderBy('d_pakai_barang.d_pb_created', 'DESC')
            ->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('tglPakai', function ($data) 
        {
            if ($data->d_pbdt_created == null) 
            {
                return '-';
            }
            else 
            {
                return $data->d_pbdt_created ? with(new Carbon($data->d_pbdt_created))->format('d M Y') : '';
            }
        })
        // ->rawColumns(['status', 'action'])
        ->make(true);
    }

    // ===============================================================================================================

}
