<?php

namespace App\Http\Controllers\keuangan\periode_keuangan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Keuangan\d_akun as akun;

use DataTables;
use DB;
use Session;

class periode_controller extends Controller
{
    public function index(){
    	return view('keuangan.periode_keuangan.index');
    }

    public function list_periode(){
    	$list = DB::table("d_periode_keuangan as a")
        				->select("a.*")
        				->orderBy("pk_periode", "desc")->get();
        
        return json_encode($list);
    }

    public function store(Request $request){
    	// return json_encode($request->all());

        // return response()->json([
        //     'status'    => 'berhasil',
        //     'flag'      => 'success',
        //     'content'   => 'Periode Baru Berhasil Disimpan.',
        //     // 'context'   => $data,
        // ]);

    	$bulan = explode('-', $request->bulan_periode)[1].'-'.explode('-', $request->bulan_periode)[0].'-01';
    	$cek = DB::table('d_periode_keuangan')->where('pk_periode', '>', $bulan)->first();
        $cek2 = DB::table('d_periode_keuangan')->where('pk_periode', '=', $bulan)->first();

    	if($cek){
    		return response()->json([
	            'status'    => 'gagal',
	            'flag'      => 'error',
	            'content'   => 'Anda Tidak Bisa Menambahkan Bulan Yang Sudah Berlalu.',
	            'data'		=> null
	        ]);
    	}else if($cek2){
            return response()->json([
                'status'    => 'gagal',
                'flag'      => 'error',
                'content'   => 'Periode Untuk Bulan Yang Dipilih Sudah Dibuat...',
                'data'      => null
            ]);
        }

    	$id = (DB::table('d_periode_keuangan')->max('pk_id')) ? (DB::table('d_periode_keuangan')->max('pk_id') + 1) : '1';

    	$data = [
    		'pk_id'			=> $id,
    		'pk_periode'	=> $bulan,
    		'pk_status'		=> $request->status_periode,
    	];

    	DB::table('d_periode_keuangan')->insert($data);

    	return response()->json([
            'status'    => 'berhasil',
            'flag'      => 'success',
            'content'   => 'Periode Baru Berhasil Disimpan.',
            'context'	=> $data,
        ]);
    }

    public function update(Request $request){
        // return json_encode($request->all());
        $periode = DB::table('d_periode_keuangan')->where('pk_id', $request->id);

        if(!$periode->first()){
            return response()->json([
                'status'    => 'gagal',
                'flag'      => 'error',
                'content'   => 'Periode Yang Dipilih Tidak Detemukan. Cobalah Untuk Muat Ulang Halaman ...',
                'data'      => null
            ]);
        }

        $periode->update([
            'pk_status' => $request->status_periode
        ]);

        return response()->json([
            'status'    => 'berhasil',
            'flag'      => 'success',
            'content'   => 'Periode Berhasil Diubah.',
            'context'   => $request->all(),
        ]);
    }

    public function delete(Request $request){
        $periode = DB::table('d_periode_keuangan')->where('pk_id', $request->id);

        if(!$periode->first()){
            return response()->json([
                'status'    => 'gagal',
                'flag'      => 'error',
                'content'   => 'Periode Yang Dipilih Tidak Detemukan. Cobalah Untuk Muat Ulang Halaman ...',
                'data'      => null
            ]);
        }else if(strtotime($periode->first()->pk_periode) <= strtotime(date('Y-m-d'))){
            return response()->json([
                'status'    => 'gagal',
                'flag'      => 'error',
                'content'   => 'Tidak Bisa Menghapus Periode Yang Sudah/Masih Berjalan ...',
                'data'      => null
            ]);
        }

        $periode->delete();

        return response()->json([
            'status'    => 'berhasil',
            'flag'      => 'success',
            'content'   => 'Periode Berhasil Dihapus.',
            'context'   => $request->all(),
        ]);
    }

    public function integrasi(Request $request){
        // return json_encode($request->all());

        $periode = DB::table('d_periode_keuangan')->where('pk_id', $request->id)->first();

        if(!$periode || date('Y-m', strtotime($periode->pk_periode)) != date('Y-m') || $periode->pk_status != '1'){
            return response()->json([
                'status'    => 'gagal',
                'flag'      => 'error',
                'content'   => 'Integrasi Gagal. Pastikan Periode Pada Bulan Ini Sudah Dibuat Dan Berstatus \'Aktif\'',
                'data'      => null
            ]);
        }

        // DB::table('d_periode_keuangan')->update([
        //     'pk_status'     => '0'
        // ]);

        // DB::table('d_periode_keuangan')->where('pk_id', $request->id)->update([
        //     'pk_status'     => '1'
        // ]);

        // $aktiva = DB::table('d_aktiva')
                        // ->join('d_golongan_aktiva', 'd_golongan_aktiva.ga_nomor', '=', 'd_aktiva.a_kelompok')
                        // ->where('a_tanggal_beli', '<=', $periode->pk_periode)
                        // ->where('a_tanggal_habis', '>=', $periode->pk_periode)
                        // ->where('a_status', 'active')
                        // ->select('d_aktiva.*', 'd_golongan_aktiva.ga_akun_harta', 'd_golongan_aktiva.ga_akun_penyusutan', 'd_golongan_aktiva.ga_akun_akumulasi')
                        // ->get();

        // foreach($aktiva as $key => $value){
        //     $penyusutan = DB::table('dk_aktiva_detail')
        //                         ->where('ad_aktiva', $value->a_id)
        //                         ->where('ad_tahun', date('Y', strtotime($periode->pk_periode)))
        //                         ->first();
        //     if($penyusutan){

        //         $acc = [];
        //         $nilaiPenyusutan = $penyusutan->ad_penyusutan / $penyusutan->ad_jumlah_bulan;

        //         $acc[$value->ga_akun_penyusutan] = [
        //             'td_acc'    => $value->ga_akun_penyusutan,
        //             'td_posisi' => 'D',
        //             'value'     => $nilaiPenyusutan
        //         ];

        //         $acc[$value->ga_akun_akumulasi] = [
        //             'td_acc'    => $value->ga_akun_akumulasi,
        //             'td_posisi' => 'K',
        //             'value'     => $nilaiPenyusutan
        //         ];

        //         $state_jurnal = _initiateJournal_self_detail($value->a_nomor, 'MM', date('Y-m-d', strtotime($periode->pk_periode)), 'Penyusutan Atas Aset '.$value->a_name.' ('.$value->a_nomor.'),  Periode Bulan '.date('m/Y', strtotime($periode->pk_periode)), $acc);

        //         $nilai_sisa = $value->a_nilai_sisa - $nilaiPenyusutan;

        //         DB::table('d_aktiva')->where('a_id', $value->a_id)->update([
        //             'a_nilai_sisa'  => $nilai_sisa
        //         ]);

        //     }else{
        //         return json_encode("err");
        //     }

        //     // return json_encode($acc);
        // }

        // return json_encode($aktiva);

        $saldo = DB::table('d_akun_saldo')->get();
        $insert = [];
        $d1 = $periode->pk_periode;
        $d2 = date('Y-m-d', strtotime('+1  months', strtotime($d1)));
        $d3 = date('Y-m-d', strtotime('-1  months', strtotime($d1)));

        $akun = akun::select('id_akun as id_akun', 'posisi_akun', DB::raw('coalesce(opening_balance, 0) as saldo_akun'))
                ->with([
                      'mutasi_kas_debet' => function($query) use ($d1, $d2, $d3){
                            $query->whereIn('jrdt_jurnal', function($alpha) use ($d1, $d2, $d3){
                            $alpha->select('jurnal_id')
                                    ->from('d_jurnal')
                                    ->where("d_jurnal.tanggal_jurnal", ">=", $d1)
                                    ->where("d_jurnal.tanggal_jurnal", "<", $d2)
                                    ->where(DB::raw('substring(d_jurnal.no_jurnal,1,1)'), "K")
                                    ->distinct('d_jurnal.jurnal_id')->get();
                            })
                            ->where("jrdt_dk", "D")
                            ->groupBy('jrdt_acc')
                            ->select('jrdt_acc', DB::raw('sum(coalesce(abs(jrdt_value), 0)) as total'));
                      },
                      'mutasi_kas_kredit' => function($query) use ($d1, $d2, $d3){
                            $query->whereIn('jrdt_jurnal', function($alpha) use ($d1, $d2, $d3){
                            $alpha->select('jurnal_id')
                                    ->from('d_jurnal')
                                    ->where("d_jurnal.tanggal_jurnal", ">=", $d1)
                                    ->where("d_jurnal.tanggal_jurnal", "<", $d2)
                                    ->where(DB::raw('substring(d_jurnal.no_jurnal,1,1)'), "K")
                                    ->distinct('d_jurnal.jurnal_id')->get();
                            })
                            ->where("jrdt_dk", "K")
                            ->groupBy('jrdt_acc')
                            ->select('jrdt_acc', DB::raw('sum(coalesce(abs(jrdt_value), 0)) as total'));
                      },
                      'mutasi_bank_debet' => function($query) use ($d1, $d2, $d3){
                            $query->whereIn('jrdt_jurnal', function($alpha) use ($d1, $d2, $d3){
                            $alpha->select('jurnal_id')
                                    ->from('d_jurnal')
                                    ->where("d_jurnal.tanggal_jurnal", ">=", $d1)
                                    ->where("d_jurnal.tanggal_jurnal", "<", $d2)
                                    ->where(DB::raw('substring(d_jurnal.no_jurnal,1,1)'), "B")
                                    ->distinct('d_jurnal.jurnal_id')->get();
                            })
                            ->where("jrdt_dk", "D")
                            ->groupBy('jrdt_acc')
                            ->select('jrdt_acc', DB::raw('sum(coalesce(abs(jrdt_value), 0)) as total'));
                      },
                      'mutasi_bank_kredit' => function($query) use ($d1, $d2, $d3){
                            $query->whereIn('jrdt_jurnal', function($alpha) use ($d1, $d2, $d3){
                            $alpha->select('jurnal_id')
                                    ->from('d_jurnal')
                                    ->where("d_jurnal.tanggal_jurnal", ">=", $d1)
                                    ->where("d_jurnal.tanggal_jurnal", "<", $d2)
                                    ->where(DB::raw('substring(d_jurnal.no_jurnal,1,1)'), "B")
                                    ->distinct('d_jurnal.jurnal_id')->get();
                            })
                            ->where("jrdt_dk", "K")
                            ->groupBy('jrdt_acc')
                            ->select('jrdt_acc', DB::raw('sum(coalesce(abs(jrdt_value), 0)) as total'));
                      },
                      'mutasi_memorial_debet' => function($query) use ($d1, $d2, $d3){
                            $query->whereIn('jrdt_jurnal', function($alpha) use ($d1, $d2, $d3){
                            $alpha->select('jurnal_id')
                                    ->from('d_jurnal')
                                    ->where("d_jurnal.tanggal_jurnal", ">=", $d1)
                                    ->where("d_jurnal.tanggal_jurnal", "<", $d2)
                                    ->where(DB::raw('substring(d_jurnal.no_jurnal,1,1)'), "M")
                                    ->distinct('d_jurnal.jurnal_id')->get();
                            })
                            ->where("jrdt_dk", "D")
                            ->groupBy('jrdt_acc')
                            ->select('jrdt_acc', DB::raw('sum(coalesce(abs(jrdt_value), 0)) as total'));
                      },
                      'mutasi_memorial_kredit' => function($query) use ($d1, $d2, $d3){
                            $query->whereIn('jrdt_jurnal', function($alpha) use ($d1, $d2, $d3){
                            $alpha->select('jurnal_id')
                                    ->from('d_jurnal')
                                    ->where("d_jurnal.tanggal_jurnal", ">=", $d1)
                                    ->where("d_jurnal.tanggal_jurnal", "<", $d2)
                                    ->where(DB::raw('substring(d_jurnal.no_jurnal,1,1)'), "M")
                                    ->distinct('d_jurnal.jurnal_id')->get();
                            })
                            ->where("jrdt_dk", "K")
                            ->groupBy('jrdt_acc')
                            ->select('jrdt_acc', DB::raw('sum(coalesce(abs(jrdt_value), 0)) as total'));
                      },
                ])
                ->where('type_akun', 'DETAIL')
                ->get();

        foreach ($akun as $key => $data) {
            $plus = $minus = 0;
            $mutasiKasDebet         = (count($data->mutasi_kas_debet) > 0) ? $data->mutasi_kas_debet[0]['total'] : 0;
            $mutasiKasKredit        = (count($data->mutasi_kas_kredit) > 0) ? $data->mutasi_kas_kredit[0]['total'] : 0;
            $mutasiBankDebet        = (count($data->mutasi_bank_debet) > 0) ? $data->mutasi_bank_debet[0]['total'] : 0;
            $mutasiBankKredit       = (count($data->mutasi_bank_kredit) > 0) ? $data->mutasi_bank_kredit[0]['total'] : 0;
            $mutasiMemorialDebet    = (count($data->mutasi_memorial_debet) > 0) ? $data->mutasi_memorial_debet[0]['total'] : 0;
            $mutasiMemorialKredit   = (count($data->mutasi_memorial_kredit) > 0) ? $data->mutasi_memorial_kredit[0]['total'] : 0;

            if($data->posisi_akun == "D"){
                $plus  = ($mutasiKasDebet + $mutasiBankDebet + $mutasiMemorialDebet);
                $minus = ($mutasiKasKredit + $mutasiBankKredit + $mutasiMemorialKredit);
            }else{
                $plus = ($mutasiKasKredit + $mutasiBankKredit + $mutasiMemorialKredit);
                $minus  = ($mutasiKasDebet + $mutasiBankDebet + $mutasiMemorialDebet);
            }

            if(count($saldo) == 0){
                $insert[$key] = [
                    "id_akun"                   => $data->id_akun,
                    "saldo_awal"                => $data->saldo_akun,
                    "periode"                   => $periode->pk_periode,
                    "mutasi_kas_debet"          => $mutasiKasDebet,
                    "mutasi_kas_kredit"         => $mutasiKasKredit,
                    "mutasi_bank_debet"         => $mutasiBankDebet,
                    "mutasi_bank_kredit"        => $mutasiBankKredit,
                    "mutasi_memorial_debet"     => $mutasiMemorialDebet,
                    "mutasi_memorial_kredit"    => $mutasiMemorialKredit,
                    "saldo_akhir"               => ($data->opening_balance + ($plus - $minus)),
                ];
            }else{
                $saldoAwal = DB::table('d_akun_saldo')
                                    ->where('periode', $d3)
                                    ->where('id_akun', $data->id_akun)
                                    ->select('saldo_akhir')
                                    ->first();

                $insert[$key] = [
                    "id_akun"                   => $data->id_akun,
                    "saldo_awal"                => (!$saldoAwal) ? 0 : $saldoAwal->saldo_akhir,
                    "periode"                   => $periode->pk_periode,
                    "mutasi_kas_debet"          => $mutasiKasDebet,
                    "mutasi_kas_kredit"         => $mutasiKasKredit,
                    "mutasi_bank_debet"         => $mutasiBankDebet,
                    "mutasi_bank_kredit"        => $mutasiBankKredit,
                    "mutasi_memorial_debet"     => $mutasiMemorialDebet,
                    "mutasi_memorial_kredit"    => $mutasiMemorialKredit,
                    "saldo_akhir"               => ($saldoAwal->saldo_akhir + ($plus - $minus)),
                ];
            }
        }

        // return json_encode($insert);
        DB::table('d_akun_saldo')->insert($insert);

        return response()->json([
            'status'    => 'berhasil',
            'flag'      => 'success',
            'content'   => 'Periode Baru Berhasil Disimpan.',
            'data'      => null
        ]);
    }
}
