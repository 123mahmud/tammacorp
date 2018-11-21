<?php

namespace App\Http\Controllers\Hrd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Response;
use App\Http\Requests;
use App\d_hasil_garapan;
use App\m_produksi;
use App\m_gaji_pro;
use App\m_jabatan_pro;
use App\abs_pegawai_pro;
use DataTables;
use URL;

class PayrollProduksiController extends Controller
{
    public function index(){
      $produksi = m_produksi::all();
      $m_gaji_pro = m_gaji_pro::select('c_id',
        'nm_gaji')
        ->where('c_status','GR')
        ->get();
      $c_jabatan_pro = m_jabatan_pro::all();
      return view('hrd.payroll-produksi.index',compact('produksi','m_gaji_pro','c_jabatan_pro'));
    }

    public function tableDataGarapan($rumah, $jabatan, $tgl1, $tgl2){
      $d = substr($tgl1,0,2);
      $y = substr($tgl1, -4);
      $m = substr($tgl1, -7,-5);
        $tgl1 = $y.'-'.$m.'-'.$d;

      $d = substr($tgl2,0,2);
      $y = substr($tgl2, -4);
      $m = substr($tgl2, -7,-5);
        $tgl2 = $y.'-'.$m.'-'.$d;

      $garapan = d_hasil_garapan::select(
        'm_pegawai_pro.c_id as id_p',
        'c_code',
        'c_nik',
        'c_nama',
        'c_nik',
        'c_nama',
        DB::raw("SUM(d_hg_gaji) as dataGaji"),
        DB::raw("SUM(d_hg_lembur) as dataLembur"),
        'app_pp',
        'app_tanggal',
        'c_jabatan_pro_id'
        )

      ->join('m_pegawai_pro', function($join) use ($tgl1, $tgl2) {
          $join->on('m_pegawai_pro.c_id', '=', 'd_hasil_garapan.d_hg_pid')
              ->where('d_hg_tgl','>=',$tgl1)
              ->where('d_hg_tgl','<=',$tgl2);
        })
      
      ->join('abs_pegawai_pro', function($join) use ($tgl1, $tgl2) {
          $join->on('abs_pegawai_pro.app_pp', '=', 'm_pegawai_pro.c_id')
              ->where('app_tanggal','>=',$tgl1)
              ->where('app_tanggal','<=',$tgl2);
        })

      ->join('m_jabatan_pro','m_jabatan_pro.c_id','=','c_jabatan_pro_id')
      ->where('c_rumah_produksi',$rumah)
      ->where('c_jabatan_pro_id',$jabatan)
      ->groupBy('m_pegawai_pro.c_id')
      ->get();

      // dd($garapan);
      return DataTables::of($garapan)
      ->addIndexColumn()
      ->editColumn('kode', function ($data) {
          return "$data->c_code" ;

      })

      ->editColumn('pegawai', function ($data) {
          return  "$data->c_nik - $data->c_nama";

      })

      ->editColumn('gaji', function ($data)use($tgl1, $tgl2) {
          return '<div class="text-center">
                      <button class="btn btn-sm btn-success"
                              title="Detail"
                              type="button"
                              data-toggle="modal"
                              data-target="#myModalView"
                              onclick=detailGaji('.$data->id_p.')>
                              <i class="fa fa-eye"></i>
                      </button>
                  </div>';

      })

      ->rawColumns(['kode',
                    'pegawai',
                    'gaji'
                  ])
      ->make(true);
    }

    public function lihatGaji($id, $tgl1, $tgl2){
      $d = substr($tgl1,0,2);
      $y = substr($tgl1, -4);
      $m = substr($tgl1, -7,-5);
        $tgl1 = $y.'-'.$m.'-'.$d;

      $d = substr($tgl2,0,2);
      $y = substr($tgl2, -4);
      $m = substr($tgl2, -7,-5);
        $tgl2 = $y.'-'.$m.'-'.$d;
      //hitung garapan
      $garapan = d_hasil_garapan::select(
        'c_nama',
        'c_jabatan_pro',
        'm_gaji_pro.c_id as item_id',
        'nm_gaji',
        'd_hg_pid',
        'c_gaji',
        'c_lembur',
        DB::raw("SUM(d_hg_gaji) as dataGaji"),
        DB::raw("SUM(d_hg_lembur) as dataLembur")
        )
        ->rightJoin('m_gaji_pro', function($join) use ($id, $tgl1, $tgl2) {
            $join->on('m_gaji_pro.c_id', '=', 'd_hasil_garapan.d_hg_cid')
                ->where('d_hg_pid',$id)
                ->where('d_hg_tgl','>=',$tgl1)
                ->where('d_hg_tgl','<=',$tgl2);
        })
        ->join('m_pegawai_pro','m_pegawai_pro.c_id','=','d_hg_pid')
        ->join('m_jabatan_pro','m_jabatan_pro.c_id','=','c_jabatan_pro_id')
        ->groupBy('m_gaji_pro.c_id')
        ->get();
        // dd($garapan);
       
      //selesai hitung garapn
      $cariAbs = abs_pegawai_pro::select(
         'app_pp',
         'app_tanggal',
         'app_jam_kerja',
         'app_absent',
         'app_lembur',
         'm_jabatan_pro.c_id as j_id',
         'c_jabatan_pro')
        ->join('m_pegawai_pro','m_pegawai_pro.c_id','=','app_pp')
        ->join('m_jabatan_pro','m_jabatan_pro.c_id','=','m_pegawai_pro.c_jabatan_pro_id')
        ->whereBetween('app_tanggal',[$tgl1, $tgl2])
        ->where('m_pegawai_pro.c_id',$id)
        ->get();

      $abs = abs_pegawai_pro::select(
         'app_pp',
         'app_tanggal',
         'app_jam_kerja',
         'app_absent',
         'app_lembur',
         'm_jabatan_pro.c_id as j_id',
         'c_jabatan_pro')
        ->join('m_pegawai_pro','m_pegawai_pro.c_id','=','app_pp')
        ->join('m_jabatan_pro','m_jabatan_pro.c_id','=','m_pegawai_pro.c_jabatan_pro_id')
        ->where('m_pegawai_pro.c_id',$id)
        ->first();
 
      $gaji = m_gaji_pro::select('c_id','c_status','c_gaji','c_lembur','c_gaji_jabatan')
        ->get();

      // dd($gaji);
      for ($i=0; $i <count($gaji) ; $i++) {     
        $cari[$i] = array_search($abs->j_id, explode(",", $gaji[$i]->c_gaji_jabatan));

      }

      for ($i=0; $i <count($cari) ; $i++) { 
        if ($cari[$i] !== false) {
          $a[] = $gaji[$i]->c_id;
        }      
      }
      // dd($a);
      for ($i=0; $i <count($a) ; $i++) { 
         $GR[$i] = DB::table('m_gaji_pro')
            ->select('c_id','c_status','c_gaji','c_lembur','c_gaji_jabatan')
            ->where('c_id',$a[$i])
            ->where('c_status','GR')
            ->get();
      }

      for ($i=0; $i <count($a) ; $i++) { 
         $HR[$i] = DB::table('m_gaji_pro')
            ->select('c_id','c_status','c_gaji','c_lembur','c_gaji_jabatan')
            ->where('c_id',$a[$i])
            ->where('c_status','HR')
            ->get();
      }


      foreach ($cariAbs as $val) {
          if ($val->app_absent != null) 
            { $alpha[] = $val->app_absent; } 
          else 
            { $hadir[] = $val->app_absent; }
          if ($val->app_lembur != null) 
            { $lembur[] = $val->app_lembur; } 
          else 
            { $lembur[] = "00:00:00"; }
          if ($val->app_scan_masuk != null) 
            { $dt_scanmasuk[] = $val->app_tanggal.' '.$val->app_scan_masuk; } 
          else 
            { $dt_scanmasuk[] = null; }
          if ($val->app_jam_masuk != null) 
            { $dt_jammasuk[] = $val->app_tanggal.' '.$val->app_jam_masuk; } 
          else 
            { $dt_jammasuk[] = null; }
      }


      $jam_lembur = 0;
        for ($i=0; $i < count($lembur); $i++) {
            $d_lembur = explode(':', $lembur[$i]);
            if ($d_lembur[1] <= '30') { 
                $jam_lembur += (int)$d_lembur[0];
            }else{
                $jam_lembur += ((int)$d_lembur[0] + 1);
            }
        }

        $jmlHadir = 0;
        $uangHadir = 0;
        $jmlLembur = 0;
        $uangLembur = 0;
        $gajiHR = 0;
        $gajiLembur = 0;
        $totalHRL = 0;

       // dd($jmlHadir);
       for ($i=0; $i <count($HR) ; $i++) { 
         if (count($HR[$i])>0) {
            $jmlHadir = count($hadir);
            $uangHadir = $HR[$i][0]->c_gaji;
            $jmlLembur = $jam_lembur;
            $uangLembur = $HR[$i][0]->c_lembur;
            $gajiHR = count($hadir) * $HR[$i][0]->c_gaji;
            $gajiLembur = $jam_lembur * $HR[$i][0]->c_lembur;
            $totalHRL = $gajiHR + $gajiLembur;
         }
       
       }

      $d_gaji = 0;
      $d_lembur = 0;
      foreach ($garapan as $hasil) {
        $d_gaji += ($hasil->dataGaji + $hasil->dataLembur) * $hasil->c_gaji;
        $d_lembur += $hasil->dataLembur * $hasil->c_lembur;
      }
      $total = $d_gaji + $d_lembur;

      return view('hrd.payroll-produksi.view-payroll',compact('garapan','total','jmlHadir','uangHadir','jmlLembur','uangLembur','gajiHR','gajiLembur','totalHRL'));
    }
}
