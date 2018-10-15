<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Response;
use DB;
use DataTables;
use Auth;
use Carbon\Carbon;
class ManajemenSuratController extends Controller
{
    public function index(){
        return view('hrd/manajemensurat/index');
    }
    public function indexPhk(){
        $maxid = DB::Table('d_phk')->select('c_id')->max('c_id');
        // untuk +1 nilai yang ada,, jika kosong maka maxid = 1 , 
        if ($maxid <= 0 || $maxid <= '') {
            $maxid  = 1;
        }else{
            $maxid += 1;
        }
        $tahun = Carbon::now('Asia/Jakarta')->format('Y');
        $bulan = Carbon::now('Asia/Jakarta')->format('m');
        switch ($bulan) {
            case "01":
                $bulan = "I";
                break;
            case "02":
                $bulan =  "II";
                break;
            case "03":
                $bulan =  "III";
                break;
            case "04":
                $bulan =  "IV";
                break;
            case "05":
                $bulan =  "V";
                break;
            case "06":
                $bulan =  "vI";
                break;
            case "07":
                $bulan =  "VII";
                break;
            case "08":
                $bulan =  "VIII";
                break;
            case "09":
                $bulan =  "IX";
                break;
            case "10":
                $bulan =  "X";
                break;
            case "11":
                $bulan =  "XI";
                break;
            case "12":
                $bulan =  "XII";
                break;
            default:
                echo "masukan format bulan dengan benar";
        }
        $kode = str_pad($maxid, 3, '0', STR_PAD_LEFT)."/PHK/HRD/TRI/".$bulan."/".$tahun;
        // dd($kode);
        return view('hrd/manajemensurat/surat/form_phk/surat_phk',['kode' => $kode]);
    }
    public function phkData(){
        $list = DB::table('d_phk')->get();
        $data = collect($list);
        return Datatables::of($data)           
                ->addColumn('action', function ($data) {
                         return  '<button id="edit" onclick="edit('.$data->c_id.')" class="btn btn-warning btn-sm" title="Edit"><i class="glyphicon glyphicon-pencil"></i></button>'.'
                                        <a href="'.url('/hrd/manajemensurat/cetak-surat/'.$data->c_id).'" target="_blank" class="btn btn-info"><i class="glyphicon glyphicon-print"></i></a>'.'
                                        <button id="delete" onclick="hapus('.$data->c_id.')" class="btn btn-danger btn-sm" title="Hapus"><i class="glyphicon glyphicon-trash"></i></button>';
                })
                ->addColumn('kode', function ($data) {
                    return  str_pad($data->c_id, 3, '0', STR_PAD_LEFT);
                })
                ->addColumn('none', function ($data) {
                    return '-';
                })
                ->addColumn('pegawai', function ($data) {
                    if ($data->c_type_pegawai == "PRO") {return "Produksi"; }else{ return 'Manajemen'; }
                })
                ->addColumn('tanggal', function ($data) {
                    if ($data->c_tgl_phk == null) {
                        return '-';
                    } else {
                        return $data->c_tgl_phk ? with(new Carbon($data->c_tgl_phk))->format('d M Y') : '';
                    }    
                })
                ->addColumn('status', function ($data) {
                    if($data->c_jenis == 1){
                        $status = 'Pengurangan pegawai';
                    }else{
                        $status = 'Kesalahan berat';
                    }
                    return $status;
                })
                ->rawColumns(['action','confirmed'])
                ->make(true);
    }
    public function lookupPegawai(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term)) 
        {
            if ($request->typePeg == "MAN") {
                $pegawai = DB::table('m_pegawai_man')->orderBy('c_nama', 'ASC')->limit(10)->get();
                foreach ($pegawai as $val) {
                    $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_nama];
                }
            }else{
                $pegawai = DB::table('m_pegawai_pro')->orderBy('c_nama', 'ASC')->limit(10)->get();
                foreach ($pegawai as $val) {
                    $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_nama];
                }
            }
            return Response::json($formatted_tags);
        }
        else
        {  
            if ($request->typePeg == "MAN") {
                $pegawai = DB::table('m_pegawai_man')->where('c_nama', 'LIKE', '%'.$term.'%')->orderBy('c_nama', 'ASC')->limit(10)->get();
                foreach ($pegawai as $val) {
                    $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_nama];
                }
            }else{
                $pegawai = DB::table('m_pegawai_pro')->where('c_nama', 'LIKE', '%'.$term.'%')->orderBy('c_nama', 'ASC')->limit(10)->get();
                foreach ($pegawai as $val) {
                    $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_nama];
                }
            }
            return Response::json($formatted_tags);  
        }
    }
    public function simpanPhk(Request $request){
        $input = $request->except('_token');
        $input['c_tgl_phk'] = date('Y-m-d',strtotime($input['c_tgl_phk']));
        $input['created_at'] = Carbon::now('Asia/Jakarta');
        if($input['c_bulan_terakhir'] == null){
            $input['c_bulan_terakhir'] = "-"; 
        }

        DB::table('d_phk')->insert($input);

        return redirect('/hrd/manajemensurat/surat/form_phk/surat-phk');
    }
    public function editPhk($id){
        $phk = DB::table('d_phk')->where('c_id', $id)->first();

        return view('hrd/manajemensurat/surat/form_phk/edit_phk',['phk' => $phk]);
    }
    public function updatePhk(Request $request, $id){
        $input = $request->except('_token','_method');
        $input['updated_at'] = Carbon::now('Asia/Jakarta');

        $data = DB::table('d_phk')->where('c_id', $id)->update($input);
        return redirect('/hrd/manajemensurat/surat/form_phk/surat-phk');
    }
    public function deletePhk($id){
        $data = DB::table('d_phk')->where('c_id', $id)->delete();

        return redirect('/hrd/manajemensurat/surat/form_phk/surat-phk');
    }
    public function cetakSurat($id){
        $data = DB::table('d_phk')->where('c_id', $id)->first();
        if ($data->c_jenis == '1') {
            return view('hrd/manajemensurat/surat/form_phk/surat_phk_print', ['data' => $data]);
        }else{
            return view('hrd/manajemensurat/surat/form_phk/surat_phk_print_berat', ['data' => $data]);
        }

        return response()->json([
            'status' => 'sukses',
            'data' => $data,
            'divisi' => $divisi,
            'jabatan' => $jabatan,
            'pegawai' => $pegawai
        ]);
    }
    public function surat_phk_print(){
        return view('hrd/manajemensurat/surat/form_phk/surat_phk_print');
    }
    public function surat_phk_print_berat(){
        return view('hrd/manajemensurat/surat/form_phk/surat_phk_print_berat');
    }

    //==============================================END PHK====================================================================
        
    public function form_kenaikan_gaji(){
        return view('hrd/manajemensurat/surat/form_kenaikan_gaji/form_kenaikan_gaji');
    }
    public function form_kenaikan_gaji_print(){
        return view('hrd/manajemensurat/surat/form_kenaikan_gaji/form_kenaikan_gaji_print');
    }
    public function lookupPegawai2(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term)) 
        {
            $pegawai = DB::table('m_pegawai_man')
                ->join('m_divisi', 'm_pegawai_man.c_divisi_id', '=', 'm_divisi.c_id')
                ->join('m_jabatan', 'm_pegawai_man.c_jabatan_id', '=', 'm_jabatan.c_id')
                ->join('m_sub_divisi', 'm_jabatan.c_sub_divisi_id', '=', 'm_sub_divisi.c_id')
                ->select('m_pegawai_man.c_id',
                         'm_pegawai_man.c_nama',
                         'm_pegawai_man.c_tahun_masuk',
                         'm_pegawai_man.c_divisi_id',
                         'm_pegawai_man.c_jabatan_id',
                         'm_pegawai_man.c_pendidikan',
                         'm_divisi.c_divisi',
                         'm_jabatan.c_posisi',
                         'm_jabatan.c_sub_divisi_id',
                         'm_sub_divisi.c_subdivisi')
                ->orderBy('m_pegawai_man.c_nama', 'ASC')->limit(10)->get();
        }
        else
        {  
            $pegawai = DB::table('m_pegawai_man')
                ->join('m_divisi', 'm_pegawai_man.c_divisi_id', '=', 'm_divisi.c_id')
                ->join('m_jabatan', 'm_pegawai_man.c_jabatan_id', '=', 'm_jabatan.c_id')
                ->join('m_sub_divisi', 'm_jabatan.c_sub_divisi_id', '=', 'm_sub_divisi.c_id')
                ->select('m_pegawai_man.c_id',
                         'm_pegawai_man.c_nama',
                         'm_pegawai_man.c_tahun_masuk',
                         'm_pegawai_man.c_divisi_id',
                         'm_pegawai_man.c_jabatan_id',
                         'm_pegawai_man.c_pendidikan',
                         'm_divisi.c_divisi',
                         'm_jabatan.c_posisi',
                         'm_jabatan.c_sub_divisi_id',
                         'm_sub_divisi.c_subdivisi')
                ->where('m_pegawai_man.c_nama', 'LIKE', '%'.$term.'%')
                ->orderBy('m_pegawai_man.c_nama', 'ASC')
                ->limit(10)->get();
        }
        foreach ($pegawai as $val) {
            if ($val->c_pendidikan == 'S2') {
                $akronim_title = 'c_s1';
            }else{
                $akronim_title = strtolower('c_'.$val->c_pendidikan);
            }

            $gj = DB::table('m_gaji_man')->select($akronim_title)->first();
            $gapok = (int)$gj->$akronim_title;

            $formatted_tags[] = [
                'id' => $val->c_id,
                'text' => $val->c_nama,
                'divisi' => $val->c_divisi_id,
                'txtDivisi' => $val->c_divisi,
                'tglAwalMasuk' => $val->c_tahun_masuk,
                'jabatan' => $val->c_jabatan_id,
                'txtJabatan' => $val->c_posisi,
                'level' => $val->c_sub_divisi_id,
                'txtLevel' => $val->c_subdivisi,
                'gapok' => $gapok
            ];
        }
        return Response::json($formatted_tags);
    }

    //==============================================END KENAIKAN GAJI==========================================================
    
    public function form_laporan_leader(){
        return view('hrd/manajemensurat/surat/form_laporan_leader/form_laporan_leader');
    }
    public function form_laporan_leader_print(){
        return view('hrd/manajemensurat/surat/form_laporan_leader/form_laporan_leader_print');
    }
    public function form_overhandle(){
        return view('hrd/manajemensurat/surat/form_overhandle/form_overhandle');
    }
    public function form_overhandle_print(){
        return view('hrd/manajemensurat/surat/form_overhandle/form_overhandle_print');
    }
    public function form_permintaan(){
        return view('hrd/manajemensurat/surat/form_permintaan/form_permintaan');
    }
    public function form_permintaan_print(){
        return view('hrd/manajemensurat/surat/form_permintaan/form_permintaan_print');
    }
    public function form_keterangan_kerja(){
        return view('hrd/manajemensurat/surat/form_keterangan_kerja/form_keterangan_kerja');
    }
    public function form_keterangan_kerja_print(){
        return view('hrd/manajemensurat/surat/form_keterangan_kerja/form_keterangan_kerja_print');
    }
    public function form_application_print(){
        return view('hrd/manajemensurat/surat/form_application/form_application');
    }
}
