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
        $bulan = $this->convertMonthToGreek(Carbon::now('Asia/Jakarta')->format('m'));
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

        return redirect('/hrd/manajemensurat/surat-phk');
    }
    public function editPhk($id){
        $phk = DB::table('d_phk')->where('c_id', $id)->first();

        return view('hrd/manajemensurat/surat/form_phk/edit_phk',['phk' => $phk]);
    }
    public function updatePhk(Request $request, $id){
        $input = $request->except('_token','_method');
        $input['updated_at'] = Carbon::now('Asia/Jakarta');

        $data = DB::table('d_phk')->where('c_id', $id)->update($input);
        return redirect('/hrd/manajemensurat/surat-phk');
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
            }elseif($val->c_pendidikan == null){
                $akronim_title = 'c_sma';
            }
            else{
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
    public function lookupjabatan(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term)) 
        {
            $jabatan = DB::table('m_jabatan')
            ->select('m_jabatan.*', 'm_sub_divisi.c_subdivisi')
            ->join('m_sub_divisi', 'm_jabatan.c_sub_divisi_id', '=', 'm_sub_divisi.c_id')
            ->where('m_jabatan.c_divisi_id', $request->divisi)
            ->orderBy('m_jabatan.c_posisi', 'ASC')
            ->limit(10)->get();
        }
        else
        {  
            $jabatan = DB::table('m_jabatan')
            ->select('m_jabatan.*', 'm_sub_divisi.c_subdivisi')
            ->join('m_sub_divisi', 'm_jabatan.c_sub_divisi_id', '=', 'm_sub_divisi.c_id')
            ->where('m_jabatan.c_divisi_id', $request->divisi)
            ->where('m_jabatan.c_posisi', 'LIKE', '%'.$term.'%')
            ->orderBy('m_jabatan.c_posisi', 'ASC')->limit(10)->get();
        }
        foreach ($jabatan as $val) {
            $formatted_tags[] = [ 
                'id' => $val->c_id,
                'text' => $val->c_posisi,
                'idlevel' => $val->c_sub_divisi_id,
                'level' => $val->c_subdivisi
            ];
        }
        return Response::json($formatted_tags);
    }
    public function simpanNaikJabatan(Request $request){
        //dd($request->all());
        $maxid = DB::Table('d_naik_jabatan')->select('nj_id')->max('nj_id');
        if ($maxid <= 0 || $maxid <= '') { $maxid  = 1; }else{ $maxid += 1; }

        $dtnow = Carbon::now('Asia/Jakarta');
        $dnow = date('Y-m-d',strtotime(Carbon::now('Asia/Jakarta')));
        $tahun = Carbon::now('Asia/Jakarta')->format('Y');
        $bulan = $this->convertMonthToGreek(Carbon::now('Asia/Jakarta')->format('m'));
        $kode = str_pad($maxid, 3, '0', STR_PAD_LEFT)."/PROMOSI/HRD/".$bulan."/".$tahun;

        DB::table('d_naik_jabatan')->insert([
            'nj_id' => $maxid,
            'nj_code' => $kode,
            'nj_type' => 'J',
            'nj_pid' => $request->pegawai,
            'nj_alasan' => $request->alasan,
            'nj_tgl' => date('Y-m-d',strtotime($request->tanggal)),
            'nj_tgl_aktif' => date('Y-m-d',strtotime($request->tanggal_now)),
            'nj_level_lama' => $request->idlevel_now,
            'nj_posisi_lama' => $request->idjabatan_now,
            'nj_level_baru' => $request->idlevel,
            'nj_posisi_baru' => $request->jabatan,
            'nj_p_rekom' => $request->rekomendasi,
            'nj_divisi_rekom' => $request->iddivisi_rekom,
            'nj_jabatan_rekom' => $request->idjabatan_rekom,
            'nj_created' => $dtnow
        ]);

        return redirect('/hrd/manajemensurat/form_kenaikan_gaji');
    }
    public function promosiData(){
        $list = DB::table('d_naik_jabatan')
        ->join('m_pegawai_man', 'd_naik_jabatan.nj_pid', '=', 'm_pegawai_man.c_id')
        ->join('m_divisi', 'm_pegawai_man.c_divisi_id', '=', 'm_divisi.c_id')
        ->join('m_jabatan', 'm_pegawai_man.c_jabatan_id', '=', 'm_jabatan.c_id')
        ->select('d_naik_jabatan.*', 'm_pegawai_man.c_id','m_pegawai_man.c_nama','m_pegawai_man.c_divisi_id','m_pegawai_man.c_jabatan_id','m_divisi.c_divisi','m_jabatan.c_posisi')
        ->get();

        $data = collect($list);
        return Datatables::of($data)           
                ->addColumn('action', function ($data) {
                         return  '<a href="'.url('/hrd/manajemensurat/cetak-surat-promosi/'.$data->nj_id).'" target="_blank" class="btn btn-info btn-sm"><i class="glyphicon glyphicon-print"></i></a>'.'
                                  <button id="delete" onclick="hapus('.$data->nj_id.')" class="btn btn-danger btn-sm" title="Hapus"><i class="glyphicon glyphicon-trash"></i></button>';
                })
                ->addColumn('kode', function ($data) {
                    return  str_pad($data->c_id, 3, '0', STR_PAD_LEFT);
                })
                ->addColumn('none', function ($data) {
                    return '-';
                })
                ->addColumn('type', function ($data) {
                    if ($data->nj_type == "G") {return "Gaji"; }else{ return 'Jabatan'; }
                })
                ->addColumn('usul', function ($data) {
                    $nm_peg = DB::table('m_pegawai_man')->select('c_nama')->where('c_id', $data->nj_p_rekom)->first();
                    return $nm_peg->c_nama;
                })
                ->addColumn('tanggal', function ($data) {
                    if ($data->nj_tgl == null) {
                        return '-';
                    } else {
                        return $data->nj_tgl ? with(new Carbon($data->nj_tgl))->format('d M Y') : '';
                    }    
                })
                ->rawColumns(['action'])
                ->make(true);
    }
    public function cetakSuratPromosi($id){
        $data = DB::table('d_naik_jabatan')
                ->join('m_pegawai_man', 'd_naik_jabatan.nj_pid', '=', 'm_pegawai_man.c_id')
                ->join('m_divisi', 'm_pegawai_man.c_divisi_id', '=', 'm_divisi.c_id')
                ->join('m_jabatan', 'm_pegawai_man.c_jabatan_id', '=', 'm_jabatan.c_id')
                ->join('m_sub_divisi', 'm_jabatan.c_sub_divisi_id', '=', 'm_sub_divisi.c_id')
                ->where('d_naik_jabatan.nj_id', $id)
                ->select(
                    'd_naik_jabatan.*',
                    'm_pegawai_man.c_id',
                    'm_pegawai_man.c_nama',
                    'm_pegawai_man.c_divisi_id',
                    'm_pegawai_man.c_jabatan_id',
                    'm_pegawai_man.c_tahun_masuk',
                    'm_pegawai_man.c_pendidikan',
                    'm_divisi.c_divisi',
                    'm_jabatan.c_posisi',
                    'm_sub_divisi.c_subdivisi'
                )
                ->first();

        $rekom = DB::table('m_pegawai_man')
                    ->join('m_divisi', 'm_pegawai_man.c_divisi_id', '=', 'm_divisi.c_id')
                    ->join('m_jabatan', 'm_pegawai_man.c_jabatan_id', '=', 'm_jabatan.c_id')
                    ->join('m_sub_divisi', 'm_jabatan.c_sub_divisi_id', '=', 'm_sub_divisi.c_id')
                    ->where('m_pegawai_man.c_id', $data->nj_p_rekom)
                    ->select(
                        'm_pegawai_man.c_id',
                        'm_pegawai_man.c_nama',
                        'm_pegawai_man.c_divisi_id',
                        'm_pegawai_man.c_jabatan_id',
                        'm_divisi.c_divisi',
                        'm_jabatan.c_posisi',
                        'm_sub_divisi.c_subdivisi'
                    )
                    ->first();

        $posisiBaru = DB::table('m_jabatan')->select('c_posisi')->where('c_id', $data->nj_posisi_baru)->first();
        $levelBaru = DB::table('m_sub_divisi')->select('c_subdivisi')->where('c_id', $data->nj_level_baru)->first();

        if ($data->c_pendidikan == 'S2') {
                $akronim_title = 'c_s1';
        }else{
            $akronim_title = strtolower('c_'.$data->c_pendidikan);
        }

        $gj = DB::table('m_gaji_man')->select($akronim_title)->first();
        $gapok = (int)$gj->$akronim_title;

        return view('hrd/manajemensurat/surat/form_kenaikan_gaji/form_kenaikan_gaji_print', [
            'data' => $data,
            'gapok' => $gapok,
            'rekom' => $rekom,
            'posisiBaru' => $posisiBaru,
            'levelBaru' => $levelBaru
        ]);
    }
    public function deleteSuratPromosi($id){
        $data = DB::table('d_naik_jabatan')->where('nj_id', $id)->delete();

        return redirect('/hrd/manajemensurat/form_kenaikan_gaji');
    }

    //==============================================END KENAIKAN GAJI==========================================================
    
    public function form_laporan_leader(){
        $pic = DB::table('m_pegawai_man')
        ->join('m_jabatan', 'm_pegawai_man.c_jabatan_id', '=' , 'm_jabatan.c_id')
        ->select('m_pegawai_man.c_id', 'c_nama', 'c_posisi')
        ->get();
        // return $list;

        return view('hrd/manajemensurat/surat/form_laporan_leader/form_laporan_leader', ['pic' => $pic]);
    }
    public function form_laporan_leader_hapus($id){
        DB::table('d_form_laporan_leader')->where('fll_id', $id)->delete();
        DB::table('d_form_laporan_leader_dt')->where('fll_id', $id)->delete();
    }
    public function form_laporan_leader_autocomplete(Request $request){
        // return $request;

        $pic = DB::table('m_pegawai_man')
        ->join('m_jabatan', 'm_pegawai_man.c_jabatan_id', '=' , 'm_jabatan.c_id')
        ->join('m_divisi', 'm_pegawai_man.c_divisi_id', '=', 'm_divisi.c_id')
        ->select('m_pegawai_man.c_id', 'c_nama', 'c_posisi', 'c_divisi')
        ->where('m_pegawai_man.c_id', $request->pic)
        ->get();
        // return $list;

        return $pic;
    }
    public function form_laporan_leader_tambah(Request $request){
        // return $request;
        $id = DB::table('d_form_laporan_leader')->select('fll_id')->max('fll_id');

        $max_id = $id+1;

        $hari = date("Y-m-d", strtotime($request->hari));

        DB::table('d_form_laporan_leader')->insert([
            'fll_id' => $max_id,
            'fll_pic' => $request->nama,
            'fll_hari' => $hari,
            'fll_divisi' => $request->divisi
        ]);

        
        for ($i=0; $i < count($request->aktifitas); $i++) { 
            $idx = DB::table('d_form_laporan_leader_dt')->select('flldt_id')->max('flldt_id');

            $max_idx = $idx+1;

            DB::table('d_form_laporan_leader_dt')->insert([
                'flldt_id' => $max_idx,
                'fll_id' => $max_id,
                'flldt_aktifitas' => $request->aktifitas[$i],
                'flldt_keterangan' => $request->keterangan[$i]
            ]);
        }

        
    }

    public function form_laporan_leader_datatable(){
        $list = DB::table('d_form_laporan_leader')->select('fll_id', 'fll_divisi', 'fll_hari', 'fll_pic')
        ->orderBy('fll_id', 'DESC')
        ->get();

        $data = collect($list);

        setlocale(LC_ALL, "id_ID");

        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('aksi', function($data){
            return  '<div class="btn-group btn-group-sm">'.
                        '<a href="'.url('hrd/manajemensurat/form_laporan_leader_print/'.$data->fll_id).'" target="_blank" class="btn btn-info"><i class="fa fa-print"></i></a>'.
                        '<button class="btn btn-danger btn-hapus" onclick="hapus('. $data->fll_id.')" type="button"><i class="fa fa-trash-o"></i></button>'.
                    '</div>';
        })
        ->addColumn('hari', function($data){
            return strftime("%A, %e %B %Y", strtotime($data->fll_hari));
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }

    public function form_laporan_leader_print($id){

        $head = DB::table('d_form_laporan_leader')
        ->select('fll_hari', 'fll_pic', 'fll_divisi')
        ->where('fll_id', $id)
        ->get();

        $list = DB::table('d_form_laporan_leader_dt')
        ->select('flldt_aktifitas', 'flldt_keterangan')
        ->where('fll_id', $id)
        ->get()->toArray();
        
        // return $head;
        // return $list;
        return view('hrd/manajemensurat/surat/form_laporan_leader/form_laporan_leader_print', ['head' => $head, 'list' => $list]);
    }
    public function form_overhandle(){
        $month = date('m');

        $year = date('Y');

        $id = DB::table('d_form_overhandle')->select('foh_id')->max('foh_id');

        $max_id = $id+1;

        if($max_id < 10){
            $id_awal = '00'.$max_id;
        } elseif($max_id < 100){
            $id_awal = '0'.$max_id;
        } else {
            $id_awal = $max_id;
        }

        $month_kurawal = $this->convertMonthToGreek($month);

        $kode = $id_awal.'/STT/HRD/'.$month_kurawal.'/'.$year;

        $karyawan = DB::table('m_pegawai_man')
        ->join('m_jabatan', 'm_pegawai_man.c_jabatan_id', '=' , 'm_jabatan.c_id')
        ->select('m_pegawai_man.c_id', 'c_nama', 'c_ktp', 'c_alamat', 'c_posisi', 'c_nik')
        ->get();

        // return $karyawan;
        return view('hrd/manajemensurat/surat/form_overhandle/form_overhandle', ['code' => $kode, 'pegawai' => $karyawan]);
    }
    public function form_overhandle_tambah(Request $request){
        $tgl_awal = date("Y-m-d", strtotime($request->tgl_awal));

        $tgl_akhir = date("Y-m-d", strtotime($request->tgl_akhir));

        $tanggal = date("Y-m-d", strtotime($request->tanggal));

        // return $request;

        $id = DB::table('d_form_overhandle')->select('foh_id')->max('foh_id');

        $max_id = $id+1;

        $table1 = DB::table('d_form_overhandle')
        ->insert([
            'foh_id' => $max_id,
            'fohdt_id' => $max_id,
            'foh_surat' => $request->kode,
            
            'foh_tugas' => $request->tugas,
            
            'foh_awal_tanggal' => $tgl_awal,
            'foh_akhir_tanggal' => $tgl_akhir,
            'foh_dibuat_di' => $request->dibuat,
            'foh_tanggal' => $tanggal
        ]);

        $table2 = DB::table('d_form_overhandle_dt')
        ->insert([
            'fohdt_id' => $max_id,
            
            'fohdt_nama1' => $request->nama1,
            'fohdt_alamat1' => $request->alamat1,
            'fohdt_ktp1' => $request->ktp1,
            'fohdt_nik1' => $request->nik1,
            
            'fohdt_nama2' => $request->nama2,
            'fohdt_alamat2' => $request->alamat2,
            'fohdt_ktp2' => $request->ktp2,
            'fohdt_nik2' => $request->nik2,
            'fohdt_posisi1' => $request->posisi1,
            'fohdt_posisi2' => $request->posisi2

        ]);

        $month = date('m');

        $year = date('Y');

        $max_idx = $max_id+1;

        if($max_idx < 10){
            $id_awal = '00'.$max_idx;
        } elseif($max_idx < 100){
            $id_awal = '0'.$max_idx;
        } else {
            $id_awal = $max_idx;
        }

        $month_kurawal = $this->convertMonthToGreek($month);

        $kode = array();

        $kode[] = $id_awal.'/STT/HRD/'.$month_kurawal.'/'.$year;

        return Response::json($kode);

    }
    public function form_overhandle_datatable(){
        $list = DB::table('d_form_overhandle')->select('foh_id', 'foh_surat', 'foh_tanggal', 'fohdt_nama1', 'fohdt_nama2')
        ->join('d_form_overhandle_dt', 'd_form_overhandle.foh_id', '=', 'd_form_overhandle_dt.fohdt_id')
        ->orderBy('foh_id', 'DESC')
        ->get();

        $data = collect($list);

        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('aksi', function($data){
            return  '<div class="btn-group btn-group-sm">'.
                        '<a href="'.url('hrd/manajemensurat/form_overhandle_print/'.$data->foh_id).'" target="_blank" class="btn btn-info"><i class="fa fa-print"></i></a>'.
                        '<button class="btn btn-danger btn-hapus" onclick="hapus('. $data->foh_id.')" type="button"><i class="fa fa-trash-o"></i></button>'.
                    '</div>';
        })
        ->addColumn('tgl', function($data){
            return date("d M Y", strtotime($data->foh_tanggal));
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }
    public function form_overhandle_autocomplete(Request $request){
        // return $request->id_karyawan1;
        $karyawan = DB::table('m_pegawai_man')
        ->join('m_jabatan', 'm_pegawai_man.c_jabatan_id', '=' , 'm_jabatan.c_id')
        ->select('m_pegawai_man.c_id', 'c_nama', 'c_ktp', 'c_alamat', 'c_posisi', 'c_nik')
        ->where('m_pegawai_man.c_id', $request->id_karyawan1)
        ->get();

        return $karyawan;
    }
    public function form_overhandle_autocomplete2(Request $request){
        // return $request->id_karyawan1;
        $karyawan = DB::table('m_pegawai_man')
        ->join('m_jabatan', 'm_pegawai_man.c_jabatan_id', '=' , 'm_jabatan.c_id')
        ->select('m_pegawai_man.c_id', 'c_nama', 'c_ktp', 'c_alamat', 'c_posisi', 'c_nik')
        ->where('m_pegawai_man.c_id', $request->id_karyawan2)
        ->get();

        return $karyawan;
    }
    public function form_overhandle_print($id){
        $data = DB::table('d_form_overhandle')
        ->select('foh_tanggal',
         'foh_awal_tanggal',
         'foh_akhir_tanggal',
         'foh_surat',
         'foh_tugas',
         'foh_dibuat_di',
         'fohdt_nama1',
         'fohdt_nama2',
         'fohdt_ktp2',
         'fohdt_ktp1',
         'fohdt_alamat2',
         'fohdt_alamat1',
         'fohdt_posisi2',
         'fohdt_posisi1',
         'fohdt_nik2',
         'fohdt_nik1')
        ->join('d_form_overhandle_dt', 'd_form_overhandle.foh_id', '=', 'd_form_overhandle_dt.fohdt_id')
        ->where('foh_id', $id)
        ->get();

        // return $data;

        $tanggal_awal = date_create($data[0]->foh_awal_tanggal);
        $tanggal_akhir = date_create($data[0]->foh_akhir_tanggal);

        $hitung_hari = date_diff($tanggal_awal, $tanggal_akhir);

        $hasil_hari = $hitung_hari->format("%a");
        

        return view('hrd/manajemensurat/surat/form_overhandle/form_overhandle_print', ['daita'=> $data, 'count_day' => $hasil_hari]);
    }
    public function form_permintaan(){
        $data = DB::table('m_jabatan')->select('c_id', 'c_posisi')->get()->toArray();

        // return $data;

        return view('hrd/manajemensurat/surat/form_permintaan/form_permintaan', ['daita' => $data]);
    }
    public function hapus_form_overhandle($id){
        $data = DB::table('d_form_overhandle')->where('foh_id', $id)->delete();
        $data1 = DB::table('d_form_overhandle_dt')->where('fohdt_id', $id)->delete();

        $id = DB::table('d_form_overhandle')->select('foh_id')->max('foh_id');

        $max_id = $id+1;

        $month = date('m');

        $year = date('Y');

        if($max_id < 10){
            $id_awal = '00'.$max_id;
        } elseif($max_id < 100){
            $id_awal = '0'.$max_id;
        } else {
            $id_awal = $max_id;
        }

        $month_kurawal = $this->convertMonthToGreek($month);

        $kode = array();

        $kode[] = $id_awal.'/STT/HRD/'.$month_kurawal.'/'.$year;

        return Response::json($kode);

    }
    public function form_permintaan_datatable(){

        $list = DB::table('d_form_permintaan_karyawan_baru')->select('pkb_id', 'pkb_departement', 'pkb_tgl_pengujian', 'pkb_tgl_masuk')
        ->orderBy('pkb_id', 'DESC')
        ->get();

        $data = collect($list);

        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('aksi', function($data){
            return  '<div class="btn-group btn-group-sm">'.
                        '<a href="'.url('hrd/manajemensurat/form_permintaan_print/'.$data->pkb_id).'" target="_blank" class="btn btn-info"><i class="fa fa-print"></i></a>'.
                        '<button class="btn btn-danger btn-hapus" onclick="hapus('. $data->pkb_id.')" type="button"><i class="fa fa-trash-o"></i></button>'.
                    '</div>';
        })
        ->addColumn('tgl_masuk', function($data){
            return  date('d M Y', strtotime($data->pkb_tgl_masuk));
        })
        ->addColumn('tgl_pengujian', function($data){
            return  date('d M Y', strtotime($data->pkb_tgl_pengujian));
        })
        ->rawColumns(['aksi'])
        ->make(true);

    }
    public function form_permintaan_print($id){
        $data = DB::table('d_form_permintaan_karyawan_baru')
        ->where('pkb_id', $id)
        ->get();
        // return $data;
        return view('hrd/manajemensurat/surat/form_permintaan/form_permintaan_print', ['daita' => $data]);
    }
    public function form_keterangan_kerja(){
        $karyawan = DB::table('m_pegawai_man')
        ->join('m_jabatan', 'm_pegawai_man.c_jabatan_id', '=' , 'm_jabatan.c_id')
        ->select('m_pegawai_man.c_id', 'c_nama', 'c_alamat', 'c_posisi', 'c_lahir')
        ->get();

        $id = DB::table('d_form_keterangan_kerja')->select('fkj_id')->max('fkj_id');

        $max_id = $id+1;

        $month = date('m');

        $bulan = $this->convertMonthToGreek($month);

        $tahun = date('Y');

        if($max_id < 10){
            $kode_awal = '00'.$max_id;
        } elseif($max_id < 100){
            $kode_awal = '0'.$max_id;
        } else {
            $kode_awal = $max_id;
        }

        $kode  = $kode_awal.'/SKK-HRD/'.$bulan.'/'.$tahun;

        // return $kode;

        return view('hrd/manajemensurat/surat/form_keterangan_kerja/form_keterangan_kerja', ['pegawai' => $karyawan, 'kode_surat' => $kode]);
    }
    public function form_keterangan_kerja_print($id){
        $list = DB::table('d_form_keterangan_kerja')
        ->select('fkj_id', 'fkj_kode', 'fkj_tanggal_awal', 'fkj_tanggal_akhir', 'fkjdt_nama1', 'fkjdt_nama2', 'fkjdt_jabatan1', 'fkjdt_alamat1', 'fkjdt_alamat2', 'fkjdt_jk2', 'fkjdt_ttl2', 'fkjdt_posisi2')
        ->join('d_form_keterangan_kerja_dt', 'd_form_keterangan_kerja.fkj_id' ,'=', 'd_form_keterangan_kerja_dt.fkjdt_id')
        ->where('fkj_id', $id)
        ->get();

        // return $list;

        // return $list[0]->fkj_tanggal_awal;
        return view('hrd/manajemensurat/surat/form_keterangan_kerja/form_keterangan_kerja_print', ['daita' => $list]);
    }
    public function form_keterangan_kerja_autocomplete(Request $request){
        // return $request->id_karyawan1;
        $karyawan = DB::table('m_pegawai_man')
        ->join('m_jabatan', 'm_pegawai_man.c_jabatan_id', '=' , 'm_jabatan.c_id')
        ->select('m_pegawai_man.c_id', 'c_nama', 'c_ktp', 'c_alamat', 'c_posisi', 'c_lahir')
        ->where('m_pegawai_man.c_id', $request->karyawan1)
        ->get();

        return $karyawan;
    }
    public function form_keterangan_kerja_autocomplete2(Request $request){
        // return $request->id_karyawan1;
        $karyawan = DB::table('m_pegawai_man')
        ->join('m_jabatan', 'm_pegawai_man.c_jabatan_id', '=' , 'm_jabatan.c_id')
        ->select('m_pegawai_man.c_id', 'c_nama', 'c_ktp', 'c_alamat', 'c_posisi', 'c_lahir')
        ->where('m_pegawai_man.c_id', $request->karyawan2)
        ->get();

        return $karyawan;
    }
    public function form_keterangan_kerja_tambah(Request $request){
        $id = DB::table('d_form_keterangan_kerja')->select('fkj_id')->max('fkj_id');

        $max_id = $id+1;

        // return $request;

        $tgl_awal = date("Y-m-d", strtotime($request->tgl_awal));
        $tgl_akhir = date("Y-m-d", strtotime($request->tgl_akhir));

        $insert = DB::table('d_form_keterangan_kerja')
        ->insert([
            'fkj_id' => $max_id,
            'fkjdt_id' => $max_id,
            'fkj_kode' => $request->kode,
            'fkj_tanggal_awal' => $tgl_awal,
            'fkj_tanggal_akhir' => $tgl_akhir
        ]);

        $insert2 = DB::table('d_form_keterangan_kerja_dt')
        ->insert([
            'fkjdt_id' => $max_id,
            'fkjdt_nama1' => $request->nama1,
            'fkjdt_jabatan1' => $request->posisi1,
            'fkjdt_alamat1' => $request->alamat1,
            'fkjdt_nama2' => $request->nama2,
            'fkjdt_jk2' => $request->jk2,
            'fkjdt_ttl2' => $request->ttl2,
            'fkjdt_alamat2' => $request->alamat2,
            'fkjdt_posisi2' => $request->posisi2
        ]);
        $month = date('m');

        $year = date('Y');

        $max_idx = $max_id+1;

        if($max_idx < 10){
            $id_awal = '00'.$max_idx;
        } elseif($max_idx < 100){
            $id_awal = '0'.$max_idx;
        } else {
            $id_awal = $max_idx;
        }

        $month_kurawal = $this->convertMonthToGreek($month);

        $kode_surat_keterangan = array();

        $kode_surat_keterangan[] = $id_awal.'/SKK-HRD/'.$month_kurawal.'/'.$year;

        return Response::json($kode_surat_keterangan);
    }
    public function form_application_print(){
        return view('hrd/manajemensurat/surat/form_application/form_application');
    }
    public function form_keterangan_kerja_datatable(){
        $list = DB::table('d_form_keterangan_kerja')->select('fkj_id', 'fkj_kode', 'fkjdt_nama1', 'fkjdt_nama2', 'd_form_keterangan_kerja.CREATED_AT')
        ->join('d_form_keterangan_kerja_dt', 'd_form_keterangan_kerja.fkjdt_id', '=', 'd_form_keterangan_kerja_dt.fkjdt_id')
        ->orderBy('fkj_id', 'DESC')
        ->get();

        $data = collect($list);

        setlocale(LC_ALL, "id_ID");

        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('aksi', function($data){
            return  '<div class="btn-group btn-group-sm">'.
                        '<a href="'.url('hrd/manajemensurat/form_keterangan_kerja_print/'.$data->fkj_id).'" target="_blank" class="btn btn-info"><i class="fa fa-print"></i></a>'.
                        '<button class="btn btn-danger btn-hapus" onclick="hapus('. $data->fkj_id.')" type="button"><i class="fa fa-trash-o"></i></button>'.
                    '</div>';
        })
        ->addColumn('tanggal_buat', function($data){
            return strftime("%A, %e %B %Y %H:%M:%S", strtotime($data->CREATED_AT));
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }
    public function form_keterangan_kerja_hapus($id){
        $data = DB::table('d_form_keterangan_kerja')->where('fkj_id', $id)->delete();
        $data1 = DB::table('d_form_keterangan_kerja_dt')->where('fkjdt_id', $id)->delete();

        $id = DB::table('d_form_keterangan_kerja')->select('fkj_id')->max('fkj_id');

        $max_id = $id+1;

        $month = date('m');

        $bulan = $this->convertMonthToGreek($month);

        $tahun = date('Y');

        if($max_id < 10){
            $kode_awal = '00'.$max_id;
        } elseif($max_id < 100){
            $kode_awal = '0'.$max_id;
        } else {
            $kode_awal = $max_id;
        }

        $kode  = $kode_awal.'/SKK-HRD/'.$bulan.'/'.$tahun;

        return Response::json($kode);
    }
    public function convertMonthToGreek($bulan)
    {
        switch ($bulan) {
            case "01":
                return "I";
                break;
            case "02":
                return "II";
                break;
            case "03":
                return "III";
                break;
            case "04":
                return "IV";
                break;
            case "05":
                return "V";
                break;
            case "06":
                return "vI";
                break;
            case "07":
                return "VII";
                break;
            case "08":
                return "VIII";
                break;
            case "09":
                return "IX";
                break;
            case "10":
                return "X";
                break;
            case "11":
                return "XI";
                break;
            case "12":
                return "XII";
                break;
            default:
                return "masukan format bulan dengan benar";
        }
    }
    public function tambah_form_permintaan(Request $request){
        // return $request;
        $max_id = DB::table('d_form_permintaan_karyawan_baru')->select('pkb_id')->max('pkb_id');

        $id = $max_id+1;

        // return $id;
        $tgl_pengujian = date('Y-m-d', strtotime($request->tgl_pengujian));

        $tgl_masuk = date('Y-m-d', strtotime($request->tgl_masuk));

        $gaji = str_replace(',', '', $request->gaji);
        // $gaji = intval($request->gaji);
        // $gaji = $request->gaji;

        // return $gaji;

        $data = DB::table('d_form_permintaan_karyawan_baru')->insert([
            'pkb_id' => $id,
            'pkbdt_id' => $id,
            'pkb_departement' => $request->department,
            'pkb_tgl_pengujian' => $tgl_pengujian,
            'pkb_tgl_masuk' => $tgl_masuk,
            'pkb_posisi' => $request->posisi,
            'pkb_jumlah_butuh' => $request->jumlah_butuh,
            'pkb_jumlah_karyawan' => $request->jumlah_karyawan,
            'pkb_penambahan' => $request->penambahan,
            'pkb_alasan' => $request->alasan,
            'pkb_usia' => $request->usia,
            'pkb_jk' => $request->jk,
            'pkb_pendidikan' => $request->pendidikan,
            'pkb_pengalaman' => $request->pengalaman,
            'pkb_keahlian' => $request->keahlian,
            'pkb_gaji' => $gaji,
            'pkb_keterangan' => $request->keterangan
        ]);
    }
    public function hapus_form_permintaan($id){
        $data = DB::table('d_form_permintaan_karyawan_baru')->where('pkb_id', $id)->delete();

        // return redirect('hrd.manajemensurat.surat.form_permintaan.form_permintaan');
    }
}
