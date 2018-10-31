<!DOCTYPE html>
<html>
<head>
	<title>SURAT JALAN RETURN PEMBELIAN</title>
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
						<td class="s16 underline bold text-center" colspan="3">SURAT JALAN RETUR PEMBELIAN</td>
					</tr>
					<tr>
						<td width="80%">
							No Surat Jalan : <label class="bold">{{$dataHeader[0]['d_pcsr_code']}}</label><br>
							Tanggal Surat Jalan : <label class="bold">{{date('d M Y',strtotime($dataHeader[0]['d_pcsr_datecreated']))}}</label><br>
							Nama Staff : <label class="bold">{{$dataHeader[0]['m_name']}}</label><br>
						</td>
						<td>
							Suplier : <label class="bold">{{$dataHeader[0]['s_company']}}</label><br>
							No PO : <label class="bold">{{$dataHeader[0]['d_pcs_code']}}</label><br>
							@if ($dataHeader[0]['d_pcsr_method'] == "PN")
								Metode Retur : <label class="bold"> Potong Nota </label><br>
							@elseif ($dataHeader[0]['d_pcsr_method'] == "TK")
								Metode Retur : <label class="bold"> Tukar Barang </label><br>
							@endif
						</td>
					</tr>
				</table>

				<table width="100%" cellpadding="3px" class="tabel" border="1px" style="border-bottom: 0px; border-right: 0px;" >
					<tr class="text-center">
						<td width="5%">No</td>
						<td width="30%" colspan="3">Nama Item</td>
						<td width="5%">Satuan</td>
						<td width="10%">Quantity</td>
						<td width="10%">Harga</td>
						<td width="15%">Total</td>
					</tr>

					@for($j=0;$j<count($dataIsi[$i]);$j++)
						<tr>
							<td class="text-center">{{$j+1}}</td>
							<td colspan="3">{{$dataIsi[$i][$j]['i_name']}}</td>
							<td class="text-center">{{$dataIsi[$i][$j]['m_sname']}}</td>
							<td style="text-align: center;">{{number_format($dataIsi[$i][$j]['d_pcsrdt_qty'],0,',','.')}}</td>
							<td>
								<div class="float-left">
									Rp.
								</div>
								<div class="float-right">
									{{ number_format($dataIsi[$i][$j]['d_pcsrdt_price'],2,',','.')}}
								</div>
							</td>
							<td>
								<div class="float-left">
									Rp.
								</div>
								<div class="float-right">
									{{ number_format($dataIsi[$i][$j]['d_pcsrdt_pricetotal'],2,',','.')}}
								</div>
							</td>
						</tr>
					@endfor
					<?php
						$kosong = [];
						$hitung = 10 - count($dataIsi[$i]);

						for ($a=0; $a < $hitung; $a++) { 
							array_push($kosong, 'a');
						}
					?>
					@foreach($kosong as $index => $we)
						<tr>
							<td class="text-center empty"></td>
							<td colspan="3"></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					@endforeach
					<tr>
						<td colspan="6" class="border-none-bottom border-none-right border-none-left empty"></td>
					</tr>
					<tr class="border-hidden">
						<td colspan="2">Nett : <label class="bold">{{$data['hargaTotalReturn']}}</label></td>
						<td colspan="4">Total : <label class="bold">{{$data['hargaTotalReturn']}}</label></td>
					</tr>
					<tr class="border-hidden">
						<td class="empty"></td>
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
						<td class="s16 underline bold text-center" colspan="3">SURAT JALAN RETUR PEMBELIAN</td>
					</tr>
					<tr>
						<td width="80%">
							No Surat Jalan : <label class="bold">{{$dataHeader[0]['d_pcsr_code']}}</label><br>
							Tanggal Surat Jalan : <label class="bold">{{date('d M Y',strtotime($dataHeader[0]['d_pcsr_datecreated']))}}</label><br>
							Nama Staff : <label class="bold">{{$dataHeader[0]['m_name']}}</label><br>
						</td>
						<td>
							Suplier : <label class="bold">{{$dataHeader[0]['s_company']}}</label><br>
							No PO : <label class="bold">{{$dataHeader[0]['d_pcs_code']}}</label><br>
							@if ($dataHeader[0]['d_pcsr_method'] == "PN")
								Metode Retur : <label class="bold"> Potong Nota </label><br>
							@elseif ($dataHeader[0]['d_pcsr_method'] == "TK")
								Metode Retur : <label class="bold"> Tukar Barang </label><br>
							@endif
						</td>
					</tr>
				</table>

				<table width="100%" cellpadding="3px" class="tabel" border="1px" style="border-bottom: 0px; border-right: 0px;" >
					<tr class="text-center">
						<td width="5%">No</td>
						<td width="30%" colspan="3">Nama Item</td>
						<td width="5%">Satuan</td>
						<td width="10%">Quantity</td>
						<td width="10%">Harga</td>
						<td width="15%">Total</td>
					</tr>

					@for($j=0;$j<count($dataIsi[$i]);$j++)
						<tr>
							<td class="text-center">{{$j+1}}</td>
							<td colspan="3">{{$dataIsi[$i][$j]['i_name']}}</td>
							<td class="text-center">{{$dataIsi[$i][$j]['m_sname']}}</td>
							<td style="text-align: center;">{{number_format($dataIsi[$i][$j]['d_pcsrdt_qty'],0,',','.')}}</td>
							<td>
								<div class="float-left">
									Rp.
								</div>
								<div class="float-right">
									{{ number_format($dataIsi[$i][$j]['d_pcsrdt_price'],2,',','.')}}
								</div>
							</td>
							<td>
								<div class="float-left">
									Rp.
								</div>
								<div class="float-right">
									{{ number_format($dataIsi[$i][$j]['d_pcsrdt_pricetotal'],2,',','.')}}
								</div>
							</td>
						</tr>
					@endfor
					<?php
						$kosong = [];
						$hitung = 10 - count($dataIsi[$i]);

						for ($a=0; $a < $hitung; $a++) { 
							array_push($kosong, 'a');
						}
					?>
					@foreach($kosong as $index => $we)
						<tr>
							<td class="text-center empty"></td>
							<td colspan="3"></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					@endforeach
					<tr>
						<td colspan="6" class="border-none-bottom border-none-right border-none-left empty"></td>
					</tr>
					<tr class="border-hidden">
						<td colspan="2">Nett : <label class="bold">{{$data['hargaTotalReturn']}}</label></td>
						<td colspan="4">Total : <label class="bold">{{$data['hargaTotalReturn']}}</label></td>
					</tr>
					<tr class="border-hidden">
						<td class="empty"></td>
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