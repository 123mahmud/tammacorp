<?php

namespace App\Http\Controllers\Hrd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use URL;
use Carbon\Carbon;
use DB;
use Response;
use App\Http\Requests;
use App\m_pegawai_man;
use App\m_pegawai_pro;
use App\m_divisi;
use App\m_produksi;
use App\abs_pegawai_man;
use App\abs_pegawai_pro;
use Excel;
use Illuminate\Support\Facades\Input;

class AbsensiController extends Controller
{
    public function index(){
      $devisi = m_divisi::all();
      $produksi = m_produksi::all();
      return view('hrd.Absensi.index', compact('devisi','produksi'));
    }

    public function table($tgl1, $tgl2, $data){
      $d = substr($tgl1,0,2);
      $y = substr($tgl1, -4);
      $m = substr($tgl1, -7,-5);
        $tgl1 = $y.'-'.$m.'-'.$d;

      $d = substr($tgl2,0,2);
      $y = substr($tgl2, -4);
      $m = substr($tgl2, -7,-5);
        $tgl2 = $y.'-'.$m.'-'.$d;

      $pegawai = abs_pegawai_man::select(
          'apm_tanggal',
          'c_nik',
          'c_nama',
          'apm_jam_kerja',
          'apm_jam_masuk',
          'apm_jam_pulang',
          'apm_scan_masuk',
          'apm_scan_pulang',
          'apm_terlambat',
          'apm_jml_jamkerja')
        ->join('m_pegawai_man','m_pegawai_man.c_id','=','apm_pm')
        ->where('c_isactive','TRUE')
        ->where('apm_tanggal','>=',$tgl1)
        ->where('apm_tanggal','<=',$tgl2)
        ->where('c_divisi_id',$data)
        ->get();
      // dd($pegawai);
      return DataTables::of($pegawai)
      ->addIndexColumn()

      ->editColumn('tanggal', function ($data){
          return date('d M Y', strtotime($data->apm_tanggal));
      })

      ->editColumn('pegawai', function ($data) {
          return "$data->c_nik - $data->c_nama" ;

      })


      ->rawColumns(['tanggal',
                    'pegawai'
                  ])
      ->make(true);

    }

  public function savePeg(Request $request){
    DB::beginTransaction();
      try {
    $tgl = $request->tanggal;
    $d = substr($tgl,0,2);
    $y = substr($tgl, -4);
    $m = substr($tgl, -7,-5);
      $tgl = $y.'-'.$m.'-'.$d;
        for ($i=0; $i <count($request->apm_ket) ; $i++) {
          $id = abs_pegawai_man::select('apm_id')->max('apm_id')+1;
            $cek = abs_pegawai_man::where('apm_pm',$request->apm_pm[$i])
              ->where('apm_date',$tgl)
              ->first();
              // dd($cek);
              if ($cek == null) {
                abs_pegawai_man::insert([
                  'apm_id' => $id,
                  'apm_pm' => $request->apm_pm[$i],
                  'apm_date' => $tgl,
                  'apm_ket' => $request->apm_ket[$i],
                  'apm_insert' => Carbon::now()
                ]);
              }else {
                $cek->update([
                  'apm_ket' => $request->apm_ket[$i],
                  'apm_update' => Carbon::now()
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

  public function detAbsensi($tgl1, $tgl2, $data){
    $d = substr($tgl1,0,2);
    $y = substr($tgl1, -4);
    $m = substr($tgl1, -7,-5);
      $tgl1 = $y.'-'.$m.'-'.$d;

    $d2 = substr($tgl2,0,2);
    $y2 = substr($tgl2, -4);
    $m2 = substr($tgl2, -7,-5);
      $tgl2 = $y2.'-'.$m2.'-'.$d2;

    $pegawai = abs_pegawai_pro::select(
          'app_tanggal',
          'c_nik',
          'c_nama',
          'app_jam_kerja',
          'app_jam_masuk',
          'app_jam_pulang',
          'app_scan_masuk',
          'app_scan_pulang',
          'app_terlambat',
          'app_jml_jamkerja')
        ->join('m_pegawai_pro','m_pegawai_pro.c_id','=','app_pp')
        ->where('cp_isactive','TRUE')
        ->where('app_tanggal','>=',$tgl1)
        ->where('app_tanggal','<=',$tgl2)
        ->where('c_rumah_produksi',$data)
        ->get();
      // dd($pegawai);
    return DataTables::of($pegawai)

    ->addIndexColumn()

      ->editColumn('tanggal', function ($data){
          return date('d M Y', strtotime($data->app_tanggal));
      })

      ->editColumn('pegawai', function ($data) {
          return "$data->c_nik - $data->c_nama" ;

      })


      ->rawColumns(['tanggal',
                    'pegawai'
                  ])
      ->make(true);

  }

  public function importDataManajemen(Request $request){
    if ($request->hasFile('file')) {
      $path = $request->file('file')->getRealPath();
      $data = Excel::load($path, function($reader){})->get();
      if (!empty($data) && $data->count()) {
        foreach ($data as $key => $value) {
          $cek = abs_pegawai_man::where('apm_pm',$value->id_manajemen)
                    ->where('apm_tanggal',$value->tanggal)
                    ->first();
          if ($cek == null) {
            $absensi = new abs_pegawai_man();
            $absensi->apm_pm = $value->id_manajemen;
            $absensi->apm_tanggal = $value->tanggal;
            $absensi->apm_jam_kerja = $value->jam_kerja;
            $absensi->apm_jam_masuk = $value->jam_masuk;
            $absensi->apm_jam_pulang = $value->jam_pulang;
            $absensi->apm_scan_masuk = $value->scan_masuk;
            $absensi->apm_scan_pulang = $value->scan_pulang;
            $absensi->apm_terlambat = $value->terlambat;
            $absensi->apm_plg_cepat = $value->plg_cepat;
            $absensi->apm_absent = $value->absent;
            $absensi->apm_lembur = $value->lembur;
            $absensi->apm_jml_jamkerja = $value->jml_jam_kerja;
            $absensi->save();
          }else{
            $cek->update([
                'apm_jam_kerja' => $value->jam_kerja,
                'apm_jam_masuk' => $value->jam_masuk,
                'apm_jam_pulang' => $value->jam_pulang,
                'apm_scan_masuk' => $value->scan_masuk,
                'apm_scan_pulang' => $value->scan_pulang,
                'apm_terlambat' => $value->terlambat,
                'apm_plg_cepat' => $value->plg_cepat,
                'apm_absent' => $value->absent,
                'apm_lembur' => $value->lembur,
                'apm_jml_jamkerja' => $value->jml_jam_kerja
            ]);
          }
        }
      }
    }

    return back();
  }

  public function importDataProduksi(Request $request){
    if ($request->hasFile('file-produksi')) {
      $path = $request->file('file-produksi')->getRealPath();
      $data = Excel::load($path, function($reader){})->get();
      if (!empty($data) && $data->count()) {
        foreach ($data as $key => $value) {
          $cek = abs_pegawai_pro::where('app_pp',$value->id_produksi)
                    ->where('app_tanggal',$value->tanggal)
                    ->first();
          if ($cek == null) {
            $absensi = new abs_pegawai_pro();
            $absensi->app_pp = $value->id_produksi;
            $absensi->app_tanggal = $value->tanggal;
            $absensi->app_jam_kerja = $value->jam_kerja;
            $absensi->app_jam_masuk = $value->jam_masuk;
            $absensi->app_jam_pulang = $value->jam_pulang;
            $absensi->app_scan_masuk = $value->scan_masuk;
            $absensi->app_scan_pulang = $value->scan_pulang;
            $absensi->app_terlambat = $value->terlambat;
            $absensi->app_plg_cepat = $value->plg_cepat;
            $absensi->app_absent = $value->absent;
            $absensi->app_lembur = $value->lembur;
            $absensi->app_jml_jamkerja = $value->jml_jam_kerja;
            $absensi->save();
          }else{
            $cek->update([
              'app_jam_kerja' => $value->jam_kerja,
              'app_jam_masuk' => $value->jam_masuk,
              'app_jam_pulang' => $value->jam_pulang,
              'app_scan_masuk' => $value->scan_masuk,
              'app_scan_pulang' => $value->scan_pulang,
              'app_terlambat' => $value->terlambat,
              'app_plg_cepat' => $value->plg_cepat,
              'app_absent' => $value->absent,
              'app_lembur' => $value->lembur,
              'app_jml_jamkerja' => $value->jml_jam_kerja
            ]);
          }
          
        }
      }
    }

    return back();
  }

  public function exportManajemen(){
    $manajemen = m_pegawai_man::select('c_id','c_nama')->get();
    return Excel::create('id_manajemen', function($excel) use ($manajemen){
      $excel->sheet('mysheet', function($sheet) use ($manajemen){
        $sheet->fromArray($manajemen);
      });
    })->download('xls');
  }

  public function exportProduksi(){
    $produksi = m_pegawai_pro::select('c_id','c_nama')->get();
    return Excel::create('id_produksi', function($excel) use ($produksi){
      $excel->sheet('mysheet', function($sheet) use ($produksi){
        $sheet->fromArray($produksi);
      });
    })->download('xls');
  }
}
