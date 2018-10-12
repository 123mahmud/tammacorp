<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Response;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use PDF;
use DataTables;
use Auth;
//class untuk menangani storege file (unlink misal)
use Illuminate\Support\Facades\Storage;
//load package image resize
use Image;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;
use App\Model\Hrd\d_pelamar;
use App\Model\Hrd\d_pelamar_jadwal;
use App\Model\Hrd\d_berkas_pelamar;
use App\Model\Hrd\d_cv_pelamar;

class RecruitmentController extends Controller
{
    public function recruitment()
    {
        $lowongan = DB::table('d_lowongan')->select('l_code')->where('l_isactive', 'Y')->get();
        return view('hrd/recruitment/index', compact('lowongan'));
    }

    public function process_rekrut($id)
    {
        $data = d_pelamar::join('d_pelamar_status','d_pelamar.p_apply_status','=','d_pelamar_status.p_st_id')
                ->join('d_pelamar_statusdt','d_pelamar.p_apply_statusdt','=','d_pelamar_statusdt.p_stdt_id')
                ->join('d_lowongan','d_pelamar.p_vacancyid','=','d_lowongan.l_id')
                ->select('d_pelamar.*', 'd_pelamar_status.*', 'd_lowongan.*', 'd_pelamar_statusdt.*')
                ->where('d_pelamar.p_id', $id)
                ->first();

        $vacancy = DB::table('d_lowongan')->join('m_divisi', 'd_lowongan.l_divisi', '=', 'm_divisi.c_id')->join('m_sub_divisi', 'd_lowongan.l_subdivisi', '=', 'm_sub_divisi.c_id')->join('m_jabatan', 'd_lowongan.l_jabatan', '=', 'm_jabatan.c_id')->where('l_id', $data->p_vacancyid)->first();

        $jadwal_i = d_pelamar_jadwal::join('d_pelamar','d_pelamar_jadwal.pj_pid','=','d_pelamar.p_id')
                ->join('m_pegawai_man','d_pelamar_jadwal.pj_pmid','=','m_pegawai_man.c_id')
                ->select('d_pelamar_jadwal.*', 'd_pelamar.*', 'm_pegawai_man.c_nama', 'm_pegawai_man.c_nik', 'm_pegawai_man.c_id')
                ->where('d_pelamar_jadwal.pj_pid', $id)
                ->where('d_pelamar_jadwal.pj_type', 'I')
                ->where('d_pelamar_jadwal.pj_isactive', 'Y')
                ->first();

        $jadwal_p = d_pelamar_jadwal::join('d_pelamar','d_pelamar_jadwal.pj_pid','=','d_pelamar.p_id')
                ->join('m_pegawai_man','d_pelamar_jadwal.pj_pmid','=','m_pegawai_man.c_id')
                ->select('d_pelamar_jadwal.*', 'd_pelamar.*', 'm_pegawai_man.c_nama', 'm_pegawai_man.c_nik', 'm_pegawai_man.c_id')
                ->where('d_pelamar_jadwal.pj_pid', $id)
                ->where('d_pelamar_jadwal.pj_type', 'P')
                ->where('d_pelamar_jadwal.pj_isactive', 'Y')
                ->first();

        $approve1 = DB::table('d_pelamar_status')->join('d_pelamar_statusdt', 'd_pelamar_status.p_st_id', '=', 'd_pelamar_statusdt.p_stdt_sid')->where('d_pelamar_status.p_st_id', '2')->get();
        $approve2 = DB::table('d_pelamar_status')->join('d_pelamar_statusdt', 'd_pelamar_status.p_st_id', '=', 'd_pelamar_statusdt.p_stdt_sid')->where('d_pelamar_status.p_st_id', '3')->get();
        $approve3 = DB::table('d_pelamar_status')->join('d_pelamar_statusdt', 'd_pelamar_status.p_st_id', '=', 'd_pelamar_statusdt.p_stdt_sid')->where('d_pelamar_status.p_st_id', '4')->get();


        $cek1 = DB::table('d_apply')->where('ap_pid', $id)->where('ap_stid', '2')->first();
        $cek2 = DB::table('d_apply')->where('ap_pid', $id)->where('ap_stid', '3')->first();
        $cek3 = DB::table('d_apply')->where('ap_pid', $id)->where('ap_stid', '4')->first();

        /*if (count($cek1) > 0 ) { $cek_app1 = $cek1->ap_stdt_id; } else { $cek_app1 = '1'; }
        if (count($cek2) > 0 ) { $cek_app2 = $cek2->ap_stdt_id; } else { $cek_app2 = '1'; }
        if (count($cek3) > 0 ) { $cek_app3 = $cek3->ap_stdt_id; } else { $cek_app3 = '1'; }*/
        if (!empty($cek1)) { $cek_app1 = $cek1->ap_stdt_id; } else { $cek_app1 = '1'; }
        if (!empty($cek2)) { $cek_app2 = $cek2->ap_stdt_id; } else { $cek_app2 = '1'; }
        if (!empty($cek3)) { $cek_app3 = $cek3->ap_stdt_id; } else { $cek_app3 = '1'; }

        return view('hrd/recruitment/process_rekrut', compact('data', 'approve1', 'approve2', 'approve3', 'cek_app1', 'cek_app2', 'cek_app3', 'jadwal_i', 'jadwal_p', 'vacancy'));
    }

    public function preview_rekrut($id)
    {
        $data = d_pelamar::join('d_pelamar_status','d_pelamar.p_apply_status','=','d_pelamar_status.p_st_id')
                ->join('d_pelamar_statusdt','d_pelamar.p_apply_statusdt','=','d_pelamar_statusdt.p_stdt_id')
                ->join('d_lowongan','d_pelamar.p_vacancyid','=','d_lowongan.l_id')
                ->select('d_pelamar.*', 'd_pelamar_status.*', 'd_lowongan.*', 'd_pelamar_statusdt.*')
                ->where('d_pelamar.p_id', $id)
                ->first();

        //cv
        $cv = d_cv_pelamar::where('d_cv_pid', $id)->get();
        if (count($cv) == 1) {
            $cv1 = d_cv_pelamar::where('d_cv_pid', $id)->orderBy('d_cv_id', 'ASC')->limit(1)->get()->toArray();
            $cv2[] = array('d_cv_pid' => '', 'd_cv_company' => '', 'd_cv_thnmasuk' => '', 'd_cv_thnkeluar' => '', 'd_cv_jobdesc' => '', 'd_cv_created' => '', 'd_cv_updated' => '');
        }elseif (count($cv) == 2){
            $cv1 = d_cv_pelamar::where('d_cv_pid', $id)->orderBy('d_cv_id', 'ASC')->limit(1)->get()->toArray();
            $cv2 = d_cv_pelamar::where('d_cv_pid', $id)->orderBy('d_cv_id', 'DESC')->limit(1)->get()->toArray();
        }else{
            $cv1[] = array('d_cv_pid' => '', 'd_cv_company' => '', 'd_cv_thnmasuk' => '', 'd_cv_thnkeluar' => '', 'd_cv_jobdesc' => '', 'd_cv_created' => '', 'd_cv_updated' => '');
            $cv2[] = array('d_cv_pid' => '', 'd_cv_company' => '', 'd_cv_thnmasuk' => '', 'd_cv_thnkeluar' => '', 'd_cv_jobdesc' => '', 'd_cv_created' => '', 'd_cv_updated' => '');
        }

        //berkas
        $ijasah[] = array('bks_id' => '', 'bks_pid' => '', 'bks_type' => '', 'bks_name' => '', 'bks_dtype' => '');
        $serti[] = array('bks_id' => '', 'bks_pid' => '', 'bks_type' => '', 'bks_name' => '', 'bks_dtype' => '');
        $lain[] = array('bks_id' => '', 'bks_pid' => '', 'bks_type' => '', 'bks_name' => '', 'bks_dtype' => '');
        $drh[] = array('bks_id' => '', 'bks_pid' => '', 'bks_type' => '', 'bks_name' => '', 'bks_dtype' => '');
        $berkas = d_berkas_pelamar::where('bks_pid', $id)->where('bks_type', 'D')->get();
        foreach ($berkas as $value)
        {
            if ($value->bks_dtype == 'KT') {
                $result = d_berkas_pelamar::where('bks_pid', $id)->where('bks_dtype', 'KT')->limit(1)->get()->toArray();
                $serti = array_replace($serti, $result);
            }
            else if ($value->bks_dtype == 'IJ')
            {
                $result = d_berkas_pelamar::where('bks_pid', $id)->where('bks_dtype', 'IJ')->limit(1)->get()->toArray();
                $ijasah = array_replace($ijasah, $result);
            }
            else if ($value->bks_dtype == 'LL')
            {
                $result = d_berkas_pelamar::where('bks_pid', $id)->where('bks_dtype', 'LL')->limit(1)->get()->toArray();
                $lain = array_replace($lain, $result);
            }
            else if ($value->bks_dtype == 'CV')
            {
                $result = d_berkas_pelamar::where('bks_pid', $id)->where('bks_dtype', 'CV')->limit(1)->get()->toArray();
                $drh = array_replace($drh, $result);
            }
        }

        //dd($serti, $lain, $ijasah);
        return view('hrd/recruitment/preview_rekrut', compact('data', 'cv1', 'cv2', 'ijasah', 'serti', 'lain', 'drh'));
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            //set rules form name
            'kdlowong' => 'required|min:7',
            'nama' => 'required',
            'noktp' => 'required|min:16',
            'alamat' => 'required',
            'alamatnow' => 'required',
            'tempatlahir' => 'required',
            'tanggal' => 'required',
            'bulan' => 'required',
            'tahun' => 'required',
            'pendidikanterakhir' => 'required|min:2',
            'pendidikan' => 'required',
            'dob_pend_awal1' => 'required',
            'dob_pend_akhir1' => 'required',
            'jurusan' => 'required',
            'nilai' => 'required',
            // 'email' => 'required|d_pelamar|unique:email',
            'email' => 'required',
            'notlp' => 'required|min:7',
            'agama' => 'required',
            'status' => 'required',
            'promo' => 'required',
            'sertifikat' => "mimes:pdf,jpeg,png,jpg|max:5000",
            'ijazah' => "mimes:pdf|max:5000",
            'file_lain_lain' => "mimes:pdf|max:5000",
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ],[
            'kdlowong.required' => ' Kode Lowongan Tidak Boleh Kosong',
            'kdlowong.min' => ' Kode Lowongan Minimal 7 Karakter',
            'nama.required' => ' Nama tidak boleh kosong',
            'noktp.required' => ' KTP tidak boleh kosong',
            'noktp.min' => ' KTP minimal harus 16 karakter',
            'alamat.required' => ' Alamat tidak boleh kosong.',
            'alamatnow.required' => ' Alamat saat ini tidak boleh kosong',
            'tempatlahir.required' => ' Tempat Lahir tidak boleh kosong',
            'tanggal.required' => ' Wajib Memilih Tanggal Lahir',
            'bulan.required' => ' Wajib Memilih Bulan Lahir',
            'tahun.required' => ' Wajib Memilih Tahun Lahir',
            'pendidikanterakhir.required' => ' Pendidikan tidak boleh kosong',
            'pendidikanterakhir.min' => ' Pendidikan minimal harus 16 karakter',
            'pendidikan' => ' Nama Sekolah/Universitas tidak boleh kosong',
            'dob_pend_awal1' => ' Wajib Memilih Tahun Masuk',
            'dob_pend_akhir1' => ' Wajib Memilih Tahun Lulus',
            'jurusan' => ' Jurusan tidak boleh kosong',
            'nilai' => ' Nilai tidak boleh kosong',
            'email.required' => ' Email tidak boleh kosong',
            'notlp.required' => ' Nomor Telepon tidak boleh kosong',
            'notlp.min' => ' Nomor Telepon Minimal harus 7 karakter',
            'agama.required' => ' Agama tidak boleh kosong',
            'status.required' => ' Status Telepon tidak boleh kosong',
            'promo' => ' Maaf anda wajib mempromosikan diri anda',
            'image.required' => ' Anda Wajib Upload data Foto',
        ]);

        $id = d_pelamar::select('p_id')->max('p_id');
        if ($id == 0 || $id == '') { $id  = 1; } else { $id++; }

        $birth = $request->tahun . '-' . $request->bulan . '-' . $request->tanggal;
        $status = null;

        if ($request->status == 'menikah') { $status = 'M'; } else { $status = 'S'; }
        $id_lowong = DB::table('d_lowongan')->select('l_id')->where('l_code', $request->kdlowong)->first();
        //d_pelamar
        $data = new d_pelamar;
            $data->p_id = $id;
            $data->p_date = date('Y-m-d');
            $data->p_vacancyid = $id_lowong->l_id;
            $data->p_name = $request->nama;
            $data->p_nip = $request->noktp;
            $data->p_address = $request->alamat;
            $data->p_address_now = $request->alamatnow;
            $data->p_birth_place = $request->tempatlahir;
            $data->p_birthday = $birth;
            $data->p_education = $request->pendidikanterakhir;
            $data->p_schoolname = $request->pendidikan;
            $data->p_yearin = $request->dob_pend_awal1;
            $data->p_yearout = $request->dob_pend_akhir1;
            $data->p_jurusan = $request->jurusan;
            $data->p_nilai = $request->nilai; 
            $data->p_email = $request->email;
            $data->p_tlp = $request->notlp;
            $data->p_religion = $request->agama;
            $data->p_status = $status;
            $data->p_promo = $request->promo;
            $data->p_child = $request->anak;
            $data->p_wife_name = $request->partner_name;
            $data->p_created = Carbon::now('Asia/Jakarta');
            $data->save();

        //d_cv_pelamar
        if ($request->perusahaan1 != null)
        {
            $cv = new d_cv_pelamar;
            $cv->d_cv_pid = $id;
            $cv->d_cv_company = $request->perusahaan1;
            $cv->d_cv_thnmasuk = $request->dob_cv_awal1;
            $cv->d_cv_thnkeluar = $request->dob_cv_akhir1;
            $cv->d_cv_jobdesc = $request->jobdesc1;
            $cv->d_cv_created = Carbon::now('Asia/Jakarta');
            $cv->save();
        }

        if ($request->perusahaan2 != null)
        {
            $cv = new d_cv_pelamar;
            $cv->d_cv_pid = $id;
            $cv->d_cv_company = $request->perusahaan2;
            $cv->d_cv_thnmasuk = $request->dob_cv_awal2;
            $cv->d_cv_thnkeluar = $request->dob_cv_akhir2;
            $cv->d_cv_jobdesc = $request->jobdesc2;
            $cv->d_cv_created = Carbon::now('Asia/Jakarta');
            $cv->save();
        }

        //d_berkas_pelamar
        if($request->hasFile('image'))
        {
            $berkas = new d_berkas_pelamar;
            $image = $request->file('image');
            $path = public_path(). '/assets/berkas/foto-pelamar';
            $filename = $request->nama.'_'.$id.'_foto' . '.' . $image->getClientOriginalExtension();
            $image->move($path, $filename);
            //load object dari package image resize
            Image::make($path.'/'.$filename)->resize(800, 800)->save();
            // set field to table
            $berkas->bks_name = $filename;
            $berkas->bks_type = 'I';
            $berkas->bks_pid = $id;
            $savedImg = $berkas->save();
        }

        if($request->hasFile('sertifikat'))
        {
            $berkas = new d_berkas_pelamar;
            $sertifikat = $request->file('sertifikat');
            $path = public_path(). '/assets/berkas/dokumen-pelamar';
            $filename = $request->nama.'_'.$id.'_ktp' . '.' . $sertifikat->getClientOriginalExtension();
            $sertifikat->move($path, $filename);
            // set field to table
            $berkas->bks_name = $filename;
            $berkas->bks_type = 'D';
            $berkas->bks_dtype = 'KT';
            $berkas->bks_pid = $id;
            $savedSertifikat = $berkas->save();
        }

        if($request->hasFile('ijazah'))
        {
            $berkas = new d_berkas_pelamar;
            $ijazah = $request->file('ijazah');
            $path = public_path(). '/assets/berkas/dokumen-pelamar';
            $filename = $request->nama.'_'.$id.'_ijazah' . '.' . $ijazah->getClientOriginalExtension();
            $ijazah->move($path, $filename);
            // set field to table
            $berkas->bks_name = $filename;
            $berkas->bks_type = 'D';
            $berkas->bks_dtype = 'IJ';
            $berkas->bks_pid = $id;
            $savedIjazah = $berkas->save();
        }

        if($request->hasFile('file_lain_lain'))
        {
            $berkas = new d_berkas_pelamar;
            $file_lain_lain = $request->file('file_lain_lain');
            $path = public_path(). '/assets/berkas/dokumen-pelamar';
            $filename = $request->nama.'_'.$id.'_lain' . '.' . $file_lain_lain->getClientOriginalExtension();
            $file_lain_lain->move($path, $filename);
            // set field to table
            $berkas->bks_name = $filename;
            $berkas->bks_type = 'D';
            $berkas->bks_dtype = 'LL';
            $berkas->bks_pid = $id;
            $savedIjazah = $berkas->save();
        }

        //generate pdf
        $this->buat_pdf($id);
        DB::commit();
        // return redirect('/recruitment#apply')->with(['sukses' => 'Data berhasil disimpan, Anda Akan dihubungi apabila lolos administrasi. Terima Kasih']);
        $request->session()->flash('sukses', 'Data berhasil disimpan, Anda Akan dihubungi apabila lolos administrasi. Terima Kasih');
        return redirect('/recruitment#apply');
    }

    public function cekEmail(Request $request)
    {
        $e = trim($request->email);
        $data = d_pelamar::select('p_email')->where('p_email', '=', $e)->first();
        //dd($data);
        if (!empty($data) || isset($data)) {
          return response()->json([
            'status' => 'gagal',
            'pesan' => 'Email Telah terdaftar, Mohon cek kembali email anda'
          ]);
        }elseif ($e == null) {
          return response()->json([
              'status' => 'gagal',
              'pesan' => 'Mohon Input Email terlebih dahulu'
          ]);
        }else {
           return response()->json([
                'status' => 'sukses',
            ]);
        }
    }

    public function cekWa(Request $request)
    {
        $e = trim($request->wa);
        $data = d_pelamar::select('p_tlp')->where('p_tlp', '=', $e)->first();
        if (!empty($data) || isset($data)) {
            return response()->json([
                'status' => 'gagal',
                'pesan' => 'No Telp/WA Telah terdaftar, Mohon cek kembali'
            ]);
        }
        elseif ($e == null) {
            return response()->json([
                'status' => 'gagal',
                'pesan' => 'Mohon Input No Telp/WA terlebih dahulu'
            ]);
        }
        else{
           return response()->json([
                'status' => 'sukses'
            ]);
        }
    }

    public function getDataHrd(Request $request)
    {
        //dd($request->all());
        $y = substr($request->tgl1, -4);
        $m = substr($request->tgl1, -7, -5);
        $d = substr($request->tgl1, 0, 2);
        $tanggal1 = $y.'-'.$m.'-'.$d;

        $yy = substr($request->tgl2, -4);
        $mm = substr($request->tgl2, -7, -5);
        $dd = substr($request->tgl2, 0, 2);
        $tanggal2 = $yy.'-'.$mm.'-'.$dd;

        if($request->status == 'semua' && $request->grade == 'semua'){
            $data = d_pelamar::join('d_pelamar_status','d_pelamar.p_apply_status','=','d_pelamar_status.p_st_id')
                ->join('d_pelamar_statusdt','d_pelamar.p_apply_statusdt','=','d_pelamar_statusdt.p_stdt_id')
                ->select('d_pelamar.*', 'd_pelamar_status.*', 'd_pelamar_statusdt.*')
                ->whereBetween('d_pelamar.p_date', [$tanggal1, $tanggal2])
                ->orderBy('d_pelamar.p_created', 'DESC')
                ->get();
        }elseif ($request->grade == 'semua') {
            $data = d_pelamar::join('d_pelamar_status','d_pelamar.p_apply_status','=','d_pelamar_status.p_st_id')
                ->join('d_pelamar_statusdt','d_pelamar.p_apply_statusdt','=','d_pelamar_statusdt.p_stdt_id')
                ->select('d_pelamar.*', 'd_pelamar_status.*', 'd_pelamar_statusdt.*')
                ->where('d_pelamar.p_apply_status', $request->status)
                ->whereBetween('d_pelamar.p_date', [$tanggal1, $tanggal2])
                ->orderBy('d_pelamar.p_created', 'DESC')
                ->get();
        }elseif($request->status == 'semua'){
            $data = d_pelamar::join('d_pelamar_status','d_pelamar.p_apply_status','=','d_pelamar_status.p_st_id')
                ->join('d_pelamar_statusdt','d_pelamar.p_apply_statusdt','=','d_pelamar_statusdt.p_stdt_id')
                ->select('d_pelamar.*', 'd_pelamar_status.*', 'd_pelamar_statusdt.*')
                ->where('d_pelamar.p_education', $request->grade)
                ->whereBetween('d_pelamar.p_date', [$tanggal1, $tanggal2])
                ->orderBy('d_pelamar.p_created', 'DESC')
                ->get();
        }else{
            $data = d_pelamar::join('d_pelamar_status','d_pelamar.p_apply_status','=','d_pelamar_status.p_st_id')
                ->join('d_pelamar_statusdt','d_pelamar.p_apply_statusdt','=','d_pelamar_statusdt.p_stdt_id')
                ->select('d_pelamar.*', 'd_pelamar_status.*', 'd_pelamar_statusdt.*')
                ->where('d_pelamar.p_education', $request->grade)
                ->where('d_pelamar.p_apply_status', $request->status)
                ->whereBetween('d_pelamar.p_date', [$tanggal1, $tanggal2])
                ->orderBy('d_pelamar.p_created', 'DESC')
                ->get();
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('tglBuat', function ($data)
            {
                if ($data->p_created == null) {
                    return '-';
                } else {
                    return $data->p_created ? with(new Carbon($data->p_created))->format('d M Y') : '';
                }
            })
            ->editColumn('status', function ($data)
            {
                if ($data->p_apply_status == 1) {
                    return '<span style="color:#e557d0">'.$data->p_st_name.'</span>';
                }else{
                    return '<span>'.$data->p_st_name.'</span>';
                }
            })
            ->editColumn('statusdt', function ($data)
            {
                if ($data->p_apply_statusdt == 1) {
                    return '-';
                }elseif ($data->p_apply_statusdt == 9) {
                    return '<span style="color:blue">'.$data->p_stdt_name.'</span>';
                }elseif ($data->p_apply_statusdt == 2 || $data->p_apply_statusdt == 5 || $data->p_apply_statusdt == 8) {
                    return '<span style="color:red">'.$data->p_stdt_name.'</span>';
                }else{
                    return $data->p_stdt_name;
                }
            })
            ->addColumn('action', function($data)
            {
                return '<div class="text-center">
                            <a href="./preview_rekrut/'.$data->p_id.'" class="btn btn-sm btn-success" title="Preview">
                                <i class="glyphicon glyphicon-search"></i>
                            </a>
                            <a href="./process_rekrut/'.$data->p_id.'" class="btn btn-sm btn-info" title="Process">
                                <i class="glyphicon glyphicon-ok"></i>
                            </a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-danger" title="Delete" onclick=deleteDataPelamar("'.$data->p_id.'")>
                                <i class="glyphicon glyphicon-trash"></i>
                            </a>
                        </div>';
            })
            ->rawColumns(['status', 'action', 'statusdt'])
            ->make(true);
    }

    public function approval_1(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try
        {
            $id = DB::table('d_apply')->select('ap_id')->max('ap_id');
            if ($id == 0 || $id == '') { $id  = 1; } else { $id++; }

            $tanggal = date("Y-m-d h:i:s");
            $tgl = date("Y-m-d");

            //insert d_apply
            DB::table('d_apply')
                ->insert([
                    'ap_id'=>$id,
                    'ap_pid' => $request->id,
                    'ap_stid'=> 2,
                    'ap_stdt_id'=> $request->approval_1,
                    'ap_date'=> $tgl,
                    'ap_created'=> $tanggal
                ]);

            //update d_pelamar
            d_pelamar::where('p_id','=',$request->id)
                ->update([
                    'p_apply_status' => 2,
                    'p_apply_statusdt' => $request->approval_1,
                    'p_updated'=> $tanggal
                ]);

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Approval 1 Berhasil Disimpan'
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

    public function update_approval_1(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $tanggal = date("Y-m-d h:i:s");
            $tgl = date("Y-m-d");
            //get apply id
            $data_apply = DB::table('d_apply')->select('ap_id')->where('ap_pid', $request->id)->where('ap_stid', $request->status)->where('ap_stdt_id', $request->statusdt)->first();
            //update
            DB::table('d_apply')->where('ap_id', '=', $data_apply->ap_id)
                ->update([
                    'ap_stdt_id'=> $request->approval_1,
                    'ap_updated'=> $tanggal
                ]);
            //update d_pelamar
            d_pelamar::where('p_id','=',$request->id)
                ->update([
                    'p_apply_statusdt' => $request->approval_1,
                    'p_updated'=> $tanggal
                ]);

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Approval 1 Berhasil Diupdate'
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

    public function approval_2(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try
        {
            $id = DB::table('d_apply')->select('ap_id')->max('ap_id');
            if ($id == 0 || $id == '') { $id  = 1; } else { $id++; }

            $tanggal = date("Y-m-d h:i:s");
            $tgl = date("Y-m-d");

            //insert d_apply
            DB::table('d_apply')
                ->insert([
                    'ap_id'=>$id,
                    'ap_pid' => $request->id,
                    'ap_stid'=> 3,
                    'ap_stdt_id'=> $request->approval_2,
                    'ap_date'=> $tgl,
                    'ap_created'=> $tanggal
                ]);

            //update d_pelamar
            d_pelamar::where('p_id','=',$request->id)
                ->update([
                    'p_apply_status' => 3,
                    'p_apply_statusdt' => $request->approval_2,
                    'p_updated'=> $tanggal
                ]);

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Approval 2 Berhasil Disimpan'
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

    public function update_approval_2(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $tanggal = date("Y-m-d h:i:s");
            $tgl = date("Y-m-d");
            //get apply id
            $data_apply = DB::table('d_apply')->select('ap_id')->where('ap_pid', $request->id)->where('ap_stid', $request->status)->where('ap_stdt_id', $request->statusdt)->first();
            //update
            DB::table('d_apply')->where('ap_id', '=', $data_apply->ap_id)
                ->update([
                    'ap_stdt_id'=> $request->approval_2,
                    'ap_updated'=> $tanggal
                ]);
            //update d_pelamar
            d_pelamar::where('p_id','=',$request->id)
                ->update([
                    'p_apply_statusdt' => $request->approval_2,
                    'p_updated'=> $tanggal
                ]);

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Approval 2 Berhasil Diupdate'
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

    public function approval_3(Request $request)
    {
        DB::beginTransaction();
        try
        {
            //dd($request->all());
            $id = DB::table('d_apply')->select('ap_id')->max('ap_id');
            if ($id == 0 || $id == '') { $id  = 1; } else { $id++; }

            $tanggal = date("Y-m-d h:i:s");
            $tgl = date("Y-m-d");

            //insert d_apply
            DB::table('d_apply')
                ->insert([
                    'ap_id'=>$id,
                    'ap_pid' => $request->id,
                    'ap_stid'=> 4,
                    'ap_stdt_id'=> $request->approval_3,
                    'ap_date'=> $tgl,
                    'ap_created'=> $tanggal
                ]);

            //update d_pelamar
            d_pelamar::where('p_id','=',$request->id)
                ->update([
                    'p_apply_status' => 4,
                    'p_apply_statusdt' => $request->approval_3,
                    'p_updated'=> $tanggal
                ]);

            if ($request->approval_3 == '9')
            {
                $maxid = DB::Table('m_pegawai_man')->select('c_id_by_production')->where([
                    ['c_divisi_id', $request->get('c_divisi_id')],
                    ['c_jabatan_id', $request->get('c_jabatan_id')]
                ])->max('c_id_by_production');
                // untuk +1 nilai yang ada,, jika kosong maka maxid = 1 ,
                if ($maxid <= 0 || $maxid <= '') { $maxid  = 1; } else { $maxid += 1; }

                $nik = date('y', strtotime($tanggal)).str_pad($request->h_divisi, 2, '0', STR_PAD_LEFT).str_pad($request->h_level, 2, '0', STR_PAD_LEFT).str_pad($maxid, 3, '0', STR_PAD_LEFT);

                //$input['c_hari_kerja'] = $request->get('c_hari_awal')." - ".$request->get('c_hari_akhir');
                $pelamar = d_pelamar::where('p_id', $request->id)->first();
                if ($pelamar->p_status == 'S') { $nikah = 'Belum Menikah'; } else { $nikah = 'Menikah'; }
                $ttl = $pelamar->p_birth_place.", ".$this->tgl_indo($pelamar->p_birthday);

                DB::table('m_pegawai_man')
                    ->insert([
                        // 'c_id'=>$maxid,
                        'c_id_by_production' => $maxid,
                        'c_code'=> $this->kodePegawai(),
                        'c_nik'=> $nik,
                        'c_nama'=> $request->nama,
                        'c_ktp'=> 'KTP ('.$pelamar->p_nip.')',
                        'c_ktp_alamat'=> $pelamar->p_address,
                        'c_alamat'=> $pelamar->p_address_now,
                        'c_lahir'=> $ttl,
                        'c_pendidikan'=> $pelamar->p_education,
                        'c_email'=> $pelamar->p_email,
                        'c_hp'=> $pelamar->p_tlp,
                        'c_agama'=> $pelamar->p_religion,
                        'c_nikah'=> $nikah,
                        'c_pasangan'=> $pelamar->p_wife_name,
                        'c_anak'=> $pelamar->p_child,
                        'c_divisi_id'=> $request->h_divisi,
                        'c_jabatan_id'=> $request->h_posisi,
                        'c_shift_id'=> 1,
                        'created_at'=> $tanggal,
                    ]);
            }

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Approval 3 Berhasil Disimpan'
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

    public function deleteDataPelamar(Request $request)
    {
      //dd($request->all());
      DB::beginTransaction();
      try {
        $d_lamar = d_pelamar::where('p_id', $request->idpelamar)->first();
        $pegawai = DB::table('m_pegawai_man')
                    ->where('m_pegawai_man.c_nama', '=', $d_lamar->p_name)
                    ->where('m_pegawai_man.c_email', '=', $d_lamar->p_email)
                    ->where('m_pegawai_man.c_hp', '=', $d_lamar->p_tlp)
                    ->where('m_pegawai_man.c_ktp', '=', 'KTP ('.$d_lamar->p_nip.')')
                    ->first();

        if (!empty($data) || isset($data)) {
            //delete pegawai manajemen
            DB::table('m_pegawai_man')->where('c_id', $pegawai->c_id)->delete();
        }

        //delete row table d_apply
        DB::table('d_apply')->where('ap_pid', $request->idpelamar)->delete();
        //delete row table d_pelamar_jadwal
        DB::table('d_pelamar_jadwal')->where('pj_pid', $request->idpelamar)->delete();
        //delete row table d_cv_pelamar
        $data_cv = DB::table('d_cv_pelamar')->where('d_cv_pid', $request->idpelamar)->get();
        if (count($data_cv) > 0) {
            DB::table('d_cv_pelamar')->where('d_cv_pid', $request->idpelamar)->delete();
        }
        //unlink all file
        $berkas_foto = d_berkas_pelamar::where('bks_pid', $request->idpelamar)->where('bks_type', 'I')->get();
        $berkas_dokumen = d_berkas_pelamar::where('bks_pid', $request->idpelamar)->where('bks_type', 'D')->get();

        if(count($berkas_foto) > 0) {
            foreach ($berkas_foto as $val_img) {
                $img_path = public_path(). '/assets/berkas/foto-pelamar/'.$val_img->bks_name;
                if(File::exists($img_path)) {
                    File::delete($img_path);
                }
            }
        }

        if(count($berkas_dokumen) > 0) {
            foreach ($berkas_dokumen as $val_doc) {
                $doc_path = public_path(). '/assets/berkas/dokumen-pelamar/'.$val_doc->bks_name;
                if(File::exists($doc_path)) {
                    File::delete($doc_path);
                }
            }
        }

        //delete row table d_berkas_pelamar
        $data_berkas = d_berkas_pelamar::where('bks_pid', $request->idpelamar)->get();
        if (count($data_berkas) > 0) {
            d_berkas_pelamar::where('bks_pid', $request->idpelamar)->delete();
        }

        //delete row table d_pelamar
        d_pelamar::where('p_id', $request->idpelamar)->delete();

        DB::commit();
        return response()->json([
            'status' => 'sukses',
            'pesan' => 'Data Pelamar Berhasil Dihapus'
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

    public function autocomplete(Request $request)
    {
        //dd($request->all());
        $term = $request->term;
        $results = array();
        $queries = DB::table('m_pegawai_man')
            ->where('c_nama', 'LIKE', '%'.$term.'%')
            ->take(10)->get();

        if ($queries == null)
        {
            $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
        }
        else
        {
            foreach ($queries as $val)
            {
                $results[] = [ 'id' => $val->c_id, 'label' => $val->c_nik .'  '.$val->c_nama, ];
            }
        }

      return Response::json($results);
    }

    public function getJadwalInterview($id)
    {
        $data = d_pelamar_jadwal::join('d_pelamar','d_pelamar_jadwal.pj_pid','=','d_pelamar.p_id')
            ->join('m_pegawai_man','d_pelamar_jadwal.pj_pmid','=','m_pegawai_man.c_id')
            ->select('d_pelamar_jadwal.*', 'd_pelamar.*', 'm_pegawai_man.c_nama', 'm_pegawai_man.c_nik', 'm_pegawai_man.c_id')
            ->where('d_pelamar_jadwal.pj_pid', '=', $id)
            ->where('d_pelamar_jadwal.pj_type', '=', 'I')
            ->where('d_pelamar_jadwal.pj_isactive', '=', 'Y')
            ->get();

        return response()->json([
            'status' => 'sukses',
            'data' => $data
        ]);
    }

    public function procJadwalInterview(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try
        {
            $y = substr($request->i_tgl, -4);
            $m = substr($request->i_tgl, -7, -5);
            $d = substr($request->i_tgl, 0, 2);

            $tanggal = date("Y-m-d h:i:s");
            $tgl = $y.'-'.$m.'-'.$d;

            if ($request->i_pjadwal_id != null)
            {
                //update
                d_pelamar_jadwal::where('pj_id','=',$request->i_pjadwal_id)
                ->update([
                    'pj_pid' => $request->i_pelamarid,
                    'pj_pmid' => $request->i_pic_id,
                    'pj_date' => $tgl,
                    'pj_time' => $request->i_jam,
                    'pj_lokasi' => strtoupper($request->i_lokasi),
                    'pj_type' => 'I',
                    'pj_isactive' => 'Y',
                    'pj_updated' => $tanggal
                ]);
            }
            else
            {
                $id = d_pelamar_jadwal::select('pj_id')->max('pj_id');
                if ($id == 0 || $id == '') { $id  = 1; } else { $id++; }
                //insert
                $pj = new d_pelamar_jadwal;
                $pj->pj_id = $id;
                $pj->pj_pid = $request->i_pelamarid;
                $pj->pj_pmid = $request->i_pic_id;
                $pj->pj_date = $tgl;
                $pj->pj_time = $request->i_jam;
                $pj->pj_lokasi = strtoupper($request->i_lokasi);
                $pj->pj_type = 'I';
                $pj->pj_isactive = 'Y';
                $pj->pj_created = $tanggal;
                $pj->save();
            }

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Jadwal berhasil di simpan'
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

    public function getJadwalPresentasi($id)
    {
        $data = d_pelamar_jadwal::join('d_pelamar','d_pelamar_jadwal.pj_pid','=','d_pelamar.p_id')
            ->join('m_pegawai_man','d_pelamar_jadwal.pj_pmid','=','m_pegawai_man.c_id')
            ->select('d_pelamar_jadwal.*', 'd_pelamar.*', 'm_pegawai_man.c_nama', 'm_pegawai_man.c_nik', 'm_pegawai_man.c_id')
            ->where('d_pelamar_jadwal.pj_pid', '=', $id)
            ->where('d_pelamar_jadwal.pj_type', '=', 'P')
            ->where('d_pelamar_jadwal.pj_isactive', '=', 'Y')
            ->get();

        return response()->json([
            'status' => 'sukses',
            'data' => $data
        ]);
    }

    public function procJadwalPresentasi(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try
        {
            $y = substr($request->p_tgl, -4);
            $m = substr($request->p_tgl, -7, -5);
            $d = substr($request->p_tgl, 0, 2);

            $tanggal = date("Y-m-d h:i:s");
            $tgl = $y.'-'.$m.'-'.$d;

            if ($request->p_pjadwal_id != null)
            {
                //update
                d_pelamar_jadwal::where('pj_id','=',$request->p_pjadwal_id)
                ->update([
                    'pj_pid' => $request->p_pelamarid,
                    'pj_pmid' => $request->p_pic_id,
                    'pj_date' => $tgl,
                    'pj_time' => $request->p_jam,
                    'pj_lokasi' => strtoupper($request->p_lokasi),
                    'pj_type' => 'P',
                    'pj_isactive' => 'Y',
                    'pj_updated' => $tanggal
                ]);
            }
            else
            {
                $id = d_pelamar_jadwal::select('pj_id')->max('pj_id');
                if ($id == 0 || $id == '') { $id  = 1; } else { $id++; }
                //insert
                $pj = new d_pelamar_jadwal;
                $pj->pj_id = $id;
                $pj->pj_pid = $request->p_pelamarid;
                $pj->pj_pmid = $request->p_pic_id;
                $pj->pj_date = $tgl;
                $pj->pj_time = $request->p_jam;
                $pj->pj_lokasi = strtoupper($request->p_lokasi);
                $pj->pj_type = 'P';
                $pj->pj_isactive = 'Y';
                $pj->pj_created = $tanggal;
                $pj->save();
            }

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Jadwal berhasil di simpan'
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

    public function kodePegawai()
    {
        $tanggal = date("ym");
        $maxid = DB::Table('m_pegawai_man')->select('c_id')->max('c_id');
        if ($maxid <= 0 || $maxid <= '') { $maxid  = 1; }else { $maxid += 1; }

        $kode = str_pad($maxid, 2, '0', STR_PAD_LEFT);
        return $id_pegawai = 'PG-' . $tanggal . '/' .  $kode;
    }

    public function getDataHrdDiterima(Request $request)
    {
        //dd($request->all());
        $y = substr($request->tgl1, -4);
        $m = substr($request->tgl1, -7, -5);
        $d = substr($request->tgl1, 0, 2);
        $tanggal1 = $y.'-'.$m.'-'.$d;

        $yy = substr($request->tgl2, -4);
        $mm = substr($request->tgl2, -7, -5);
        $dd = substr($request->tgl2, 0, 2);
        $tanggal2 = $yy.'-'.$mm.'-'.$dd;

        if ($request->grade == 'semua') {
           $data = d_pelamar::join('d_pelamar_status','d_pelamar.p_apply_status','=','d_pelamar_status.p_st_id')
                ->join('d_pelamar_statusdt','d_pelamar.p_apply_statusdt','=','d_pelamar_statusdt.p_stdt_id')
                ->select('d_pelamar.*', 'd_pelamar_status.*', 'd_pelamar_statusdt.*')
                ->where('d_pelamar.p_apply_statusdt', '9')
                ->whereBetween('d_pelamar.p_date', [$tanggal1, $tanggal2])
                ->orderBy('d_pelamar.p_created', 'DESC')
                ->get();
            }else{
               $data = d_pelamar::join('d_pelamar_status','d_pelamar.p_apply_status','=','d_pelamar_status.p_st_id')
                ->join('d_pelamar_statusdt','d_pelamar.p_apply_statusdt','=','d_pelamar_statusdt.p_stdt_id')
                ->select('d_pelamar.*', 'd_pelamar_status.*', 'd_pelamar_statusdt.*')
                ->where('d_pelamar.p_apply_statusdt', '9')
                ->where('d_pelamar.p_education', $request->grade)
                ->whereBetween('d_pelamar.p_date', [$tanggal1, $tanggal2])
                ->orderBy('d_pelamar.p_created', 'DESC')
                ->get();
            }

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('tglBuat', function ($data)
            {
                if ($data->p_created == null) {
                    return '-';
                } else {
                    return $data->p_created ? with(new Carbon($data->p_created))->format('d M Y') : '';
                }
            })
            ->editColumn('status', function ($data)
            {
                if ($data->p_apply_status == 1) {
                    return '<span style="color:#e557d0">'.$data->p_st_name.'</span>';
                }else{
                    return '<span>'.$data->p_st_name.'</span>';
                }
            })
            ->editColumn('statusdt', function ($data)
            {
                if ($data->p_apply_statusdt == 1) {
                    return '-';
                }elseif ($data->p_apply_statusdt == 9) {
                    return '<span style="color:blue">'.$data->p_stdt_name.'</span>';
                }elseif ($data->p_apply_statusdt == 2 || $data->p_apply_statusdt == 5 || $data->p_apply_statusdt == 8) {
                    return '<span style="color:red">'.$data->p_stdt_name.'</span>';
                }else{
                    return $data->p_stdt_name;
                }
            })
            ->addColumn('action', function($data)
            {
                return '<div class="text-center">
                            <a href="./preview_rekrut/'.$data->p_id.'" class="btn btn-sm btn-success" title="Preview">
                                <i class="glyphicon glyphicon-search"></i>
                            </a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-info" title="Process" onclick=prosesPegBaru("'.$data->p_id.'","'.$data->p_isset_employee.'")>
                                <i class="glyphicon glyphicon-ok"></i>
                            </a>
                        </div>';
            })
            ->rawColumns(['status', 'action', 'statusdt'])
            ->make(true);
    }

    public function getDataSetPegawai($id, $p_empset)
    {
        if ($p_empset == 'N')
        {
            $data = d_pelamar::join('d_lowongan','d_pelamar.p_vacancyid','=','d_lowongan.l_id')
                ->join('m_divisi','d_lowongan.l_divisi','=','m_divisi.c_id')
                ->join('m_jabatan','d_lowongan.l_jabatan','=','m_jabatan.c_id')
                ->select('d_pelamar.*', 'd_lowongan.*', 'm_divisi.*', 'm_jabatan.*')
                ->where('d_pelamar.p_id', '=', $id)
                ->get();

            $data2 = array();
            $data2['nama'] = $data[0]->p_name;
            $data2['tgl_masuk'] = date("Y-m-d");
            $data2['hari_awal'] = 'Senin';
            $data2['hari_akhir'] = 'Senin';
            $data2['data_shift'] = '1';
            $data2['id_divisi'] = $data[0]->l_divisi;
            $data2['id_jabatan'] = $data[0]->l_jabatan;
        }
        else
        {
            $lamar = d_pelamar::where('p_id', $id)->first();
            $data = DB::table('m_pegawai_man')
                ->join('m_divisi','m_pegawai_man.c_divisi_id','=','m_divisi.c_id')
                ->join('m_jabatan','m_pegawai_man.c_jabatan_id','=','m_jabatan.c_id')
                ->select('m_pegawai_man.*', 'm_divisi.*', 'm_jabatan.*')
                ->where('m_pegawai_man.c_nama', '=', $lamar->p_name)
                ->where('m_pegawai_man.c_email', '=', $lamar->p_email)
                ->where('m_pegawai_man.c_hp', '=', $lamar->p_tlp)
                ->where('m_pegawai_man.c_ktp', '=', 'KTP ('.$lamar->p_nip.')')
                ->get();

            $data2 = array();
            $data2['nama'] = $data[0]->c_nama;

            if ($data[0]->c_tahun_masuk == '0000-00-00') {
                $data2['tgl_masuk'] = date("Y-m-d");
            }else{
                $data2['tgl_masuk'] = $data[0]->c_tahun_masuk;
            }

            if ($data[0]->c_hari_kerja == '' || $data[0]->c_hari_kerja == null) {
                $data2['hari_awal'] = 'Senin';
                $data2['hari_akhir'] = 'Senin';
            }else{
                $hari = explode(' - ', $data[0]->c_hari_kerja);
                $data2['hari_awal'] = $hari[0];
                $data2['hari_akhir'] = $hari[1];
            }

            $data2['data_shift'] = $data[0]->c_shift_id;
            $data2['id_divisi'] = $data[0]->c_divisi_id;
            $data2['id_jabatan'] = $data[0]->c_jabatan_id;
        }

        $d_lamar = d_pelamar::where('p_id', $id)->first();
        $d_pegman =  DB::table('m_pegawai_man')
                        ->where('m_pegawai_man.c_nama', '=', $d_lamar->p_name)
                        ->where('m_pegawai_man.c_email', '=', $d_lamar->p_email)
                        ->where('m_pegawai_man.c_hp', '=', $d_lamar->p_tlp)
                        ->where('m_pegawai_man.c_ktp', '=', 'KTP ('.$d_lamar->p_nip.')')
                        ->first();

        $data2['shift'] = DB::table('m_shift')->get();
        $data2['idpelamar'] = $id;

        return response()->json([
            'status' => 'sukses',
            'data' => $data,
            'data2' => $data2,
            'd_pegman' => $d_pegman
        ]);
    }

    public function simpanPegawaiBaru(Request $request)
    {
        DB::beginTransaction();
        try
        {
            //dd($request->all());
            $tanggal = date("Y-m-d h:i:s");
            $tgl = date("Y-m-d");

            //update m_pegawai_man
            DB::table('m_pegawai_man')->where('c_id','=',$request->tr_idpegman)
                ->update([
                    'c_hari_kerja' => $request->tr_hariawal.' - '.$request->tr_hariakhir,
                    'c_tahun_masuk' => date('Y-m-d',strtotime($request->tr_tgl)),
                    'c_shift_id' => $request->tr_shift,
                    'updated_at' => $tanggal
                ]);

             //update d_pelamar
             d_pelamar::where('p_id','=',$request->tr_idlamar)
                ->update([
                    'p_isset_employee' => 'Y',
                    'p_updated' => $tanggal
                ]);

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Sukses Atur data karyawan baru'
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

    public function tgl_indo($tanggal)
    {
        $bulan = array (
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        );
        $pecah = explode('-', $tanggal);

        // variabel pecah 0 = tahun
        // variabel pecah 1 = bulan
        // variabel pecah 2 = tanggal
        return $pecah[2].' '.$bulan[$pecah[1]].' ' .$pecah[0];
    }

    public function buat_pdf($id_pelamar)
    {
        $pelamar = d_pelamar::where('p_id', $id_pelamar)->first();
        $foto = d_berkas_pelamar::where('bks_pid', $id_pelamar)->where('bks_type', 'I')->first();
        $cv = d_cv_pelamar::where('d_cv_pid', $id_pelamar)->get();

        // Send data to the view using loadView function of PDF facade
        $pdf = PDF::loadView('hrd.recruitment.pdf-cv', array('pelamar' => $pelamar, 'foto' => $foto, 'cv' => $cv));
        $path_cv = public_path(). '/assets/berkas/dokumen-pelamar';
        $namafile = $pelamar->p_name.'_'.$id_pelamar.'_cv.pdf';
        //save
        $pdf->save($path_cv.'/'.$namafile);
        // file preview function
        //return $pdf->stream($namafile);
        //simpan pdf ke db
        $berkas_cv = new d_berkas_pelamar;
        $berkas_cv->bks_name = $namafile;
        $berkas_cv->bks_type = 'D';
        $berkas_cv->bks_dtype = 'CV';
        $berkas_cv->bks_pid = $id_pelamar;
        $berkas_cv->save();
    }
}
