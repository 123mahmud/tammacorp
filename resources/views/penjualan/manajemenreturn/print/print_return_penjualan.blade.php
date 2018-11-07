<!DOCTYPE html>
<html>
<head>
	<title>NOTA RETURN PENJUALAN</title>
	<style type="text/css">
		* :not(h1):not(h2):not(h3):not(h4):not(h5):not(h6):not(small){
			font-size: 14px;
		}
		.s16{
			font-size: 16px !important;
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
		.text-left{
			text-align: left;
		}
		.border-none-right{
			border-right: hidden;
		}
		.border-none-left{
			border-left:hidden;
		}
		.border-none-bottom{
			border-bottom: hidden;
		}
		.border-none-top{
			border-top: hidden;
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
			height: 18px;
		}
		table,td{
			border:1px solid black;
		}
		table{
			border-collapse: collapse;
		}
		table.border-none ,.border-none td{
			border:none !important;
		}
		.position-top{
			vertical-align: top;
		}
		@page {
			size: portrait;
			margin:0;
		}
		@media print {
			.btn-print{
				display: none;
			}
		}
		fieldset{
			border: 1px solid black;
			margin:-.5px;
		}
		.btn-print button, .btn-print a{
			float: right;
		}
		.page-break-after{
			page-break-after: always;
		}
	</style>
</head>
<body>
	<div class="btn-print">
		<button type="button" onclick="javascript:window.print();">Print</button>
	</div>
	<div class="div-width">
		<div class="page-break-after">
			<table class="border-none" width="100%" cellspacing="0" cellpadding="0" style="margin-bottom: 5px;">
				<tr>
					
					<td class="s16 text-left" colspan="2">
						<h4>TAMMA ROBAH INDONESIA</h4>
						<small>
							Jl. Raya Randu no. 74<br>
							Sidotopo Wetan - Surabaya<br>
							Tlp. 031-51165528
						</small>
					</td>
				</tr>
				<tr>
					<td colspan="2" class="text-center bold">
						<h2>NOTA RETURN PENJUALAN</h2>
					</td>
				</tr>
				<tr>
					<td>
						<fieldset>
							Kepada Yth		:<br>
							{{ $dataCus->c_name }}<br>
							{{ $dataCus->c_address }}<br>
							{{ $dataCus->c_region }}
						</fieldset>
					</td>
					<td class="s16 position-top" width="40%">
						<table class="border-none" width="100%">
							<tr>
								<td class="s16">No. Bukti</td>
								<td class="s16">:</td>
								<td class="s16">{{ $dataCus->dsr_code }}</td>
							</tr>
							<tr>
								<td class="s16">Tanggal</td>
								<td class="s16">:</td>
								<td class="s16">{{ $dataCus->dsr_date }}</td>
							</tr>
						</table>
					</td>
					
				</tr>
			</table>
			<table width="100%" cellspacing="0" class="tabel" border="1px">
				<tr class="text-center">
					<td>No</td>
					<td>Kode Barang</td>
					<td>Nama Barang</td>
					<td colspan="2">Unit</td>
					<td width="10%">Harga</td>
					<td width="10%">Unit Disc</td>
					<td width="10%">Total</td>
				</tr>
				{{-- {{ dd($retur) }} --}}
				@for($i=0; $i<count($retur); $i++)
				<tr class="border-none-bottom">
					<td class="text-center">{{ $i + 1 }}</td>
					<td>{{ $retur[$i]['i_code'] }}</td>
					<td>{{ $retur[$i]['i_name'] }}</td>
					<td class="text-right" width="5%">{{ $retur[$i]['dsrdt_qty_confirm'] }}</td>
					<td class="text-right border-none-left" width="1%">{{ $retur[$i]['m_sname'] }}</td>
					<td class="text-right">{{number_format($retur[$i]['dsrdt_price'],0,',','.')}}</td>
					<td class="text-right">{{number_format($retur[$i]['dsrdt_disc_value'] + $retur[$i]['dsrdt_disc_vpercent'],0,',','.')}} </td>
					<td class="text-right">{{number_format($retur[$i]['dsrdt_return_price'] - ($retur[$i]['dsrdt_qty_confirm'] * $retur[$i]['dsrdt_disc_value']),0,',','.')}}</td>
				</tr>
				@endfor
				<?php
						$kosong = [];
						$hitung = 10 - count($retur);

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
							<td class="text-right border-none-left" width="1%"></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					@endforeach
				
				<tr class="border-none">
					<td colspan="3" class="top"></td>
					<td class="text-right top"></td>
					<td colspan="4">
						<table class="border-none float-right" width="90%">
							<tr>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Total Retur</td>
								<td>{{number_format($result,0,',','.')}}</td>
							</tr>
							<tr>
								<td>Total Diskon</td>
								<td>0,00</td>
							</tr>
							<tr>
								<td>SubTotal</td>
								<td>999.999.999,00</td>
							</tr>
							<tr>
								<td>PPn</td>
								<td>0,00</td>
							</tr>
							<tr>
								<td>Total</td>
								<td>999.999.999,00</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr class="border-none-bottom">
					<td colspan="8">
						<label class="bold">Catatan :</label><br>
						<small></small>
					</td>
				</tr>
				<tr>
					<td colspan="8">
						<table width="100%" class="border-none" cellpadding="25px">
							<tr>
								<td>
									<div class="float-left">
										<div class="text-center">
											Pengirim
										</div>
										<div style="width: 200px;border-bottom: 1px solid black;height: 100px;">
											
										</div>
									</div>
								</td>
								<td>
									<div class="float-left">
										<div class="text-center">
											Diterima Oleh,
										</div>
										<div style="width: 200px;border-bottom: 1px solid black;height: 100px;">
											
										</div>
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
	</div>
</body>
</html>