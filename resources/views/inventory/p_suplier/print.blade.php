<!DOCTYPE html>
<html>
<head>
	<title>FORM PENERIMAAN PEMBELIAN</title>
	<style type="text/css">
		*{
			font-size: 12px;
		}
		.s16{
			font-size: 14px !important;
		}
		.div-width{
			margin: auto;
			width: 95vw;
		}
		.underline{
			text-decoration: underline;
		}
		.italic{
			font-style: italic;
		}
		.bold{
			font-weight: bold;
		}
		.text-center{
			text-align: center;
		}
		.text-right{
			text-align: right;
		}
		.border-none-right{
			border-right: hidden;
		}
		.border-none-left{
			border-left:hidden;
		}
		.border-none-top{
			border-top: hidden;
		}
		.border-none-bottom{
			border-bottom: hidden;
		}
		.border-none-all{
			border: hidden;
		}
		.float-left{
			float: left;
		}
		.float-right{
			float: right;
		}
		.top{
			vertical-align: text-top;
		}
		.vertical-baseline{
			vertical-align: baseline;
		}
		.bottom{
			vertical-align: text-bottom;
		}
		.ttd{
			top: 0;
			position: absolute;
		}
		.relative{
			position: relative;
		}
		.absolute{
			position: absolute;
		}
		.empty{
			height: 15px;
		}
		table,td{
			border:1px solid black;
		}
		table{
			border-collapse: collapse;
		}
		table.border-none ,.border-none td, .border-none tr{
			border:none !important;
		}
		@media print{
			.btn-print{
				display: none;
			}
		}
		@page{
			size: landscape;
			margin: 0;
		}
		.div-page-break{
			page-break-after: always;
		}
		.border-hidden tr, .border-hidden td{
			border: hidden;
		}
		.btn-print{
			right: 10px;
			position: absolute;
		}
</style>
</head>
<body>
	<div class="btn-print">
		<button onclick="javascript:window.print();">Print</button>
	</div>
	<div class="div-width">

		@for($i=0;$i<count($dataIsi);$i++)
		
			<div class="div-page-break">
					<h1 class="s16">TAMMA ROBAH INDONESIA</h1>
					<table class="border-none" width="100%" cellspacing="0" cellpadding="0">
						<tr>
							<td class="s16 underline bold text-center" colspan="3">FORM PENERIMAAN PEMBELIAN</td>
						</tr>
						<tr>
							<td width="80%">
								Nota Return Pembelian : <label class="bold">{{$dataHeader[0]['d_tb_noreff']}}</label><br>
								Tanggal Penerimaan : <label class="bold">{{date('d M Y',strtotime($dataHeader[0]['d_tb_date']))}}</label><br>
								Suplier : <label class="bold">{{$dataHeader[0]['s_name']}}</label>
							</td>
							<td>
								Kode Penerimaan : <label class="bold">{{$dataHeader[0]['d_tb_code']}}</label><br>
								Staff : <label class="bold">{{$dataHeader[0]['m_name']}}</label><br>
								Metode Pembelian : <label class="bold">{{$dataHeader[0]['d_pcs_method']}}</label><br>
							</td>
						</tr>
					</table>
					<table width="100%" cellpadding="3px" class="tabel" border="1px">
						<tr class="text-center">
							<td>No</td>
							<td>Kode | Barang</td>
							<td>Qty</td>
							<td>Qty Terima</td>
							<td>Satuan</td>
							<td>Stok</td>
						</tr>

						@for($j=0;$j<count($dataIsi[$i]);$j++)
							<tr>
								<td width="5%" class="text-center">{{$j+1}}</td>
								<td>{{$dataIsi[$i][$j]['i_code']}} {{$dataIsi[$i][$j]['i_name']}}</td>
								<td width="10%" class="text-center">{{$dataIsi[$i][$j]['d_pcsdt_qtyconfirm']}}</td>
								<td width="10%">{{$dataIsi[$i][$j]['d_tbdt_qty']}}</td>
								<td width="10%">{{$dataIsi[$i][$j]['m_sname']}}</td>
								<td width="15%">{{ $val_stock[$i][$j]->qtyStok }} {{ $txt_satuan[$i][$j] }}</td>
								
							</tr>
						@endfor


						<?php
							$kosong = [];
							$hitung = 14 - count($dataIsi[$i]);

							for ($a=0; $a < $hitung; $a++) { 
								array_push($kosong, 'a');
							}
						?>
						@foreach($kosong as $index => $we)
						<tr>
							<td class="text-center empty"></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						@endforeach
						
						
						<tr>
							<td colspan="6" class="border-none-bottom border-none-right border-none-left empty"></td>
						</tr>
						
					</table>
							<div class="float-left" style="margin-left: 3vw;">
								<div class="top">
									Mengetahui,
								</div>
								<div class="bottom" style="margin-top: 40px;">
									(......................................)
								</div>
							</div>
							<div class="float-left" style="margin-left: 25px;">
								<div class="top">
									Finance,
								</div>
								<div class="bottom" style="margin-top: 40px;">
									(......................................)
								</div>
							</div>
							<div class="float-right" style="margin-right: 25px;">
								<div class="top">
									Pemohon,
								</div>
								<div class="bottom" style="margin-top: 40px;">
									(......................................)
								</div>
							</div>
							<div class="float-right" style="margin-right: 3vw;">
								<div class="top">
									Purchasing,
								</div>
								<div class="bottom" style="margin-top: 40px;">
									({{Auth::user()->m_name}})
								</div>
							</div>
			</div>
			
		@endfor
	</div>

	<div style="padding-top: 100px;">
		<hr>
	</div>

	<div class="div-width">

		@for($i=0;$i<count($dataIsi);$i++)
		
			<div class="div-page-break">
					<h1 class="s16">TAMMA ROBAH INDONESIA</h1>
					<table class="border-none" width="100%" cellspacing="0" cellpadding="0">
						<tr>
							<td class="s16 underline bold text-center" colspan="3">FORM PENERIMAAN PEMBELIAN</td>
						</tr>
						<tr>
							<td width="80%">
								Nota Return Pembelian : <label class="bold">{{$dataHeader[0]['d_tb_noreff']}}</label><br>
								Tanggal Penerimaan : <label class="bold">{{date('d M Y',strtotime($dataHeader[0]['d_tb_date']))}}</label><br>
								Suplier : <label class="bold">{{$dataHeader[0]['s_name']}}</label>
							</td>
							<td>
								Kode Penerimaan : <label class="bold">{{$dataHeader[0]['d_tb_code']}}</label><br>
								Staff : <label class="bold">{{$dataHeader[0]['m_name']}}</label><br>
								Metode Pembelian : <label class="bold">{{$dataHeader[0]['d_pcs_method']}}</label><br>
							</td>
						</tr>
					</table>
					<table width="100%" cellpadding="3px" class="tabel" border="1px">
						<tr class="text-center">
							<td>No</td>
							<td>Kode | Barang</td>
							<td>Qty</td>
							<td>Qty Terima</td>
							<td>Satuan</td>
							<td>Stok</td>
						</tr>

						@for($j=0;$j<count($dataIsi[$i]);$j++)
							<tr>
								<td width="1%" class="text-center">{{$j+1}}</td>
								<td>{{$dataIsi[$i][$j]['i_code']}} {{$dataIsi[$i][$j]['i_name']}}</td>
								<td width="1%" class="text-center">{{$dataIsi[$i][$j]['d_pcsdt_qtyconfirm']}}</td>
								<td width="1%">{{$dataIsi[$i][$j]['d_tbdt_qty']}}</td>
								<td width="1%">{{$dataIsi[$i][$j]['m_sname']}}</td>
								<td width="10%">{{ $val_stock[$i][$j]->qtyStok }} {{ $txt_satuan[$i][$j] }}</td>
								
							</tr>
						@endfor


						<?php
							$kosong = [];
							$hitung = 14 - count($dataIsi[$i]);

							for ($a=0; $a < $hitung; $a++) { 
								array_push($kosong, 'a');
							}
						?>
						@foreach($kosong as $index => $we)
						<tr>
							<td class="text-center empty"></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						@endforeach
						
						
						<tr>
							<td colspan="6" class="border-none-bottom border-none-right border-none-left empty"></td>
						</tr>
						
					</table>
							<div class="float-left" style="margin-left: 3vw;">
								<div class="top">
									Mengetahui,
								</div>
								<div class="bottom" style="margin-top: 40px;">
									(......................................)
								</div>
							</div>
							<div class="float-left" style="margin-left: 25px;">
								<div class="top">
									Finance,
								</div>
								<div class="bottom" style="margin-top: 40px;">
									(......................................)
								</div>
							</div>
							<div class="float-right" style="margin-right: 25px;">
								<div class="top">
									Pemohon,
								</div>
								<div class="bottom" style="margin-top: 40px;">
									(......................................)
								</div>
							</div>
							<div class="float-right" style="margin-right: 3vw;">
								<div class="top">
									Purchasing,
								</div>
								<div class="bottom" style="margin-top: 40px;">
									({{Auth::user()->m_name}})
								</div>
							</div>
			</div>
			
		@endfor
	</div>
</body>
</html>