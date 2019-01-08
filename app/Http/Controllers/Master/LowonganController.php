<?php

namespace App\Http\Controllers\Master;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use DataTables;
use URL;

// use App\mmember

class LowonganController extends Controller
{
    public function index()
    {
        return view('master.datalowongan.index');
    }

    public function tambah_data()
    {
        return view('master.datalowongan.tambah');
    }

    public function simpan_data(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {   
        	$id = DB::table('d_lowongan')->select('l_id')->max('l_id');
        	if ($id == 0 || $id == '') { $id  = 1; } else { $id++; }

            $akronim = DB::table('m_divisi')->select('c_divisi_akronim')->where('c_id', $request->divisi)->first();
            $code = $this->kode_lowongan($akronim->c_divisi_akronim);
            
            DB::table('d_lowongan')
                ->insert([
                    'l_id'=>$id,
                    'l_code' => $code,
                    'l_divisi' => $request->divisi,
                    'l_subdivisi' => $request->level,
                    'l_jabatan' => $request->jabatan,
                    'l_created'=> Carbon::now('Asia/Jakarta')
                ]);

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Master Lowongan Berhasil Disimpan'
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

    public function kode_lowongan($akronim)
    {
        $kode = DB::select(DB::raw("SELECT MAX(RIGHT(l_code,3)) as kode_max from d_lowongan where l_code like '%$akronim%'"));
        $kd = "";

        if(count($kode)>0)
        {
            foreach($kode as $k)
            {
                $tmp = ((int)$k->kode_max)+1;
                $kd = sprintf("%03s", $tmp);
            }
        }
        else
        {
            $kd = "001";
        }

        return $code = 'LWG'.'/'.$akronim.'/'.$kd;
    } 

    public function get_datatable_index()
    {
        $data = DB::table('d_lowongan')->join('m_divisi', 'd_lowongan.l_divisi', '=', 'm_divisi.c_id')->join('m_sub_divisi', 'd_lowongan.l_subdivisi', '=', 'm_sub_divisi.c_id')->join('m_jabatan', 'd_lowongan.l_jabatan', '=', 'm_jabatan.c_id')->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('aksi', function ($data) 
        {  
            if ($data->l_isactive == "Y") 
            {
                return  '<button id="edit" 
                            onclick=edit("'.$data->l_id.'") 
                            class="btn btn-warning btn-sm" 
                            title="Edit">
                            <i class="glyphicon glyphicon-pencil"></i>
                        </button>'.'
                        <button id="delete" 
                            onclick=gantiStatus("'.$data->l_id.'","aktif") 
                            class="btn btn-primary btn-sm" 
                            title="Aktif">
                            <i class="fa fa-check-square" aria-hidden="true"></i>
                        </button>';
            }
            else
            {
                return  '<div class="text-center">'.
                            '<button id="delete" 
                                    onclick=gantiStatus("'.$data->l_id.'","nonaktif") 
                                    class="btn btn-danger btn-sm" title="Tidak Aktif">
                                    <i class="fa fa-minus-square" aria-hidden="true">
                            </button>'.
                        '</div>';
            }
        })
        ->addColumn('status', function ($data) {
            if ($data->l_isactive == 'Y') {
            	return '<span style="color:blue">Aktif</span>';
            }else{
            	return '<span style="color:red">Nonaktif</span>';
            }
        })
        ->rawColumns(['aksi','status'])
        ->make(true);
    }

    public function ubah_status(Request $request)
    {
        DB::beginTransaction();
        try 
        {   
            $tanggal = date("Y-m-d h:i:s");
            if ($request->statusBrg == 'aktif') {
                $active = 'N';
                $pesan = 'Data Lowongan berhasil Dinonaktifkan';
            }else{
                $active = 'Y';
                $pesan = 'Data Lowongan berhasil Diaktifkan';
            }
            
            DB::table('d_lowongan')
                ->where('l_id','=',$request->id)
                ->update([
                    'l_updated' => $tanggal,
                    'l_isactive' => $active
                ]);

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

    public function edit_data(Request $request)
    {
        $data = DB::table('d_lowongan')->join('m_divisi', 'd_lowongan.l_divisi', '=', 'm_divisi.c_id')->join('m_sub_divisi', 'd_lowongan.l_subdivisi', '=', 'm_sub_divisi.c_id')->join('m_jabatan', 'd_lowongan.l_jabatan', '=', 'm_jabatan.c_id')->where('l_id','=',$request->id)->first();
        return view('master/datalowongan/edit', compact('data'));
    }

    public function update_data(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {   
            DB::table('d_lowongan')
                ->where('l_id','=',$request->kode_old)
                ->update([
                    'l_subdivisi' => $request->level,
                    'l_jabatan' => $request->jabatan,
                    'l_updated' => Carbon::now('Asia/Jakarta')
                ]);

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Lowongan Berhasil Diupdate'
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

    public function lookup_divisi(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term)) 
        {
            $divisi = DB::table('m_divisi')->orderBy('c_divisi', 'ASC')->limit(10)->get();
            foreach ($divisi as $val) 
            {
                $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_divisi];
            }
            return Response::json($formatted_tags);
        }
        else
        {
            $divisi = DB::table('m_divisi')->where('c_divisi', 'LIKE', '%'.$term.'%')->orderBy('c_divisi', 'ASC')->limit(10)->get();
            foreach ($divisi as $val) 
            {
                $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_divisi];
            }

          return Response::json($formatted_tags);  
        }
    }

    public function lookup_level(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term)) 
        {
            $subdivisi = DB::table('m_sub_divisi')->orderBy('c_subdivisi', 'ASC')->limit(10)->get();
            foreach ($subdivisi as $val) 
            {
                $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_subdivisi];
            }
            return Response::json($formatted_tags);
        }
        else
        {
            $subdivisi = DB::table('m_sub_divisi')->where('c_subdivisi', 'LIKE', '%'.$term.'%')->orderBy('c_subdivisi', 'ASC')->limit(10)->get();
            foreach ($subdivisi as $val) 
            {
            $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_subdivisi];
            }

          return Response::json($formatted_tags);  
        }
    }

    public function lookup_jabatan(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term)) 
        {
            $jabatan = DB::table('m_jabatan')->where('c_divisi_id', '=', $request->divisi)->where('c_sub_divisi_id', '=', $request->level)->orderBy('c_posisi', 'ASC')->limit(10)->get();
            foreach ($jabatan as $val) 
            {
                $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_posisi];
            }
            return Response::json($formatted_tags);
        }
        else
        {
            $jabatan = DB::table('m_jabatan')->where('c_divisi_id', '=', $request->divisi)->where('c_sub_divisi_id', '=', $request->level)->where('c_posisi', 'LIKE', '%'.$term.'%')->orderBy('c_posisi', 'ASC')->limit(10)->get();
            foreach ($jabatan as $val) 
            {
                $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_posisi];
            }

          return Response::json($formatted_tags);  
        }
    }

    // =======================================================================================================================
}