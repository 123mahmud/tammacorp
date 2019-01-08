<?php

namespace App\Http\Controllers\keuangan\Penerimaan_piutang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use DB;

class penerimaan_piutang_controller extends Controller
{
    public function index(){
    	return view('keuangan.penerimaan_piutang.index');
    }

    public function form_resource(){
    	$data = DB::table('m_customer')->select('c_id as value', 'c_name as nama')->where('c_isactive','TRUE')->orderBy('c_name', 'asc')->get();
        $akun_kas = DB::table('d_akun')->where(DB::raw('substring(id_akun,1,3)'), '100')->where('type_akun', 'DETAIL')->select('id_akun', 'nama_akun')->get();
        $akun_bank = DB::table('d_akun')->where(DB::raw('substring(id_akun,1,3)'), '101')->where('type_akun', 'DETAIL')->select('id_akun', 'nama_akun')->get();

    	return response()->json([
            'supplier'  => $data,
            'akun_kas'  => $akun_kas,
            'akun_bank' => $akun_bank
            // 'akun_bank' => $bank
         ]);
    }

    public function get_sales(Request $request){
        // return json_encode($request->all());
        $data = DB::table('d_sales')
                    ->where('s_sisa', '!=', 0)
                    ->whereNotNull('s_sisa')
                    ->where('s_customer', $request->cust)
                    ->select('d_sales.*', DB::raw('(s_net - s_sisa) as s_payed'))
                    ->get();

        return json_encode($data);
    }

    public function save(Request $request){
        // return json_encode($request->all());

        $akun = ($request->jenis_pembayaran == 'T') ? $request->akun_bank : $request->akun_kas;

        if(jurnal_setting()->allow_jurnal_to_execute){
            $acc = [
                [
                    'td_acc'    => $akun,
                    'td_posisi' => 'D',
                    'value'     => str_replace(',', '', $request->nominal_pembayaran)
                ],

                [
                    'td_acc'    => '110.01',
                    'td_posisi' => 'K',
                    'value'     => str_replace(',', '', $request->nominal_pembayaran),
                    'cashflow'  => '4'
                ]
            ];
        }

        $cek = (DB::table('d_sales_receive')->max('sr_id')) ? (DB::table('d_sales_receive')->max('sr_id') + 1) : 1;
        $cek2 = DB::table('d_sales_receive')
                            ->where(DB::raw('month(sr_date)'), date('m', strtotime($request->tanggal_pembayaran)))
                            ->orderBy('sr_date', 'desc')
                            ->first();

        // return json_encode($cek2);

        $code = ($cek2) ? (explode('/', $cek2->sr_code)[2] + 1) : 1;
        $no_sr = 'SR-'.date('ymd').'/'.$request->supplier.'/'.str_pad($code, 4, '0', STR_PAD_LEFT);
        $state = ($request->jenis_pembayaran == 'T') ? 'BK' : 'KK';

        // return json_encode($acc);

        DB::table('d_sales_receive')->insert([
            'sr_id'            => $cek,
            'sr_code'          => $no_sr,
            'sr_note'          => $request->nomor_po,
            'sr_keterangan'    => $request->keterangan_pembayaran,
            'sr_date'          => date('Y-m-d', strtotime($request->tanggal_pembayaran)),
            'sr_type'          => ($request->jenis_pembayaran == 'C') ? 'CASH' : 'TRANSFER',
            'sr_value'         => str_replace(',', '', $request->nominal_pembayaran),
        ]);

        $sales = DB::table('d_sales')
                        ->where('s_note', $request->nomor_po)->first();

        $idpi = DB::table('d_sales_payment')->where('sp_sales', $sales->s_id)->max('sp_paymentid');
        $idNext = ($idpi) ? ($idpi + 1) : 1;

        // return json_encode($idNext);

        DB::table('d_sales_payment')->insert([
            'sp_sales'      => $sales->s_id,
            'sp_paymentid'  => $idNext,
            'sp_method'     => '',
            'sp_nominal'    => str_replace(',', '', $request->nominal_pembayaran),
            'sp_ref'        => $no_sr
        ]);

        $payment = DB::table('d_sales_payment')->where('sp_sales', $sales->s_id)->select(DB::raw('sum(sp_nominal) as payment'))->first();

        // return json_encode($payment);

        DB::table('d_sales')->where('s_id', $sales->s_id)->update([
            's_sisa'     => $sales->s_net - $payment->payment,
        ]);

        if(jurnal_setting()->allow_jurnal_to_execute){
            $state_jurnal = _initiateJournal_self_detail($no_sr, $state, date('Y-m-d', strtotime($request->tanggal_pembayaran)), $request->keterangan_pembayaran, $acc);
        }

        return json_encode([
            'status'    => 'berhasil',
            'content'   => null
        ]);

    }

    public function update(Request $request){
        // return json_encode($request->all());

        $transaksi = DB::table('d_sales_receive')->where('sr_code', $request->nomor_nota);
        $purchase = DB::table('d_sales')->where('s_note', $request->nomor_po);
        $jurnal = DB::table('d_jurnal')->where('jr_ref', $request->nomor_nota);

        if(!$transaksi->first()){
            return json_encode([
                'status'    => 'not_exist',
                'content'   => null
            ]);
        }else if(!$purchase->first()){

            DB::table('d_jurnal_dt')->where('jrdt_jurnal', $jurnal->first()->jr_id)->delete();
            DB::table('d_sales_receive')->where('sr_note', $request->nomor_po)->delete();
            $jurnal->delete();

            return json_encode([
                'status'    => 'po_not_exist',
                'content'   => null
            ]);
        }

        $akun = ($request->jenis_pembayaran == 'T') ? $request->akun_bank : $request->akun_kas;

        if(jurnal_setting()->allow_jurnal_to_execute){
            $acc = [
                [
                    'td_acc'    => $akun,
                    'td_posisi' => 'D',
                    'value'     => str_replace(',', '', $request->nominal_pembayaran)
                ],

                [
                    'td_acc'    => '110.01',
                    'td_posisi' => 'K',
                    'value'     => str_replace(',', '', $request->nominal_pembayaran),
                    'cashflow'  => '4'
                ]
            ];
        }

        $state = ($request->jenis_pembayaran == 'T') ? 'BK' : 'KK';
        $sales = DB::table('d_sales')
                        ->where('s_note', $request->nomor_po)->first();

        $transaksi->update([
            'sr_keterangan'    => $request->keterangan_pembayaran,
            'sr_type'          => ($request->jenis_pembayaran == 'C') ? 'CASH' : 'TRANSFER',
            'sr_value'         => str_replace(',', '', $request->nominal_pembayaran),
        ]);

        DB::table('d_sales_payment')->where('sp_ref', $request->nomor_nota)->update([
            'sp_nominal'    => str_replace(',', '', $request->nominal_pembayaran),
        ]);

        $payment = DB::table('d_sales_payment')->where('sp_sales', $sales->s_id)->select(DB::raw('sum(sp_nominal) as payment'))->first();

        DB::table('d_sales')->where('s_id', $sales->s_id)->update([
            's_sisa'     => $sales->s_net - $payment->payment,
        ]);

        if(jurnal_setting()->allow_jurnal_to_execute){
            $state_jurnal = _updateJournal_self_detail($transaksi->first()->sr_code, $state, $transaksi->first()->sr_date, $request->keterangan_pembayaran, $acc);
        }

        // return 'okee';

        return json_encode([
            'status'    => 'berhasil',
            'content'   => null
        ]);
    } 

    public function delete(Request $request){
        // return json_encode($request->all());

        $transaksi = DB::table('d_sales_receive')->where('sr_code', $request->id);
        $purchase = DB::table('d_sales')->where('s_note', $transaksi->first()->sr_note);
        $jurnal = DB::table('d_jurnal')->where('jurnal_ref', $request->id);
        // return json_encode($jurnal->first());

        if(!$transaksi->first()){
            return json_encode([
                'status'    => 'not_exist',
                'content'   => null
            ]);
        }

        DB::table('d_sales_payment')->where('sp_ref', $request->id)->delete();

        $payment = DB::table('d_sales_payment')->where('sp_sales', $purchase->first()->s_id)->select(DB::raw('sum(sp_nominal) as payment'))->first();

        $purchase->update([
            's_sisa'     => $purchase->first()->s_net - $payment->payment,
        ]);

        // _delete_jurnal($transaksi->first()->sr_code);
        $transaksi->delete();

        return json_encode([
            'status'    => 'berhasil',
            'content'   => null
        ]);
    }

    public function get_transaksi(Request $request){
        // return json_encode($request->all());

        if(is_null($request->tgl)){
            $data = DB::table('d_sales_receive')
                            ->join('d_sales', 'd_sales_receive.sr_note', '=', 'd_sales.s_note')
                            ->where('d_sales.s_customer', $request->sp)
                            ->orderBy('d_sales_receive.sr_date', 'asc')->get();
        }else{
            $data = DB::table('d_sales_receive')
                            ->join('d_sales', 'd_sales_receive.sr_note', '=', 'd_sales.s_note')
                            ->where('d_sales.s_customer', $request->sp)
                            ->where('d_sales_receive.sr_date', date('Y-m-d', strtotime($request->tgl)))
                            ->orderBy('d_sales_receive.sr_date', 'asc')->get();
        }

        return json_encode($data);
    }
}
