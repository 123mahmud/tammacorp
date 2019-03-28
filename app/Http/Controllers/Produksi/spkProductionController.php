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
use App\d_productresult_dt;
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

            ->editColumn('produksi', function ($user) {
                return $result = d_productresult_dt::
                    join('d_productresult','d_productresult.pr_id','=','prdt_productresult')
                    ->where('pr_spk',$user->spk_id)
                    ->sum('d_productresult_dt.prdt_qty');
            })

            ->rawColumns(['status', 'action','produksi'])
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

            ->editColumn('produksi', function ($user) {
                return $result = d_productresult_dt::
                    join('d_productresult','d_productresult.pr_id','=','prdt_productresult')
                    ->where('pr_spk',$user->spk_id)
                    ->sum('d_productresult_dt.prdt_qty');
            })

            ->rawColumns(['status', 'action','produksi'])
            ->make(true);
    }

    public function ubahStatusSpk($spk_id)
    {
        // return json_encode($request->all());
        $status = d_spk::where('spk_id', $spk_id)
                ->first();

        $hpp = []; $err = true; $acc_temp = []; $acc_temp2 = []; $hpp_value = 0;
        $spk = d_spk::where('spk_id', $spk_id)
                        ->join('d_productplan', 'pp_id', '=', 'spk_ref')
                        ->select('d_spk.*', 'd_productplan.pp_qty')->first();

        if(!$spk){
            return response()->json([
                'status' => 'gagal',
                'pesan'  => 'Gagal! Barang Yang Akan Diproduksi Tidak Bisa Ditemukan....'
            ]);
        }

        $spkDt = spk_formula::where('fr_spk', $spk->spk_id)
            ->get();

        // cek jurnal

        if(jurnal_setting()->allow_jurnal_to_execute){
            $akun_1;
            for ($i=0; $i <count($spkDt) ; $i++) 
            { 

                $item = m_item::where('i_id', $spkDt[$i]->fr_formula)
                            ->join('m_group', 'm_item.i_code_group', '=', 'm_group.m_gcode')
                            ->select('i_code_group', 'm_akun_persediaan', 'm_akun_beban', 'i_id')
                            ->first();

                $need = (int) $spkDt[$i]->fr_value;

                $cek2 = DB::table('d_akun')->where('id_akun', $item->m_akun_persediaan)->first();
                $cek3 = DB::table('d_akun')->where('id_akun', $item->m_akun_beban)->first();

                if(!$item || !$item->m_akun_persediaan || !$item->m_akun_beban || !$cek2 || !$cek3)
                {
                    $err = false;
                }
                else
                {
                    
                    $prevCost = DB::table('d_stock_mutation')
                                    ->select('sm_item', 'sm_qty', 'sm_qty_sisa', 'sm_hpp' )
                                    ->where('sm_item', '=', $item->i_id)
                                    ->where('sm_mutcat', '=', "14")
                                    ->where('sm_qty_sisa', '>', 0)
                                    ->orderBy('sm_date', 'asc')
                                    ->get();

                    if(count($prevCost) == 0)
                    {
                        $default_cost = DB::table('m_price')->select('m_pbuy1')->where('m_pitem', $item->i_id)->first();
                        $hargaLalu = $default_cost->m_pbuy1;
                        $hppTemp = $hargaLalu;
                    }
                    else
                    {
                        $hppTemp = 0;

                        foreach ($prevCost as $key => $cost) 
                        {
                            if($cost->sm_qty_sisa > $need)
                            {
                                $hppTemp += ($need * $cost->sm_hpp);
                                $need = 0;
                                break;
                            }
                            else
                            {
                                $hppTemp += ($cost->sm_qty_sisa * $cost->sm_hpp);
                                $need -= $cost->sm_qty_sisa;
                            }

                        }

                        // #### Ini Untuk Mengecek Jika Stock Tidak Mencukupi;

                        $hargaLalu = $hppTemp;
                    }   

                    spk_formula::where('fr_spk',$spk_id)
                        ->where('fr_formula',$item->i_id)
                        ->update([
                            'fr_hpp' => $hargaLalu
                        ]);


                    if(array_key_exists($item->m_akun_persediaan, $acc_temp)){
                            $acc_temp[$item->m_akun_persediaan] = [
                                'td_acc'      => $item->m_akun_persediaan,
                                'td_posisi'   => "K",
                                'value'       => $acc_temp[$item->m_akun_persediaan]['value'] + $hargaLalu
                            ];
                        }else{
                            $acc_temp[$item->m_akun_persediaan] = [
                                'td_acc'      => $item->m_akun_persediaan,
                                'td_posisi'   => "K",
                                'value'       => $hargaLalu
                            ];
                        }

                        if(array_key_exists($item->m_akun_beban, $acc_temp2)){
                            $acc_temp2[$item->m_akun_beban] = [
                                'td_acc'      => $item->m_akun_beban,
                                'td_posisi'   => "D",
                                'value'       => $acc_temp2[$item->m_akun_beban]['value'] + $hargaLalu
                            ];
                        }else{
                            $acc_temp2[$item->m_akun_beban] = [
                                'td_acc'      => $item->m_akun_beban,
                                'td_posisi'   => "D",
                                'value'       => $hargaLalu
                            ];
                        }

                    $hpp_value += $hppTemp;
                }

            }
        }

        if(!$err){
            return response()->json([
                'status' => 'gagal',
                'pesan'  => 'Tidak Bisa Melakukan Jurnal Pada SPK Ini Karena Salah Satu Dari Item Belum Berelasi Dengan Akun Persediaan Atau Akun Beban.'
            ]);
        }
        
        DB::table('m_price')->where('m_pitem', $spk->spk_item)->update([
            "m_hpp" => $hpp_value / $spk->pp_qty
        ]);

         DB::table('d_spk')->where('spk_id', $spk_id)->update([
            "spk_hpp"   => $hpp_value / $spk->pp_qty
         ]);
        // cek jurnal end

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

        $jr = DB::table('d_jurnal')->where('jurnal_ref', $spk->spk_code)->first();
        // return json_encode($jr);

        if(!$jr && jurnal_setting()->allow_jurnal_to_execute){
            $item_spk = m_item::where('i_id', $spk->spk_item)->first();

            if($item_spk){
                // return "aa";
                $state_jurnal = _initiateJournal_self_detail($spk->spk_code, 'MM', date('Y-m-d'), 'Proses Produksi '.$item_spk->i_name.' '.date('Y/m/d'), array_merge($acc_temp, $acc_temp2));
            }else{
                return response()->json([
                    'status' => 'gagal',
                    'pesan'  => 'Tidak Bisa Melakukan Jurnal Pada SPK Ini Karena Barang Yang Akan Diproduksi Tidak Bisa Ditemukan....'
                ]);
            }
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
            'spk_hpp',
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
            'm_sname',
            's_qty',
            'fr_hpp')
            ->where('fr_spk', $request->x)
            ->join('m_item', 'i_id', '=', 'fr_formula')
            ->join('m_satuan', 'm_sid', '=', 'fr_scale')
            ->leftJoin('d_stock', function($q){
                $q->on('s_item', '=', 'i_id');
                $q->on('s_item', '=', 'fr_formula');
                $q->on('s_comp', '=', DB::raw('3'));
                $q->on('s_position', '=', DB::raw('3'));
            })
            ->get();

        $ket = $spk[0]->spk_status;
        $id = $spk[0]->spk_id;


        // return json_encode(count($bambang));
        return view('produksi.spk.detail-formula', compact('spk', 'formula', 'bambang','ket','id'));

    }

    public function inputData(Request $request)
    {
        $spk = d_spk::select('spk_id')
            ->where('spk_id', $request->x)
            ->first();

        $actual = spk_actual::where('ac_spk', $request->x)
            ->first();

        $dataFormula = spk_formula::select('i_id',
                                             'i_code',
                                             'i_name',
                                             'm_sname',
                                             'fr_value'
                                             )
            ->join('m_item','m_item.i_id','=','fr_formula')
            ->join('m_satuan','m_satuan.m_sid','=','fr_scale')
            ->where('fr_spk', $request->x)
            ->get();
        // dd($dataFormula);

        return view('produksi.spk.table-inputactual', compact('spk', 'actual', 'dataFormula'));
    }

    public function print($spk_id)
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
