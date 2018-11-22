<?php

namespace App\Http\Controllers\Master;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use App\Pegawai;
use App\PegawaiProduksi;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use DataTables;
use URL;
use Illuminate\Support\Facades\Input;
use Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PegawaiController extends Controller
{
    public function pegawai(){
        return view('master.datapegawai.pegawai');
    }

    public function pegawaiData(){
        $list = DB::table('m_pegawai_man')
                ->select('m_pegawai_man.*', 'm_jabatan.c_posisi')
                ->join('m_jabatan', 'm_pegawai_man.c_jabatan_id', '=', 'm_jabatan.c_id')
                ->get();
        $data = collect($list);
        return Datatables::of($data)           
                ->addColumn('action', function ($data) {
                         return  '<button id="edit" onclick="edit('.$data->c_id.')" class="btn btn-warning btn-sm" title="Edit"><i class="glyphicon glyphicon-pencil"></i></button>'.'
                                        <button id="delete" onclick="hapus('.$data->c_id.')" class="btn btn-danger btn-sm" title="Hapus"><i class="glyphicon glyphicon-trash"></i></button>';
                })
                ->addColumn('none', function ($data) {
                    return '-';
                })
                ->rawColumns(['action','confirmed'])
                ->make(true);
    }

    public function pegawaiPro(){
        $list = DB::table('m_pegawai_pro')
                ->select('m_pegawai_pro.*', 'm_jabatan_pro.c_jabatan_pro')
                ->join('m_jabatan_pro', 'm_pegawai_pro.c_jabatan_pro_id', '=', 'm_jabatan_pro.c_id')
                ->get();
        $data = collect($list);
        return Datatables::of($data)           
                ->addColumn('action', function ($data) {
                         return  '<button id="edit" onclick="editPro('.$data->c_id.')" class="btn btn-warning btn-sm" title="Edit"><i class="glyphicon glyphicon-pencil"></i></button>'.'
                                        <button id="delete" onclick="hapusPro('.$data->c_id.')" class="btn btn-danger btn-sm" title="Hapus"><i class="glyphicon glyphicon-trash"></i></button>';
                })
                ->addColumn('none', function ($data) {
                    return '-';
                })
                ->rawColumns(['action','confirmed'])
                ->make(true);
    }

    public function tambahPegawai(){
        $tanggal = date("ym");
        //select max dari c_id dari table m_pegawai_man
        $maxid = DB::Table('m_pegawai_man')->select('c_id')->max('c_id');
        //untuk +1 nilai yang ada,, jika kosong maka maxid = 1 , 
        if ($maxid <= 0 || $maxid <= '') {
          $maxid  = 1;
        }else{
          $maxid += 1;
        }
        $kode = str_pad($maxid, 2, '0', STR_PAD_LEFT);
        $id_pegawai = 'PG-' . $tanggal . '/' .  $kode;
        $divisi = DB::table('m_divisi')->get(); 
        $shift = DB::table('m_shift')->get();   
        return view('/master/datapegawai/tambah_pegawai', compact('id_pegawai','divisi','shift'));
    }

    public function tambahPegawaiPro(){
        $tanggal = date("ym");
        //select max dari c_id dari table m_pegawai_man
        $maxid = DB::Table('m_pegawai_man')->select('c_id')->max('c_id');
        //untuk +1 nilai yang ada,, jika kosong maka maxid = 1 , 
        if ($maxid <= 0 || $maxid <= '') {
          $maxid  = 1;
        }else{
          $maxid += 1;
        }
        $kode = str_pad($maxid, 2, '0', STR_PAD_LEFT);
        $id_pegawai = 'PG-' . $tanggal . '/' .  $kode;
        $tugas = DB::table('m_jabatan_pro')->get(); 
        return view('/master/datapegawai/tambah_pegawai_pro', compact('id_pegawai','tugas'));
    }

    public function jabatanData($id){
        $jabatan = DB::table('m_jabatan')->where('c_divisi_id', $id)->get();
        return json_encode($jabatan);
    }

    public function simpanPegawai(Request $request){
        DB::beginTransaction();
        try {
        $maxid = DB::Table('m_pegawai_man')->select('c_id_by_production')->where([
            ['c_divisi_id', $request->get('c_divisi_id')],
            ['c_jabatan_id', $request->get('c_jabatan_id')]
        ])->max('c_id_by_production');
        // untuk +1 nilai yang ada,, jika kosong maka maxid = 1 , 
        if ($maxid <= 0 || $maxid <= '') {
            $maxid  = 1;
        }else{
            $maxid += 1;
        }
        $input = $request->all();
        $input['c_id_by_production'] = $maxid;
        $section = explode("-",$request->get('c_jabatan_id'));
        $input['c_nik'] = date('y', strtotime($request->get('c_tahun_masuk'))).str_pad($request->get('c_divisi_id'), 2, '0', STR_PAD_LEFT).str_pad($section[1], 2, '0', STR_PAD_LEFT).str_pad($maxid, 3, '0', STR_PAD_LEFT);
        $input['c_hari_kerja'] = $request->get('c_hari_awal')." - ".$request->get('c_hari_akhir'); 
        $input['c_jabatan_id'] = $section[0];
        $input['c_lahir'] = $request->get('c_tempat').", ".$request->get('c_tanggal');
        // dd($input);exit;
        $data = Pegawai::create($input);
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

    public function simpanPegawaiPro(Request $request){
        $maxid = DB::Table('m_pegawai_pro')->select('c_id_by_production')->where([
            ['c_jabatan_pro_id', $request->get('c_jabatan_pro_id')],
            ['c_rumah_produksi', $request->get('c_rumah_produksi')]
        ])->max('c_id_by_production');
        // untuk +1 nilai yang ada,, jika kosong maka maxid = 1 , 
        if ($maxid <= 0 || $maxid <= '') {
            $maxid  = 1;
        }else{
            $maxid += 1;
        }
        $input = $request->all();
        $input['c_id_by_production'] = $maxid;
        if($request->get('c_jabatan_pro_id') == 7){
            $input['c_nik'] = "4".str_pad($request->get('c_rumah_produksi'), 2, '0', STR_PAD_LEFT)."-".str_pad($request->get('c_jabatan_pro_id'), 2, '0', STR_PAD_LEFT).$request->get('c_rumah_produksi')."-".str_pad($maxid, 3, '0', STR_PAD_LEFT);
        }else{
            $input['c_nik'] = "4".str_pad($request->get('c_rumah_produksi'), 2, '0', STR_PAD_LEFT)."-".str_pad($request->get('c_jabatan_pro_id'), 2, '0', STR_PAD_LEFT)."-".str_pad($maxid, 3, '0', STR_PAD_LEFT);
        }
        // dd($input);exit;
        $data = PegawaiProduksi::create($input);
        return redirect('/master/datapegawai/pegawai');
    }

    public function editPegawai($id){
        $divisi = DB::table('m_divisi')->get(); 
        $shift = DB::table('m_shift')->get();  
        $data = DB::table('m_pegawai_man')->where('c_id', $id)->first();
        $hari = explode(" - ",$data->c_hari_kerja);
        // dd($data->c_hari_kerja);
        $data->c_hari_awal = $hari[0];
        $data->c_hari_akhir = $hari[1];
        if($data->c_lahir){
            $lahir = explode(", ",$data->c_lahir);
            $data->c_tempat = $lahir[0];
            $data->tgl_lahir = $lahir[1];
        }else{
            $data->c_tempat = "-";
            $data->tgl_lahir = "-";
        }
        return view('master.datapegawai.edit_pegawai',['data' => $data, 'divisi'=> $divisi, 'shift' => $shift]);
    }

    public function editPegawaiPro($id){
        $tugas = DB::table('m_jabatan_pro')->get(); 
        $data = DB::table('m_pegawai_pro')->where('c_id', $id)->first();
        return view('master.datapegawai.edit_pegawai_pro',['data' => $data, 'tugas'=> $tugas]);
    }

    public function updatePegawai(Request $request, $id){
        // dd($request->all());
        DB::beginTransaction();
        try {
        $input = $request->except('_token', '_method','c_hari_awal','c_hari_akhir','c_tempat','c_tanggal');
        $section = explode("-",$request->get('c_jabatan_id'));
        // $input['c_nik'] = date('y', strtotime($request->get('c_tahun_masuk'))).str_pad($request->get('c_divisi_id'), 2, '0', STR_PAD_LEFT).str_pad($section[1], 2, '0', STR_PAD_LEFT).str_pad($maxid, 3, '0', STR_PAD_LEFT);
        $input['c_jabatan_id'] = $section[0];
        $input['c_hari_kerja'] = $request->get('c_hari_awal')." - ".$request->get('c_hari_akhir'); 
        // $input['c_section_id'] = ltrim($section[1], '0');
        $input['c_lahir'] = $request->get('c_tempat').", ".$request->get('c_tanggal');
        // dd($section);
        $data = Pegawai::where('c_id', $id)->update($input);
        // dd($input);exit;
        // $data = Pegawai::create($input);
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

    public function updatePegawaiPro(Request $request, $id){
        $input = $request->except('_token', '_method');
        
        $data = PegawaiProduksi::where('c_id', $id)->update($input);
        return redirect('master/datapegawai/pegawai');
    }

    public function deletePegawaiPro($id){
        $data = DB::table('m_pegawai_pro')->where('c_id', $id)->delete();

        return redirect('master/datapegawai/pegawai');
    }

    public function deletePegawai($id){
        $data = DB::table('m_pegawai_man')->where('c_id', $id)->delete();

        return redirect('master/datapegawai/pegawai');
    }
    public function importPegawai(){
		if(Input::hasFile('import_file')){
			$path = Input::file('import_file')->getRealPath();
			$data = Excel::load($path, function($reader) {
			})->get();
			if(!empty($data) && $data->count()){
				foreach ($data as $key => $value) {
					$insert[] = [
                        'c_code' => $value->c_code,
                        'c_id_by_production' => $value->c_id_by_production,
                        'c_nik' => $value->c_nik,
                        'c_nama' => $value->c_nama,
                        'c_tahun_masuk' => $value->c_tahun_masuk,
                        'c_hari_kerja' => $value->c_hari_kerja,
                        'c_divisi_id' => $value->c_divisi_id,
                        'c_ktp' => $value->c_ktp,
                        'c_ktp_alamat' => $value->c_ktp_alamat,
                        'c_alamat' => $value->c_alamat,
                        'c_lahir' => $value->c_lahir,
                        'c_pendidikan' => $value->c_pendidikan,
                        'c_email' => $value->c_email,
                        'c_hp' => $value->c_hp,
                        'c_agama' => $value->c_agama,
                        'c_nikah' => $value->c_nikah,
                        'c_pasangan' => $value->c_pasangan,
                        'c_anak' => $value->c_anak,
                        'c_bank' => $value->c_bank,
                        'c_rekening' => $value->c_rekening,
                        'c_sertification' => $value->c_sertification,
                        'c_sertif_tahun' => $value->c_sertif_tahun,
                        'c_sertif_tempat' => $value->c_sertif_tempat,
                        'c_jabatan_id' => $value->c_jabatan_id,
                        'c_shift_id' => $value->c_shift_id
                    ];
                    //  print_r($insert);exit;
				}
				if(!empty($insert)){
					DB::table('m_pegawai_man')->insert($insert);
					dd('Insert Record successfully.');
				}
			}
		}
		return back();
    }
    public function importPegawaiPro(){
		if(Input::hasFile('import_file')){
			$path = Input::file('import_file')->getRealPath();
			$data = Excel::load($path, function($reader) {
			})->get();
			if(!empty($data) && $data->count()){
				foreach ($data as $key => $value) {
                    $tanggal = explode(" ",$value->c_tahun_masuk);
                    $nik = explode("-",$value->c_nik);
                    print_r($value);exit;
                    $c_id_by_production = ltrim($nik[2], 0);
                    $c_rumah_produksi = substr($nik[0], 2);
					$insert[] = [
                        'c_code' => $value->c_code,
                        'c_id_by_production' => $c_id_by_production,
                        'c_nik' => $value->c_nik,
                        'c_nama' => $value->c_nama,
                        'c_jabatan_pro_id' => $value->c_jabatan_pro_id,
                        'c_rumah_produksi' => $c_rumah_produksi,
                        'c_tahun_masuk' => $tanggal[0]
                    ];
				}
				if(!empty($insert)){
					DB::table('m_pegawai_pro')->insert($insert);
					dd('Insert Record successfully.');
				}
			}
        }
        
		return back();
    }
    public function getFile(){
        $file_path = storage_path('file/pegawai-manajemen.csv');
        return Response::download($file_path);
    }
    public function getFilePro(){
        $file_path = storage_path('file/pegawai.xls');
        return Response::download($file_path);
    }
}
