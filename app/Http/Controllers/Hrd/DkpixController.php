<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Model\Hrd\d_kpix;
use App\Model\Hrd\d_kpix_dt;
use App\Model\Master\m_kpix;
use Response;
use DB;
use DataTables;
use Auth;

class DkpixController extends Controller
{
    public function index()
    {
        //dd(Auth::user());
        return view('hrd/datainputkpix/index');
    }

    public function getKpixByTgl($tgl1, $tgl2)
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
        
        $data = d_kpix::join('m_pegawai_man','d_kpix.d_kpix_pid','=','m_pegawai_man.c_id')
                    ->where('c_divisi_id', $div_id)
                    ->whereBetween('d_kpix_date', [$tanggal1, $tanggal2])
                    ->orderBy('d_kpix_created', 'DESC')->get();
        
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
                                onclick=detailKpix("'.$data->d_kpix_id.'")><i class="fa fa-info-circle"></i> 
                            </button>
                            <button class="btn btn-sm btn-warning" title="Edit"
                                onclick=editKpix("'.$data->d_kpix_id.'") disabled><i class="fa fa-edit"></i> 
                            </button>
                            <button class="btn btn-sm btn-danger" title="Hapus"
                                onclick=hapusKpix("'.$data->d_kpix_id.'") disabled><i class="fa fa-times-circle"></i>
                            </button>
                        </div>';
            }else{
                return '<div class="text-center">
                            <button class="btn btn-sm btn-success" title="Detail"
                                onclick=detailKpix("'.$data->d_kpix_id.'")><i class="fa fa-info-circle"></i> 
                            </button>
                            <button class="btn btn-sm btn-warning" title="Edit"
                                onclick=editKpix("'.$data->d_kpix_id.'")><i class="fa fa-edit"></i> 
                            </button>
                            <button class="btn btn-sm btn-danger" title="Hapus"
                                onclick=hapusKpix("'.$data->d_kpix_id.'")><i class="fa fa-times-circle"></i>
                            </button>
                        </div>';
            }
        })
        ->rawColumns(['action','status'])
        ->make(true);
    }

    public function tambahData()
    {
        $id_peg = Auth::user()->m_pegawai_id;
        $data = DB::table('m_pegawai_man')
            ->join('m_divisi', 'm_pegawai_man.c_divisi_id', '=', 'm_divisi.c_id')
            ->select('m_pegawai_man.c_divisi_id', 'm_divisi.c_divisi')
            ->where('m_pegawai_man.c_id', '=', $id_peg)->first();

        return response()->json([
            'status' => 'sukses',
            'data' => $data,
        ]);
    }

    public function lookupJabatan(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        $idDiv = $request->idDiv;
        if (empty($term)) 
        {
            $jabatan = DB::table('m_jabatan')->where('c_divisi_id', $idDiv)->get();
            foreach ($jabatan as $val) {
                $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_posisi];
            }
            
            return Response::json($formatted_tags);
        }
        else
        {
            $jabatan = DB::table('m_jabatan')->where('c_divisi_id', $idDiv)->where('c_posisi', 'LIKE', '%'.$term.'%')->get();
            foreach ($jabatan as $val) {
                $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_posisi];
            }

          return Response::json($formatted_tags);  
        }
    }

    public function lookupPegawai(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        $idJabatan = $request->idJabatan;
        $idDiv = $request->idDiv;
        if (empty($term)) 
        {
            $pegawai = DB::table('m_pegawai_man')->where('c_divisi_id', $idDiv)->where('c_jabatan_id', $idJabatan)->get();
            foreach ($pegawai as $val) {
                $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_nama];
            }
            return Response::json($formatted_tags);
        }
        else
        {
            $pegawai = DB::table('m_pegawai_man')->where('c_divisi_id', $idDiv)->where('c_jabatan_id', $idJabatan)->where('c_nama', 'LIKE', '%'.$term.'%')->get();
            foreach ($pegawai as $val) {
                $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_nama];
            }
            return Response::json($formatted_tags);  
        }
    }

    public function setFieldModal($id)
    {
        $kpi = m_kpix::where('kpix_p_id', '=', $id)->get();
        if (count($kpi) > 0) {
            return response()->json([ 'status' => 'sukses', 'kpi' => $kpi ]);
        }else{
            return response()->json([ 'status' => 'error', 'kpi' => null ]);
        }
    }

    public function simpanData(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {
            //code penerimaan
            $kode = $this->kodeKpixAuto();
            $lastId = d_kpix::select('d_kpix_id')->max('d_kpix_id');
            if ($lastId == 0 || $lastId == '') { $lastId  = 1; } else { $lastId += 1; } 
            
            $kpix = new d_kpix;
            $kpix->d_kpix_id = $lastId;
            $kpix->d_kpix_code = $kode;
            $kpix->d_kpix_pid = $request->pegawai;
            $kpix->d_kpix_date = date('Y-m-d',strtotime($request->tglKpix));
            $kpix->d_kpix_created = Carbon::now('Asia/Jakarta');
            $kpix->save();

            for ($i=0; $i < count($request->value_kpix); $i++) 
            { 
                d_kpix_dt::insert([
                            'd_kpixdt_dkpix_id' => $lastId,
                            'd_kpixdt_mkpix_id' => $request->index_kpix[$i],
                            'd_kpixdt_value' => strtoupper($request->value_kpix[$i]),
                            'd_kpixdt_created' => Carbon::now('Asia/Jakarta')
                        ]);
            }
                   
            DB::commit();
            return response()->json([
                'status' => 'sukses',
                'pesan' => 'Data KPI Berhasil Disimpan'
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

    public function kodeKpixAuto()
    {
        $query = DB::select(DB::raw("SELECT MAX(RIGHT(d_kpix_code,4)) as kode_max from d_kpix WHERE DATE_FORMAT(d_kpix_created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));
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

        return $code = "KPI-".date('ym')."-".$kd;
    }

    public function getDataEdit($id)
    {
        $id_peg = d_kpix::select('d_kpix_pid')->where('d_kpix.d_kpix_id', $id)->first();

        $data = d_kpix::join('d_kpix_dt', 'd_kpix.d_kpix_id', '=', 'd_kpix_dt.d_kpixdt_dkpix_id')
                            ->join('m_kpix', 'd_kpix_dt.d_kpixdt_mkpix_id', '=', 'm_kpix.kpix_id')
                            ->where('d_kpix.d_kpix_id', $id)->get();

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
            'data' => $data
        ]);
    }

    public function updateData(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {   
            $tanggal = Carbon::now('Asia/Jakarta');
            $d_kpix = d_kpix::find($request->e_old);
            $d_kpix->d_kpix_date = date('Y-m-d',strtotime($request->eTglKpix));
            $d_kpix->d_kpix_updated = $tanggal;
            $d_kpix->save();

            for ($i=0; $i < count($request->e_value_kpix); $i++) 
            { 
                d_kpix_dt::where('d_kpixdt_id','=',$request->e_index_dt[$i])
                        ->update([
                            'd_kpixdt_value' => strtoupper($request->e_value_kpix[$i]),
                            'd_kpixdt_updated' => Carbon::now('Asia/Jakarta')
                        ]);
            }

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Input KPI Berhasil Diupdate'
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

    public function deleteData(Request $request)
    {
      DB::beginTransaction();
      try {
        d_kpix_dt::where('d_kpixdt_dkpix_id', $request->id)->delete();
        d_kpix::where('d_kpix_id', $request->id)->delete();

        DB::commit();
        return response()->json([
            'status' => 'sukses',
            'pesan' => 'Data Input KPI Berhasil Dihapus'
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
