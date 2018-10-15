<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\abs_pegawai_man;
use App\m_pegawai_man;
use App\Model\Hrd\d_payroll_man;
use App\Model\Hrd\d_payroll_mandt;
use App\Model\Hrd\d_lembur;
use App\Model\Hrd\d_potongan;
use Response;
use DB;
use DataTables;
use Auth;

class PayrollmanController extends Controller
{
    public function index()
    {
        $data = DB::table('m_divisi')->select('c_id', 'c_divisi')->get();
        return view('hrd/payrollman/index', compact('data'));
    }

    public function listGajiManajemen(Request $request)
    {
        $tanggal_a = date('Y-m-d',strtotime($request->tgl1));
        $tanggal_b = date('Y-m-d',strtotime($request->tgl2));
        //$jml_hari = cal_days_in_month(CAL_GREGORIAN, $request->bln, $request->thn);
        //$tanggal = date('Y-m-d',strtotime($tgl1));
        
        if ($request->status == 'ALL' && $request->divisi == 'semua') {
            $data = d_payroll_man::join('m_pegawai_man','d_payroll_man.d_pm_pid','=','m_pegawai_man.c_id')
                        ->select('d_payroll_man.*', 'm_pegawai_man.*')
                        ->whereBetween('d_payroll_man.d_pm_date', [$tanggal_a, $tanggal_b])
                        ->orderBy('d_payroll_man.d_pm_created', 'DESC')->get();
        }elseif ($request->status == 'ALL') {
            $data = d_payroll_man::join('m_pegawai_man','d_payroll_man.d_pm_pid','=','m_pegawai_man.c_id')
                        ->select('d_payroll_man.*', 'm_pegawai_man.*')
                        ->where('m_pegawai_man.c_divisi_id', $request->divisi)
                        ->whereBetween('d_payroll_man.d_pm_date', [$tanggal_a, $tanggal_b])
                        ->orderBy('d_payroll_man.d_pm_created', 'DESC')->get();
        }elseif ($request->divisi == 'semua') {
            $data = d_payroll_man::join('m_pegawai_man','d_payroll_man.d_pm_pid','=','m_pegawai_man.c_id')
                        ->select('d_payroll_man.*', 'm_pegawai_man.*')
                        ->where('d_payroll_man.d_pm_iscetak', '=', $request->status)
                        ->whereBetween('d_payroll_man.d_pm_date', [$tanggal_a, $tanggal_b])
                        ->orderBy('d_payroll_man.d_pm_created', 'DESC')->get();
        }else{  
            $data = d_payroll_man::join('m_pegawai_man','d_payroll_man.d_pm_pid','=','m_pegawai_man.c_id')
                        ->select('d_payroll_man.*', 'm_pegawai_man.*')
                        ->where('d_payroll_man.d_pm_iscetak', '=', $request->status)
                        ->where('m_pegawai_man.c_divisi_id', $request->divisi)
                        ->whereBetween('d_payroll_man.d_pm_date', [$tanggal_a, $tanggal_b])
                        ->orderBy('d_payroll_man.d_pm_created', 'DESC')->get();
        }
        //dd($data);
        
        return DataTables::of($data)
        ->editColumn('tglBuat', function ($data) 
        {
            if ($data->d_pm_date == null) {
                return '-';
            } else {
                return $data->d_pm_date ? with(new Carbon($data->d_pm_date))->format('d M Y') : '';
            }
        })
        ->editColumn('tglCetak', function ($data) 
        {
            if ($data->d_pm_datecetak == '0000-00-00') {
                return '-';
            } else {
                return $data->d_pm_datecetak ? with(new Carbon($data->d_pm_datecetak))->format('d M Y') : '';
            }
        })
        ->editColumn('totGaji', function ($data) 
        {
            return 'Rp. '.number_format($data->d_pm_totalnett,2,",",".");
        })
        ->addColumn('action', function($data)
        { 
            return '<div class="text-center">
                        <button class="btn btn-sm btn-success" title="Detail"
                            onclick=detailPman("'.$data->d_pm_id.'")><i class="fa fa-info-circle"></i> 
                        </button>
                        <button class="btn btn-sm btn-danger" title="Batalkan Konfirmasi"
                            onclick=hapusPman("'.$data->d_pm_id.'")><i class="fa fa-times-circle"></i>
                        </button>
                    </div>';  
        })
        ->rawColumns(['action','status'])
        ->make(true);
    }

    public function lookupDivisi(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term)) 
        {
            $divisi = DB::table('m_divisi')->orderBy('c_divisi', 'ASC')->limit(10)->get();
            foreach ($divisi as $val) {
                $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_divisi];
            }
            return Response::json($formatted_tags);
        }
        else
        {  
            $divisi = DB::table('m_divisi')->where('c_divisi', 'LIKE', '%'.$term.'%')->orderBy('c_divisi', 'ASC')->limit(10)->get();
            foreach ($divisi as $val) {
                $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_divisi];
            }
            return Response::json($formatted_tags);  
        }
    }

    public function lookupJabatan(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term)) 
        {
            $jabatan = DB::table('m_jabatan')->where('c_divisi_id', $request->divisi)->orderBy('c_posisi', 'ASC')->limit(10)->get();
            foreach ($jabatan as $val) {
                $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_posisi];
            }
            return Response::json($formatted_tags);
        }
        else
        {  
            $jabatan = DB::table('m_jabatan')->where('c_divisi_id', $request->divisi)->where('c_posisi', 'LIKE', '%'.$term.'%')->orderBy('c_posisi', 'ASC')->limit(10)->get();
            foreach ($jabatan as $val) {
                $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_posisi];
            }
            return Response::json($formatted_tags);  
        }
    }

    public function lookupPegawai(Request $request)
    {
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term)) 
        {
            $pegawai = DB::table('m_pegawai_man')->where('c_divisi_id', $request->divisi)->where('c_jabatan_id', $request->jabatan)->orderBy('c_nama', 'ASC')->limit(10)->get();
            foreach ($pegawai as $val) {
                $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_nama];
            }
            return Response::json($formatted_tags);
        }
        else
        {  
            $pegawai = DB::table('m_pegawai_man')->where('c_divisi_id', $request->divisi)->where('c_jabatan_id', $request->jabatan)->where('c_nama', 'LIKE', '%'.$term.'%')->orderBy('c_nama', 'ASC')->limit(10)->get();
            foreach ($pegawai as $val) {
                $formatted_tags[] = ['id' => $val->c_id, 'text' => $val->c_nama];
            }
            return Response::json($formatted_tags);  
        }
    }

    public function setFieldModal(Request $request)
    {
        //pertanggalan
        $tahun = date("Y");
        $tanggal_a = date('Y-m-d',strtotime($request->sDate));
        $tanggal_b = date('Y-m-d',strtotime($request->lDate));
        //tgl minggu dalam periode yang ditentukan
        $tgl_minggu = $this->cariMinggu($tanggal_a, $tanggal_b);
        //hitung jumlah lembur pada hari minggu
        $jml_lembur_minggu = 0;
        $datalembur = d_lembur::select('d_lembur_id', 'd_lembur_date')->where('d_lembur_jenispeg', 'MAN')->where('d_lembur_pid', $request->pegawai)->whereBetween('d_lembur_date', [$tanggal_a, $tanggal_b])->get();
        foreach ($datalembur as $aa) {
            for ($i=0; $i <count($tgl_minggu); $i++) {
                if ($aa->d_lembur_date != $tgl_minggu[$i]) {
                    $jml_lembur_minggu += 0; 
                } else {
                    $jml_lembur_minggu += 1; 
                }
            }
        }

        //data pegawai
        $d_pegawai = m_pegawai_man::select('c_anak','c_nikah','c_pendidikan', 'c_tunjangan', 'c_tahun_masuk')->where('c_id', $request->pegawai)->first();

        //pendidikan
        if ($d_pegawai->c_pendidikan == 'S2') {
            $akronim_title = 'c_s1';
        }else{
            $akronim_title = strtolower('c_'.$d_pegawai->c_pendidikan);
        }

        //gaji pokok
        $gj = DB::table('m_gaji_man')->select($akronim_title)->first();
        $gapok = (int)$gj->$akronim_title;

        //level pegawai
        $lp = DB::table('m_jabatan')->select('c_sub_divisi_id')->where('c_id', $request->jabatan)->where('c_divisi_id', $request->divisi)->first();
        $lvl_peg = $lp->c_sub_divisi_id;

        //kelola data absensi
        $d_absen = abs_pegawai_man::where('apm_pm', $request->pegawai)->whereBetween('apm_tanggal', [$tanggal_a, $tanggal_b])->get();

        //kelola tunjangan
        if (count($d_absen) > 0) {
            foreach ($d_absen as $val) {
                if ($val->apm_absent != null) { $alpha[] = $val->apm_absent; } else { $hadir[] = $val->apm_absent; }
                if ($val->apm_lembur != null) { $lembur[] = $val->apm_lembur; } else { $lembur[] = "01:00:00"; }
                if ($val->apm_scan_masuk != null) { $dt_scanmasuk[] = $val->apm_tanggal.' '.$val->apm_scan_masuk; } else { $dt_scanmasuk[] = null; }
                if ($val->apm_jam_masuk != null) { $dt_jammasuk[] = $val->apm_tanggal.' '.$val->apm_jam_masuk; } else { $dt_jammasuk[] = null; }
            }
        }
        //dd($lembur);
        //dd($dt_scanmasuk, $dt_jammasuk);

        //hitung lembur jam reguler
        $jam_lembur = 0;
        for ($i=0; $i < count($lembur); $i++) {
            $d_lembur = explode(':', $lembur[$i]);
            if ($d_lembur[1] <= '30') { 
                $jam_lembur += (int)$d_lembur[0];
            }else{
                $jam_lembur += ((int)$d_lembur[0] + 1);
            }
        }

        $tunjangan = DB::table('m_tunjangan_man')->get();
        $list = explode(",", $d_pegawai->c_tunjangan);
        foreach ($tunjangan as $value) 
        {
            for ($z=0; $z <count($list); $z++) 
            { 
                if ($value->tman_id == $list[$z] && $value->tman_periode == "HR") 
                { 
                    $income[] = (int)$value->tman_value * count($hadir);
                    $arr_pot[] = (int)$value->tman_value;
                    //$t_hdrmkn = (int)$value->tman_value * count($hadir);
                }
                elseif($value->tman_id == $list[$z] && $value->tman_periode == "ST" && $list[$z] == "6")
                {
                    $income[] = (int)$value->tman_value * $d_pegawai->c_anak;
                }
                elseif($value->tman_id == $list[$z] && $value->tman_periode == "ST" && $list[$z] == "7")
                {
                    if ($d_pegawai->c_nikah == 'Menikah') { $income[] = (int)$value->tman_value; }else{ $income[] = 0; }
                }
                elseif($value->tman_id == $list[$z] && $value->tman_periode == "ST" && $list[$z] == "14")
                {
                    //$thnmasuk = explode('-', $d_pegawai->c_tahun_masuk);
                    if ($d_pegawai->c_tahun_masuk == '0000-00-00') {
                        $tahun_msk = (int)date('Y');
                    }else{
                        $tahun_msk = (int)date('Y',strtotime($d_pegawai->c_tahun_masuk));    
                    }
                    $income[] = ((int)date('Y') - $tahun_msk) * (int)$value->tman_value;
                }
                elseif($value->tman_id == $list[$z] && $value->tman_periode == "ST")
                {
                    $income[] = (int)$value->tman_value; 
                }
                elseif($value->tman_id == $list[$z] && $value->tman_periode == "JM")
                {
                    $income[] = (int)$value->tman_value * $jam_lembur; 
                }
                elseif($value->tman_id == $list[$z] && $value->tman_periode == "MG")
                {
                    $income[] = (int)$value->tman_value * $jml_lembur_minggu;
                }
            }
        }
        
        //cari selisih jam scan terhadap jam masuk
        for ($x=0; $x <count($dt_scanmasuk); $x++) 
        { 
            if ($dt_scanmasuk[$x] != null) 
            {
                $datetime1 = strtotime($dt_jammasuk[$x]);
                $datetime2 = strtotime($dt_scanmasuk[$x]);
                $interval  = $datetime2 - $datetime1;
                $hasil_menit[] = (int)round($interval / 60);
            }
        }
        //dd($hasil_menit);
        //hitung menit telat dan berapa nilainya
        $potongan = 0;
        $ngentot = [];
        $nilai_tunjangan = [];
        $potonganTxt = [];
        for ($y=0; $y <count($hasil_menit); $y++) 
        {   
            $ngentot = $arr_pot;
            if ($hasil_menit[$y] > 0 && $hasil_menit[$y] <= 15) {
                unset($ngentot[1]);
                unset($ngentot[2]);
                $potongan += array_sum($ngentot);
                $potonganTxt[] = array('harian' => array_sum($ngentot),'harianmakan' => 0, 'harianmakantrans' => 0);
            }elseif ($hasil_menit[$y] > 15 && $hasil_menit[$y] <= 30) {
                unset($ngentot[2]);
                $potongan += array_sum($ngentot);
                $potonganTxt[] = array('harian' => 0,'harianmakan' => array_sum($ngentot), 'harianmakantrans' => 0);
            }elseif ($hasil_menit[$y] > 30) {
                $potongan += array_sum($ngentot);
                $potonganTxt[] = array('harian' => 0,'harianmakan' => 0, 'harianmakantrans' => array_sum($ngentot));
            }else{
                $potongan += 0;
            }
        }
        //dd($potonganTxt, $potongan);
        $total_tunjangan = array_sum($income);
        $nilai_tunjangan = $income;
        array_push($income, $gapok);
        $total_income = array_sum($income) - $potongan;
        return response()->json([
            'status' => 'sukses',
            'gapok' => $gapok,
            'list' => $list,
            'nilai_tunjangan' => $nilai_tunjangan,
            'total_tunjangan' => $total_tunjangan,
            'total_income' => $total_income,
            'potongan' => $potongan,
            'potonganTxt' => $potonganTxt
        ]);
    }

    public function simpanData(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {
            $datetime =  Carbon::now('Asia/Jakarta');
            $date = $datetime->toDateString();
            $periode = $request->i_tgl1." s/d ".$request->i_tgl2;
            $kode = $this->kodePayrollAuto();
            $lastId = d_payroll_man::select('d_pm_id')->max('d_pm_id');
            if ($lastId == 0 || $lastId == '') { $lastId  = 1; } else { $lastId += 1; } 
            //insert to table d_terimapembelian
            $proll = new d_payroll_man;
            $proll->d_pm_id = $lastId;
            $proll->d_pm_code = $kode;
            $proll->d_pm_pid = $request->i_pegawai;
            $proll->d_pm_date = $date;
            $proll->d_pm_periode = $periode;
            $proll->d_pm_gapok = str_replace('.', '', $request->i_gapok);
            $proll->d_pm_totaltun = str_replace('.', '', $request->i_tunjangan);
            $proll->d_pm_totalpot = str_replace('.', '', $request->i_potongan);
            $proll->d_pm_totalnett = str_replace('.', '', $request->i_totgaji);
            $proll->d_pm_created = $datetime;
            $proll->save();

            for ($i=0; $i < count($request->index_tunjangan); $i++) 
            {
                $prolldt = new d_payroll_mandt;
                $prolldt->d_pmdt_pmid = $lastId;
                $prolldt->d_pmdt_type = "TJ";
                $prolldt->d_pmdt_typeid = $request->index_tunjangan[$i];
                $prolldt->d_pmdt_nilai = $request->nilai_tunjangan[$i];
                $prolldt->d_pmdt_created = $datetime;
                $prolldt->save();
            }

            //potongan kehadiran
            if (isset($request->harian)) {
                for ($i=0; $i < count($request->harian); $i++) 
                {
                    if ($request->harian[$i] != 0) {
                        $pharian = new d_potongan;
                        $pharian->d_pot_pid = $request->i_pegawai;
                        $pharian->d_pot_prollid = $lastId;
                        $pharian->d_pot_keterangan = "Potongan Kehadiran";
                        $pharian->d_pot_date = $date;
                        $pharian->d_pot_value = $request->harian[$i];
                        $pharian->d_pot_created = $datetime;
                        $pharian->save();
                    }
                    
                }
            }
            
            //potongan kehadiran + makan
            if (isset($request->harianmakan)) {
                for ($i=0; $i < count($request->harianmakan); $i++) 
                {
                    if ($request->harianmakan[$i] != 0) {
                        $pharianmakan = new d_potongan;
                        $pharianmakan->d_pot_pid = $request->i_pegawai;
                        $pharianmakan->d_pot_prollid = $lastId;
                        $pharianmakan->d_pot_keterangan = "Potongan Kehadiran & Makan";
                        $pharianmakan->d_pot_date = $date;
                        $pharianmakan->d_pot_value = $request->harianmakan[$i];
                        $pharianmakan->d_pot_created = $datetime;
                        $pharianmakan->save();
                    }
                    
                }
            }
            
            //potongan kehadiran + makan + transport
            if (isset($request->harianmakantrans)) {
                for ($i=0; $i < count($request->harianmakantrans); $i++) 
                {
                    if ($request->harianmakantrans[$i] != 0) {
                        $pharianmakantrans = new d_potongan;
                        $pharianmakantrans->d_pot_pid = $request->i_pegawai;
                        $pharianmakantrans->d_pot_prollid = $lastId;
                        $pharianmakantrans->d_pot_keterangan = "Potongan Kehadiran, Makan & Transport";
                        $pharianmakantrans->d_pot_date = $date;
                        $pharianmakantrans->d_pot_value = $request->harianmakantrans[$i];
                        $pharianmakantrans->d_pot_created = $datetime;
                        $pharianmakantrans->save();
                    }
                }
            }
            

            $prolldt2 = new d_payroll_mandt;
            $prolldt2->d_pmdt_pmid = $lastId;
            $prolldt2->d_pmdt_type = "GJ";
            $prolldt2->d_pmdt_typeid = null;
            $prolldt2->d_pmdt_nilai = str_replace('.', '', $request->i_gapok);
            $prolldt2->d_pmdt_created = $datetime;
            $prolldt2->save();

            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Payroll Pegawai Manajemen Berhasil Disimpan'
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

    public function getDataDetail($id)
    {
        $payroll = d_payroll_man::join('m_pegawai_man', 'd_payroll_man.d_pm_pid', '=', 'm_pegawai_man.c_id')
                            ->join('m_divisi', 'm_pegawai_man.c_divisi_id', '=', 'm_divisi.c_id')
                            ->join('m_jabatan', 'm_pegawai_man.c_jabatan_id', '=', 'm_jabatan.c_id')
                            ->select('d_payroll_man.*', 'm_pegawai_man.c_id', 'm_pegawai_man.c_nama' ,'m_pegawai_man.c_divisi_id', 'm_pegawai_man.c_jabatan_id', 'm_pegawai_man.c_tunjangan', 'm_divisi.c_divisi', 'm_jabatan.c_posisi', 'm_jabatan.c_sub_divisi_id')
                            ->where('d_payroll_man.d_pm_id', $id)->first();

        //$list = explode(",", $payroll->c_tunjangan);

        $list_tunjangan = d_payroll_mandt::join('d_payroll_man', 'd_payroll_mandt.d_pmdt_pmid', '=', 'd_payroll_man.d_pm_id')
                            ->join('m_tunjangan_man', 'd_payroll_mandt.d_pmdt_typeid', '=', 'm_tunjangan_man.tman_id')
                            ->select('d_payroll_mandt.*', 'd_payroll_man.*', 'm_tunjangan_man.*')
                            ->where('d_payroll_mandt.d_pmdt_type', "TJ")
                            ->where('d_payroll_mandt.d_pmdt_pmid', $id)
                            ->get();

        $list_gaji = d_payroll_mandt::select('d_pmdt_nilai')->where('d_pmdt_type', "GJ")->where('d_pmdt_pmid', $id)->first();
        $list_potongan = d_potongan::where('d_pot_prollid', $id)->where('d_pot_pid', $payroll->c_id)->get();

        //dd($payroll, $list_tunjangan, $list_gaji);

        return response()->json([
            'status' => 'sukses',
            'payroll' => $payroll,
            'list_tunjangan' => $list_tunjangan,
            'list_gaji' => $list_gaji,
            'list_potongan' => $list_potongan
        ]);
    }

    public function deleteData(Request $request)
    {
      DB::beginTransaction();
      try {
        d_payroll_mandt::where('d_pmdt_pmid', $request->id)->delete();
        d_payroll_man::where('d_pm_id', $request->id)->delete();
        d_potongan::where('d_pot_prollid', $request->id)->delete();

        DB::commit();
        return response()->json([
            'status' => 'sukses',
            'pesan' => 'Data Payroll Berhasil Dihapus'
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

    public function cariMinggu($start, $end) 
    {
        $timestamp1 = strtotime($start);
        $timestamp2 = strtotime($end);
        $sundays    = array();
        $oneDay     = 60*60*24;

        for($i = $timestamp1; $i <= $timestamp2; $i += $oneDay) {
            $day = date('N', $i);
            // If sunday
            if($day == 7) {
                // Save sunday in format YYYY-MM-DD, if you need just timestamp
                // save only $i
                $sundays[] = date('Y-m-d', $i);

                // Since we know it is sunday, we can simply skip 
                // next 6 days so we get right to next sunday
                $i += 6 * $oneDay;
            }
        }

        return $sundays;
    }

    public function kodePayrollAuto()
    {
        $query = DB::select(DB::raw("SELECT MAX(RIGHT(d_pm_code,4)) as kode_max from d_payroll_man WHERE DATE_FORMAT(d_pm_created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));
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

        return $code = "PAY-".date('ym')."-".$kd;
    }

    // ===============================================================================================================

    public function print_payroll($id)
    {
        $payroll = d_payroll_man::join('m_pegawai_man', 'd_payroll_man.d_pm_pid', '=', 'm_pegawai_man.c_id')
                            ->join('m_divisi', 'm_pegawai_man.c_divisi_id', '=', 'm_divisi.c_id')
                            ->join('m_jabatan', 'm_pegawai_man.c_jabatan_id', '=', 'm_jabatan.c_id')
                            ->select('d_payroll_man.*', 'm_pegawai_man.c_id', 'm_pegawai_man.c_nama' ,'m_pegawai_man.c_divisi_id', 'm_pegawai_man.c_jabatan_id', 'm_pegawai_man.c_tunjangan', 'm_divisi.c_divisi', 'm_jabatan.c_posisi', 'm_jabatan.c_sub_divisi_id')
                            ->where('d_payroll_man.d_pm_id', $id)->first();

        //$list = explode(",", $payroll->c_tunjangan);

        $list_tunjangan = d_payroll_mandt::join('d_payroll_man', 'd_payroll_mandt.d_pmdt_pmid', '=', 'd_payroll_man.d_pm_id')
                            ->join('m_tunjangan_man', 'd_payroll_mandt.d_pmdt_typeid', '=', 'm_tunjangan_man.tman_id')
                            ->select('d_payroll_mandt.*', 'd_payroll_man.*', 'm_tunjangan_man.*')
                            ->where('d_payroll_mandt.d_pmdt_type', "TJ")
                            ->where('d_payroll_mandt.d_pmdt_pmid', $id)
                            ->get();

        $list_gaji = d_payroll_mandt::select('d_pmdt_nilai')->where('d_pmdt_type', "GJ")->where('d_pmdt_pmid', $id)->first();
        $list_potongan = d_potongan::where('d_pot_prollid', $id)->where('d_pot_pid', $payroll->c_id)->get();

        //dd($payroll, $list_tunjangan, $list_gaji);

        // return response()->json([
        //     'status' => 'sukses',
        //     'payroll' => $payroll,
        //     'list_tunjangan' => $list_tunjangan,
        //     'list_gaji' => $list_gaji,
        //     'list_potongan' => $list_potongan
        // ]);

        return view('hrd.payrollman.print-payroll', [ 'rocknroll' => $payroll , 'tunjangan' => $list_tunjangan , 'gaji' => $list_gaji, 'potongan' => $list_potongan ]);
    }
}
