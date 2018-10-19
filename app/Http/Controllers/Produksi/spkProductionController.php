<?php

namespace App\Http\Controllers\Produksi;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Response;
use DataTables;
use App\d_spk;
use App\m_item;
use App\d_send_product;
use App\d_productplan;
use App\spk_formula;
use App\spk_actual;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\lib\mutasi;

class spkProductionController extends Controller
{
    public function spk()
    {
        return view('produksi.spk.index');
    }

    public function spkCreateId($x)
    {
        $year = carbon::now()->format('y');
        $month = carbon::now()->format('m');
        $date = carbon::now()->format('d');

        $idSpk = d_spk::max('spk_id');
        if ($idSpk <= 0 || $idSpk <= '') {
            $idSpk = 1;
        } else {
            $idSpk += 1;
        }
        $idSpk = 'SPK' . $year . $month . $date . $idSpk;

        $m_item = m_item::where('i_id', $x)->first();
        // dd($m_item);
        $data = ['status' => 'sukses',
            'id_spk' => $idSpk,
            'i_name' => $m_item];

        return json_encode($data);

    }

    public function cariDataSpk(Request $request)
    {
        if ($request->tanggal1 == '' && $request->tanggal2 == '') {
            $request->tanggal1 == '2018-04-06';
            $request->tanggal2 == '2018-04-13';
        }

        $request->tanggal1 = date('Y-m-d', strtotime($request->tanggal1));
        $request->tanggal2 = date('Y-m-d', strtotime($request->tanggal2));

        $productplan = DB::table('d_productplan')
            ->join('m_item', 'pp_item', '=', 'i_id')
            ->where('pp_isspk', 'N')
            ->where('pp_date', '>=', $request->tanggal1)
            ->where('pp_date', '<=', $request->tanggal2)
            ->get();

        return view('produksi.spk.data-plan', compact('productplan'));
    }


    public function getSpkByTgl($tgl1, $tgl2)
    {
        $y = substr($tgl1, -4);
        $m = substr($tgl1, -7, -5);
        $d = substr($tgl1, 0, 2);
        $tanggal1 = $y . '-' . $m . '-' . $d;

        $y2 = substr($tgl2, -4);
        $m2 = substr($tgl2, -7, -5);
        $d2 = substr($tgl2, 0, 2);
        $tanggal2 = $y2 . '-' . $m2 . '-' . $d2;

        $spk = d_spk::join('m_item', 'spk_item', '=', 'i_id')
            ->join('d_productplan', 'pp_id', '=', 'spk_ref')
            ->select('spk_id', 'spk_date', 'i_name', 'pp_qty', 'spk_code', 'spk_status')
            ->where('spk_status', 'AP')
            ->orWhere('spk_status', 'PB')
            ->where('spk_date', '>=', $tanggal1)
            ->where('spk_date', '<=', $tanggal2)
            ->orderBy('spk_date', 'DESC')
            ->get();

        return DataTables::of($spk)
            ->addIndexColumn()
            ->editColumn('status', function ($data) {
                if ($data->spk_status == "AP") {
                    return '<span class="label label-info">di Setujui</span>';
                } elseif ($data->spk_status == "PB") {
                    return '<span class="label label-warning">Proses</span>';
                } elseif ($data->spk_status == "FN") {
                    return '<span class="label label-success">Selesai</span>';
                }
            })

            ->addColumn('action', function ($data) {
                if ($data->spk_status == "AP") {
                    return '<div class="text-center">
                    <button class="btn btn-sm btn-success"
                          title="Detail"
                          type="button"
                          data-toggle="modal"
                          data-target="#myModalView"
                          onclick=detailManSpk("' . $data->spk_id . '")>
                          <i class="fa fa-eye"></i>
                    </button>
             
          </div>';
                } elseif ($data->spk_status == "PB") {
                    return '<div class="text-center">
                    <button class="btn btn-sm btn-success"
                              title="Detail"
                              type="button"
                              data-toggle="modal"
                              data-target="#myModalView"
                              onclick=detailManSpk("' . $data->spk_id . '")>
                              <i class="fa fa-eye"></i>
                    </button>&nbsp;
                    <button class="btn btn-sm btn-info"
                              title="Ubah Status"
                              onclick=ubahStatus("' . $data->spk_id . '")>
                              <i class="glyphicon glyphicon-ok"></i>
                    </button>
                </div>';
                } else{
                    return '<div class="text-center">
                    <button class="btn btn-sm btn-success"
                              title="Detail"
                              type="button"
                              data-toggle="modal"
                              data-target="#myModalView"
                              onclick=detailManSpk("' . $data->spk_id . '")>
                              <i class="fa fa-eye"></i>
                    </button>&nbsp;
                    <button class="btn btn-sm btn-info"
                            title=Input data"
                            type="button"
                            data-toggle="modal"
                            data-target="#myModalActual"
                            onclick=inputData("' . $data->spk_id . '")>
                            <i class="fa fa-check-square-o"></i>
                    </button>
                </div>';
                }
            })
            ->editColumn('spk_date', function ($user) {
                return $user->spk_date ? with(new Carbon($user->spk_date))->format('d M Y') : '';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function getSpkByTglCL($tgl1, $tgl2)
    {
        $y = substr($tgl1, -4);
        $m = substr($tgl1, -7, -5);
        $d = substr($tgl1, 0, 2);
        $tanggal1 = $y . '-' . $m . '-' . $d;

        $y2 = substr($tgl2, -4);
        $m2 = substr($tgl2, -7, -5);
        $d2 = substr($tgl2, 0, 2);
        $tanggal2 = $y2 . '-' . $m2 . '-' . $d2;

        $spk = d_spk::join('m_item', 'spk_item', '=', 'i_id')
            ->join('d_productplan', 'pp_id', '=', 'spk_ref')
            ->select('spk_id', 'spk_date', 'i_name', 'pp_qty', 'spk_code', 'spk_status')
            ->where('spk_status', 'FN')
            ->where('spk_date', '>=', $tanggal1)
            ->where('spk_date', '<=', $tanggal2)
            ->orderBy('spk_date', 'DESC')
            ->get();

        return DataTables::of($spk)
            ->addIndexColumn()
            ->editColumn('status', function ($data) {
                    return '<span class="label label-success">Selesai</span>';
            })
            ->addColumn('action', function ($data) {
                    return '<div class="text-center">
                    <button class="btn btn-sm btn-success"
                              title="Detail"
                              type="button"
                              data-toggle="modal"
                              data-target="#myModalView"
                              onclick=detailManSpk("' . $data->spk_id . '")>
                              <i class="fa fa-eye"></i>
                    </button>&nbsp;
                    <button class="btn btn-sm btn-info"
                            title=Input data"
                            type="button"
                            data-toggle="modal"
                            data-target="#myModalActual"
                            onclick=inputData("' . $data->spk_id . '")>
                            <i class="fa fa-check-square-o"></i>
                    </button>
                </div>';
            })
            ->editColumn('spk_date', function ($user) {
                return $user->spk_date ? with(new Carbon($user->spk_date))->format('d M Y') : '';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function ubahStatusSpk($spk_id)
    {
        d_productplan::where('pp_id', $spk_id)
            ->update([
                'pp_isspk' => 'C'
            ]);
        $spk = d_spk::find($spk_id);
        $spkDt = spk_formula::where('fr_spk', $spk->spk_id)
            ->get();
        // dd($spk);
        if ($spk->spk_status == "AP") {
            //update status to PB
            for ($i=0; $i <count($spkDt) ; $i++) { 
                $a[] = $spkDt[$i]->fr_value;
                if(mutasi::mutasiStok(  $spkDt[$i]->fr_formula,
                                        $spkDt[$i]->fr_value,
                                        $comp=3,
                                        $position=3,
                                        $flag=2,
                                        $spk->spk_code)){}
            }
            

            $spk = d_spk::find($spk_id);
            $spk->spk_status = 'PB';
            $spk->save();
        } else {
            //update status to FN
            $spk = d_spk::find($spk_id);
            $spk->spk_status = 'FN';
            $spk->save();
        }

        return response()->json([
            'status' => 'sukses',
            'pesan' => 'Status SPK telah berhasil diubah',
        ]);
    }

    public function lihatFormula(Request $request)
    {
        $spk = d_spk::select('pp_date',
            'i_name',
            'pp_qty',
            'spk_code',
            'spk_id',
            'spk_status')
            ->where('spk_id', $request->x)
            ->join('m_item', 'i_id', '=', 'spk_item')
            ->join('d_productplan', 'pp_id', '=', 'spk_ref')
            ->get();

        $formula = spk_formula::select('i_code',
            'i_name',
            'fr_value',
            'i_id',
            'i_type',
            'm_sname')
            ->where('fr_spk', $request->x)
            ->join('m_item', 'i_id', '=', 'fr_formula')
            ->join('m_satuan', 'm_sid', '=', 'fr_scale')
            ->get();

        foreach ($formula as $val) {
            //cek type barang
            if ($val->i_type == "BJ") //brg jual
            {
                //ambil stok berdasarkan type barang
                $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock
                  where s_item = '$val->i_id'
                  AND s_comp = '2'
                  AND s_position = '2' limit 1) ,'0') as qtyStok"));
                $stok = $query[0]->qtyStok;
            } elseif ($val->i_type == "BB") //bahan baku
            {
                //ambil stok berdasarkan type barang
                $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock
                  where s_item = '$val->i_id'
                  AND s_comp = '3'
                  AND s_position = '3' limit 1) ,'0') as qtyStok"));
                $stok = $query[0]->qtyStok;
            }

            //get prev cost
            $idItem = $val->i_id;
            $prevCost = DB::table('d_stock_mutation')
                // ->select(DB::raw('MAX(sm_hpp) as hargaPrev'))
                ->select('sm_hpp', 'sm_qty')
                ->where('sm_item', '=', $idItem)
                ->where('sm_mutcat', '=', "14")
                ->orderBy('sm_date', 'desc')
                ->limit(1)
                ->get();

            foreach ($prevCost as $value) {
                $hargaLalu[] = $value->sm_hpp;
                $qty[] = $value->sm_qty;
            }

        }
        // dd($formula[0]['fr_value']);
        for ($i = 0; $i < count($hargaLalu); $i++) {
            $cabangPurnama = $hargaLalu[$i];
            $bambang[] = $formula[$i]['fr_value'] * $cabangPurnama;
        }
        // dd($bambang);

        $ket = $spk[0]->spk_status;
        $id = $spk[0]->spk_id;

        return view('produksi.spk.detail-formula', compact('spk', 'formula', 'bambang','ket','id'));

    }

    public function inputData(Request $request)
    {
        $spk = d_spk::select('spk_id')
            ->where('spk_id', $request->x)
            ->first();

        $actual = spk_actual::where('ac_spk', $request->x)
            ->first();

        return view('produksi.spk.table-inputactual', compact('spk', 'actual'));
    }

    public
    function print($spk_id)
    {
        $spk = d_spk::select('pp_date',
            'i_name',
            'pp_qty',
            'spk_code')
            ->where('spk_id', $spk_id)
            ->join('m_item', 'i_id', '=', 'spk_item')
            ->join('d_productplan', 'pp_id', '=', 'spk_ref')
            ->get()->toArray();

        $formula = spk_formula::select('i_code',
            'i_name',
            'fr_value',
            'm_sname')
            ->where('fr_spk', $spk_id)
            ->join('m_item', 'i_id', '=', 'fr_formula')
            ->join('m_satuan', 'm_sid', '=', 'fr_scale')
            ->get()->toArray();

        $formula = array_chunk($formula, 14);

        return view('produksi.spk.print', compact('spk', 'formula'));
    }

    public function saveActual(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = spk_actual::where('ac_spk', $id)
                ->first();
            $ac_id = spk_actual::max('ac_id') + 1;

            if ($data == null) {
                spk_actual::insert([
                    'ac_id' => $ac_id,
                    'ac_spk' => $id,
                    'ac_adonan' => $request->ac_adonan,
                    'ac_adonan_scale' => 3,
                    'ac_kriwilan' => $request->ac_kriwilan,
                    'ac_kriwilan_scale' => 3,
                    'ac_sampah' => $request->ac_sampah,
                    'ac_sampah_scale' => 3,
                    'ac_insert' => Carbon::now()
                ]);
            } else {
                $data->update([
                    'ac_adonan' => $request->ac_adonan,
                    'ac_kriwilan' => $request->ac_kriwilan,
                    'ac_sampah' => $request->ac_sampah,
                    'ac_update' => Carbon::now()
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
}
