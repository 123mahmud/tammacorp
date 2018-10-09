<?php

namespace App\Http\Controllers\Keuangan\Pembayaran_hutang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Keuangan\purchase_payment as payment;

use DB;

class pembayaran_hutang_controller extends Controller
{
    public function index(){
    	return view('Keuangan.pembayaran_hutang.index');
    }

    public function form_resource(){
    	$data = DB::table('d_supplier')->select('s_company', 's_id')->orderBy('s_company', 'asc')->get();
        $akun_kas = DB::table('d_akun')->where(DB::raw('substring(id_akun,1,3)'), '100')->where('type_akun', 'DETAIL')->select('id_akun', 'nama_akun')->get();
        $akun_bank = DB::table('d_akun')->where(DB::raw('substring(id_akun,1,3)'), '101')->where('type_akun', 'DETAIL')->select('id_akun', 'nama_akun')->get();

    	return response()->json([
            'supplier'  => $data,
            'akun_kas'  => $akun_kas,
            'akun_bank' => $akun_bank
            // 'akun_bank' => $bank
         ]);
    }

    public function get_po(Request $request){
    	// return json_encode($request->all());

    	$data = DB::table('d_purchasing')
                    ->where('d_pcs_status', 'CF')
    				->where('d_pcs_sisapayment', '!=', '0')
    				->where('s_id', $request->supplier)
                    ->orWhere('d_pcs_status', 'RC')
                    ->where('d_pcs_sisapayment', '!=', '0')
                    ->where('s_id', $request->supplier)
    				->get();

    	return json_encode($data);
    }

    public function save(Request $request){
    	
    	// return json_encode($request->all());

    	// return json_encode(date('Y-m-d', strtotime($request->tanggal_pembayaran)));

        $akun = ($request->jenis_pembayaran == 'T') ? $request->akun_bank : $request->akun_kas;

        $acc = [
            [
                'td_acc'    => $akun,
                'td_posisi' => 'K',
                'value'     => str_replace('.', '', explode(',', $request->nominal_pembayaran)[0])
            ],

            [
                'td_acc'    => '301.01',
                'td_posisi' => 'D',
                'value'     => str_replace('.', '', explode(',', $request->nominal_pembayaran)[0])
            ]
        ];

    	$cek = (payment::max('payment_id')) ? (payment::max('payment_id') + 1) : 1;
    	$cek2 = payment::where(DB::raw('month(payment_date)'), date('m', strtotime($request->tanggal_pembayaran)))
    						->orderBy('payment_date', 'desc')
    						->first();

    	$code = ($cek2) ? (explode('/', $cek2->payment_code)[2] + 1) : 1;
        $no_pp = 'PP-'.date('ymd').'/'.$request->supplier.'/'.str_pad($code, 4, '0', STR_PAD_LEFT);
        $state = ($request->jenis_pembayaran == 'T') ? 'BK' : 'KK';

    	// return json_encode($code); 

    	payment::insert([
    		'payment_id'			=> $cek,
    		'payment_code'			=> $no_pp,
    		'payment_po'			=> $request->nomor_po,
    		'payment_keterangan'	=> $request->keterangan_pembayaran,
    		'payment_date'			=> date('Y-m-d', strtotime($request->tanggal_pembayaran)),
    		'payment_type'			=> ($request->jenis_pembayaran == 'C') ? 'CASH' : 'TRANSFER',
    		'payment_value'			=> str_replace('.', '', explode(',', $request->nominal_pembayaran)[0]),
    	]);

    	$purchase = DB::table('d_purchasing')
    					->where('d_pcs_code', $request->nomor_po)->first();

    	$payment = $purchase->d_pcs_payment + str_replace('.', '', explode(',', $request->nominal_pembayaran)[0]);

    	DB::table('d_purchasing')->where('d_pcs_id', $purchase->d_pcs_id)->update([
    		'd_pcs_payment'			=> $payment,
    		'd_pcs_sisapayment'		=> $purchase->d_pcs_total_net - $payment,
    	]);

        $state_jurnal = _initiateJournal_self_detail($no_pp, $state, date('Y-m-d', strtotime($request->tanggal_pembayaran)), $request->keterangan_pembayaran, $acc);

    	return json_encode([
    		'status'	=> 'berhasil',
    		'content'	=> null
    	]);
    }

    public function get_transaksi(Request $request){
    	// return json_encode($request->all());

    	if(is_null($request->tgl)){
    		$data = DB::table('d_purchase_payment')
    						->join('d_purchasing', 'd_purchasing.d_pcs_code', '=', 'd_purchase_payment.payment_po')
    						->where('s_id', $request->sp)
    						->orderBy('d_purchase_payment.payment_date', 'asc')->get();
    	}else{
    		$data = DB::table('d_purchase_payment')
    						->join('d_purchasing', 'd_purchasing.d_pcs_code', '=', 'd_purchase_payment.payment_po')
    						->where('s_id', $request->sp)
    						->where('payment_date', date('Y-m-d', strtotime($request->tgl)))
    						->orderBy('d_purchase_payment.payment_date', 'asc')->get();
    	}

    	return json_encode($data);
    }

    public function update(Request $request){
    	// return json_encode($request->all());

    	$transaksi = DB::table('d_purchase_payment')->where('payment_code', $request->nomor_nota);
    	$purchase = DB::table('d_purchasing')->where('d_pcs_code', $request->nomor_po);
    	$jurnal = DB::table('d_jurnal')->where('jr_ref', $request->nomor_nota);

    	if(!$transaksi->first()){
    		return json_encode([
	    		'status'	=> 'not_exist',
	    		'content'	=> null
	    	]);
    	}else if(!$purchase->first()){

    		DB::table('d_jurnal_dt')->where('jrdt_jurnal', $jurnal->first()->jr_id)->delete();
    		DB::table('d_purchase_payment')->where('payment_po', $request->nomor_po)->delete();
    		$jurnal->delete();

    		return json_encode([
	    		'status'	=> 'po_not_exist',
	    		'content'	=> null
	    	]);
    	}

        $akun = ($request->jenis_pembayaran == 'T') ? $request->akun_bank : $request->akun_kas;

        $acc = [
            [
                'td_acc'    => $akun,
                'td_posisi' => 'K',
                'value'     => str_replace('.', '', explode(',', $request->nominal_pembayaran)[0])
            ],

            [
                'td_acc'    => '301.01',
                'td_posisi' => 'D',
                'value'     => str_replace('.', '', explode(',', $request->nominal_pembayaran)[0])
            ]
        ];

        $state = ($request->jenis_pembayaran == 'T') ? 'BK' : 'KK';

    	$update_payment = str_replace('.', '', explode(',', $request->nominal_pembayaran)[0]) - $transaksi->first()->payment_value;

    	// return json_encode($purchase->first()->d_payment + $update_payment);
    	// return json_encode($purchase->first()->d_pcs_total_net - ($purchase->first()->d_payment + $update_payment));
    	// return json_encode($purchase->first()->d_payment + $update_payment);

    	$transaksi->update([
    		'payment_keterangan'	=> $request->keterangan_pembayaran,
    		'payment_type'			=> ($request->jenis_pembayaran == 'C') ? 'CASH' : 'TRANSFER',
    		'payment_value'			=> str_replace('.', '', explode(',', $request->nominal_pembayaran)[0]),
    	]);

    	$purchase->update([
    		'd_pcs_payment'			=> $purchase->first()->d_pcs_payment + $update_payment,
    		'd_pcs_sisapayment'		=> $purchase->first()->d_pcs_total_net - ($purchase->first()->d_pcs_payment + $update_payment),
    	]);

        $state_jurnal = _updateJournal_self_detail($transaksi->first()->payment_code, $state, $transaksi->first()->payment_date, $request->keterangan_pembayaran, $acc);

    	return json_encode([
    		'status'	=> 'berhasil',
    		'content'	=> null
    	]);

    	// return json_encode($data->first());
    }

    public function delete(Request $request){
    	// return json_encode($request->all());
    	$transaksi = DB::table('d_purchase_payment')->where('payment_code', $request->id);
    	$purchase = DB::table('d_purchasing')->where('d_pcs_code', $transaksi->first()->payment_po);
    	$jurnal = DB::table('d_jurnal')->where('jurnal_ref', $request->id);

    	if(!$transaksi->first()){
    		return json_encode([
	    		'status'	=> 'not_exist',
	    		'content'	=> null
	    	]);
    	}

    	if($jurnal->first())
    		DB::table('d_jurnal_dt')->where('jrdt_jurnal', $jurnal->first()->jr_id)->delete();

    	$purchase->update([
    		'd_pcs_payment'		=> $purchase->first()->d_pcs_payment - $transaksi->first()->payment_value,
    		'd_pcs_sisapayment'	=> $purchase->first()->d_pcs_total_net - ($purchase->first()->d_pcs_payment - $transaksi->first()->payment_value),
    	]);

    	$transaksi->delete();
        _delete_jurnal($transaksi->first()->payment_code);

    	return json_encode([
    		'status'	=> 'berhasil',
    		'content'	=> null
    	]);
    }
}
