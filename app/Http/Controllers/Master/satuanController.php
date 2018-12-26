<?php

namespace App\Http\Controllers\master;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use DataTables;
use URL;

// use App\mmember

class satuanController extends Controller
{
    public function satuan()
    { 
        $data = DB::table('m_satuan')->get();
        return view('/master/datasatuan/satuan',compact('data'));
    }
    public function datatable_satuan()
    {
        $list = DB::select("SELECT * from m_satuan");
        // return $list;
        $data = collect($list);
        
        // return $data;

        return Datatables::of($data)
                
          ->addColumn('aksi', function ($data) {
            if ($data->m_isactive == 'TRUE') 
            {
              return  '<div class="text-center">'.
                          '<button id="edit" 
                            onclick="edit('.$data->m_sid.')" 
                            class="btn btn-warning btn-sm" 
                            title="Edit">
                            <i class="glyphicon glyphicon-pencil"></i>
                          </button>'.'
                          <button id="status'.$data->m_sid.'" 
                              onclick="ubahStatus('.$data->m_sid.')" 
                              class="btn btn-primary btn-sm" 
                              title="Aktif">
                              <i class="fa fa-check-square" aria-hidden="true"></i>
                          </button>'.
                      '</div>';                                                                     
            }
            else
            {
              return '<div class="text-center">'.
                        '<button id="status'.$data->m_sid.'" 
                            onclick="ubahStatus('.$data->m_sid.')" 
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
    public function tambah_satuan(Request $request)
    {
        $kode = DB::table('m_satuan')->max('m_sid');
        if ($kode == null) {
          $kode = 1;
        }else{
          $kode +=1;
        }
        $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);

        $nota = 'ST-'.$kode;

        return view('/master/datasatuan/tambah_satuan',compact('nota'));
    }
    public function simpan_satuan(Request $request)
    {
        $kode = DB::table('m_satuan')->max('m_sid');
        if ($kode == null) {
          $kode = 1;
        }else{
          $kode +=1;
        }
        $kode = DB::table('m_satuan')
                  ->insert([
                      'm_sid'=>$kode,
                      'm_scode'=>$request->id,
                      'm_sname'=>$request->nama,
                    ]);
    }
    public function hapus_satuan(Request $request)
    {
      $data = DB::table('m_satuan')->where('m_sid','=',$request->id)->delete();
      return response()->json(['status'=>'sukses']);
    }
    public function edit_satuan(Request $request)
    {
      $data = DB::table('m_satuan')->where('m_sid','=',$request->id)->first();
      json_encode($data);
      return view('master/datasatuan/edit_satuan',compact('data'));
    }
    public function update_satuan(Request $request)
    {
      $kode = DB::table('m_satuan')
                  ->where('m_scode','=',$request->id)
                  ->update([
                      'm_sname'=>$request->nama,
                    ]);
      return response()->json(['status'=>1]);
    }


}



