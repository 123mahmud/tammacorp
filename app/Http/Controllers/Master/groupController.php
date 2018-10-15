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
                   'd.nama_akun as penjualan')
         ->leftjoin('d_akun as c', function($join) {
             $join->on('c.id_akun', '=', 'm_group.m_akun_persediaan')
               ->where('c.type_akun','DETAIL');
           })
         ->leftjoin('d_akun as d', function($join) {
             $join->on('d.id_akun', '=', 'm_group.m_akun_penjualan')
               ->where('d.type_akun','DETAIL');
           })
         ->get();

        // return $list;
        $data = collect($list);

        // return $data;

        return Datatables::of($list)

                ->addColumn('aksi', function ($data) {
                  return
                  '<div class="text-center">
                    <button id="edit" onclick="edit('.$data->m_gid.')"
                                      class="btn btn-warning btn-sm"
                                      title="Edit">
                                      <i class="glyphicon glyphicon-pencil"></i>
                    </button>
                    <button id="delete" onclick="hapus('.$data->m_gid.')"
                                      class="btn btn-danger btn-sm"
                                      title="Hapus">
                                      <i class="glyphicon glyphicon-trash"></i>
                    </button>
                  </div>';
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

        return view('/master/datagroup/tambah_group',compact('nota','item','penjualan'));
    }
    public function simpan_group(Request $request)
    {
        // dd($request->all());
        $id = DB::table('m_group')->max('m_gid');
        if ($id == null) {
          $id = 1;
        }else{
          $id +=1;
        }

        $code = m_group::select('m_gcode')->max('m_gcode')+1;

        DB::table('m_group')
                  ->insert([
                      'm_gid'=>$id,
                      'm_gcode'=>'0'. $request->id,
                      'm_gname'=>$request->nama,
                      'm_akun_persediaan'=>$request->akun,
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
                 'c.nama_akun as persediaan_nama',
                 'd.nama_akun as penjualan_nama')
        ->leftjoin('d_akun as c', function($join) {
            $join->on('c.id_akun', '=', 'm_group.m_akun_persediaan')
              ->where('c.type_akun','DETAIL');
          })
        ->leftjoin('d_akun as d', function($join) {
            $join->on('d.id_akun', '=', 'm_group.m_akun_penjualan')
              ->where('d.type_akun','DETAIL');
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

      json_encode($data);

      return view('master/datagroup/edit_group',compact('data','item','penjualan'));
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
                      'm_akun_penjualan'=>$request->penjualan,
                      'm_gupdate'=>$tanggal,
                    ]);
      return response()->json(['status'=>1]);
    }


}
