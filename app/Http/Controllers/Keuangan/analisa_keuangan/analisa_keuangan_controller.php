<?php

namespace App\Http\Controllers\Keuangan\analisa_keuangan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

class analisa_keuangan_controller extends Controller
{
    public function hutang_piutang(){
        $today = date('Y-m').'-01';
        $date = [];
        $tot_hutang = $tot_piutang = [];

        for ($i = 12; $i >= 1; $i--) {
            $cek_date = date('Y-m-d', strtotime('-'.$i.' months', strtotime($today)));
            $cek_date_next = date('Y-m-d', strtotime('+1 months', strtotime($cek_date)));
            $cek_piutang = DB::table('d_sales')
                                    ->where('s_jatuh_tempo', '!=', '0000-00-00')
                                    ->where('s_date', '>=', $cek_date)
                                    ->where('s_date', '<', $cek_date_next)
                                    ->select(DB::raw('coalesce(sum(s_net), 0) as piutang'))->first()->piutang / 1000000;

              $cek_hutang = DB::table('d_purchasing')
                            ->where('d_pcs_date_confirm', '>=', $cek_date)
                            ->where('d_pcs_date_confirm', '<', $cek_date_next)
                            ->select(DB::raw('coalesce(sum(d_pcs_total_net), 0) as piutang'))->first()->piutang / 1000000;

            array_push($date, date('m/y', strtotime('-'.$i.' months', strtotime($today))));
            array_push($tot_piutang, $cek_piutang);
            array_push($tot_hutang, $cek_hutang);
        }

        $tot_piutang = json_encode($tot_piutang);
        $tot_hutang = json_encode($tot_hutang);

        // return $tot_hutang;

        $date_1 = json_encode($date);
        $periode = date('Y-m').'-01';
        $periode_before = date('Y-m-d', strtotime('-1 months', strtotime($periode)));
        $periode_next = date('Y-m-d', strtotime('+1 months', strtotime($periode)));

        $piutang = [
            "Saldo_awal" => DB::table('d_sales')
                            ->where('s_jatuh_tempo', '!=', '0000-00-00')
                            ->where('s_date', '>=', $periode_before)
                            ->where('s_date', '<', $periode)
                            ->select(DB::raw('coalesce(sum(s_net), 0) as piutang'))->first()->piutang,

            "baru"       => DB::table('d_sales')
                            ->where('s_jatuh_tempo', '!=', '0000-00-00')
                            ->where('s_date', '>=', $periode)
                            ->where('s_date', '<', $periode_next)
                            ->select(DB::raw('coalesce(sum(s_net), 0) as piutang'))->first()->piutang,

            'dibayar'    => DB::table('d_sales')
                            ->where('s_jatuh_tempo', '!=', '0000-00-00')
                            ->where('s_date', '>=', $periode)
                            ->where('s_date', '<', $periode_next)
                            ->select(DB::raw('coalesce(sum((s_net - s_sisa)), 0) as piutang'))->first()->piutang,

            "periode"    => $periode
        ];

        $hutang = [
            "Saldo_awal" => DB::table('d_purchasing')
                            ->where('d_pcs_date_confirm', '>=', $periode_before)
                            ->where('d_pcs_date_confirm', '<', $periode)
                            ->select(DB::raw('coalesce(sum(d_pcs_total_net), 0) as piutang'))->first()->piutang,

            "baru"       => DB::table('d_purchasing')
                            ->where('d_pcs_date_confirm', '>=', $periode)
                            ->where('d_pcs_date_confirm', '<', $periode_next)
                            ->select(DB::raw('coalesce(sum(d_pcs_total_net), 0) as piutang'))->first()->piutang,

            'dibayar'    => DB::table('d_purchasing')
                            ->where('d_pcs_date_confirm', '>=', $periode)
                            ->where('d_pcs_date_confirm', '<', $periode_next)
                            ->select(DB::raw('coalesce(sum((d_pcs_total_net - d_pcs_sisapayment)), 0) as piutang'))->first()->piutang,

            "periode"    => $periode
        ];

        // return json_encode($piutang);

        return view("keuangan.analisa_keuangan.analisa_hutang_piutang.index", compact('date_1', 'piutang', 'hutang', 'tot_piutang', 'tot_hutang'));
    }

    public function ocf_profit(){

        $today = date('Y-m').'-01';
        $date = [];
        $tot_pendapatan = $tot_ocf = [];

        $periode = date('Y-m').'-01';
        $periode_before = date('Y-m-d', strtotime('-1 months', strtotime($periode)));
        $periode_next = date('Y-m-d', strtotime('+1 months', strtotime($periode)));

        for ($i = 12; $i >= 1; $i--) {
            $cek_date = date('Y-m-d', strtotime('-'.$i.' months', strtotime($today)));
            $cek_date_next = date('Y-m-d', strtotime('+1 months', strtotime($cek_date)));
            $tot_cf = 0;

            $pendapatan = DB::table('d_jurnal_dt')
                            ->join('d_jurnal', 'd_jurnal.jurnal_id', '=', 'd_jurnal_dt.jrdt_jurnal')
                            ->where('d_jurnal.tanggal_jurnal', '>=', $cek_date)
                            ->where('d_jurnal.tanggal_jurnal', '<', $cek_date_next)
                            ->whereIn('jrdt_acc', function($query){
                                $query->select('id_akun')
                                            ->from('d_akun')
                                            ->where('kelompok_akun', 'PENDAPATAN')
                                            ->where('type_akun', 'DETAIL')
                                            ->orWhere('kelompok_akun', 'PENDAPATAN LAIN LAIN')
                                            ->where('type_akun', 'DETAIL')->get();
                            })->select(DB::raw('coalesce(sum(jrdt_value), 0) as pendapatan'))->first();

            $beban = DB::table('d_jurnal_dt')
                                ->join('d_jurnal', 'd_jurnal.jurnal_id', '=', 'd_jurnal_dt.jrdt_jurnal')
                                ->where('d_jurnal.tanggal_jurnal', '>=', $cek_date)
                                ->where('d_jurnal.tanggal_jurnal', '<', $cek_date_next)
                                ->whereIn('jrdt_acc', function($query){
                                    $query->select('id_akun')
                                                ->from('d_akun')
                                                ->where('kelompok_akun', 'POTONGAN PENJUALAN')
                                                ->where('type_akun', 'DETAIL')
                                                ->orWhere('kelompok_akun', 'BEBAN POKOK PENJUALAN')
                                                ->where('type_akun', 'DETAIL')
                                                ->orWhere('kelompok_akun', 'BEBAN PRODUKSI')
                                                ->where('type_akun', 'DETAIL')
                                                ->orWhere('kelompok_akun', 'BEBAN PERALATAN PRODUKSI')
                                                ->where('type_akun', 'DETAIL')
                                                ->orWhere('kelompok_akun', 'BEBAN POKOK LAIN LAIN')
                                                ->where('type_akun', 'DETAIL')
                                                ->orWhere('kelompok_akun', 'SELISIH SALDO PERSEDIAAN BARANG')
                                                ->where('type_akun', 'DETAIL')
                                                ->orWhere(DB::raw('substring(id_akun, 1, 1)'), "6")
                                                ->where('type_akun', 'DETAIL')
                                                ->orWhere(DB::raw('substring(id_akun, 1, 3)'), "800")
                                                ->where('type_akun', 'DETAIL')->get();
                                })->select(DB::raw('coalesce(sum(jrdt_value), 0) as beban'))->first();

            $cashflow = DB::table('d_jurnal_dt')
                            ->join('d_jurnal', 'd_jurnal.jurnal_id', '=', 'd_jurnal_dt.jrdt_jurnal')
                            ->where('d_jurnal.tanggal_jurnal', '>=', $cek_date)
                            ->where('d_jurnal.tanggal_jurnal', '<', $cek_date_next)
                            ->whereIn('jrdt_cashflow', function($query){
                                $query->select('tc_id')
                                      ->from('dk_transaksi_cashflow')
                                      ->where('tc_cashflow', "OCF")->get();
                            })->select('jrdt_value', 'jrdt_acc')->get();
        
            foreach($cashflow as $numeric => $cf){
                $acc = DB::table('d_akun')->where('id_akun', $cf->jrdt_acc)->select('posisi_akun')->first();
                $nilai = ($acc->posisi_akun == "K") ? $cf->jrdt_value : ($cf->jrdt_value * -1);

                $tot_cf += $nilai;
            }

            array_push($date, date('m/y', strtotime('-'.$i.' months', strtotime($today))));
            array_push($tot_pendapatan, (($pendapatan->pendapatan - $beban->beban) / 1000000));
            array_push($tot_ocf, ($tot_cf / 1000000));
        }

        $date = json_encode($date);
        $tot_pendapatan = json_encode($tot_pendapatan);
        $tot_ocf = json_encode($tot_ocf);

        // return json_encode($tot_ocf);

        // $cashflow = DB::table('dk_transaksi_cashflow')->select('tc_id', 'tc_name', 'tc_cashflow')->where('tc_cashflow', "OCF")->get();

        // return json_encode($tot_cf);

        return view("keuangan.analisa_keuangan.analisa_ocf_profit.index", compact('date', 'tot_pendapatan', 'tot_ocf'));
    }

    public function cashflow(Request $request){
        
        $data = [];

        if($request->jenis == 'bulanan'){
            for ($i=0; $i < 12; $i++) { 

                $durasi = date('Y').'-'.($i + 1).'-01';
                $durasi_end    = date('Y-m-d', strtotime('+1 months', strtotime($durasi)));
                $durasi_before    = date('Y-m-d', strtotime('-1 months', strtotime($durasi)));

                $ocfIn = $ocfOut = $icfIn = $icfOut = $fcfIn = $fcfOut = 0;

                $saldoAwal = DB::table('d_akun_saldo')
                        ->whereIn('id_akun', function($query){
                            $query->select('id_akun')
                                    ->from('d_akun')
                                    ->where('group_neraca', 'A-1')
                                    ->where('type_akun', 'DETAIL')->get();
                        })
                        ->where('periode', $durasi_before)
                        ->select(DB::raw('coalesce(sum(saldo_akhir), 0) as saldoAwal'))->first();

                $detail = DB::table('d_jurnal_dt')
                      ->join('d_jurnal', 'd_jurnal.jurnal_id', '=', 'd_jurnal_dt.jrdt_jurnal')
                      ->join('d_akun', 'd_jurnal_dt.jrdt_acc', '=', 'd_akun.id_akun')
                      ->join('dk_transaksi_cashflow', 'dk_transaksi_cashflow.tc_id', 'd_jurnal_dt.jrdt_cashflow')
                      ->whereNotNull('jrdt_cashflow')
                      ->where('d_jurnal.tanggal_jurnal', '>=', $durasi)
                      ->where('d_jurnal.tanggal_jurnal', '<', $durasi_end)
                      ->select('d_jurnal_dt.*', 'd_jurnal.tanggal_jurnal', 'd_akun.posisi_akun', 'dk_transaksi_cashflow.tc_cashflow')
                      ->get();

                foreach ($detail as $key => $dataDetail) {
                    $numState = $dataDetail->jrdt_value;

                    if($dataDetail->tc_cashflow == 'OCF'){
                        if($dataDetail->posisi_akun == 'D'){
                            $numState *= -1;
                        }

                        if($numState < 1)
                            $ocfOut += $numState;
                        else
                            $ocfIn += $numState;
                    }else if($dataDetail->tc_cashflow == 'ICF'){
                        if($dataDetail->posisi_akun == 'D'){
                            $numState *= -1;
                        }

                        if($numState < 1)
                            $icfOut += $numState;
                        else
                            $icfIn += $numState;
                    }else if($dataDetail->tc_cashflow == 'FCF'){
                        if($dataDetail->posisi_akun == 'D'){
                            $numState *= -1;
                        }

                        if($numState < 1)
                            $fcfOut += $numState;
                        else
                            $fcfIn += $numState;
                    }
                }

                $data[$i] = [
                    "bulan"     => $durasi,
                    "saldoAwal" => $saldoAwal->saldoAwal,
                    "ocfIn"     => str_replace('-', '', $ocfIn),
                    "ocfOut"    => str_replace('-', '', $ocfOut),
                    'icfIn'     => str_replace('-', '', $icfIn),
                    'icfOut'    => str_replace('-', '', $icfOut),
                    'fcfIn'     => str_replace('-', '', $fcfIn),
                    'fcfOut'    => str_replace('-', '', $fcfOut),
                ];
            }
        }else{
            $ocfIn = $ocfOut = $icfIn = $icfOut = $fcfIn = $fcfOut = 0;
            $durasi = date('Y').'-01-01';

            $saldoAwal = DB::table('d_akun_saldo')
                        ->whereIn('id_akun', function($query){
                            $query->select('id_akun')
                                    ->from('d_akun')
                                    ->where('group_neraca', 'A-1')
                                    ->where('type_akun', 'DETAIL')->get();
                        })
                        ->where('periode', $durasi)
                        ->select(DB::raw('coalesce(sum(saldo_akhir), 0) as saldoAwal'))->first();


            for ($i=0; $i < 12; $i++) { 

                $durasi = date('Y').'-'.($i + 1).'-01';
                $durasi_end    = date('Y-m-d', strtotime('+1 months', strtotime($durasi)));
                $durasi_before    = date('Y-m-d', strtotime('-1 months', strtotime($durasi)));

                $detail = DB::table('d_jurnal_dt')
                      ->join('d_jurnal', 'd_jurnal.jurnal_id', '=', 'd_jurnal_dt.jrdt_jurnal')
                      ->join('d_akun', 'd_jurnal_dt.jrdt_acc', '=', 'd_akun.id_akun')
                      ->join('dk_transaksi_cashflow', 'dk_transaksi_cashflow.tc_id', 'd_jurnal_dt.jrdt_cashflow')
                      ->whereNotNull('jrdt_cashflow')
                      ->where('d_jurnal.tanggal_jurnal', '>=', $durasi)
                      ->where('d_jurnal.tanggal_jurnal', '<', $durasi_end)
                      ->select('d_jurnal_dt.*', 'd_jurnal.tanggal_jurnal', 'd_akun.posisi_akun', 'dk_transaksi_cashflow.tc_cashflow')
                      ->get();

                foreach ($detail as $key => $dataDetail) {
                    $numState = $dataDetail->jrdt_value;

                    if($dataDetail->tc_cashflow == 'OCF'){
                        if($dataDetail->posisi_akun == 'D'){
                            $numState *= -1;
                        }

                        if($numState < 1)
                            $ocfOut += $numState;
                        else
                            $ocfIn += $numState;
                    }else if($dataDetail->tc_cashflow == 'ICF'){
                        if($dataDetail->posisi_akun == 'D'){
                            $numState *= -1;
                        }

                        if($numState < 1)
                            $icfOut += $numState;
                        else
                            $icfIn += $numState;
                    }else if($dataDetail->tc_cashflow == 'FCF'){
                        if($dataDetail->posisi_akun == 'D'){
                            $numState *= -1;
                        }

                        if($numState < 1)
                            $fcfOut += $numState;
                        else
                            $fcfIn += $numState;
                    }
                }

                $data[$i] = [
                    "bulan"     => $durasi,
                    "saldoAwal" => $saldoAwal->saldoAwal,
                    "ocfIn"     => str_replace('-', '', $ocfIn),
                    "ocfOut"    => str_replace('-', '', $ocfOut),
                    'icfIn'     => str_replace('-', '', $icfIn),
                    'icfOut'    => str_replace('-', '', $icfOut),
                    'fcfIn'     => str_replace('-', '', $fcfIn),
                    'fcfOut'    => str_replace('-', '', $fcfOut),
                ];
            }
        }

        // return json_encode($data);

        return view("keuangan.analisa_keuangan.analisa_cashflow.index", compact('data', 'request'));
    }
}
