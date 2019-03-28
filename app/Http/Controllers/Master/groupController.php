<?php

namespace App\Http\Controllers\master;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\m_group;
use DataTables;
use URL;

// use App\mmember

class groupController extends Controller
{
    public function group()
    {
        $data = DB::table('m_group')->get();
        return view('/master/datagroup/group',compact('data'));
    }
    public function datatable_group()
    {
        $list = DB::table('m_group')
          ->select('m_gid',
                   'm_gcode',
                   'm_gname',
                   'c.nama_akun as persediaan',
                   'd.nama_akun as penjualan',
                   'e.nama_akun as beban',
                   'm_isactive')
         ->leftjoin('d_akun as c', function($join) {
             $join->on('c.id_akun', '=', 'm_group.m_akun_persediaan')
               ->where('c.type_akun','DETAIL');
           })
         ->leftjoin('d_akun as d', function($join) {
             $join->on('d.id_akun', '=', 'm_group.m_akun_penjualan')
               ->where('d.type_akun','DETAIL');
           })
         ->leftjoin('d_akun as e', function($join) {
             $join->on('e.id_akun', '=', 'm_group.m_akun_beban')
               ->where('e.type_akun','DETAIL');
           })
         ->get();

        // return json_encode($list);
        $data = collect($list);

        // return $data;

        return Datatables::of($list)

                ->addColumn('aksi', function ($data) {
                  if ($data->m_isactive == 'TRUE') 
                  {
                    return  '<div class="text-center">
                              <button id="edit" 
                                      onclick="edit('.$data->m_gid.')"
                                      class="btn btn-warning btn-sm"
                                      title="Edit">
                                      <i class="glyphicon glyphicon-pencil"></i>
                              </button>
                              <button id="status'.$data->m_gid.'" 
                                      onclick="ubahStatus('.$data->m_gid.')" 
                                      class="btn btn-primary btn-sm" 
                                      title="Aktif">
                                      <i class="fa fa-check-square" aria-hidden="true"></i>
                              </button>
                          </div>';
                  }
                  else
                  {
                    return  '<div class="text-center">'.
                                '<button id="status'.$data->m_gid.'" 
                                    onclick="ubahStatus('.$data->m_gid.')" 
                                    class="btn btn-danger btn-sm" 
                                    title="Tidak Aktif">
                                    <i class="fa fa-minus-square" aria-hidden="true"></i>
                                </button>'.
                            '</div>';
                  }
                  
                })
                ->addColumn('none', function ($data) {
                    return '-';
                })
                ->rawColumns(['aksi','confirmed'])
                ->make(true);
    }
    public function tambah_group(Request $request)
    {
        $kode = DB::table('m_group')->max('m_gid');
        if ($kode == null) {
          $kode = 1;
        }else{
          $kode +=1;
        }
        $tanggal = date("ym");

        $kode = str_pad($kode, 3, '0', STR_PAD_LEFT);

        $nota = $kode;

        $item = DB::table('d_akun')
          ->select('id_akun',
                  'nama_akun')
          ->where('type_akun','DETAIL')
          ->where(DB::raw('substring(id_akun, 1, 3)'), '120')
          ->orWhere('type_akun','DETAIL')
          ->where(DB::raw('substring(id_akun, 1, 3)'), '121')
          ->get();

        $penjualan = DB::table('d_akun')
          ->select('id_akun',
                  'nama_akun')
          ->where('type_akun','DETAIL')
          ->where(DB::raw('substring(id_akun, 1, 3)'), '500')
          ->get();

        $beban = DB::table('d_akun')
          ->select('id_akun',
                  'nama_akun')
          ->where('type_akun','DETAIL')
          ->where(DB::raw('substring(id_akun, 1, 3)'), '550')
          ->orWhere('type_akun','DETAIL')
          ->where(DB::raw('substring(id_akun, 1, 3)'), '551')
          ->get();

        return view('/master/datagroup/tambah_group',compact('nota','item','penjualan', 'beban'));
    }
    public function simpan_group(Request $request)
    {
        // dd($request->all());
        $id = DB::table('m_group')->max('m_gid')+1;
        if ($id == null) {
          $id = 1;
        }else{
          $id +=1;
        }

        $code = m_group::select('m_gcode')->max('m_gcode')+1;

        DB::table('m_group')
                  ->insert([
                      'm_gid'=>$id,
                      'm_gcode'=>'0'. $code,
                      'm_gname'=>$request->nama,
                      'm_akun_persediaan'=>$request->akun,
                      'm_akun_beban'=>$request->akun_beban,
                      'm_akun_penjualan'=>$request->akun_penjualan,
                      'm_gcreate'=>Carbon::now(),
                    ]);
    }
    public function hapus_group($id)
    {
      $data = DB::table('m_group')->where('m_gid',$id)->delete();
      return response()->json(['status'=>1]);
    }
    public function edit_group($id)
    {
      // dd($request->all());
      $data = DB::table('m_group')
        ->select('m_gid',
                 'm_gname',
                 'm_gcode',
                 'm_akun_persediaan',
                 'c.id_akun as persediaan',
                 'd.id_akun as penjualan',
                 'e.id_akun as beban',
                 'c.nama_akun as persediaan_nama',
                 'd.nama_akun as penjualan_nama',
                 'e.nama_akun as beban_nama')
        ->leftjoin('d_akun as c', function($join) {
            $join->on('c.id_akun', '=', 'm_group.g_akun_persediaan')
              ->where('c.type_akun','DETAIL');
          })
        ->leftjoin('d_akun as d', function($join) {
            $join->on('d.id_akun', '=', 'm_group.g_akun_penjualan')
              ->where('d.type_akun','DETAIL');
          })
        ->leftjoin('d_akun as e', function($join) {
            $join->on('e.id_akun', '=', 'm_group.g_akun_beban')
              ->where('e.type_akun','DETAIL');
          })
        ->where('m_gid','=',$id)
        ->first();

      $item = DB::table('d_akun')
        ->select('id_akun',
                'nama_akun')
        ->where('type_akun','DETAIL')
        ->where(DB::raw('substring(id_akun, 1, 3)'), '120')
        ->orWhere('type_akun','DETAIL')
        ->where(DB::raw('substring(id_akun, 1, 3)'), '121')
        ->get();

      $penjualan = DB::table('d_akun')
          ->select('id_akun',
                  'nama_akun')
          ->where('type_akun','DETAIL')
          ->where(DB::raw('substring(id_akun, 1, 3)'), '500')
          ->get();

      $beban = DB::table('d_akun')
          ->select('id_akun',
                  'nama_akun')
          ->where('type_akun','DETAIL')
          ->where(DB::raw('substring(id_akun, 1, 3)'), '550')
          ->orWhere('type_akun','DETAIL')
          ->where(DB::raw('substring(id_akun, 1, 3)'), '551')
          ->get();

      json_encode($data);

      return view('master/datagroup/edit_group',compact('data','item','penjualan', 'beban'));
    }
    public function update_group(Request $request)
    {
      // dd($request->all());
      $tanggal = date("Y-m-d h:i:s");

      $kode = DB::table('m_group')
                  ->where('m_gid','=',$request->id)
                  ->update([
                      'm_gname'=>$request->nama,
                      'm_akun_persediaan'=>$request->akun,
                      'm_akun_beban'=>$request->beban,
                      'm_akun_penjualan'=>$request->penjualan,
                      'm_gupdate'=>$tanggal,
                    ]);
      return response()->json(['status'=>1]);
    }

  public function ubahStatus(Request $request)
  {
    DB::beginTransaction();
        try {
    $cek = m_group::select('m_isactive')
      ->where('m_gid',$request->id)
      ->first();

    if ($cek->m_isactive == 'TRUE') 
    {
      m_group::where('m_gid',$request->id)
        ->update([
          'm_isactive' => 'FALSE'
        ]);
    }
    else
    {
      m_group::where('m_gid',$request->id)
        ->update([
          'm_isactive' => 'TRUE'
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
