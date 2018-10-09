<?php

namespace App\Http\Controllers\Keuangan\Transaksi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Keuangan\transaksi as transaksi;
use App\Model\Keuangan\d_jurnal as jurnal;
use App\Model\Keuangan\d_jurnal_dt as jurnal_dt;
use App\Model\Keuangan\transaksi_detail as transaksi_detail;

use DB;

class transaksi_kas_controller extends Controller
{
    public function index(){
    	return view('keuangan.input_transaksi.transaksi_kas.index');
    }

    public function form_resource(){
    	// return json_encode('granted');

    	$akun_perkiraan = DB::table('d_akun')->where(DB::raw('substring(id_akun,1,3)'), '100')->where('type_akun', 'DETAIL')->select('id_akun', 'nama_akun')->get();

    	$akun_lawan = DB::table('d_akun')->where(DB::raw('substring(id_akun,1,3)'), '!=', '100')->where(DB::raw('substring(id_akun,1,3)'), '!=', '101')->where('type_akun', 'DETAIL')->select('id_akun', 'nama_akun')->get();

    	// return json_encode($list_transaksi);

    	return response()->json([
    		'akun_perkiraan'	=> $akun_perkiraan,
    		'akun_lawan'		=> $akun_lawan,
    	]);
    }

    public function list_transaksi(Request $request){
        // return json_encode($request->all());

        $idx = ($request->idx == 'KM') ? 'BKM' : 'BKK';
        $tgl = date('Y-m-d', strtotime($request->tgl));

        $list_transaksi = transaksi::where(DB::raw('substring(no_bukti,1,3)'), $idx)->where('tanggal_transaksi', $tgl)->with('jurnal.detail')->get();

        return response()->json($list_transaksi);
    }

    public function save(Request $request){

    	// return json_encode($request->all());

    	if($request->jenis_transaksi == 'KM'){

    		$cek = transaksi::where(DB::raw('month(tanggal_transaksi)'), date('n', strtotime($request->tanggal_transaksi)))->where(DB::raw('substring(no_bukti, 1, 3)'), 'BKM')->orderBy('id_transaksi', 'desc')->first();

    		$next = ($cek) ? (int)substr($cek->no_bukti, -5) : 0;

    		$bukti = 'BKM-'.date('myd', strtotime($request->tanggal_transaksi)).str_pad(($next + 1), 5, '0', STR_PAD_LEFT);

            $id = (transaksi::max('id_transaksi')) ? (transaksi::max('id_transaksi') + 1) : 1;

    		transaksi::insert([
                'id_transaksi'      => $id,
    			'no_bukti'			=> $bukti,
    			'tanggal_transaksi'	=> date('Y-m-d', strtotime($request->tanggal_transaksi)),
    			'nama_transaksi'	=> $request->nama_transaksi,
    			'keterangan'		=> $request->keterangan,
    			'nominal'			=> str_replace('.', '', explode(',', $request->nominal)[0])
    		]);

            transaksi_detail::insert([
                'tkd_transaksi'     => $id,
                'tkd_no'            => 1,
                'tkd_acc'           => $request->perkiraan,
                'tkd_value'         => str_replace('.', '', explode(',', $request->nominal)[0]),
                'tkd_dk'            => 'D'
            ]);

            $akun = DB::table('d_akun')->where('id_akun', $request->akun_lawan)->first();
            $pos = "K";
            $val = str_replace('.', '', explode(',', $request->nominal)[0]);

            if($akun->posisi_akun != $pos){
                $val = '-'.str_replace('.', '', explode(',', $request->nominal)[0]);
            }

            // return json_encode($akun);

            transaksi_detail::insert([
                'tkd_transaksi'     => $id,
                'tkd_no'            => 2,
                'tkd_acc'           => $request->akun_lawan,
                'tkd_value'         => $val,
                'tkd_dk'            => $pos
            ]);

    		// Pembukuan Jurnal

                $acc = [
                    [
                        "td_acc"    => $request->perkiraan,
                        "td_posisi" => 'D',
                        'value'     => str_replace('.', '', explode(',', $request->nominal)[0])
                    ],

                    [
                        "td_acc"    => $request->akun_lawan,
                        "td_posisi" => "K",
                        "value"     => str_replace('.', '', explode(',', $request->nominal)[0])
                    ]
                ];

                _initiateJournal_self_detail($bukti, "KM", $request->tanggal_transaksi, $request->keterangan, $acc);

	    		
	    	// Pembukuan Jurnal End

    		return response()->json([
    			'status'	=> 'berhasil',
    			'content'	=> null
    		]);

    	}else{
            // return json_encode(str_replace('.', '', explode(',', $request->nominal)[0]));
    		$cek = transaksi::where(DB::raw('month(tanggal_transaksi)'), date('n', strtotime($request->tanggal_transaksi)))->where(DB::raw('substring(no_bukti, 1, 3)'), 'BKK')->orderBy('id_transaksi', 'desc')->first();

    		$next = ($cek) ? (int)substr($cek->no_bukti, -5) : 0;

    		$bukti = 'BKK-'.date('myd', strtotime($request->tanggal_transaksi)).str_pad(($next + 1), 5, '0', STR_PAD_LEFT);

    		$id = (transaksi::max('id_transaksi')) ? (transaksi::max('id_transaksi') + 1) : 1;

            transaksi::insert([
                'id_transaksi'      => $id,
                'no_bukti'          => $bukti,
                'tanggal_transaksi' => date('Y-m-d', strtotime($request->tanggal_transaksi)),
                'nama_transaksi'    => $request->nama_transaksi,
                'keterangan'        => $request->keterangan,
                'nominal'           => str_replace('.', '', explode(',', $request->nominal)[0])
            ]);

            transaksi_detail::insert([
                'tkd_transaksi'     => $id,
                'tkd_no'            => 1,
                'tkd_acc'           => $request->perkiraan,
                'tkd_value'         => '-'.str_replace('.', '', explode(',', $request->nominal)[0]),
                'tkd_dk'            => 'K'
            ]);

            $akun = DB::table('d_akun')->where('id_akun', $request->akun_lawan)->first();
            $pos = "D";
            $val = str_replace('.', '', explode(',', $request->nominal)[0]);

            if($akun->posisi_akun != $pos){
                $val = '-'.str_replace('.', '', explode(',', $request->nominal)[0]);
            }

            // return json_encode($akun);

            transaksi_detail::insert([
                'tkd_transaksi'     => $id,
                'tkd_no'            => 2,
                'tkd_acc'           => $request->akun_lawan,
                'tkd_value'         => $val,
                'tkd_dk'            => $pos
            ]);

            // Pembukuan Jurnal

                $acc = [
                    [
                        "td_acc"    => $request->perkiraan,
                        "td_posisi" => 'K',
                        'value'     => str_replace('.', '', explode(',', $request->nominal)[0])
                    ],

                    [
                        "td_acc"    => $request->akun_lawan,
                        "td_posisi" => "D",
                        "value"     => str_replace('.', '', explode(',', $request->nominal)[0])
                    ]
                ];

                _initiateJournal_self_detail($bukti, "KK", $request->tanggal_transaksi, $request->keterangan, $acc);

            // Pembukuan Jurnal End

    		return response()->json([
    			'status'	=> 'berhasil',
    			'content'	=> null
    		]);
    	}
    }

    public function update(Request $request){
        // return json_encode($request->all());

        $transaksi = transaksi::where('id_transaksi', $request->id_transaksi);

        $transaksi->update([
            'nama_transaksi'    => $request->nama_transaksi,
            'keterangan'        => $request->keterangan,
            'nominal'           => str_replace('.', '', explode(',', $request->nominal)[0])
        ]);

        transaksi_detail::where('tkd_transaksi', $request->id_transaksi)->delete();

        if(substr($transaksi->first()->no_bukti, 0, 3) == 'BKM'){

            transaksi_detail::insert([
                'tkd_transaksi'     => $request->id_transaksi,
                'tkd_no'            => 1,
                'tkd_acc'           => $request->perkiraan,
                'tkd_value'         => str_replace('.', '', explode(',', $request->nominal)[0]),
                'tkd_dk'            => 'D'
            ]);

            $akun = DB::table('d_akun')->where('id_akun', $request->akun_lawan)->first();
            $pos = "K";
            $val = str_replace('.', '', explode(',', $request->nominal)[0]);

            if($akun->posisi_akun != $pos){
                $val = '-'.str_replace('.', '', explode(',', $request->nominal)[0]);
            }

            // return json_encode($akun);

            transaksi_detail::insert([
                'tkd_transaksi'     => $request->id_transaksi,
                'tkd_no'            => 2,
                'tkd_acc'           => $request->akun_lawan,
                'tkd_value'         => $val,
                'tkd_dk'            => $pos
            ]);

        }else{
            transaksi_detail::insert([
                'tkd_transaksi'     => $request->id_transaksi,
                'tkd_no'            => 1,
                'tkd_acc'           => $request->perkiraan,
                'tkd_value'         => '-'.str_replace('.', '', explode(',', $request->nominal)[0]),
                'tkd_dk'            => 'K'
            ]);

            $akun = DB::table('d_akun')->where('id_akun', $request->akun_lawan)->first();
            $pos = "D";
            $val = str_replace('.', '', explode(',', $request->nominal)[0]);

            if($akun->posisi_akun != $pos){
                $val = '-'.str_replace('.', '', explode(',', $request->nominal)[0]);
            }

            // return json_encode($akun);

            transaksi_detail::insert([
                'tkd_transaksi'     => $request->id_transaksi,
                'tkd_no'            => 2,
                'tkd_acc'           => $request->akun_lawan,
                'tkd_value'         => $val,
                'tkd_dk'            => $pos
            ]);
        }


        // Pembukuan Jurnal
            $jurnal = jurnal::where('jurnal_ref', $transaksi->first()->no_bukti);

            $jurnal->update([
                'keterangan'    => $request->keterangan
            ]);

            jurnal_dt::where('jrdt_jurnal', $jurnal->first()->jurnal_id)->delete();

            if(substr($jurnal->first()->no_jurnal, 0, 2) == 'KM'){
                jurnal_dt::insert([
                    'jrdt_jurnal'   => $jurnal->first()->jurnal_id,
                    'jrdt_no'       => 1,
                    'jrdt_acc'      => $request->perkiraan,
                    'jrdt_value'    => str_replace('.', '', explode(',', $request->nominal)[0]),
                    'jrdt_dk'       => 'D'
                ]);

                $akun = DB::table('d_akun')->where('id_akun', $request->akun_lawan)->first();
                $pos = "K";
                $val = str_replace('.', '', explode(',', $request->nominal)[0]);

                if($akun->posisi_akun != $pos){
                    $val = '-'.str_replace('.', '', explode(',', $request->nominal)[0]);
                }

                // return json_encode($akun);

                jurnal_dt::insert([
                    'jrdt_jurnal'   => $jurnal->first()->jurnal_id,
                    'jrdt_no'       => 2,
                    'jrdt_acc'      => $request->akun_lawan,
                    'jrdt_value'    => $val,
                    'jrdt_dk'       => $pos
                ]);
            }else{
                jurnal_dt::insert([
                    'jrdt_jurnal'   => $jurnal->first()->jurnal_id,
                    'jrdt_no'       => 1,
                    'jrdt_acc'      => $request->perkiraan,
                    'jrdt_value'    => '-'.str_replace('.', '', explode(',', $request->nominal)[0]),
                    'jrdt_dk'       => 'K'
                ]);

                $akun = DB::table('d_akun')->where('id_akun', $request->akun_lawan)->first();
                $pos = "D";
                $val = str_replace('.', '', explode(',', $request->nominal)[0]);

                if($akun->posisi_akun != $pos){
                    $val = '-'.str_replace('.', '', explode(',', $request->nominal)[0]);
                }

                // return json_encode($akun);

                jurnal_dt::insert([
                    'jrdt_jurnal'   => $jurnal->first()->jurnal_id,
                    'jrdt_no'       => 2,
                    'jrdt_acc'      => $request->akun_lawan,
                    'jrdt_value'    => $val,
                    'jrdt_dk'       => $pos
                ]);
            }


        // Pembukuan Jurnal End


        // return json_encode($jurnal);


        return response()->json([
            'status'    => 'berhasil',
            'content'   => null
        ]);

    }

    public function delete(Request $request){
        // return json_encode($request->all());

        $transaksi = transaksi::where('id_transaksi', $request->id);
        transaksi_detail::where('tkd_transaksi', $request->id)->delete();

        $jurnal = jurnal::where('jurnal_ref', $transaksi->first()->no_bukti);

        jurnal_dt::where('jrdt_jurnal', $jurnal->first()->jurnal_id)->delete();

        $jurnal->delete();
        $transaksi->delete();

        return response()->json([
            'status'    => 'berhasil',
            'content'   => null
        ]);
    }
}
