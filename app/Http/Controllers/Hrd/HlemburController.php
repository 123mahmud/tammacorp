<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Model\Hrd\d_lembur;
use Response;
use DB;
use DataTables;
use Auth;

class HlemburController extends Controller
{
    public function index()
    {
        return view('hrd/datalembur/index');
    }

    public function lookup_divisi(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        $jenis_peg = $request->jenis;
        if (empty($term)) 
        {
            if ($jenis_peg == 'man') {
                $jabatan = DB::table('m_divisi')->where('c_isactive','TRUE')->orderBy('c_divisi', 'ASC')->limit(10)->get();
                foreach ($jabatan as $val) {
                    $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_divisi];
                }
            } elseif ($jenis_peg == 'pro') {
                $jabatan = DB::table('m_divisi')->where('c_id', '4')->orderBy('c_divisi', 'ASC')->limit(10)->get();
                foreach ($jabatan as $val) {
                    $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_divisi];
                }
            }

            return Response::json($formatted_tags);
        }
        else
        {
            if ($jenis_peg == 'man') {
                $jabatan = DB::table('m_divisi')->where('c_divisi', 'LIKE', '%'.$term.'%')->where('c_isactive','TRUE')->orderBy('c_divisi', 'ASC')->limit(10)->get();
                foreach ($jabatan as $val) {
                    $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_divisi];
                }
            } elseif ($jenis_peg == 'pro') {
                $jabatan = DB::table('m_divisi')->where('c_id', '4')->orderBy('c_divisi', 'ASC')->limit(10)->get();
                foreach ($jabatan as $val) {
                    $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_divisi];
                }
            }

          return Response::json($formatted_tags);  
        }
    }

    public function lookup_jabatan(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        $divisi = $request->divisi;
        $jenis_peg = $request->jenis;
        if (empty($term)) 
        {
            if ($jenis_peg == 'man') {
                $jabatan = DB::table('m_jabatan')->where('c_isactive','TRUE')->where('c_divisi_id', $divisi)->orderBy('c_posisi', 'ASC')->limit(10)->get();
                foreach ($jabatan as $val) {
                    $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_posisi];
                }
            } elseif ($jenis_peg == 'pro') {
                $jabatan = DB::table('m_jabatan_pro')->where('c_isactive','TRUE')->orderBy('c_jabatan_pro', 'ASC')->limit(10)->get();
                foreach ($jabatan as $val) {
                    $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_jabatan_pro];
                }
            }
            return Response::json($formatted_tags);
        }
        else
        {
            if ($jenis_peg == 'man') {
                $jabatan = DB::table('m_jabatan')->where('c_isactive','TRUE')->where('c_divisi_id', $divisi)->where('c_posisi', 'LIKE', '%'.$term.'%')->orderBy('c_posisi', 'ASC')->limit(10)->get();
                foreach ($jabatan as $val) {
                    $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_posisi];
                }
            } elseif ($jenis_peg == 'pro') {
                $jabatan = DB::table('m_jabatan_pro')->where('c_isactive','TRUE')->where('c_jabatan_pro', 'LIKE', '%'.$term.'%')->orderBy('c_jabatan_pro', 'ASC')->limit(10)->get();
                foreach ($jabatan as $val) {
                    $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_jabatan_pro];
                }
            }

            return Response::json($formatted_tags);  
        }
    }

    public function lookup_pegawai(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        $divisi = $request->divisi;
        $jabatan = $request->jabatan;
        $jenis_peg = $request->jenis;
        if (empty($term)) 
        {
            if ($jenis_peg == 'man') {
                $pegawai = DB::table('m_pegawai_man')->where('c_isactive','TRUE')->where('c_divisi_id', $divisi)->where('c_jabatan_id', $jabatan)->orderBy('c_nama', 'ASC')->limit(10)->get();
                foreach ($pegawai as $val) {
                    $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_nama];
                }
            } elseif ($jenis_peg == 'pro') {
                $pegawai = DB::table('m_pegawai_pro')->where('c_isactive','TRUE')->where('c_jabatan_pro_id', $jabatan)->orderBy('c_nama', 'ASC')->limit(10)->get();
                foreach ($pegawai as $val) {
                    $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_nama];
                }
            }
            return Response::json($formatted_tags);
        }
        else
        {
            if ($jenis_peg == 'man') {
                $pegawai = DB::table('m_pegawai_man')->where('c_isactive','TRUE')->where('c_divisi_id', $divisi)->where('c_jabatan_id', $jabatan)->where('c_nama', 'LIKE', '%'.$term.'%')->orderBy('c_nama', 'ASC')->limit(10)->get();
                foreach ($pegawai as $val) {
                    $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_nama];
                }
            } elseif ($jenis_peg == 'pro') {
                $pegawai = DB::table('m_pegawai_pro')->where('c_isactive','TRUE')->where('c_jabatan_pro_id', $jabatan)->where('c_nama', 'LIKE', '%'.$term.'%')->orderBy('c_nama', 'ASC')->limit(10)->get();
                foreach ($pegawai as $val) {
                    $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_nama];
                }
            }

            return Response::json($formatted_tags);  
        }
    }

    public function getLemburByTgl($tgl1, $tgl2)
    {
        $tanggal1 = date('Y-m-d',strtotime($tgl1));
        $tanggal2 = date('Y-m-d',strtotime($tgl2));
        $data = d_lembur::whereBetween('d_lembur_date', [$tanggal1, $tanggal2])->orderBy('d_lembur_created', 'DESC')->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('tglBuat', function ($data) 
        {
            if ($data->d_lembur_date == null) {
                return '-';
            } else {
                return $data->d_lembur_date ? with(new Carbon($data->d_lembur_date))->format('d M Y') : '';
            }
        })
        ->editColumn('jenis_peg', function ($data) 
        {
            if ($data->d_lembur_jenispeg == "MAN") {
                return 'Manajemen';
            } else {
                return 'Produksi';
            }
        })
        ->addColumn('action', function($data)
        { 
            return '<div class="text-center">
                        <button class="btn btn-sm btn-success" title="Detail"
                            onclick=detailLembur("'.$data->d_lembur_id.'","'.$data->d_lembur_jenispeg.'")><i class="fa fa-info-circle"></i> 
                        </button>
                        <button class="btn btn-sm btn-warning" title="Edit"
                            onclick=editLembur("'.$data->d_lembur_id.'","'.$data->d_lembur_jenispeg.'")><i class="fa fa-edit"></i> 
                        </button>
                        <button class="btn btn-sm btn-danger" title="Hapus"
                            onclick=hapuslLembur("'.$data->d_lembur_id.'")><i class="fa fa-times-circle"></i> 
                        </button>
                    </div>';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function getDataDetail($id, $jenis)
    {
        if ($jenis == "MAN") {
            $data = d_lembur::join('m_pegawai_man','d_lembur.d_lembur_pid','=','m_pegawai_man.c_id')
                            ->join('m_divisi', 'm_pegawai_man.c_divisi_id', '=', 'm_divisi.c_id')
                            ->join('m_jabatan', 'm_pegawai_man.c_jabatan_id', '=', 'm_jabatan.c_id')
                            ->select('d_lembur.*', 'm_pegawai_man.*', 'm_divisi.*', 'm_jabatan.*')
                            ->where('d_lembur.d_lembur_id', $id)
                            ->get();
            $divisi = $data[0]->c_divisi;
            $jabatan = $data[0]->c_posisi;
            $pegawai = $data[0]->c_nama;
        }else{
            $data = d_lembur::join('m_pegawai_pro','d_lembur.d_lembur_pid','=','m_pegawai_pro.c_id')
                            ->join('m_jabatan_pro', 'm_pegawai_pro.c_jabatan_pro_id', '=', 'm_jabatan_pro.c_id')
                            ->select('d_lembur.*', 'm_pegawai_pro.*', 'm_jabatan_pro.*')
                            ->where('d_lembur.d_lembur_id', $id)
                            ->get();
            $divisi = "Produksi";
            $jabatan = $data[0]->c_jabatan_pro;
            $pegawai = $data[0]->c_nama;
        }
        
        return response()->json([
            'status' => 'sukses',
            'data' => $data,
            'divisi' => $divisi,
            'jabatan' => $jabatan,
            'pegawai' => $pegawai
        ]);
    }

    public function getDataEdit($id, $jenis)
    {
        if ($jenis == "MAN") {
            $data = d_lembur::join('m_pegawai_man','d_lembur.d_lembur_pid','=','m_pegawai_man.c_id')
                            ->join('m_divisi', 'm_pegawai_man.c_divisi_id', '=', 'm_divisi.c_id')
                            ->join('m_jabatan', 'm_pegawai_man.c_jabatan_id', '=', 'm_jabatan.c_id')
                            ->select('d_lembur.*', 'm_pegawai_man.c_id', 'm_pegawai_man.c_nama', 'm_pegawai_man.c_divisi_id', 'm_pegawai_man.c_jabatan_id', 'm_divisi.*', 'm_jabatan.*')
                            ->where('d_lembur.d_lembur_id', $id)
                            ->get();

            $divisi = $data[0]->c_divisi_id;
            $jabatan = $data[0]->c_jabatan_id;
            $pegawai = $data[0]->d_lembur_nama;
            $divisiTxt = $data[0]->c_divisi;
            $jabatanTxt = $data[0]->c_posisi;
        }else{
            $data = d_lembur::join('m_pegawai_pro','d_lembur.d_lembur_pid','=','m_pegawai_pro.c_id')
                            ->join('m_jabatan_pro', 'm_pegawai_pro.c_jabatan_pro_id', '=', 'm_jabatan_pro.c_id')
                            ->select('d_lembur.*', 'm_pegawai_pro.c_id', 'm_pegawai_pro.c_jabatan_pro_id', 'm_jabatan_pro.*')
                            ->where('d_lembur.d_lembur_id', $id)
                            ->get();
            
            $divisi = "4";
            $jabatan = $data[0]->c_jabatan_pro_id;
            $pegawai = $data[0]->d_lembur_nama;
            $divisiTxt = "Produksi";
            $jabatanTxt = $data[0]->c_jabatan_pro;
        }
        
        return response()->json([
            'status' => 'sukses',
            'data' => $data,
            'divisi' => $divisi,
            'jabatan' => $jabatan,
            'pegawai' => $pegawai,
            'divisiTxt' => $divisiTxt,
            'jabatanTxt' => $jabatanTxt
        ]);
    }
    
    public function simpanLembur(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {
            //code penerimaan
            $kode = $this->kodeLemburAuto();
            $lastId = d_lembur::select('d_lembur_id')->max('d_lembur_id');
            if ($lastId == 0 || $lastId == '') { $lastId  = 1; } else { $lastId += 1; } 
            //insert to table d_terimapembelian
            $lembur = new d_lembur;
            $lembur->d_lembur_id = $lastId;
            $lembur->d_lembur_code = $kode;
            $lembur->d_lembur_date = date('Y-m-d',strtotime($request->tglLembur));
            $lembur->d_lembur_jenispeg = strtoupper($request->jenis_pegawai);
            $lembur->d_lembur_pid = $request->pegawai;
            $lembur->d_lembur_nama = $request->namapeg;
            $lembur->d_lembur_stime = $request->jamAwal;
            $lembur->d_lembur_etime = $request->jamAkhir;
            $lembur->d_lembur_keperluan = strtoupper($request->keperluan);
            $lembur->d_lembur_created = date("Y-m-d h:i:s");
            $lembur->save();
            DB::commit();
            return response()->json([
                'status' => 'sukses',
                'pesan' => 'Data Lembur Berhasil Disimpan'
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

    public function updateLembur(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {   
            $tanggal = date("Y-m-d h:i:s");
            d_lembur::where('d_lembur_id','=',$request->lemburid_edit)
                ->update([
                    'd_lembur_date' => date('Y-m-d',strtotime($request->tglLemburEdit)),
                    'd_lembur_jenispeg' => strtoupper($request->jenis_pegawai_edit),
                    'd_lembur_pid' => $request->pegawai_edit,
                    'd_lembur_nama' => $request->namapeg_edit,
                    'd_lembur_stime' => $request->jamAwalEdit,
                    'd_lembur_etime' => $request->jamAkhirEdit,
                    'd_lembur_keperluan' => strtoupper($request->keperluan_edit),
                    'd_lembur_updated' => $tanggal
                ]);

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Lembur Berhasil Diupdate'
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

    public function deleteLembur(Request $request)
    {
      DB::beginTransaction();
      try {
        d_lembur::where('d_lembur_id', $request->id)->delete();
        DB::commit();
        return response()->json([
            'status' => 'sukses',
            'pesan' => 'Data Lembur Berhasil Dihapus'
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

    public function print($id, $jenis)
    {
        if ($jenis == "MAN") {
            $data = d_lembur::join('m_pegawai_man','d_lembur.d_lembur_pid','=','m_pegawai_man.c_id')
                            ->join('m_divisi', 'm_pegawai_man.c_divisi_id', '=', 'm_divisi.c_id')
                            ->join('m_jabatan', 'm_pegawai_man.c_jabatan_id', '=', 'm_jabatan.c_id')
                            ->select('d_lembur.*', 'm_pegawai_man.c_id', 'm_pegawai_man.c_nik', 'm_pegawai_man.c_nama', 'm_pegawai_man.c_divisi_id', 'm_pegawai_man.c_jabatan_id', 'm_divisi.*', 'm_jabatan.*')
                            ->where('d_lembur.d_lembur_id', $id)
                            ->get();

            $data2 = array(
                'divisi' => $data[0]->c_divisi_id,
                'jabatan' => $data[0]->c_jabatan_id,
                'pegawai' => $data[0]->d_lembur_nama,
                'divisiTxt' => $data[0]->c_divisi,
                'jabatanTxt' => $data[0]->c_posisi,
                'hari_indo' => $this->hari_indo($data[0]->d_lembur_date),
                'tgl_indo' => $this->tgl_indo($data[0]->d_lembur_date)
            );
        }else{
            $data = d_lembur::join('m_pegawai_pro','d_lembur.d_lembur_pid','=','m_pegawai_pro.c_id')
                            ->join('m_jabatan_pro', 'm_pegawai_pro.c_jabatan_pro_id', '=', 'm_jabatan_pro.c_id')
                            ->select('d_lembur.*', 'm_pegawai_pro.c_id', 'm_pegawai_pro.c_nik', 'm_pegawai_pro.c_jabatan_pro_id', 'm_jabatan_pro.*')
                            ->where('d_lembur.d_lembur_id', $id)
                            ->get();
            $data2 = array(
                'divisi' => "4",
                'jabatan' => $data[0]->c_jabatan_pro_id,
                'pegawai' => $data[0]->d_lembur_nama,
                'divisiTxt' => "Produksi",
                'jabatanTxt' => $data[0]->c_jabatan_pro,
                'hari_indo' => $this->hari_indo($data[0]->d_lembur_date),
                'tgl_indo' => $this->tgl_indo($data[0]->d_lembur_date)
            );   
        }

        // return response()->json([
        //     'status' => 'sukses',
        //     'data' => $data,
        //     'data2' => $data2
        // ]);

        return view('hrd/datalembur/form-lembur-print', ['data' => $data, 'data2' => $data2]);
    }

    public function kodeLemburAuto()
    {
        $query = DB::select(DB::raw("SELECT MAX(RIGHT(d_lembur_code,4)) as kode_max from d_lembur WHERE DATE_FORMAT(d_lembur_created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));
        $kd = "";

        if(count($query)>0)
        {
          foreach($query as $k)
          {
            $tmp = ((int)$k->kode_max)+1;
            $kd = sprintf("%04s", $tmp);
          }
        }
        else
        {
          $kd = "0001";
        }

        return $code = "LBR-".date('ym')."-".$kd;
    }

    public function hari_indo($tanggal)
    {
        $hari = date('D',strtotime($tanggal));
     
        switch($hari){
            case 'Sun':
                $hari_ini = "Minggu";
            break;
     
            case 'Mon':         
                $hari_ini = "Senin";
            break;
     
            case 'Tue':
                $hari_ini = "Selasa";
            break;
     
            case 'Wed':
                $hari_ini = "Rabu";
            break;
     
            case 'Thu':
                $hari_ini = "Kamis";
            break;
     
            case 'Fri':
                $hari_ini = "Jumat";
            break;
     
            case 'Sat':
                $hari_ini = "Sabtu";
            break;
            
            default:
                $hari_ini = "Undefined";     
            break;
        }
     
        return $hari_ini;
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
}
