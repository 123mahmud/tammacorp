<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use DataTables;
use App\Jabatan;
use App\m_jabatan_pro;

class JabatanController extends Controller
{
    public function index(){
       return view('master/datajabatan/datajabatan');
    }
    public function jabatanData(){
        $list = DB::table('m_jabatan')
                ->join('m_divisi', 'm_divisi.c_id', '=', 'm_jabatan.c_divisi_id')
                ->select('m_jabatan.*', 'm_divisi.c_divisi')
                ->get();
        $data = collect($list);
        return Datatables::of($data)           
                ->addColumn('action', function ($data) {
                         return  '<button id="edit" onclick="edit('.$data->c_id.')" class="btn btn-warning btn-sm" title="Edit"><i class="glyphicon glyphicon-pencil"></i></button>'.'
                                <button id="delete" onclick="hapus('.$data->c_id.')" class="btn btn-danger btn-sm" title="Hapus"><i class="glyphicon glyphicon-trash"></i></button>';
                })
                ->addColumn('kode', function ($data) {
                    return  str_pad($data->c_id, 3, '0', STR_PAD_LEFT);
                })
                ->addColumn('none', function ($data) {
                    return '-';
                })
                ->rawColumns(['action','view','posisi'])
                ->make(true);
    }
    public function getPegawai(Request $request, $id){
        $maxid = DB::Table('m_pegawai')->select('c_id_by_production')->where('c_jabatan_id', $id)->max('c_id_by_production');
        // untuk +1 nilai yang ada,, jika kosong maka maxid = 1 , 
        if ($maxid <= 0 || $maxid <= '') {
            $maxid  = 1;
        }else{
            $maxid += 1;
        }
        // $kd_produksi = Request::segment(4);
        $kd_jabatan = $request->segment(5);
        if($kd_jabatan == "7"){
            $kode = "4"."-".str_pad($id, 2, '0', STR_PAD_LEFT).$pro."-".str_pad($maxid, 3, '0', STR_PAD_LEFT);
        }else{
            $kode = "4"."-".str_pad($id, 2, '0', STR_PAD_LEFT)."-".str_pad($maxid, 3, '0', STR_PAD_LEFT);
        }
        // dd($kode);
        $shift = DB::table('m_shift')->get();
        return view('master/datajabatan/pegawai', ['kode' => $kode, 'shift' => $shift]);
    }
    public function pegawaiData($id){
        $list = DB::table('m_pegawai')
                ->select('m_pegawai.*', 'm_jabatan.c_posisi')
                ->join('m_jabatan', 'm_pegawai.c_jabatan_id', '=', 'm_jabatan.c_id')
                ->where('c_jabatan_id', $id)
                ->get();
        $data = collect($list);
        return Datatables::of($data)           
                ->addColumn('action', function ($data) {
                         return  '<button id="edit" onclick="edit('.$data->c_id.')" class="btn btn-warning btn-sm" title="Edit"><i class="glyphicon glyphicon-pencil"></i></button>'.'
                                        <button id="delete" onclick="hapus('.$data->c_id.')" class="btn btn-danger btn-sm" title="Hapus"><i class="glyphicon glyphicon-trash"></i></button>';
                })
                ->addColumn('kode', function ($data) {
                    return  str_pad($data->c_id, 3, '0', STR_PAD_LEFT);
                })
                ->addColumn('none', function ($data) {
                    return '-';
                })
                ->rawColumns(['action','confirmed'])
                ->make(true);
    }
    public function tambahJabatan(Request $request){
        $divisi = DB::table('m_divisi')->get();
        $subdivisi = DB::table('m_sub_divisi')->get();
        return view('master/datajabatan/tambah_jabatan', ['divisi' => $divisi, 'subdivisi' => $subdivisi]);
    }
    public function simpanJabatan(Request $request){
        $input = $request->all();
        // dd($input);
        $data = Jabatan::create($input);
        return redirect('master/datajabatan');
    }
    public function editJabatan($id){
        $jabatan = DB::table('m_jabatan')->where('c_id', $id)->first();
        $divisi = DB::table('m_divisi')->get();
        $subdivisi = DB::table('m_sub_divisi')->get();
        // dd($jabatan);
        return view('master/datajabatan/edit_jabatan', ['jabatan' => $jabatan, 'divisi' => $divisi, 'subdivisi' => $subdivisi]);
    }
    public function updateJabatan(Request $request, $id){
        $input = $request->except('_token', '_method');
        $data = Jabatan::where('c_id', $id)->update($input);

        return redirect('master/datajabatan');
    }
    public function deleteJabatan($id){
        $data = DB::table('m_jabatan')->where('c_id', $id)->delete();

        return redirect('master/datajabatan');
    }

    public function tablePro(){
        $produksi = m_jabatan_pro::all();
        // dd($produksi);
        return Datatables::of($produksi) 
        ->addIndexColumn()
        ->addColumn('action', function ($data) {
             return '<button id="edit" 
                        onclick="editJPro('.$data->c_id.')" 
                        class="btn btn-warning  btn-sm" 
                        title="Edit"><i class="glyphicon glyphicon-pencil"></i>
                    </button>'.'
                    <button id="delete" 
                        onclick="hapusJPro('.$data->c_id.')" 
                        class="btn btn-danger btn-sm" 
                        title="Hapus">
                        <i class="glyphicon glyphicon-trash"></i>
                    </button>';
        })

        ->rawColumns(['action'])
        ->make(true);
    }

    public function tambahJabatanPro(){

        return view('master.datajabatan.tambah-jabatanpro');
    }

    public function simpanJabatanPro(Request $req){
        //dd($req->all());
        DB::beginTransaction();
        try {
        $id = m_jabatan_pro::select('c_id')->max('c_id')+1;
        m_jabatan_pro::insert([
            'c_id' => $id,
            'c_jabatan_pro' => $req->c_jabatan_pro,
            'created_at' => Carbon::now()
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

    public function hapusJabatanPro($id){
        DB::beginTransaction();
        try {
            m_jabatan_pro::where('c_id',$id)->delete();
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
