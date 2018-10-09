<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Model\Hrd\d_kpi;
use App\Model\Hrd\d_kpi_dt;
use App\Model\Master\m_kpi;
use Response;
use DB;
use DataTables;
use Auth;

class MankpiController extends Controller
{
    public function index()
    {
        //dd(Auth::user());
        return view('hrd/manajemenkpi/index');
    }

    public function getKpiByTgl($tgl1, $tgl2, $tampil)
    {
        $id_peg = Auth::user()->m_pegawai_id;
        $tanggal1 = date('Y-m-d',strtotime($tgl1));
        $tanggal2 = date('Y-m-d',strtotime($tgl2));
        $d_pegawai = DB::table('m_pegawai_man')->where('c_id', $id_peg)->first();
        
        if ($d_pegawai->c_divisi_id == '1') {
            $div_id = $d_pegawai->c_divisi_id;
        }elseif($d_pegawai->c_divisi_id == '2'){
            $div_id = $d_pegawai->c_divisi_id;
        }elseif($d_pegawai->c_divisi_id == '3'){
            $div_id = $d_pegawai->c_divisi_id;
        }elseif($d_pegawai->c_divisi_id == '4'){
            $div_id = $d_pegawai->c_divisi_id;
        }elseif($d_pegawai->c_divisi_id == '5'){
            $div_id = $d_pegawai->c_divisi_id;
        }
        
        if ($tampil == 'ALL') {
            $data = d_kpi::join('m_pegawai_man','d_kpi.d_kpi_pid','=','m_pegawai_man.c_id')
                        ->where('c_divisi_id', $div_id)
                        ->whereBetween('d_kpi_date', [$tanggal1, $tanggal2])
                        ->orderBy('d_kpi_created', 'DESC')->get();
        }else{
            $data = d_kpi::join('m_pegawai_man','d_kpi.d_kpi_pid','=','m_pegawai_man.c_id')
                        ->where('c_divisi_id', $div_id)
                        ->where('d_kpi.d_kpi_isconfirm', '=', $tampil)
                        ->whereBetween('d_kpi_date', [$tanggal1, $tanggal2])
                        ->orderBy('d_kpi_created', 'DESC')->get();    
        }
        
        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('tglBuat', function ($data) 
        {
            if ($data->d_kpi_date == null) {
                return '-';
            } else {
                return $data->d_kpi_date ? with(new Carbon($data->d_kpi_date))->format('d M Y') : '';
            }
        })
        ->editColumn('status', function ($data) 
        {
            if ($data->d_kpi_isconfirm == 'N') {
                return '<span style="color:red;text-align:center;"> Belum Dikonfirmasi </span>';
            } else {
                return '<span style="color:blue;text-align:center;"> Sudah Dikonfirmasi </span>';
            }
        })
        ->editColumn('tglConfirm', function ($data) 
        {
            if ($data->d_kpi_dateconfirm == null) {
                return '-';
            } else {
                return $data->d_kpi_dateconfirm ? with(new Carbon($data->d_kpi_dateconfirm))->format('d M Y') : '';
            }
        })
        ->addColumn('action', function($data)
        { 
            if ($data->d_kpi_isconfirm == 'Y') {
                return '<div class="text-center">
                            <button class="btn btn-sm btn-success" title="Detail"
                                onclick=detailKpi("'.$data->d_kpi_id.'")><i class="fa fa-info-circle"></i> 
                            </button>
                            <button class="btn btn-sm btn-info" title="Confirm"
                                onclick=confirmKpi("'.$data->d_kpi_id.'") disabled><i class="fa fa-edit"></i> 
                            </button>
                            <button class="btn btn-sm btn-danger" title="Batalkan Konfirmasi"
                                onclick=ubahStatus("'.$data->d_kpi_id.'","Y")><i class="fa fa-mail-forward"></i>
                            </button>
                        </div>';
            }else{
                return '<div class="text-center">
                            <button class="btn btn-sm btn-success" title="Detail"
                                onclick=detailKpi("'.$data->d_kpi_id.'")><i class="fa fa-info-circle"></i> 
                            </button>
                            <button class="btn btn-sm btn-info" title="Confirm"
                                onclick=confirmKpi("'.$data->d_kpi_id.'")><i class="fa fa-edit"></i> 
                            </button>
                            <button class="btn btn-sm btn-default" title="Konfirmasi"
                                onclick=ubahStatus("'.$data->d_kpi_id.'","N") disabled><i class="fa fa-mail-reply"></i>
                            </button>
                        </div>';
            }  
        })
        ->rawColumns(['action','status'])
        ->make(true);
    }

    public function lookup_divisi(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        $jenis_peg = $request->jenis;
        if (empty($term)) 
        {
            if ($jenis_peg == 'man') {
                $jabatan = DB::table('m_divisi')->orderBy('c_divisi', 'ASC')->limit(10)->get();
                foreach ($jabatan as $val) {
                    $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_divisi];
                }
            } elseif ($jenis_peg == 'pro') {
                $jabatan = DB::table('m_divisi')->where('c_id', '4')->orderBy('c_divisi', 'ASC')->limit(10)->get();
                foreach ($jabatan as $val) {
                    $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_divisi];
                }
            }

            return Response::json($formatted_tags);
        }
        else
        {
            if ($jenis_peg == 'man') {
                $jabatan = DB::table('m_divisi')->where('c_divisi', 'LIKE', '%'.$term.'%')->orderBy('c_divisi', 'ASC')->limit(10)->get();
                foreach ($jabatan as $val) {
                    $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_divisi];
                }
            } elseif ($jenis_peg == 'pro') {
                $jabatan = DB::table('m_divisi')->where('c_id', '4')->orderBy('c_divisi', 'ASC')->limit(10)->get();
                foreach ($jabatan as $val) {
                    $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_divisi];
                }
            }

          return Response::json($formatted_tags);  
        }
    }

    public function setFieldModal()
    {
        $id_peg = Auth::user()->m_pegawai_id;
        $data = DB::table('m_pegawai_man')
            ->join('m_divisi', 'm_pegawai_man.c_divisi_id', '=', 'm_divisi.c_id')
            ->join('m_jabatan', 'm_pegawai_man.c_jabatan_id', '=', 'm_jabatan.c_id')
            ->select(
                'm_pegawai_man.c_nama',
                'm_pegawai_man.c_divisi_id',
                'm_pegawai_man.c_jabatan_id',
                'm_divisi.c_divisi',
                'm_jabatan.c_posisi')
            ->where('m_pegawai_man.c_id', '=', $id_peg)->first();

        $kpi = m_kpi::where('kpi_p_id', '=', $id_peg)->get();
        return response()->json([
            'status' => 'sukses',
            'id_peg' => $id_peg,
            'data' => $data,
            'kpi' => $kpi
        ]);
    }

    public function getDataEdit($id)
    {
        $id_peg = d_kpi::select('d_kpi_pid')->where('d_kpi.d_kpi_id', $id)->first();

        $data = d_kpi::join('d_kpi_dt', 'd_kpi.d_kpi_id', '=', 'd_kpi_dt.d_kpidt_dkpi_id')
                            ->join('m_kpi', 'd_kpi_dt.d_kpidt_mkpi_id', '=', 'm_kpi.kpi_id')
                            ->where('d_kpi.d_kpi_id', $id)->get();

        $pegawai = d_kpi::join('m_pegawai_man', 'd_kpi.d_kpi_pid', '=', 'm_pegawai_man.c_id')
            ->join('m_divisi', 'm_pegawai_man.c_divisi_id', '=', 'm_divisi.c_id')
            ->join('m_jabatan', 'm_pegawai_man.c_jabatan_id', '=', 'm_jabatan.c_id')
            ->select(
                'm_pegawai_man.c_nama',
                'm_pegawai_man.c_divisi_id',
                'm_pegawai_man.c_jabatan_id',
                'm_divisi.c_divisi',
                'm_jabatan.c_posisi')
            ->where('d_kpi.d_kpi_pid', '=', $id_peg->d_kpi_pid)->first();

        return response()->json([
            'status' => 'sukses',
            'pegawai' => $pegawai,
            'data' => $data
        ]);
    }

    public function updateData(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {
            $tanggal = date("Y-m-d h:i:s");

            $d_kpi = d_kpi::find($request->e_old);
            $d_kpi->d_kpi_date = date('Y-m-d',strtotime($request->eTglKpi));
            $d_kpi->d_kpi_updated = $tanggal;
            $d_kpi->d_kpi_isconfirm = 'Y';
            $d_kpi->d_kpi_dateconfirm = $tanggal;
            $d_kpi->save();

            for ($i=0; $i < count($request->e_value_kpi); $i++) 
            { 
                d_kpi_dt::where('d_kpidt_id','=',$request->e_index_dt[$i])
                        ->update([
                            'd_kpidt_value' => strtoupper($request->e_value_kpi[$i]),
                            'd_kpidt_updated' => Carbon::now('Asia/Jakarta')
                        ]);
            }

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Input Scoreboard Berhasil Dikonfirmasi'
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

    public function ubahStatus(Request $request)
    {
      DB::beginTransaction();
      try 
      {
        $tanggal = date("Y-m-d h:i:s");
        $d_kpi = d_kpi::find($request->id);
        if ($request->status == 'Y') 
        {
            $d_kpi->d_kpi_dateconfirm = null;
            $d_kpi->d_kpi_isconfirm = 'N';
            $pesan = 'Pembatalan konfirmasi data Scoreboard berhasil';
        }
        else
        {
            $d_kpi->d_kpi_dateconfirm = $tanggal;
            $d_kpi->d_kpi_isconfirm = 'Y';
            $pesan = 'Konfirmasi data Scoreboard berhasil';
        }
        $d_kpi->save();

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

    // =======================================================================================================================
}
