<?php
	
	function _initiateJournal_from_transaksi($referensi, $tanggal_jurnal, $keterangan, $id_transaksi, $value){

		$transaksi = DB::table('m_transaksi')->where('id_transaksi', $id_transaksi)->first();

		$jurnal_cek = DB::table('d_jurnal')->where(DB::raw('month(tanggal_jurnal)'), date('n', strtotime($tanggal_jurnal)))->where(DB::raw('year(tanggal_jurnal)'), date('Y', strtotime($tanggal_jurnal)))->where(DB::raw('substring(no_jurnal, 1, 2)'), $transaksi->type_transaksi)->orderBy('jurnal_id', 'desc')->first();

		$next_jurnal = ($jurnal_cek) ? (int)substr($jurnal_cek->no_jurnal, -5) : 0;

		$bukti_jurnal = $transaksi->type_transaksi.'-'.date('myd', strtotime($tanggal_jurnal)).str_pad(($next_jurnal + 1), 5, '0', STR_PAD_LEFT);

		$id_jurnal = (DB::table('d_jurnal')->max('jurnal_id')) ? (DB::table('d_jurnal')->max('jurnal_id') + 1) : 1;

		// return json_encode($bukti_jurnal);

		DB::table('d_jurnal')->insert([
			'jurnal_id'			 => $id_jurnal,
			'no_jurnal'		 	 => $bukti_jurnal,
			'jurnal_ref'		 => $referensi,
			'tanggal_jurnal'	 => date('Y-m-d', strtotime($tanggal_jurnal)),
			'keterangan'		 => $keterangan
		]);

		$detail = DB::table('m_transaksi_detail')->where('td_transaksi', $id_transaksi)->get();

		foreach ($detail as $key => $detail_data) {
			$akun = DB::table('d_akun')->where('id_akun', $detail_data->td_acc)->first();
    		$pos = $detail_data->td_posisi;
    		$val = $value[$key];

    		if($akun->posisi_akun != $pos){
    			$val = '-'.$value[$key];
    		}

    		// return json_encode($akun);

    		DB::table('d_jurnal_dt')->insert([
    			'jrdt_jurnal'	=> $id_jurnal,
    			'jrdt_no'		=> ($key+1),
    			'jrdt_acc' 		=> $detail_data->td_acc,
    			'jrdt_value'	=> $val,
    			'jrdt_dk'		=> $pos
    		]);
		}
		return 'okee';
	}

	function _initiateJournal_self_detail($referensi, $type_transaksi, $tanggal_jurnal, $keterangan, $detail){

		$jurnal_cek = DB::table('d_jurnal')->where(DB::raw('month(tanggal_jurnal)'), date('n', strtotime($tanggal_jurnal)))->where(DB::raw('year(tanggal_jurnal)'), date('Y', strtotime($tanggal_jurnal)))->where(DB::raw('substring(no_jurnal, 1, 2)'), $type_transaksi)->orderBy('jurnal_id', 'desc')->first();

		$next_jurnal = ($jurnal_cek) ? (int)substr($jurnal_cek->no_jurnal, -5) : 0;

		$bukti_jurnal = $type_transaksi.'-'.date('myd', strtotime($tanggal_jurnal)).str_pad(($next_jurnal + 1), 5, '0', STR_PAD_LEFT);

		$id_jurnal = (DB::table('d_jurnal')->max('jurnal_id')) ? (DB::table('d_jurnal')->max('jurnal_id') + 1) : 1;

		// return json_encode($detail);

		DB::table('d_jurnal')->insert([
			'jurnal_id'			 => $id_jurnal,
			'no_jurnal'		 	 => $bukti_jurnal,
			'jurnal_ref'		 => $referensi,
			'tanggal_jurnal'	 => date('Y-m-d', strtotime($tanggal_jurnal)),
			'keterangan'		 => $keterangan
		]);

		foreach ($detail as $key => $detail_data) {
			$akun = DB::table('d_akun')->where('id_akun', $detail_data['td_acc'])->first();
    		$pos = $detail_data['td_posisi'];
    		$val = $detail_data['value'];

    		if($akun->posisi_akun != $pos){
    			$val = '-'.$detail_data['value'];
    		}

    		// return json_encode($akun);

    		DB::table('d_jurnal_dt')->insert([
    			'jrdt_jurnal'	=> $id_jurnal,
    			'jrdt_no'		=> ($key+1),
    			'jrdt_acc' 		=> $detail_data["td_acc"],
    			'jrdt_value'	=> $val,
    			'jrdt_dk'		=> $pos
    		]);
		}

		return 'okee';

	}

	function _updateJournal_from_transaksi($referensi, $tanggal_jurnal, $keterangan, $id_transaksi, $value){
		$transaksi = DB::table('m_transaksi')->where('id_transaksi', $id_transaksi)->first();
		$jurnal = DB::table('d_jurnal')->where('jurnal_ref', $referensi);

		$jurnal_cek = DB::table('d_jurnal')->where(DB::raw('month(tanggal_jurnal)'), date('n', strtotime($tanggal_jurnal)))->where(DB::raw('year(tanggal_jurnal)'), date('Y', strtotime($tanggal_jurnal)))->where(DB::raw('substring(no_jurnal, 1, 2)'), $transaksi->type_transaksi)->orderBy('jurnal_id', 'desc')->first();

		$next_jurnal = ($jurnal_cek) ? (int)substr($jurnal_cek->no_jurnal, -5) : 0;

		if(date('n-Y', strtotime($jurnal->first()->tanggal_jurnal)) != date('n-Y', strtotime($tanggal_jurnal)) || substr($jurnal->first()->no_jurnal, 0, 2) != $type_transaksi)
			$bukti_jurnal = $transaksi->type_transaksi.'-'.date('myd', strtotime($tanggal_jurnal)).str_pad(($next_jurnal + 1), 5, '0', STR_PAD_LEFT);
		else
			$bukti_jurnal = $jurnal->first()->no_jurnal;

		// return json_encode($bukti_jurnal);

		$jurnal->update([
			'no_jurnal'		 	 => $bukti_jurnal,
			'tanggal_jurnal'	 => date('Y-m-d', strtotime($tanggal_jurnal)),
			'keterangan'		 => $keterangan
		]);

		DB::table('d_jurnal_dt')->where('jrdt_jurnal', $jurnal->first()->jurnal_id)->delete();
		$detail = DB::table('m_transaksi_detail')->where('td_transaksi', $id_transaksi)->get();

		foreach ($detail as $key => $detail_data) {
			$akun = DB::table('d_akun')->where('id_akun', $detail_data->td_acc)->first();
    		$pos = $detail_data->td_posisi;
    		$val = $value[$key];

    		if($akun->posisi_akun != $pos){
    			$val = '-'.$value[$key];
    		}

    		// return json_encode($akun);

    		DB::table('d_jurnal_dt')->insert([
    			'jrdt_jurnal'	=> $jurnal->first()->jurnal_id,
    			'jrdt_no'		=> ($key+1),
    			'jrdt_acc' 		=> $detail_data->td_acc,
    			'jrdt_value'	=> $val,
    			'jrdt_dk'		=> $pos
    		]);
		}
		return 'okee';
	}

	function _updateJournal_self_detail($referensi, $type_transaksi, $tanggal_jurnal, $keterangan, $detail){
		// $transaksi = DB::table('m_transaksi')->where('id_transaksi', $id_transaksi)->first();
		$jurnal = DB::table('d_jurnal')->where('jurnal_ref', $referensi);

		$jurnal_cek = DB::table('d_jurnal')->where(DB::raw('month(tanggal_jurnal)'), date('n', strtotime($tanggal_jurnal)))->where(DB::raw('year(tanggal_jurnal)'), date('Y', strtotime($tanggal_jurnal)))->where(DB::raw('substring(no_jurnal, 1, 2)'), $type_transaksi)->orderBy('jurnal_id', 'desc')->first();

		$next_jurnal = ($jurnal_cek) ? (int)substr($jurnal_cek->no_jurnal, -5) : 0;

		if(date('n-Y', strtotime($jurnal->first()->tanggal_jurnal)) != date('n-Y', strtotime($tanggal_jurnal)) || substr($jurnal->first()->no_jurnal, 0, 2) != $type_transaksi)
			$bukti_jurnal = $type_transaksi.'-'.date('myd', strtotime($tanggal_jurnal)).str_pad(($next_jurnal + 1), 5, '0', STR_PAD_LEFT);
		else
			$bukti_jurnal = $jurnal->first()->no_jurnal;

		// return json_encode($bukti_jurnal);

		$jurnal->update([
			'no_jurnal'		 	 => $bukti_jurnal,
			'tanggal_jurnal'	 => date('Y-m-d', strtotime($tanggal_jurnal)),
			'keterangan'		 => $keterangan
		]);

		DB::table('d_jurnal_dt')->where('jrdt_jurnal', $jurnal->first()->jurnal_id)->delete();

		foreach ($detail as $key => $detail_data) {
			$akun = DB::table('d_akun')->where('id_akun', $detail_data['td_acc'])->first();
    		$pos = $detail_data['td_posisi'];
    		$val = $detail_data['value'];

    		if($akun->posisi_akun != $pos){
    			$val = '-'.$detail_data['value'];
    		}

    		// return json_encode($akun);

    		DB::table('d_jurnal_dt')->insert([
    			'jrdt_jurnal'	=> $jurnal->first()->jurnal_id,
    			'jrdt_no'		=> ($key+1),
    			'jrdt_acc' 		=> $detail_data["td_acc"],
    			'jrdt_value'	=> $val,
    			'jrdt_dk'		=> $pos
    		]);
		}

		return 'okee';
	}
	
	function _delete_jurnal($ref){
		$jurnal = DB::table('d_jurnal')->where('jurnal_ref', $ref);

		if(!$jurnal->first())
			return 'false';

		DB::table('d_jurnal_dt')->where('jrdt_jurnal', $jurnal->first()->jurnal_id)->delete();
		$jurnal->delete();

		return 'true';
	}

	function count_neraca($array, $id_group, $status, $tanggal){
		$total = 0;

		foreach ($array as $key => $data) {
			if($data->id_group == $id_group){
				foreach ($data->akun_neraca as $key => $detail) {
					$mutasi = (count($detail->mutasi_bank_debet) > 0) ? $detail->mutasi_bank_debet[0]->total : 0;
					$saldo = $detail->opening_balance;

					if($status == 'aktiva' && $detail->posisi_akun == 'K'){
						$mutasi = $mutasi * -1;
					}elseif($status == 'pasiva' && $detail->posisi_akun == 'D'){
						$mutasi = $mutasi * -1;
					}

					$total += ($saldo + $mutasi);
				}
			}
		}

		return $total;
	}

	function count_laba_rugi($array, $id_group, $status, $tanggal){
		$total = 0;

		foreach ($array as $key => $data) {
			if($data->id_group == $id_group){
				foreach ($data->akun_laba_rugi as $key => $detail) {
					$mutasi = (count($detail->mutasi_bank_debet) > 0) ? $detail->mutasi_bank_debet[0]->total : 0;
					$saldo = $detail->opening_balance;

					if($status == 'aktiva' && $detail->posisi_akun == 'K'){
						$mutasi = $mutasi * -1;
					}elseif($status == 'pasiva' && $detail->posisi_akun == 'D'){
						$mutasi = $mutasi * -1;
					}

					$total += ($saldo + $mutasi);
				}
			}
		}

		return $total;
	}

?>