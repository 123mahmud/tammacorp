<?php

namespace App\Http\Controllers\Produksi;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\d_productresult_dt;
use App\d_delivery_order;
use App\d_delivery_orderdt;
use App\d_stock_mutation;
use App\d_stock;
use App\lib\mutasi;
use App\d_gudangcabang;
use DB;
use DataTables;
use App\Http\Controllers\Controller;

class PengambilanItemController extends Controller
{
    public function SuratJalan()
    {
        $data = d_gudangcabang::where('cg_gudang', 'GG')->get();

        return view('produksi.PemSuratJalan.index', compact('data'));
    }

    public function tabelDelivery(Request $request)
    {
        $data = d_productresult_dt::select('m_item.i_code',
            'm_item.i_name',
            'd_productresult_dt.prdt_qty',
            'd_productresult_dt.prdt_productresult',
            'd_productresult_dt.prdt_detail',
            'd_productresult_dt.prdt_item')
            ->join('d_productresult', 'd_productresult_dt.prdt_productresult', '=', 'd_productresult.pr_id')
            ->join('d_spk', 'd_productresult.pr_spk', '=', 'd_spk.spk_id')
            ->join('m_item', 'd_productresult.pr_item', '=', 'm_item.i_id')
            ->where('prdt_status', 'RD')
            ->get();
        // dd($data);

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                return '<div class="text-center" data-toggle="buttons">
                <label class="btn btn-default">
                  <input id="something" type="checkbox" name="delivery[]" value="' . $data->prdt_productresult . '|' . $data->prdt_detail . '|' . $data->prdt_item . '|' . $data->prdt_qty . '">
                  <span class="glyphicon glyphicon-ok"></span>
                </label>
              </div>';

            })
            ->addColumn('prdt_qty', function ($data) {
                return '<input  id="prdt_qty" 
                      class="form-control text-right" 
                      type="text" 
                      name="prdt_qty[]" 
                      readonly
                      value="' . $data->prdt_qty . '">';

            })
            ->addColumn('prdt_item', function ($data) {
                return '' . $data->i_name . '<input  id="prdt_productresult" 
                      class="form-control hidden" 
                      type="text" 
                      name="prdt_productresult[]" 
                      readonly
                      value="' . $data->prdt_productresult . '">
                <input  id="prdt_detail" 
                      class="form-control hidden" 
                      type="text" 
                      name="prdt_detail[]" 
                      readonly
                      value="' . $data->prdt_detail . '">
                <input  id="prdt_item" 
                      class="form-control hidden" 
                      type="text" 
                      name="prdt_item[]" 
                      readonly
                      value="' . $data->prdt_item . '">';

            })
            ->addIndexColumn()
            ->rawColumns(['prdt_qty', 'prdt_item'])
            ->make(true);
    }

    function store(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            // nota do
            $year = carbon::now()->format('y');
            $month = carbon::now()->format('m');
            $date = carbon::now()->format('d');

            $maxiddo = d_delivery_order::select('do_id')->max('do_id') + 1;

            $nota_do = 'DO' . $year . $month . $date . '-' . '000' . '-' . $maxiddo;
            // end nota do
            $maxid = d_delivery_order::select('do_id')->max('do_id') + 1;

            d_delivery_order::insert([
                'do_id' => $maxid,
                'do_nota' => $nota_do,
                'do_date_send' => Carbon::now(),
                'do_time' => Carbon::now(),
                'do_insert' => Carbon::now()
            ]);

            for ($i = 0; $i < count($request->prdt_item); $i++) {
                d_delivery_orderdt::insert([
                    'dod_do' => $maxid,
                    'dod_detailid' => $i + 1,
                    'dod_prdt_productresult' => $request->prdt_productresult[$i],
                    'dod_prdt_detail' => $request->prdt_detail[$i],
                    'dod_item' => $request->prdt_item[$i],
                    'dod_qty_send' => $request->prdt_qty[$i],
                    'dod_date_send' => Carbon::now(),
                    'dod_time_send' => Carbon::now(),
                    'dod_qty_received' => 0,
                    'dod_status' => 'WT'
                ]);

                d_productresult_dt::where('prdt_productresult', $request->prdt_productresult[$i])
                    ->where('prdt_detail', $request->prdt_detail[$i])
                    ->update([
                        'prdt_status' => 'FN'
                    ]);
                if (mutasi::mutasiStok($request->prdt_item[$i],
                    $request->prdt_qty[$i],
                    $comp = 6,
                    $position = 6,
                    $flag = 11,
                    $nota_do)) {
                }

                $stokProduksi = d_stock::where('s_comp', '6')
                    ->where('s_position', '6')
                    ->where('s_item', $request->prdt_item[$i])
                    ->first();

                $stokBaru = $stokProduksi->s_qty - $request->prdt_qty[$i];

                $maxidd_stock = d_stock::select('s_id')->max('s_id') + 1;
                //end add id d_stock
                $stock = d_stock::where('s_item', $request->prdt_item[$i])
                    ->where('s_comp', DB::raw('2'))
                    ->where('s_position', DB::raw('5'))
                    ->first();
                // dd();
                if ($stock == null) {
                    d_stock::insert([
                        's_id' => $maxidd_stock,
                        's_comp' => 2,
                        's_position' => 5,
                        's_item' => $request->prdt_item[$i],
                        's_qty' => $request->prdt_qty[$i]
                    ]);

                    d_stock_mutation::create([
                        'sm_stock' => $maxidd_stock,
                        'sm_detailid' => 1,
                        'sm_date' => Carbon::now(),
                        'sm_comp' => 2,
                        'sm_position' => 5,
                        'sm_mutcat' => 9,
                        'sm_item' => $request->prdt_item[$i],
                        'sm_qty' => $request->prdt_qty[$i],
                        'sm_qty_used' => 0,
                        'sm_qty_sisa' => $request->prdt_qty[$i],
                        'sm_qty_expired' => 0,
                        'sm_detail' => 'PENAMBAHAN',
                        'sm_reff' => $nota_do,
                        'sm_insert' => Carbon::now()
                    ]);

                } else {

                    $stockUpdate = $stock->s_qty + $request->prdt_qty[$i];

                    $stock->update([
                        's_qty' => $stockUpdate
                    ]);

                    $sm_detailid = d_stock_mutation::select('sm_detailid')
                            ->where('sm_item', $request->prdt_item[$i])
                            ->where('sm_comp', '2')
                            ->where('sm_position', '5')
                            ->max('sm_detailid') + 1;

                    d_stock_mutation::create([
                        'sm_stock' => $stock->s_id,
                        'sm_detailid' => $sm_detailid,
                        'sm_date' => Carbon::now(),
                        'sm_comp' => 2,
                        'sm_position' => 5,
                        'sm_mutcat' => 9,
                        'sm_item' => $request->prdt_item[$i],
                        'sm_qty' => $request->prdt_qty[$i],
                        'sm_qty_used' => 0,
                        'sm_qty_sisa' => $request->prdt_qty[$i],
                        'sm_qty_expired' => 0,
                        'sm_detail' => 'PENAMBAHAN',
                        'sm_reff' => $nota_do,
                        'sm_insert' => Carbon::now()
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

    public function tabelKirim($tgl1, $tgl2)
    {
        $y = substr($tgl1, -4);
        $m = substr($tgl1, -7, -5);
        $d = substr($tgl1, 0, 2);
        $tgl1 = $y . '-' . $m . '-' . $d;

        $y2 = substr($tgl2, -4);
        $m2 = substr($tgl2, -7, -5);
        $d2 = substr($tgl2, 0, 2);
        $tgl2 = $y2 . '-' . $m2 . '-' . $d2;

        $data = d_delivery_order::
        where('do_date_send', '>=', $tgl1)
            ->where('do_date_send', '<=', $tgl2)
            ->get();

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                return '<div class="text-center" data-toggle="buttons">
                <button style="margin-left:5px;" 
                          title="Lihat Detail" 
                          type="button"
                          onclick="lihatItem(' . $data->do_id . ')"
                          data-toggle="modal"
                          data-target="#modalDetailProduksi" 
                          class="btn btn-info fa fa-eye btn-sm"
                  </button>
                </div>';

            })
            ->editColumn('do_date_send', function ($user) {
                return $user->do_date_send ? with(new Carbon($user->do_date_send))->format('d M Y') : '';
            })
            ->make(true);
    }

    public function cariTabelKirim($tgl1, $tgl2)
    {
        $y = substr($tgl1, -4);
        $m = substr($tgl1, -7, -5);
        $d = substr($tgl1, 0, 2);
        $tgl1 = $y . '-' . $m . '-' . $d;

        $y2 = substr($tgl2, -4);
        $m2 = substr($tgl2, -7, -5);
        $d2 = substr($tgl2, 0, 2);
        $tgl2 = $y2 . '-' . $m2 . '-' . $d2;

        $data = d_delivery_order::
        where('do_date_send', '>=', $tgl1)
            ->where('do_date_send', '<=', $tgl2)
            ->get();

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                return '<div class="text-center" data-toggle="buttons">
                <button style="margin-left:5px;" 
                          title="Lihat Detail" 
                          type="button"
                          data-toggle="modal"
                          data-target="#modalDetailProduksi" 
                          onclick="lihatItem(' . $data->do_id . ')"
                          class="btn btn-info fa fa-eye btn-sm"
                  </button>
                </div>';

            })
            ->editColumn('do_date_send', function ($user) {
                return $user->do_date_send ? with(new Carbon($user->do_date_send))->format('d M Y') : '';
            })
            ->make(true);
    }

    public function itemTabelKirim($id)
    {
        $data = d_delivery_orderdt::where('dod_do', '=', $id)
            ->join('m_item', 'i_id', '=', 'dod_item')
            ->get();

        return DataTables::of($data)
            ->editColumn('dod_status', function ($inquiry) {
                if ($inquiry->dod_status == 'WT')
                    return 'Belum di Terima';
                if ($inquiry->dod_status == 'FN')
                    return 'Sudah di Terima';
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function orderId(Request $request)
    {
        $data = d_delivery_order::select('do_id')
            ->where('do_id', '=', $request->x)
            ->first();

        return view('produksi.PemSuratJalan.tabelItem', compact('data'));
    }

    public function print()
    {

        // nota do
        $year = carbon::now()->format('y');
        $month = carbon::now()->format('m');
        $date = carbon::now()->format('d');

        $maxiddo = d_delivery_order::select('do_id')->max('do_id') + 1;

        $nota_do = 'DO' . $year . $month . $date . '-' . '000' . '-' . $maxiddo;
        // end nota do
        // dd($nota_do);
        $data = d_productresult_dt::select('m_item.i_code',
            'm_item.i_name',
            'd_productresult_dt.prdt_qty',
            'd_productresult_dt.prdt_productresult',
            'd_productresult_dt.prdt_detail',
            'd_productresult_dt.prdt_item',
            'm_price.m_psell1',
            'm_price.m_psell2',
            'm_price.m_psell3',
            'm_satuan.m_sname'
        )
            ->join('d_productresult', 'd_productresult_dt.prdt_productresult', '=', 'd_productresult.pr_id')
            ->join('d_spk', 'd_productresult.pr_spk', '=', 'd_spk.spk_id')
            ->join('m_item', 'd_productresult.pr_item', '=', 'm_item.i_id')
            ->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.m_sid')
            ->join('m_price', 'd_productresult.pr_item', '=', 'm_price.m_pitem')
            ->where('prdt_status', 'RD')
            ->get()->toArray();
        $data = array_chunk($data, 10);
        $total = d_productresult_dt::select(DB::raw('SUM(prdt_qty) as total_qty'))
            ->where('prdt_status', 'RD')
            ->get()->toArray();
        // return $data;
        // return $total;
        return view('produksi.PemSuratJalan.print', compact('data', 'total','nota_do'));
    }

}
