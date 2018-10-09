<?php

namespace App\Http\Controllers\Hrd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Response;
use DB;
use DataTables;
use Auth;
use App\m_jabatan;
use App\m_pegawai_man;
use App\f_pelatihan;
use App\fp_detail;
use App\d_pelatihan;
use App\d_pengajuan_pelatihan;
use App\d_pengajuan_pelatihandt;
use App\m_divisi;

class TrainingContoller extends Controller
{
  public function training(){
    $devisi = m_divisi::all();
    return view('hrd/training/training',compact('devisi'));
  }

  public function tambah_training(){
    $staf = m_pegawai_man::select('m_pegawai_man.c_id as mp_id',
        'c_nama')
      ->join('m_jabatan','m_jabatan.c_id','=','c_jabatan_id')
      ->where('c_sub_divisi_id',1)
      ->get();
    // dd($staf);
    $staff['nama'] = Auth::user()->m_name;
    $staff['id'] = Auth::User()->m_pegawai_id;
    $authJabatan['m_pegawai_id'] = Auth::User()->m_pegawai_id;
    $jabatan = m_pegawai_man::select('m_jabatan.c_id as j_id',
      'c_posisi')
      ->join('m_jabatan','m_jabatan.c_id','=','c_jabatan_id')
      ->where('m_pegawai_man.c_id',$authJabatan)
      ->first();
    // dd($jabatan);
    $soal = f_pelatihan::select('fp_id',
      'fp_soal')
      ->where('fp_status','Y')
      ->get();

    $jawab = fp_detail::select('fpd_fp',
      'fpd_jawab',
      'fpd_det',
      'fpd_type')
      ->get();

    $pelatihan = d_pelatihan::all();

    return view('hrd/training/tambah_training',compact('staff','jabatan','staf',
      'soal','jawab','pelatihan'));
  }

  public function savePengajuan(Request $request){
    // dd($request->all());
    DB::beginTransaction();
      try {
    $pp_id = d_pengajuan_pelatihan::select('pp_id')->max('pp_id')+1;
    //nota
    $year = carbon::now()->format('y');
    $month = carbon::now()->format('m');
    $date = carbon::now()->format('d');
    $fatkur = 'PP'  . $year . $month . $date . $pp_id;
    //end Nota
      d_pengajuan_pelatihan::insert([
        'pp_id' => $pp_id,
        'pp_pm' => $request->idStaff,
        'pp_code' => $fatkur,
        'pp_jabatan' => $request->pp_jabatan,
        'pp_jenis_pelatihan' => $request->jenis_pelatihan,
        'pp_nama_atasan' => $request->pp_nama_atasan,
        'pp_status' => 'PN',
        'pp_created' => Carbon::now()
      ]);

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

  public function tablePengajuan($tgl1, $tgl2, $data){
    $d = substr($tgl1,0,2);
    $y = substr($tgl1, -4);
    $m = substr($tgl1, -7,-5);
      $tgl1 = $y.'-'.$m.'-'.$d;

    $d = substr($tgl2,0,2);
    $y = substr($tgl2, -4);
    $m = substr($tgl2, -7,-5);
      $tgl2 = $y.'-'.$m.'-'.$d;

    $pengajuan = d_pengajuan_pelatihan::select(
      'pp_id',
      'pp_code',
      'u1.c_code as code_pegawai',
      'u1.c_nama as nama_pegawai',
      'u2.c_code as code_atasan',
      'u2.c_nama as nama_atasan',
      'dp_name',
      'pp_status')
      ->join('m_pegawai_man as u1','u1.c_id','=','pp_pm')
      ->join('m_pegawai_man as u2','u2.c_id','=','pp_nama_atasan')
      ->join('m_jabatan','m_jabatan.c_id','=','u1.c_jabatan_id')
      ->join('d_pelatihan','d_pelatihan.dp_id','=','pp_jenis_pelatihan')
      ->where('u1.c_divisi_id',$data)
      ->whereDate('pp_created','>=',$tgl1)
      ->whereDate('pp_created','<=',$tgl2)
      ->get();
      // dd($pengajuan);
    return DataTables::of($pengajuan)
    ->addIndexColumn()

    ->editColumn('pegawai', function ($data) {
        return "$data->code_pegawai - $data->nama_pegawai" ;

    })

    ->editColumn('atasan', function ($data) {
        return "$data->code_atasan - $data->nama_atasan" ;

    })

    ->editColumn('pelatihan', function ($data) {
        return "$data->dp_name" ;

    })

    ->editColumn('status', function ($data) {
      if ($data->pp_status == 'PN') {
        return '<div class="text-center">
                    <span class="label label-red">Waiting</span>
                </div>';
      }else{
        return '<div class="text-center">
                    <span class="label label-yellow">Approved</span>
                </div>';
      }
    })
    ->editColumn('aksi', function ($data) {
      if ($data->pp_status == 'PN') {
        return '<div class="text-center">
                  <a  onclick="openPengajuan('.$data->pp_id.')"
                      class="btn btn-warning btn-sm"
                      title="Setujui">
                      <i class="fa fa-eye"></i>
                      Pengajuan
                  </a>
                </div>';
      }else{
        return '<div class="text-center">
                    <button class="btn btn-sm btn-success"
                            title="Detail"
                            type="button"
                            onclick=openWaktu("'.$data->pp_id.'")
                            data-toggle="modal"
                            data-target="#myModalView">
                            <i class="fa fa-eye"></i>
                            Lihat
                    </button>
                </div>';
      }


    })
    ->rawColumns(['pegawai',
                  'pelatihan',
                  'atasan',
                  'status',
                  'aksi'
                ])
    ->make(true);

  }

  public function accPelatihan($id){
    $pegawai = d_pengajuan_pelatihan::select('bawahan.c_nama as b_nama',
      'c_posisi',
      'dp_name',
      'atasan.c_nama as a_nama',
      'pp_id')
      ->join('m_pegawai_man as bawahan','bawahan.c_id','=','pp_pm')
      ->join('m_pegawai_man as atasan','atasan.c_id','=','pp_nama_atasan')
      ->join('m_jabatan','m_jabatan.c_id','=','pp_jabatan')
      ->join('d_pelatihan','d_pelatihan.dp_id','=','pp_jenis_pelatihan')
      ->where('pp_id',$id)
      ->first();
      // dd($pegawai);
    $soal = f_pelatihan::select('fp_id',
      'fp_soal')
      ->where('fp_status','Y')
      ->get();

    $jawab = fp_detail::select('fpd_fp',
      'fpd_jawab',
      'fpd_det',
      'fpd_type')
      ->get();

    return view('hrd/training/isi-pelatihan',compact('pegawai','soal','jawab'));
  }

  public function savePengajuanForm(Request $request){
    // dd($request->all());
    DB::beginTransaction();
      try {
    for ($i=0; $i < count($request->fpd_idjawab) ; $i++) {
      $str = $request->fpd_idjawab[$i];
      $data = explode('|',$str);
      d_pengajuan_pelatihandt::insert([
        'ppd_pp' => $request->pp_id,
        'ppd_detailid' => $i+1,
        'ppd_fpd_fp' => $data[0],
        'pp_fpd_det' => $data[1]
      ]);
    }

    for ($i=0; $i < count($request->fpd_jawabid) ; $i++) {
      $str = $request->fpd_jawabid[$i];
      $data = explode('|',$str);
      $detailid = d_pengajuan_pelatihandt::select('ppd_detailid')
        ->where('ppd_pp',$request->pp_id)
        ->max('ppd_detailid')+1;
      d_pengajuan_pelatihandt::insert([
        'ppd_pp' => $request->pp_id,
        'ppd_detailid' => $detailid+1,
        'ppd_fpd_fp' => $data[0],
        'pp_fpd_det' => $data[1],
        'pp_fpd_ket' => $request->fpd_jawab[$i]
      ]);
    }

    $cek = d_pengajuan_pelatihan::
      where('pp_id',$request->pp_id)
      ->update([
        'pp_status' => 'AP'
      ]);
      // dd($cek);
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

  public function reqTimeTraining(Request $request){
    $pengajuan = d_pengajuan_pelatihandt::select(
        'c_nama',
        'dp_name',
        'pp_fpd_ket')
      ->join('d_pengajuan_pelatihan','d_pengajuan_pelatihan.pp_id','=','ppd_pp')
      ->join('d_pelatihan','d_pelatihan.dp_id','=','pp_jenis_pelatihan')
      ->join('m_pegawai_man','m_pegawai_man.c_id','=','pp_pm')
      ->where('ppd_pp',$request->x)
      ->where('ppd_fpd_fp',9)
      ->get();
    // dd($pengajuan);
    return view('hrd.training.view-waktu',compact('pengajuan'));
  }
}
