<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Model\Master\m_kpix;
use Response;
use DB;
use DataTables;
use Auth;

class KpiController extends Controller
{
    public function index()
    {
        //update deadline jika hari ini sudah melebihi deadline
        DB::statement("UPDATE m_kpix SET kpix_deadline = NULL WHERE kpix_deadline < DATE_FORMAT(CURRENT_DATE(), '%Y-%m-%d')");
        return view('master/datakpi/index');
    }

    public function tambahKpi()
    {
        return view('master/datakpi/tambah');
    }

    public function getDatatableKpi()
    {
        $data = m_kpix::join('m_pegawai_man', 'm_kpix.kpix_p_id', '=', 'm_pegawai_man.c_id')
                    ->join('m_divisi', 'm_kpix.kpix_div_id', '=', 'm_divisi.c_id')
                    ->join('m_jabatan', 'm_kpix.kpix_jabatan_id', '=', 'm_jabatan.c_id')
                    ->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('deadline', function ($data) 
        {  
           if ($data->kpix_deadline != null || $data->kpix_deadline != '') {
                return '<div style="text-align:center;">' .$data->kpix_deadline. '</div>';
           }else{
                return '<div style="text-align:center;"> - </div>';
           }
        })
        ->addColumn('action', function ($data) 
        {  
            return  '<button id="edit" onclick=edit("'.$data->kpix_id.'") class="btn btn-warning btn-sm" title="Edit">
                        <i class="fa fa-edit"></i>
                    </button>'.'
                    <button id="delete" onclick=hapus("'.$data->kpix_id.'") class="btn btn-danger btn-sm" title="Hapus">
                        <i class="fa fa-times-circle"></i>
                    </button>';
        })
        ->rawColumns(['action','deadline'])
        ->make(true);
    }

    public function simpanKpi(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {   
            $id = m_kpix::select('kpix_id')->max('kpix_id');
            if ($id == 0 || $id == '') { $id  = 1; } else { $id++; }

            $kpix = new m_kpix();
            $kpix->kpix_id = $id;
            $kpix->kpix_name = $request->indikator;
            $kpix->kpix_bobot = $request->bobot;
            $kpix->kpix_deadline = date('Y-m-d',strtotime($request->deadline));
            $kpix->kpix_target = $request->targetkpi;
            $kpix->kpix_p_id = $request->pegawai;
            $kpix->kpix_div_id = $request->divisi;
            $kpix->kpix_jabatan_id = $request->jabatan;
            $kpix->kpix_created = Carbon::now('Asia/Jakarta');
            $kpix->save();

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Master KPI Berhasil Disimpan'
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

    public function editKpi(Request $request)
    {
        $data = m_kpix::join('m_pegawai_man', 'm_kpix.kpix_p_id', '=', 'm_pegawai_man.c_id')
                    ->join('m_divisi', 'm_kpix.kpix_div_id', '=', 'm_divisi.c_id')
                    ->join('m_jabatan', 'm_kpix.kpix_jabatan_id', '=', 'm_jabatan.c_id')
                    ->where('m_kpix.kpix_id', '=', $request->id)
                    ->first();
        return view('master/datakpi/edit', compact('data'));
    }

    public function updateKpi(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {   
            $kpix = m_kpix::find($request->kode_old);
            $kpix->kpix_name = $request->e_nama;
            $kpix->kpix_bobot = $request->e_bobot;
            $kpix->kpix_deadline = date('Y-m-d',strtotime($request->e_deadline));
            $kpix->kpix_target = $request->e_target;
            $kpix->kpix_p_id = $request->e_pegawai;
            $kpix->kpix_div_id = $request->e_divisi;
            $kpix->kpix_updated = Carbon::now('Asia/Jakarta');
            $kpix->save();

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Master KPI Berhasil Diupdate'
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

    public function deleteKpi(Request $request)
    {
        DB::beginTransaction();
        try 
        {   
            $kpix = m_kpix::find($request->id);
            $kpix->delete();

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Master KPI Berhasil Dihapus'
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

    function generateRandomString($length = 5) 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    // ==================================================================================================================
}
