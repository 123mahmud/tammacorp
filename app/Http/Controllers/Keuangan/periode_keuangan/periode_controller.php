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

        $saldo = DB::table('d_akun_saldo')->select('*')->get();
        $insert = [];

        // DB::table('d_periode_keuangan')->update([
        //     'pk_status'     => '0'
        // ]);

        // DB::table('d_periode_keuangan')->where('pk_id', $request->id)->update([
        //     'pk_status'     => '1'
        // ]);

        $aktiva = DB::table('d_aktiva')
                        ->join('d_golongan_aktiva', 'd_golongan_aktiva.ga_nomor', '=', 'd_aktiva.a_kelompok')
                        ->where('a_tanggal_beli', '<=', $periode->pk_periode)
                        ->where('a_tanggal_habis', '>=', $periode->pk_periode)
                        ->where('a_status', 'active')
                        ->select('d_aktiva.*', 'd_golongan_aktiva.ga_akun_harta', 'd_golongan_aktiva.ga_akun_penyusutan', 'd_golongan_aktiva.ga_akun_akumulasi')
                        ->get();

        foreach($aktiva as $key => $value){
            $penyusutan = DB::table('dk_aktiva_detail')
                                ->where('ad_aktiva', $value->a_id)
                                ->where('ad_tahun', date('Y', strtotime($periode->pk_periode)))
                                ->first();
            if($penyusutan){

                $acc = [];
                $nilaiPenyusutan = $penyusutan->ad_penyusutan / $penyusutan->ad_jumlah_bulan;

                $acc[$value->ga_akun_penyusutan] = [
                    'td_acc'    => $value->ga_akun_penyusutan,
                    'td_posisi' => 'D',
                    'value'     => $nilaiPenyusutan
                ];

                $acc[$value->ga_akun_akumulasi] = [
                    'td_acc'    => $value->ga_akun_akumulasi,
                    'td_posisi' => 'K',
                    'value'     => $nilaiPenyusutan
                ];

                $state_jurnal = _initiateJournal_self_detail($value->a_nomor, 'MM', date('Y-m-d', strtotime($periode->pk_periode)), 'Penyusutan Atas Aset '.$value->a_name.' ('.$value->a_nomor.'),  Periode Bulan '.date('m/Y', strtotime($periode->pk_periode)), $acc);

                $nilai_sisa = $value->a_nilai_sisa - $nilaiPenyusutan;

                DB::table('d_aktiva')->where('a_id', $value->a_id)->update([
                    'a_nilai_sisa'  => $nilai_sisa
                ]);

            }else{
                return json_encode("err");
            }

            // return json_encode($acc);
        }

        // return json_encode($aktiva);

        if(count($saldo) == 0){
            $akun = DB::table('d_akun')->where('type_akun', 'DETAIL')->select('id_akun as id_akun', DB::raw("'".$periode->pk_periode."' as periode"), 'opening_balance as saldo')->get()->toArray();

            foreach ($akun as $key => $value) {
                $insert[$key] = [
                    'id_akun'   => $value->id_akun,
                    'periode'   => $value->periode,
                    'saldo'     => $value->saldo
                ];
            }
        }else{
            $bulanBefore = date('Y-m-d', strtotime('-1 months', strtotime($periode->pk_periode)));

            $akun = akun::select('id_akun as id_akun', DB::raw("'".$periode->pk_periode."' as periode", 'opening_balance'))
                            ->with([
                                  'mutasi_bank_debet' => function($query) use ($bulanBefore, $periode){
                                        $query->join('d_jurnal', 'd_jurnal.jurnal_id', '=', 'jrdt_jurnal')
                                              ->where('tanggal_jurnal', '>=', $bulanBefore)
                                              ->where('tanggal_jurnal', '<', $periode->pk_periode)
                                              ->groupBy('jrdt_acc')
                                              ->select('jrdt_acc', DB::raw('sum(jrdt_value) as mutasi'));
                                  },
                            ])
                            ->where('type_akun', 'DETAIL')
                            ->get();

            // return json_encode($akun);

            foreach ($akun as $key => $value) {
                $saldoBefore = DB::table('d_akun_saldo')
                                    ->where('id_akun', $value->id_akun)
                                    ->where('periode', $bulanBefore)
                                    ->select('saldo')
                                    ->first();

                $mutasi = (count($value->mutasi_bank_debet) > 0) ? $value->mutasi_bank_debet[0]->mutasi : 0;

                $insert[$key] = [
                    'id_akun'   => $value->id_akun,
                    'periode'   => $value->periode,
                    'saldo'     => ($saldoBefore) ? ($saldoBefore->saldo + $mutasi) : ($value->opening_balance + $mutasi)
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
