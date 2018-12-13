<?php

	// Jurnal Setting
		
		function jurnal_setting(){
			
			// ! penting (Pliss . Jangan Diubah Sebelum Konfirmasi Ke Pihak Yang Mengerjakan Keuangan)

			$setting = [
				'allow_jurnal_to_execute'	=> false,
			];


			return (object) $setting;
		}
		
	// end jurnal setting




	// -----------------------------------------------------------------------------------------------------------------

	// Fungsi Fungsi Helper

	// -----------------------------------------------------------------------------------------------------------------
	
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

		$num = 0;
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
    			'jrdt_no'		=> ($num+1),
    			'jrdt_acc' 		=> $detail_data->td_acc,
    			'jrdt_value'	=> $val,
    			'jrdt_dk'		=> $pos,
    			'jrdt_cashflow'	=> (isset($detail_data["cashflow"])) ? $detail_data["cashflow"] : null,
    		]);

    		$num++;
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

		$num = 0;
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
    			'jrdt_no'		=> ($num+1),
    			'jrdt_acc' 		=> $detail_data["td_acc"],
    			'jrdt_value'	=> $val,
    			'jrdt_dk'		=> $pos,
    			'jrdt_cashflow'	=> (isset($detail_data["cashflow"])) ? $detail_data["cashflow"] : null,
    		]);

    		$num++;
		}

		properSaldo(DB::table('d_jurnal')->where('jurnal_id', $id_jurnal)->first());

		return true;

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

		dropSaldo($jurnal->first());

		DB::table('d_jurnal_dt')->where('jrdt_jurnal', $jurnal->first()->jurnal_id)->delete();
		$detail = DB::table('m_transaksi_detail')->where('td_transaksi', $id_transaksi)->get();

		$num = 0;
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
    			'jrdt_no'		=> ($num+1),
    			'jrdt_acc' 		=> $detail_data->td_acc,
    			'jrdt_value'	=> $val,
    			'jrdt_dk'		=> $pos,
    			'jrdt_cashflow'	=> (isset($detail_data["cashflow"])) ? $detail_data["cashflow"] : null,
    		]);

    		$num++;
		}

		properSaldo($jurnal->first());
		
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

		dropSaldo($jurnal->first());

		DB::table('d_jurnal_dt')->where('jrdt_jurnal', $jurnal->first()->jurnal_id)->delete();

		$num = 0;
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
    			'jrdt_no'		=> ($num+1),
    			'jrdt_acc' 		=> $detail_data["td_acc"],
    			'jrdt_value'	=> $val,
    			'jrdt_dk'		=> $pos,
    			'jrdt_cashflow'	=> (isset($detail_data["cashflow"])) ? $detail_data["cashflow"] : null,
    		]);

    		$num++;
		}

		properSaldo($jurnal->first());

		return 'okee';
	}
	
	function _delete_jurnal($ref){
		$jurnal = DB::table('d_jurnal')->where('jurnal_ref', $ref);

		if(!$jurnal->first())
			return 'false';

		dropSaldo($jurnal->first());
		$jurnal->delete();

		return 'true';
	}

	function count_neraca($array, $id_group, $status, $tanggal){
		$total = 0;

		foreach ($array as $key => $data) {
			if($data->id_group == $id_group){
				foreach ($data->akun_neraca as $key => $detail) {
					$mutasi = $detail->saldo;

					if($status == 'aktiva' && $detail->posisi_akun == 'K'){
						$mutasi = $mutasi * -1;
					}elseif($status == 'pasiva' && $detail->posisi_akun == 'D'){
						$mutasi = $mutasi * -1;
					}

					$total +=  $mutasi;
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
					$mutasi = $detail->saldo;

					if($status == 'pasiva' && $detail->posisi_akun == 'K'){
						$mutasi = $mutasi;
					}elseif($status == 'pasiva' && $detail->posisi_akun == 'D'){
						$mutasi = $mutasi * -1;
					}

					$total += $mutasi;
				}
			}
		}

		return $total;
	}

	function periodeExist(){
		$periode = date('Y-m'.'-01');
		$data = DB::table('d_periode_keuangan')
					->where('pk_periode', $periode)->first();

		if($data)
			return true;

		return false;
	}

	function nullperiode(){
		$data = DB::table('d_periode_keuangan')->select('*')->get();

		if(count($data) != 0)
			return false;

		return true;
	}

	function formatAccounting($number){
		$data = ($number < 0) ? '('.number_format(str_replace('-', '', $number), 2).')' : number_format($number, 2);
		return $data;
	}

	function properSaldo($jurnal){
		$d1 = date('Y-m', strtotime($jurnal->tanggal_jurnal)).'-01';
		$flag = substr($jurnal->no_jurnal, 0, 1);
		
		$data = DB::table('d_jurnal_dt')
					->join('d_akun', 'd_akun.id_akun', '=', 'd_jurnal_dt.jrdt_acc')
					->where('jrdt_jurnal', $jurnal->jurnal_id)
					->select('d_jurnal_dt.*', 'd_akun.posisi_akun')
					->get();

		$allowPeriode = DB::table('d_periode_keuangan')->where('pk_periode', $d1)->first();

		foreach ($data as $key => $detail) {

			$periode = DB::table('d_akun_saldo')->where('periode', '>=', $d1)->where('id_akun', $detail->jrdt_acc)->get();

			foreach($periode as $key => $period){
				$saldoAwal 				= $period->saldo_awal;
				$mutasiKasDebet 		= $period->mutasi_kas_debet;
				$mutasiKasKredit 		= $period->mutasi_kas_kredit; 
				$mutasiBankDebet 		= $period->mutasi_bank_debet;
				$mutasiBankKredit 		= $period->mutasi_bank_kredit;
				$mutasiMemorialDebet 	= $period->mutasi_memorial_debet;
				$mutasiMemorialKredit 	= $period->mutasi_memorial_kredit;
				$saldoAkhir				= $period->saldo_akhir;
				$feeder = [];

				switch ($flag) {
					case 'K':
						if($detail->jrdt_dk == 'D')
							$mutasiKasDebet += str_replace('-', '', $detail->jrdt_value);
						else
							$mutasiKasKredit += str_replace('-', '', $detail->jrdt_value);
						break;
					
					case 'B':
						if($detail->jrdt_dk == 'D')
							$mutasiBankDebet += str_replace('-', '', $detail->jrdt_value);
						else
							$mutasiBankKredit += str_replace('-', '', $detail->jrdt_value);
						break;

					case 'M':
						if($detail->jrdt_dk == 'D')
							$mutasiMemorialDebet += str_replace('-', '', $detail->jrdt_value);
						else
							$mutasiMemorialKredit += str_replace('-', '', $detail->jrdt_value);
						break;
				}

				if($allowPeriode && $period->periode == $d1){
					$feeder = [
						"saldo_awal"				=> $saldoAwal,
						"mutasi_bank_debet"			=> $mutasiBankDebet,
						"mutasi_bank_kredit"		=> $mutasiBankKredit,
						"mutasi_kas_debet"			=> $mutasiKasDebet,
						"mutasi_kas_kredit"			=> $mutasiKasKredit,
						"mutasi_memorial_debet"		=> $mutasiMemorialDebet,
						"mutasi_memorial_kredit"	=> $mutasiMemorialKredit,
						"saldo_akhir"				=> $saldoAkhir + $detail->jrdt_value
					];
				}else if($allowPeriode){
					$feeder = [
						"saldo_awal"				=> $saldoAwal + $detail->jrdt_value,
						"saldo_akhir"				=> $saldoAkhir + $detail->jrdt_value
					];
				}

				DB::table('d_akun_saldo')
					->where('id_akun', $detail->jrdt_acc)
					->where('periode', $period->periode)
					->update($feeder);
			}

		}
	}

	function dropSaldo($jurnal){
		$d1 = date('Y-m', strtotime($jurnal->tanggal_jurnal)).'-01';
		$flag = substr($jurnal->no_jurnal, 0, 1);
		
		$data = DB::table('d_jurnal_dt')
					->join('d_akun', 'd_akun.id_akun', '=', 'd_jurnal_dt.jrdt_acc')
					->where('jrdt_jurnal', $jurnal->jurnal_id)
					->select('d_jurnal_dt.*', 'd_akun.posisi_akun')
					->get();

		$allowPeriode = DB::table('d_periode_keuangan')->where('pk_periode', $d1)->first();

		foreach ($data as $key => $detail) {

			$periode = DB::table('d_akun_saldo')->where('periode', '>=', $d1)->where('id_akun', $detail->jrdt_acc)->get();

			foreach($periode as $key => $period){
				$saldoAwal 				= $period->saldo_awal;
				$mutasiKasDebet 		= $period->mutasi_kas_debet;
				$mutasiKasKredit 		= $period->mutasi_kas_kredit; 
				$mutasiBankDebet 		= $period->mutasi_bank_debet;
				$mutasiBankKredit 		= $period->mutasi_bank_kredit;
				$mutasiMemorialDebet 	= $period->mutasi_memorial_debet;
				$mutasiMemorialKredit 	= $period->mutasi_memorial_kredit;
				$saldoAkhir				= $period->saldo_akhir;
				$feeder = [];

				switch ($flag) {
					case 'K':
						if($detail->jrdt_dk == 'D')
							$mutasiKasDebet -= str_replace('-', '', $detail->jrdt_value);
						else
							$mutasiKasKredit -= str_replace('-', '', $detail->jrdt_value);
						break;
					
					case 'B':
						if($detail->jrdt_dk == 'D')
							$mutasiBankDebet -= str_replace('-', '', $detail->jrdt_value);
						else
							$mutasiBankKredit -= str_replace('-', '', $detail->jrdt_value);
						break;

					case 'M':
						if($detail->jrdt_dk == 'D')
							$mutasiMemorialDebet -= str_replace('-', '', $detail->jrdt_value);
						else
							$mutasiMemorialKredit -= str_replace('-', '', $detail->jrdt_value);
						break;
				}

				if($allowPeriode && $period->periode == $d1){
					$feeder = [
						"saldo_awal"				=> $saldoAwal,
						"mutasi_bank_debet"			=> $mutasiBankDebet,
						"mutasi_bank_kredit"		=> $mutasiBankKredit,
						"mutasi_kas_debet"			=> $mutasiKasDebet,
						"mutasi_kas_kredit"			=> $mutasiKasKredit,
						"mutasi_memorial_debet"		=> $mutasiMemorialDebet,
						"mutasi_memorial_kredit"	=> $mutasiMemorialKredit,
						"saldo_akhir"				=> $saldoAkhir - $detail->jrdt_value
					];
				}else if($allowPeriode){
					$feeder = [
						"saldo_awal"				=> $saldoAwal - $detail->jrdt_value,
						"saldo_akhir"				=> $saldoAkhir - $detail->jrdt_value
					];
				}

				DB::table('d_akun_saldo')
					->where('id_akun', $detail->jrdt_acc)
					->where('periode', $period->periode)
					->update($feeder);
			}

		}
	}

?>