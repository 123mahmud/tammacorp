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
use App\d_barang_rusak;
use App\d_barang_rusakdt;
use App\d_ubah_jenis;
use App\d_ubah_jenisdt;
use App\d_stock;
use App\d_stock_mutation;
use App\lib\mutasi;

class BarangRusakController extends Controller
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
    
    public function index()
    {
        return view('inventory/b_rusak/index');
    }

    public function lookupDataGudang(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term)) 
        {
            $data = DB::table('d_gudangcabang')->limit(10)->get();
            foreach ($data as $val) 
            {
                $formatted_tags[] = ['id' => $val->cg_id, 'text' => $val->cg_cabang];
            }
            return Response::json($formatted_tags);
        }
        else
        {
            $data = DB::table('d_gudangcabang')->where('cg_cabang', 'LIKE', '%'.$term.'%')->limit(10)->get();

            foreach ($data as $val) 
            {
                $formatted_tags[] = ['id' => $val->cg_id, 'text' => $val->cg_cabang];
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
            ->select('m_item.i_id','m_item.i_type','m_item.i_sat1','m_item.i_sat2','m_item.i_sat3','m_item.i_code','m_item.i_name','d_stock.s_id','d_stock.s_qty','d_stock.s_position','d_stock.s_comp')
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

    public function getBrgRusakByTgl($tgl1, $tgl2)
    {
        $y = substr($tgl1, -4);
        $m = substr($tgl1, -7,-5);
        $d = substr($tgl1,0,2);
        $tanggal1 = $y.'-'.$m.'-'.$d;

        $y2 = substr($tgl2, -4);
        $m2 = substr($tgl2, -7,-5);
        $d2 = substr($tgl2,0,2);
        $tanggal2 = $y2.'-'.$m2.'-'.$d2;

        $data = d_barang_rusak::join('d_gudangcabang','d_barang_rusak.d_br_gdg','=','d_gudangcabang.cg_id')
              ->join('d_mem','d_barang_rusak.d_br_staff','=','d_mem.m_id')
              ->select('d_barang_rusak.*', 'd_mem.m_id', 'd_mem.m_name', 'd_gudangcabang.cg_id', 'd_gudangcabang.cg_cabang')
              ->where('d_br_status', '=', 'BR')
              ->whereBetween('d_br_date', [$tanggal1, $tanggal2])
              ->orderBy('d_br_created', 'DESC')
              ->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('tglBuat', function ($data) 
        {
            if ($data->d_br_date == null) 
            {
                return '-';
            }
            else 
            {
                return $data->d_br_date ? with(new Carbon($data->d_br_date))->format('d M Y') : '';
            }
        })
        ->addColumn('action', function($data)
        {
            return '<div class="text-center">
                        <button class="btn btn-sm btn-success" title="Detail"
                            onclick=detailBrgRusak("'.$data->d_br_id.'")><i class="fa fa-eye"></i> 
                        </button>
                        <button class="btn btn-sm btn-info" title="Opsi"
                            onclick=opsiBrgRusak("'.$data->d_br_id.'")><i class="glyphicon glyphicon-th-large"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" title="Delete"
                            onclick=deleteBrgRusak("'.$data->d_br_id.'")><i class="glyphicon glyphicon-trash"></i>
                        </button>
                    </div>'; 
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function getBrgMusnahByTgl($tgl1, $tgl2)
    {
        $y = substr($tgl1, -4);
        $m = substr($tgl1, -7,-5);
        $d = substr($tgl1,0,2);
        $tanggal1 = $y.'-'.$m.'-'.$d;

        $y2 = substr($tgl2, -4);
        $m2 = substr($tgl2, -7,-5);
        $d2 = substr($tgl2,0,2);
        $tanggal2 = $y2.'-'.$m2.'-'.$d2;

        $data = d_barang_rusakdt::join('d_barang_rusak','d_barang_rusakdt.d_brdt_brid','=','d_barang_rusak.d_br_id')
              ->join('m_item','d_barang_rusakdt.d_brdt_item','=','m_item.i_id')
              ->join('m_satuan','d_barang_rusakdt.d_brdt_sat','=','m_satuan.m_sid')
              ->join('d_gudangcabang','d_barang_rusak.d_br_gdg','=','d_gudangcabang.cg_id')
              ->join('d_mem','d_barang_rusak.d_br_staff','=','d_mem.m_id')
              ->select('d_barang_rusakdt.*', 'd_barang_rusak.*', 'd_mem.m_name', 'd_gudangcabang.cg_id', 'd_gudangcabang.cg_cabang','m_item.i_name','m_item.i_code','m_item.i_sat1','m_item.i_id','m_satuan.m_sname','m_satuan.m_sid')
              ->where('d_barang_rusak.d_br_status', '=', 'MU')
              ->whereBetween('d_barang_rusak.d_br_date', [$tanggal1, $tanggal2])
              ->orderBy('d_barang_rusak.d_br_created', 'DESC')
              ->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('tglBuat', function ($data) 
        {
            if ($data->d_br_date == null) 
            {
                return '-';
            }
            else 
            {
                return $data->d_br_date ? with(new Carbon($data->d_br_date))->format('d M Y') : '';
            }
        })
        ->editColumn('namaItem', function ($data) 
        {
            return $data->i_code.' '.$data->i_name;
        })
        ->make(true);
    }

    public function getBrgUbahJenisByTgl($tgl1, $tgl2)
    {
        $y = substr($tgl1, -4);
        $m = substr($tgl1, -7,-5);
        $d = substr($tgl1,0,2);
        $tanggal1 = $y.'-'.$m.'-'.$d;

        $y2 = substr($tgl2, -4);
        $m2 = substr($tgl2, -7,-5);
        $d2 = substr($tgl2,0,2);
        $tanggal2 = $y2.'-'.$m2.'-'.$d2;

        $data = d_barang_rusakdt::join('d_barang_rusak','d_barang_rusakdt.d_brdt_brid','=','d_barang_rusak.d_br_id')
              ->join('m_item','d_barang_rusakdt.d_brdt_item','=','m_item.i_id')
              ->join('m_satuan','d_barang_rusakdt.d_brdt_sat','=','m_satuan.m_sid')
              ->join('d_gudangcabang','d_barang_rusak.d_br_gdg','=','d_gudangcabang.cg_id')
              ->join('d_mem','d_barang_rusak.d_br_staff','=','d_mem.m_id')
              ->select('d_barang_rusakdt.*', 'd_barang_rusak.*', 'd_mem.m_name', 'd_gudangcabang.cg_id', 'd_gudangcabang.cg_cabang','m_item.i_name','m_item.i_code','m_item.i_sat1','m_item.i_id','m_satuan.m_sname','m_satuan.m_sid')
              // ->where('d_barang_rusak.d_br_status', '=', 'PJ')
              ->where('d_barang_rusakdt.d_brdt_isubah', '=', 'Y')
              ->whereBetween('d_barang_rusak.d_br_date', [$tanggal1, $tanggal2])
              ->orderBy('d_barang_rusak.d_br_created', 'DESC')
              ->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('tglBuat', function ($data) 
        {
            if ($data->d_br_date == null) 
            {
                return '-';
            }
            else 
            {
                return $data->d_br_date ? with(new Carbon($data->d_br_date))->format('d M Y') : '';
            }
        })
        ->editColumn('namaItem', function ($data) 
        {
            return $data->i_code.' '.$data->i_name;
        })
        ->addColumn('action', function($data)
        {
        
            return '<div class="text-center">
                        <button class="btn btn-sm btn-info" title="Edit"
                            onclick=prosesUbahJenis("'.$data->d_brdt_id.'")><i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" title="Hapus"
                            onclick=hapusUbahJenis("'.$data->d_brdt_id.'")><i class="fa fa-times"></i>
                        </button>
                    </div>'; 
        
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function detailBrgRusak($id)
    {
        $dataHeader = d_barang_rusak::join('d_gudangcabang','d_barang_rusak.d_br_gdg','=','d_gudangcabang.cg_id')
              ->join('d_mem','d_barang_rusak.d_br_staff','=','d_mem.m_id')
              ->select('d_barang_rusak.*', 'd_mem.m_id', 'd_mem.m_name', 'd_gudangcabang.cg_id', 'd_gudangcabang.cg_cabang')
              ->where('d_barang_rusak.d_br_id', '=', $id)
              ->orderBy('d_barang_rusak.d_br_created', 'DESC')
              ->get();
    
        $dataIsi = d_barang_rusakdt::join('d_barang_rusak', 'd_barang_rusakdt.d_brdt_brid', '=', 'd_barang_rusak.d_br_id')
            ->join('m_item', 'd_barang_rusakdt.d_brdt_item', '=', 'm_item.i_id')
            ->join('m_satuan', 'd_barang_rusakdt.d_brdt_sat', '=', 'm_satuan.m_sid')
            ->select(
                'd_barang_rusakdt.d_brdt_id',
                'd_barang_rusakdt.d_brdt_brid',
                'd_barang_rusakdt.d_brdt_item',
                'd_barang_rusakdt.d_brdt_sat',
                DB::raw('sum(d_barang_rusakdt.d_brdt_qty) as qty_pakai'),
                DB::raw('sum(d_barang_rusakdt.d_brdt_price) as harga_sat'),
                DB::raw('sum(d_barang_rusakdt.d_brdt_pricetotal) as harga_tot'),
                'd_barang_rusakdt.d_brdt_keterangan',
                'm_item.*',
                'd_barang_rusak.d_br_code',
                'm_satuan.m_sid',
                'm_satuan.m_sname'
            )
            ->where('d_barang_rusakdt.d_brdt_brid', '=', $id)
            ->where('d_barang_rusakdt.d_brdt_isubah', '=', 'N')
            ->groupBy('d_barang_rusakdt.d_brdt_item')
            ->orderBy('d_barang_rusakdt.d_brdt_created', 'DESC')
            ->get();


        foreach ($dataHeader as $val) 
        {
            $data = array(
              'id_gdg' => $val->d_br_gdg,
              'tgl_pakai' => date('d-m-Y',strtotime($val->d_br_date))
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

    public function detailBrgUbahJenis($id)
    {
        $dataIsi = d_barang_rusakdt::join('d_barang_rusak', 'd_barang_rusakdt.d_brdt_brid', '=', 'd_barang_rusak.d_br_id')
            ->join('m_item', 'd_barang_rusakdt.d_brdt_item', '=', 'm_item.i_id')
            ->join('m_satuan', 'd_barang_rusakdt.d_brdt_sat', '=', 'm_satuan.m_sid')
            ->select(
                'd_barang_rusakdt.d_brdt_id',
                'd_barang_rusakdt.d_brdt_brid',
                'd_barang_rusakdt.d_brdt_item',
                'd_barang_rusakdt.d_brdt_sat',
                DB::raw('sum(d_barang_rusakdt.d_brdt_qty) as qty_pakai'),
                DB::raw('sum(d_barang_rusakdt.d_brdt_price) as harga_sat'),
                DB::raw('sum(d_barang_rusakdt.d_brdt_pricetotal) as harga_tot'),
                'd_barang_rusakdt.d_brdt_keterangan',
                'm_item.*',
                'd_barang_rusak.d_br_code',
                'd_barang_rusak.d_br_gdg',
                'd_barang_rusak.d_br_date',
                'd_barang_rusak.d_br_pemberi',
                'm_satuan.m_sid',
                'm_satuan.m_sname'
            )
            ->where('d_barang_rusakdt.d_brdt_id', '=', $id)
            ->groupBy('d_barang_rusakdt.d_brdt_item')
            ->orderBy('d_barang_rusakdt.d_brdt_created', 'DESC')
            ->get();


        foreach ($dataIsi as $val) 
        {
            $data = array(
              'id_gdg' => $val->d_br_gdg,
              'tgl_pakai' => date('d-m-Y',strtotime($val->d_br_date))
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
            'header2' => $data,
            'stok' => $stok,
            'txtSat1' => $txtSat1,
            'data_isi' => $dataIsi,
            'staff' => $staff
        ]);
    }

    public function simpanDataRusak(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {
            $kode = $this->kodeBrgRusakAuto();
            $dataHeader = new d_barang_rusak;
            $dataHeader->d_br_code = $kode;
            $dataHeader->d_br_date = date('Y-m-d',strtotime($request->headTglPakai));
            $dataHeader->d_br_pemberi = strtoupper($request->headPemberi);
            $dataHeader->d_br_staff = $request->headStaffId;
            $dataHeader->d_br_gdg = $request->headGudang;
            $dataHeader->d_br_status = 'BR';
            $dataHeader->d_br_created = Carbon::now();
            $dataHeader->save();

            //get last lastId header
            $lastId = d_barang_rusak::select('d_br_id')->max('d_br_id');
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

                //cari id & s_qty d_stock
                $q_dstock = DB::table('d_stock')
                        ->select('s_id', 's_qty')
                        ->where('s_item', $request->fieldIpItem[$i])
                        ->where('s_comp', '8')
                        ->where('s_position', '8')
                        ->first();

                if (!empty($q_dstock)) {
                {
                    $id_dstock = $q_dstock->s_id;
                    $stokAkhir = (int)$hasilConvert + (int)$q_dstock->s_qty;
                    // update d_stock
                    DB::table('d_stock')
                        ->where('s_id', $q_dstock->s_id)->update(['s_qty' => $stokAkhir]);
                }
                else
                {
                    $lastIdStok = d_stock::select('s_id')->max('s_id');
                    if ($lastIdStok == 0 || $lastIdStok == '') { $lastIdStok  = 1; } else { $lastIdStok += 1; }
                    $id_dstock = $lastIdStok;
                    // create row d_stock
                    DB::table('d_stock')
                        ->insert([
                            's_id'=>$lastIdStok,
                            's_comp' => '8',
                            's_position'=> '8',
                            's_item'=> $request->fieldIpItem[$i],
                            's_qty'=>$hasilConvert,
                            's_qty_min'=> 1,
                            's_insert'=>Carbon::now()
                        ]);
                }

                if (count($data_sm) > 0) 
                {
                    $dt_price = $data_sm[$i]->sm_hpp;
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

                            $dataIsi = new d_barang_rusakdt;
                            $dataIsi->d_brdt_brid = $lastId;
                            $dataIsi->d_brdt_item = $request->fieldIpItem[$i];
                            $dataIsi->d_brdt_sat = $request->fieldIpSatId[$i];
                            $dataIsi->d_brdt_qty = $qty_req / $isiQty;
                            $dataIsi->d_brdt_price = $h_sat;
                            $dataIsi->d_brdt_pricetotal = $h_total;
                            $dataIsi->d_brdt_keterangan = strtoupper($request->fieldIpKet[$i]);
                            $dataIsi->d_brdt_created = Carbon::now();
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
                            
                            $dataIsi = new d_barang_rusakdt;
                            $dataIsi->d_brdt_brid = $lastId;
                            $dataIsi->d_brdt_item = $request->fieldIpItem[$i];
                            $dataIsi->d_brdt_sat = $request->fieldIpSatId[$i];
                            $dataIsi->d_brdt_qty = $qty_form;
                            $dataIsi->d_brdt_price = $h_sat;
                            $dataIsi->d_brdt_pricetotal = $h_total;
                            $dataIsi->d_brdt_keterangan = strtoupper($request->fieldIpKet[$i]);
                            $dataIsi->d_brdt_created = Carbon::now();
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

                    $dataIsi = new d_barang_rusakdt;
                    $dataIsi->d_brdt_brid = $lastId;
                    $dataIsi->d_brdt_item = $request->fieldIpItem[$i];
                    $dataIsi->d_brdt_sat = $request->fieldIpSatId[$i];
                    $dataIsi->d_brdt_qty = $request->fieldIpQty[$i];
                    $dataIsi->d_brdt_price = $dt_price;
                    $dataIsi->d_brdt_pricetotal = $dt_pricetotal;
                    $dataIsi->d_brdt_keterangan = strtoupper($request->fieldIpKet[$i]);
                    $dataIsi->d_brdt_created = Carbon::now();
                    $dataIsi->save();
                }

                //get last id stock_mutation
                $lastIdSm = DB::select(DB::raw("SELECT IFNULL((SELECT sm_detailid FROM d_stock_mutation where sm_stock = '$id_dstock' ORDER BY sm_detailid DESC LIMIT 1) ,'0') as zz"));
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
                  'sm_stock' => $id_dstock,
                  'sm_detailid' => $hasil_id,
                  'sm_date' => Carbon::now(),
                  'sm_comp' => '8',
                  'sm_position' => '8',
                  'sm_mutcat' => '4',
                  'sm_item' => $request->fieldIpItem[$i],
                  'sm_qty' => $hasilConvert,
                  'sm_qty_used' => '0',
                  'sm_qty_expired' => '0',
                  'sm_qty_sisa' => $hasilConvert,
                  'sm_detail' => "PENAMBAHAN",
                  'sm_hpp' => $dt_price,
                  'sm_sell' => '0',
                  'sm_reff' => $kode,
                  'sm_insert' => Carbon::now(),
                ]);

                if(mutasi::mutasiStok(
                    $request->fieldIpItem[$i], //item id
                    $hasilConvert, //qty hasil convert satuan terpilih -> satuan primary 
                    $comp = $request->fieldIpScomp[$i], //posisi gudang berdasarkan type item
                    $position = $request->fieldIpSpos[$i], //posisi gudang berdasarkan type item
                    $flag = 5, //sm mutcat
                    $kode //sm reff
                )) {}
            }//end loop for                

            DB::commit();
            return response()->json([
                'status' => 'sukses',
                'pesan' => 'Data Barang Rusak Berhasil Disimpan'
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

    public function simpanUbahJenis(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {
            d_barang_rusakdt::where('d_brdt_brid', $request->idTabelHeader)->update(['d_brdt_isubah' => 'Y']);
            //cek pada table barang rusak detail, jika ispo semua tbl header ubah status ke PJ
            $this->cek_status_brgrusak($request->idTabelHeader);
            DB::commit();
            return response()->json([
                'status' => 'sukses',
                'pesan' => 'Data Barang Rusak dimasukkan pada TAB UBAH JENIS'
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

    public function prosesUbahJenis(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {
            $kodeJenis = $this->kodeUbahJenisAuto();
            $dataHeader = new d_ubah_jenis;
            $dataHeader->d_uj_code = $kodeJenis;
            $dataHeader->d_uj_date = date('Y-m-d',strtotime($request->headTglUjenis));
            $dataHeader->d_uj_staff = $request->idStaffJenis;
            $dataHeader->d_uj_gdg = $request->headGudangJenis;
            $dataHeader->d_uj_created = Carbon::now();
            $dataHeader->save();

            //get last lastId header
            $lastId = d_ubah_jenis::select('d_uj_id')->max('d_uj_id');
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

                //cari id & s_qty d_stock
                $q_dstock = DB::table('d_stock')
                        ->select('s_id', 's_qty')
                        ->where('s_item', $request->fieldIpItem[$i])
                        ->where('s_comp', '8')
                        ->where('s_position', '8')
                        ->first();

                if (count($q_dstock) > 0) 
                {
                    $id_dstock = $q_dstock->s_id;
                    $stokAkhir = (int)$hasilConvert + (int)$q_dstock->s_qty;
                    // update d_stock
                    DB::table('d_stock')
                        ->where('s_id', $q_dstock->s_id)->update(['s_qty' => $stokAkhir]);
                }
                else
                {
                    $lastIdStok = d_stock::select('s_id')->max('s_id');
                    if ($lastIdStok == 0 || $lastIdStok == '') { $lastIdStok  = 1; } else { $lastIdStok += 1; }
                    $id_dstock = $lastIdStok;
                    // create row d_stock
                    DB::table('d_stock')
                        ->insert([
                            's_id'=>$lastIdStok,
                            's_comp' => '8',
                            's_position'=> '8',
                            's_item'=> $request->fieldIpItem[$i],
                            's_qty'=>$hasilConvert,
                            's_qty_min'=> 1,
                            's_insert'=>Carbon::now()
                        ]);
                }

                if (count($data_sm) > 0) 
                {
                    $dt_price = $data_sm[$i]->sm_hpp;
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

                            $dataIsi = new d_ubah_jenisdt;
                            $dataIsi->d_ujdt_ujid = $lastId;
                            $dataIsi->d_ujdt_item = $request->fieldIpItem[$i];
                            $dataIsi->d_ujdt_sat = $request->fieldIpSatId[$i];
                            $dataIsi->d_ujdt_qty = $qty_req / $isiQty;
                            $dataIsi->d_ujdt_price = $h_sat;
                            $dataIsi->d_ujdt_pricetotal = $h_total;
                            $dataIsi->d_ujdt_keterangan = strtoupper($request->fieldIpKet[$i]);
                            $dataIsi->d_ujdt_created = Carbon::now();
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
                            
                            $dataIsi = new d_ubah_jenisdt;
                            $dataIsi->d_ujdt_ujid = $lastId;
                            $dataIsi->d_ujdt_item = $request->fieldIpItem[$i];
                            $dataIsi->d_ujdt_sat = $request->fieldIpSatId[$i];
                            $dataIsi->d_ujdt_qty = $qty_form;
                            $dataIsi->d_ujdt_price = $h_sat;
                            $dataIsi->d_ujdt_pricetotal = $h_total;
                            $dataIsi->d_ujdt_keterangan = strtoupper($request->fieldIpKet[$i]);
                            $dataIsi->d_ujdt_created = Carbon::now();
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

                    $dataIsi = new d_ubah_jenisdt;
                    $dataIsi->d_ujdt_ujid = $lastId;
                    $dataIsi->d_ujdt_item = $request->fieldIpItem[$i];
                    $dataIsi->d_ujdt_sat = $request->fieldIpSatId[$i];
                    $dataIsi->d_ujdt_qty = $request->fieldIpQty[$i];
                    $dataIsi->d_ujdt_price = $dt_price;
                    $dataIsi->d_ujdt_pricetotal = $dt_pricetotal;
                    $dataIsi->d_ujdt_keterangan = strtoupper($request->fieldIpKet[$i]);
                    $dataIsi->d_ujdt_created = Carbon::now();
                    $dataIsi->save();
                }

                //get last id stock_mutation
                $lastIdSm = DB::select(DB::raw("SELECT IFNULL((SELECT sm_detailid FROM d_stock_mutation where sm_stock = '$id_dstock' ORDER BY sm_detailid DESC LIMIT 1) ,'0') as zz"));
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
                  'sm_stock' => $id_dstock,
                  'sm_detailid' => $hasil_id,
                  'sm_date' => Carbon::now(),
                  'sm_comp' => '8',
                  'sm_position' => '8',
                  'sm_mutcat' => '4',
                  'sm_item' => $request->fieldIpItem[$i],
                  'sm_qty' => $hasilConvert,
                  'sm_qty_used' => '0',
                  'sm_qty_expired' => '0',
                  'sm_qty_sisa' => $hasilConvert,
                  'sm_detail' => "PENAMBAHAN",
                  'sm_hpp' => $dt_price,
                  'sm_sell' => '0',
                  'sm_reff' => $kodeJenis,
                  'sm_insert' => Carbon::now(),
                ]);
            }//end loop for

            //variabel u/ cek primary satuan pada field header
            $primary_sat2 = DB::table('m_item')->select('m_item.*')->where('i_id', $request->idBrgRusak)->first();
        
            //cek satuan primary, convert ke primary apabila beda satuan
            if ($primary_sat2->i_sat1 == $request->satBrgRusak) 
            {
                $hasilConvert2 = (int)$request->qtyBrgRusak * (int)$primary_sat2->i_sat_isi1;
                $isiQty2 = $primary_sat2->i_sat_isi1;
                $flagMasterHarga2 = 1;
            }
            elseif ($primary_sat2->i_sat2 == $request->satBrgRusak)
            {
                $hasilConvert2 = (int)$request->qtyBrgRusak * (int)$primary_sat2->i_sat_isi2;
                $isiQty2 = $primary_sat2->i_sat_isi2;
                $flagMasterHarga2 = 2;
            }
            else
            {
                $hasilConvert2 = (int)$request->qtyBrgRusak * (int)$primary_sat2->i_sat_isi3;
                $isiQty2 = $primary_sat2->i_sat_isi3;
                $flagMasterHarga2 = 3;
            }

            //mengurangi stok gudang rusak sebelum ubah jenis
            if(mutasi::mutasiStok(
                $request->idBrgRusak, //item id
                $hasilConvert2, //qty hasil convert satuan terpilih -> satuan primary 
                $comp = 8, //posisi gudang berdasarkan type item
                $position = 8, //posisi gudang berdasarkan type item
                $flag = 5, //sm mutcat
                $request->codeBrgRusak //sm reff
            )) {}

            //delete row table d_barang_rusakdt
            d_barang_rusakdt::where('d_brdt_brid', $request->idHeaderJenis)->delete();
            //delete row table d_barang_rusak
            d_barang_rusak::where('d_br_id', $request->idHeaderJenis)->delete();      

            DB::commit();
            return response()->json([
                'status' => 'sukses',
                'pesan' => 'Data Barang Rusak Berhasil Disimpan'
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

    public function musnahkanBrgRusak(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try {
            //ambil code d_barang_rusak
            $brg_rusak = d_barang_rusak::select('d_br_code')->where('d_br_id', $request->idTabelHeader)->first();
            //ambil data pakai d_stock_mutation 
            $data_sm = DB::table('d_stock_mutation')->where('sm_reff', $brg_rusak->d_br_code)->orderBy('sm_stock','ASC')
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
                $sm_mutcat[] = $value->sm_mutcat;
                $sm_reff[] = $value->sm_reff;
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

                if ($sm_mutcat[$i] == '4') 
                {
                    //kembalikan stok sebelum pakai
                    $stokAkhir =  (int)$q_dstock->s_qty - abs($sm_qty[$i]);
                    // update d_stock
                    DB::table('d_stock')->where('s_id', $sm_stock[$i])->update(['s_qty' => $stokAkhir]);
                }

                //ambil data penerimaan d_stock_mutation 
                $data_sm_masuk = d_stock_mutation::where('sm_qty_used','>',0)
                                    ->where('sm_stock', $sm_stock[$i])
                                    ->where('sm_item', $sm_item[$i])
                                    ->where('sm_comp', $sm_comp[$i])
                                    ->where('sm_position', $sm_pos[$i])
                                    ->where('sm_hpp', $sm_hpp[$i])
                                    ->where('sm_reff', $sm_reff[$i])
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

                if ($sm_mutcat[$i] == '4') {
                    //delete row table d_stock_mutation
                    DB::table('d_stock_mutation')->where('sm_stock', '=', $sm_stock[$i])
                      ->where('sm_detailid', '=', $sm_detailid[$i])->where('sm_mutcat', '=', $sm_mutcat[$i])->delete();
                }
            }

            d_barang_rusak::where('d_br_id', $request->idTabelHeader)->update(['d_br_status' => 'MU']);
    
            DB::commit();
            return response()->json([
                'status' => 'sukses',
                'pesan' => 'Data Barang Rusak Berhasil Dimusnahkan'
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

    public function kembalikanBrgRusak(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try {
            //ambil code d_barang_rusak
            $brg_rusak = d_barang_rusak::select('d_br_code')->where('d_br_id', $request->idTabelHeader)->first();
            //ambil data pakai d_stock_mutation 
            $data_sm = DB::table('d_stock_mutation')->where('sm_reff', $brg_rusak->d_br_code)->orderBy('sm_stock','ASC')
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
                $sm_mutcat[] = $value->sm_mutcat;
                $sm_reff[] = $value->sm_reff;
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

                if ($sm_mutcat[$i] == '4') 
                {
                    //kembalikan stok sebelum pakai
                    $stokAkhir = (int)$q_dstock->s_qty - abs($sm_qty[$i]);
                    // update d_stock
                    DB::table('d_stock')->where('s_id', $sm_stock[$i])->update(['s_qty' => $stokAkhir]);
                }else{
                    //kembalikan stok sebelum pakai
                    $stokAkhir = (int)$q_dstock->s_qty + abs($sm_qty[$i]);
                    // update d_stock
                    DB::table('d_stock')->where('s_id', $sm_stock[$i])->update(['s_qty' => $stokAkhir]);
                }
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

            //delete row table d_barang_rusakdt
            d_barang_rusakdt::where('d_brdt_brid', $request->idTabelHeader)->delete();
            //delete row table d_barang_rusak
            d_barang_rusak::where('d_br_id', $request->idTabelHeader)->delete();
    
            DB::commit();
            return response()->json([
                'status' => 'sukses',
                'pesan' => 'Data Barang Rusak Berhasil Dikembalikan'
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

    public function kodeBrgRusakAuto()
    {
        $query = DB::select(DB::raw("SELECT MAX(RIGHT(d_br_code,5)) as kode_max from d_barang_rusak WHERE DATE_FORMAT(d_br_created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));
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

        return $codePakaiBrg = "PBR-".date('ym')."-".$kd;
    }

    public function kodeUbahJenisAuto()
    {
        $query = DB::select(DB::raw("SELECT MAX(RIGHT(d_uj_code,5)) as kode_max from d_ubah_jenis WHERE DATE_FORMAT(d_uj_created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));
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

        return $ubahJenis = "UJB-".date('ym')."-".$kd;
    }

    public function printTandaTerimaRusak($id)
    {
        $dataHeader = d_barang_rusak::join('d_gudangcabang','d_barang_rusak.d_br_gdg','=','d_gudangcabang.cg_id')
              ->join('d_mem','d_barang_rusak.d_br_staff','=','d_mem.m_id')
              ->select('d_barang_rusak.*', 'd_mem.m_id', 'd_mem.m_name', 'd_gudangcabang.cg_id', 'd_gudangcabang.cg_cabang')
              ->where('d_barang_rusak.d_br_id', '=', $id)
              ->orderBy('d_barang_rusak.d_br_created', 'DESC')
              ->get()->toArray();
    
        $dataIsi = d_barang_rusakdt::join('d_barang_rusak', 'd_barang_rusakdt.d_brdt_brid', '=', 'd_barang_rusak.d_br_id')
            ->join('m_item', 'd_barang_rusakdt.d_brdt_item', '=', 'm_item.i_id')
            ->join('m_satuan', 'd_barang_rusakdt.d_brdt_sat', '=', 'm_satuan.m_sid')
            ->select(
                'd_barang_rusakdt.d_brdt_id',
                'd_barang_rusakdt.d_brdt_brid',
                'd_barang_rusakdt.d_brdt_item',
                'd_barang_rusakdt.d_brdt_sat',
                DB::raw('sum(d_barang_rusakdt.d_brdt_qty) as qty_pakai'),
                DB::raw('sum(d_barang_rusakdt.d_brdt_price) as harga_sat'),
                DB::raw('sum(d_barang_rusakdt.d_brdt_pricetotal) as harga_tot'),
                'd_barang_rusakdt.d_brdt_keterangan',
                'm_item.*',
                'd_barang_rusak.d_br_code',
                'm_satuan.m_sid',
                'm_satuan.m_sname'
            )
            ->where('d_barang_rusakdt.d_brdt_brid', '=', $id)
            ->groupBy('d_barang_rusakdt.d_brdt_item')
            ->orderBy('d_barang_rusakdt.d_brdt_created', 'DESC')
            ->get()->toArray();

        /*foreach ($dataHeader as $val) 
        {*/
            $data = array(
              'id_gdg' => $dataHeader[0]['d_br_gdg'],
              'tgl_pakai' => date('d-m-Y',strtotime($dataHeader[0]['d_br_date']))
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
           
        return view('inventory.b_rusak.print', compact('dataHeader', 'dataIsi', 'val_stock', 'txt_satuan'));
    }

    public function hapusDataUbah(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {
            // d_barang_rusak::where('d_br_id', $request->idTabelHeader)->update(['d_br_status' => 'PJ']);
            d_barang_rusakdt::where('d_brdt_id', $request->idDetail)->update(['d_brdt_isubah' => 'N']);
            
            DB::commit();
            return response()->json([
                'status' => 'sukses',
                'pesan' => 'Data Barang Rusak dimasukkan pada TAB INDEX'
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

    public function cek_status_brgrusak($id_brgrusak)
    {
        // //tanggal sekarang
        // $tgl = Carbon::today()->toDateString();
        //cek pada table d_barang_rusakdt, jika isreceived semua tbl header ubah status ke PJ
        $data_dt = DB::table('d_barang_rusakdt')->select('d_brdt_isubah')->where('d_brdt_brid', '=', $id_brgrusak)->get();

        foreach ($data_dt as $x) { $data_status[] = $x->d_brdt_isubah; }

        if (!in_array("N", $data_status, TRUE)) 
        {
            //DB::table('d_barang_rusak')->where('d_br_id', $id_brgrusak->update(['d_br_status' => 'PJ', 'd_pcs_date_received' => $tgl]);
            DB::table('d_barang_rusak')->where('d_br_id', $id_brgrusak)->update(['d_br_status' => 'PJ']);
        }
    }

    // ===============================================================================================================

}
