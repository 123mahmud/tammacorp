<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Model\Hrd\d_kpi;
use App\Model\Hrd\d_kpi_dt;
use App\Model\Master\m_kpi;
use App\Model\Hrd\d_kpix;
use App\Model\Hrd\d_kpix_dt;
use App\Model\Master\m_kpix;
use Response;
use DB;
use DataTables;
use Auth;

class ManscorekpiController extends Controller
{
    public function index()
    {
        //dd(Auth::user());
        return view('hrd/manajemenkpix/index');
    }

    public function getKpiByTgl($tgl1, $tgl2, $tampil)
    {
        $id_peg = Auth::user()->m_pegawai_id;
        $tanggal1 = date('Y-m-d',strtotime($tgl1));
        $tanggal2 = date('Y-m-d',strtotime($tgl2));
        
        if ($tampil == 'ALL') {
            $data = d_kpix::join('m_pegawai_man','d_kpix.d_kpix_pid','=','m_pegawai_man.c_id')
                        ->whereBetween('d_kpix_date', [$tanggal1, $tanggal2])
                        ->orderBy('d_kpix_created', 'DESC')->get();
        }else{
            $data = d_kpix::join('m_pegawai_man','d_kpix.d_kpix_pid','=','m_pegawai_man.c_id')
                        ->where('d_kpix.d_kpix_isconfirm', '=', $tampil)
                        ->whereBetween('d_kpix_date', [$tanggal1, $tanggal2])
                        ->orderBy('d_kpix_created', 'DESC')->get();    
        }
        
        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('tglBuat', function ($data) 
        {
            if ($data->d_kpix_date == null) {
                return '-';
            } else {
                return $data->d_kpix_date ? with(new Carbon($data->d_kpix_date))->format('d M Y') : '';
            }
        })
        ->editColumn('status', function ($data) 
        {
            if ($data->d_kpix_isconfirm == 'N') {
                return '<span style="color:red;text-align:center;"> Belum Dikonfirmasi </span>';
            } else {
                return '<span style="color:blue;text-align:center;"> Sudah Dikonfirmasi </span>';
            }
        })
        ->editColumn('tglConfirm', function ($data) 
        {
            if ($data->d_kpix_dateconfirm == null) {
                return '-';
            } else {
                return $data->d_kpix_dateconfirm ? with(new Carbon($data->d_kpix_dateconfirm))->format('d M Y') : '';
            }
        })
        ->addColumn('action', function($data)
        { 
            if ($data->d_kpix_isconfirm == 'Y') {
                return '<div class="text-center">
                            <button class="btn btn-sm btn-success" title="Detail"
                                onclick=detailKpi("'.$data->d_kpix_id.'")><i class="fa fa-info-circle"></i> 
                            </button>
                            <button class="btn btn-sm btn-info" title="Confirm"
                                onclick=confirmKpi("'.$data->d_kpix_id.'") disabled><i class="fa fa-edit"></i> 
                            </button>
                            <button class="btn btn-sm btn-danger" title="Batalkan Konfirmasi"
                                onclick=ubahStatus("'.$data->d_kpix_id.'","Y")><i class="fa fa-mail-forward"></i>
                            </button>
                        </div>';
            }else{
                return '<div class="text-center">
                            <button class="btn btn-sm btn-success" title="Detail"
                                onclick=detailKpi("'.$data->d_kpix_id.'")><i class="fa fa-info-circle"></i> 
                            </button>
                            <button class="btn btn-sm btn-info" title="Confirm"
                                onclick=confirmKpi("'.$data->d_kpix_id.'")><i class="fa fa-edit"></i> 
                            </button>
                            <button class="btn btn-sm btn-default" title="Konfirmasi"
                                onclick=ubahStatus("'.$data->d_kpix_id.'","N") disabled><i class="fa fa-mail-reply"></i>
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
        $id_peg = d_kpix::select('d_kpix_pid')->where('d_kpix.d_kpix_id', $id)->first();

        $data = d_kpix::join('d_kpix_dt', 'd_kpix.d_kpix_id', '=', 'd_kpix_dt.d_kpixdt_dkpix_id')
                            ->join('m_kpix', 'd_kpix_dt.d_kpixdt_mkpix_id', '=', 'm_kpix.kpix_id')
                            ->where('d_kpix.d_kpix_id', $id)->get();
        foreach ($data as $val) {
            $score[] = ((int)$val->d_kpixdt_value / (int)$val->kpix_target) * 100;
        }

        $pegawai = d_kpix::join('m_pegawai_man', 'd_kpix.d_kpix_pid', '=', 'm_pegawai_man.c_id')
            ->join('m_divisi', 'm_pegawai_man.c_divisi_id', '=', 'm_divisi.c_id')
            ->join('m_jabatan', 'm_pegawai_man.c_jabatan_id', '=', 'm_jabatan.c_id')
            ->select(
                'm_pegawai_man.c_nama',
                'm_pegawai_man.c_divisi_id',
                'm_pegawai_man.c_jabatan_id',
                'm_divisi.c_divisi',
                'm_jabatan.c_posisi')
            ->where('d_kpix.d_kpix_pid', '=', $id_peg->d_kpix_pid)->first();

        return response()->json([
            'status' => 'sukses',
            'pegawai' => $pegawai,
            'data' => $data,
            'scoreKpi' => $score
        ]);
    }

    public function updateData(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {
            $tanggal =  Carbon::now('Asia/Jakarta');
            $totalSkor = 0;

            for ($i=0; $i < count($request->e_index_kpix); $i++) 
            { 
                $skorAkhir = floatval($request->e_score_kpix[$i]) * floatval($request->e_bobot_kpix[$i]) / 100;
                d_kpix_dt::where('d_kpixdt_id','=',$request->e_index_dt[$i])
                        ->update([
                            'd_kpixdt_value' => $request->e_value_kpix[$i],
                            'd_kpixdt_score' => $request->e_score_kpix[$i],
                            'd_kpixdt_scoreakhir' => $skorAkhir,
                            'd_kpixdt_updated' => Carbon::now('Asia/Jakarta')
                        ]);
                $totalSkor += $skorAkhir;
            }

            $d_kpix = d_kpix::find($request->e_old);
            $d_kpix->d_kpix_date = date('Y-m-d',strtotime($request->eTglKpix));
            $d_kpix->d_kpix_updated = $tanggal;
            $d_kpix->d_kpix_isconfirm = 'Y';
            $d_kpix->d_kpix_dateconfirm = $tanggal;
            $d_kpix->d_kpix_scoretotal = $totalSkor;
            $d_kpix->save();

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data KPI Berhasil Dikonfirmasi'
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
        $tanggal = Carbon::now('Asia/Jakarta');
        $d_kpix = d_kpix::find($request->id);
        if ($request->status == 'Y') 
        {
            $d_kpix->d_kpix_dateconfirm = null;
            $d_kpix->d_kpix_isconfirm = 'N';
            $pesan = 'Pembatalan konfirmasi data KPI berhasil';
        }
        else
        {
            $d_kpix->d_kpix_dateconfirm = $tanggal;
            $d_kpix->d_kpix_isconfirm = 'Y';
            $pesan = 'Konfirmasi data KPI berhasil';
        }
        $d_kpix->save();

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

    public function getScoreByTgl($tgl1, $tgl2, $tampil)
    {
        $id_peg = Auth::user()->m_pegawai_id;
        $tanggal1 = date('Y-m-d',strtotime($tgl1));
        $tanggal2 = date('Y-m-d',strtotime($tgl2));
        
        if ($tampil == 'ALL') {
            $data = d_kpi::join('m_pegawai_man','d_kpi.d_kpi_pid','=','m_pegawai_man.c_id')
                        ->whereBetween('d_kpi_date', [$tanggal1, $tanggal2])
                        ->orderBy('d_kpi_created', 'DESC')->get();
        }else{
            $data = d_kpi::join('m_pegawai_man','d_kpi.d_kpi_pid','=','m_pegawai_man.c_id')
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
                                onclick=detailScore("'.$data->d_kpi_id.'")><i class="fa fa-info-circle"></i> 
                            </button>
                        </div>';
            }else{
                return '<div class="text-center">
                            <button class="btn btn-sm btn-success" title="Detail"
                                onclick=detailScore("'.$data->d_kpi_id.'")><i class="fa fa-info-circle"></i> 
                            </button>
                        </div>';
            }  
        })
        ->rawColumns(['action','status'])
        ->make(true);
    }

    // =======================================================================================================================
}
