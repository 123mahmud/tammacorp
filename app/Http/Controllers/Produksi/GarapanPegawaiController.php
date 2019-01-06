<?php

namespace App\Http\Controllers\Produksi;

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
use DataTables;
use URL;
use Auth;

class GarapanPegawaiController extends Controller
{
    public function index(){
      $produksi = m_produksi::all();
      $staff['nama'] = Auth::user()->m_name;
      $staff['id'] = Auth::User()->m_id;
      $m_gaji_pro = m_gaji_pro::select('c_id',
        'nm_gaji')
        ->where('c_status','GR')
        ->get();
      $c_jabatan_pro = m_jabatan_pro::all();
      return view('produksi.Garapan.index',compact('produksi','staff','m_gaji_pro','c_jabatan_pro'));
    }

    public function tableGarapan($rumah, $item, $jabatan, $tgl){
      // dd($jabatan);
      $d = substr($tgl,0,2);
      $y = substr($tgl, -4);
      $m = substr($tgl, -7,-5);
        $tgl = $y.'-'.$m.'-'.$d;

      $garapan = d_hasil_garapan::select('m_pegawai_pro.c_id as c_idpro',
        'c_nik',
        'c_nama',
        'c_jabatan_pro_id',
        'c_rumah_produksi',
        'd_hg_cid',
        'd_hg_gaji',
        'd_hg_lembur')
      ->rightJoin('m_pegawai_pro', function($join) use ($tgl, $item) {
          $join->on('m_pegawai_pro.c_id', '=', 'd_hasil_garapan.d_hg_pid')
              ->where('d_hg_tgl',$tgl)
              ->where('d_hg_cid',$item);
        })
      ->join('m_jabatan_pro','m_jabatan_pro.c_id','=','c_jabatan_pro_id')
      ->where('cp_isactive','TRUE')
      ->where('c_jabatan_pro_id',$jabatan)
      ->where('c_rumah_produksi',$rumah)
      ->get();
      // dd($garapan);
      return DataTables::of($garapan)
      ->addIndexColumn()
      ->editColumn('pegawai', function ($data) {
          return  "$data->c_nik - $data->c_nama
                    <input id='tanggal1'
                      class='form-control input-sm'
                      name='c_id[]'
                      placeholder='Regular'
                      value=".$data->c_idpro."
                      type='hidden'>";

      })

      ->editColumn('item', function ($data) {
        if ($data->d_hg_gaji == null || $data->d_hg_lembur == null ) {
          return '<div class="input-group">
                    <div class="input-daterange input-group">
                      <input id="tanggal1"
                        class="form-control input-sm text-right"
                        name="d_hg_gaji[]"
                        placeholder="Regular"
                        type="number">
                      <span class="input-group-addon">|</span>
                      <input id="tanggal2"
                        class="input-sm form-control text-right"
                        name="d_hg_lembur[]"
                        type="number"
                        placeholder="Lembur"
                        value="">
                    </div>
                  </div>' ;
        }else{
          return '<div class="input-group">
                    <div class="input-daterange input-group">
                      <input id="tanggal1"
                        class="form-control input-sm"
                        name="d_hg_gaji[]"
                        placeholder="Regular"
                        type="text"
                        value="'.$data->d_hg_gaji.'">
                      <span class="input-group-addon">|</span>
                      <input id="tanggal2"
                        class="input-sm form-control"
                        name="d_hg_lembur[]"
                        type="text"
                        placeholder="Lembur"
                        value="'.$data->d_hg_lembur.'">
                    </div>
                  </div>' ;
        }

      })

      ->rawColumns(['pegawai',
                    'item',
                  ])
      ->make(true);

    }

    public function saveGarapan(Request $request){
      // dd($request->all());
      DB::beginTransaction();
        try {
      $tgl = $request->d_hg_tgl;
      $d = substr($tgl,0,2);
      $y = substr($tgl, -4);
      $m = substr($tgl, -7,-5);
        $tgl = $y.'-'.$m.'-'.$d;

      for ($i=0; $i < count($request->c_id) ; $i++) {
        $id =  d_hasil_garapan::select('d_hg_id')->max('d_hg_id')+1;
        $cek = d_hasil_garapan::where('d_hg_pid',$request->c_id[$i])
          ->where('d_hg_cid',$request->d_hg_cid)
          ->where('d_hg_tgl',$tgl)
          ->first();
        if ($cek == null) {
          $hasil = new d_hasil_garapan();
          $hasil->d_hg_id = $id;
          $hasil->d_hg_tgl = $tgl;
          $hasil->d_hg_pid = $request->c_id[$i];
          $hasil->d_hg_cid = $request->d_hg_cid;
          if ($request->d_hg_gaji[$i] == null) {
            $hasil->d_hg_gaji = 0;
          }else{
            $hasil->d_hg_gaji = $request->d_hg_gaji[$i];
          }
          if ($request->d_hg_lembur[$i] == null) {
            $hasil->d_hg_lembur = 0;
          }else{
            $hasil->d_hg_lembur = $request->d_hg_lembur[$i];
          }

          $hasil->d_hg_created = Carbon::now();
          $hasil->save();
        }else {
          if ($request->d_hg_gaji[$i] == null) {
            $cek->d_hg_gaji = 0;
          }else{
            $cek->d_hg_gaji = $request->d_hg_gaji[$i];
          }
          if ($request->d_hg_lembur[$i] == null) {
            $cek->d_hg_lembur = 0;
          }else{
            $cek->d_hg_lembur = $request->d_hg_lembur[$i];
          }
          $cek->d_hg_updated = Carbon::now();
          $cek->update();
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

  public function tableDataGarapan($rumah, $item, $jabatan, $tgl1, $tgl2){
    $d = substr($tgl1,0,2);
    $y = substr($tgl1, -4);
    $m = substr($tgl1, -7,-5);
      $tgl1 = $y.'-'.$m.'-'.$d;

    $d = substr($tgl2,0,2);
    $y = substr($tgl2, -4);
    $m = substr($tgl2, -7,-5);
      $tgl2 = $y.'-'.$m.'-'.$d;

    $garapan = d_hasil_garapan::select(
      'm_jabatan_pro.c_id as id_p',
      'c_nik',
      'c_nama',
      'c_nik',
      'c_nama',
      // 'd_hg_gaji',
      // 'd_hg_lembur',
      DB::raw("SUM(d_hg_gaji) as dataGaji"),
      DB::raw("SUM(d_hg_lembur) as dataLembur")
      )

    ->leftJoin('m_pegawai_pro', function($join) use ($item, $tgl1, $tgl2) {
        $join->on('m_pegawai_pro.c_id', '=', 'd_hasil_garapan.d_hg_pid')
            ->where('d_hg_tgl','>=',$tgl1)
            ->where('d_hg_tgl','<=',$tgl2)
            ->where('d_hg_cid',$item);
      })

    ->leftJoin('m_jabatan_pro','m_jabatan_pro.c_id','=','c_jabatan_pro_id')
    ->where('cp_isactive','TRUE')
    ->where('c_jabatan_pro_id',$jabatan)
    ->where('c_rumah_produksi',$rumah)
    ->groupBy('m_pegawai_pro.c_id')
    ->get();
    // dd($garapan);
    return DataTables::of($garapan)
    ->addIndexColumn()
    ->editColumn('pegawai', function ($data) {
        return  "$data->c_nik - $data->c_nama";

    })

    ->editColumn('item', function ($data) {
        return '<div class="input-group">
                  <div class="input-daterange input-group">
                    <input id="tanggal1"
                      class="form-control input-sm"
                      name="d_hg_jumbo_r[]"
                      placeholder="Regular"
                      type="text"
                      readonly
                      value="'.$data->dataGaji.'">
                    <span class="input-group-addon">|</span>
                    <input id="tanggal2"
                      class="input-sm form-control"
                      name="d_hg_jumbo_l[]"
                      type="text"
                      readonly
                      placeholder="Lembur"
                      value="'.$data->dataLembur.'">
                  </div>
                </div>' ;

    })

    ->rawColumns(['pegawai',
                  'item'
                ])
    ->make(true);
  }
}
