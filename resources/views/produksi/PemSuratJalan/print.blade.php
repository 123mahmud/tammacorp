<!DOCTYPE html>
<html>
<head>
	<title>BARANG PENGAMBILAN</title>
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
			size: portrait;
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

	@for($i=0;$i<count($data);$i++)
	
		<div class="div-page-break">
				<h1 class="s16">TAMMA ROBAH INDONESIA</h1>
				<small>Jl. Raya Randu no.74<br>
					Sidotopo Wetan - Surabaya

				</small>
				<table class="border-none" width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<td class="s16 underline bold text-center" colspan="3">BARANG PENGAMBILAN</td>
					</tr>
					<tr>
						<td width="70%">
							Gudang Asal : <label class="bold"></label><br>
							Gudang Tujuan : <label class="bold"></label><br>
						</td>
						<td>
							No. Bukti : <label class="bold">{{ $nota_do }}</label><br>
							Tanggal : <label class="bold">{{date('d M Y')}}</label><br>
							No. Permintaan : <label class="bold"></label>
						</td>
					</tr>
				</table>
				<table width="100%" cellpadding="3px" class="tabel" border="1px">
					<tr class="text-center">
						<td>No</td>
						<td>Kode Barang</td>
						<td>Nama Barang</td>
						<td colspan="2">Unit</td>
						<td>HrgJual1</td>
						<td>HrgJual2</td>
						<td>HrgJual3</td>
						
					</tr>

					@for($j=0;$j<count($data[$i]);$j++)
						<tr>
							<td width="1%" class="text-center">{{$j+1}}</td>
							<td>{{$data[$i][$j]['i_code']}}</td>
							<td>{{$data[$i][$j]['i_name']}}</td>
							<td class="text-right border-none-right">{{number_format($data[$i][$j]['prdt_qty'],2,',','.')}}</td>
							<td class="text-right" width="1%">{{$data[$i][$j]['m_sname']}}</td>
							<td>
								<div class="float-left">
									Rp.
								</div>
								<div class="float-right">
									{{number_format($data[$i][$j]['m_psell1'],2,',','.')}}
								</div>
							</td>
							<td>
								<div class="float-left">
									Rp.
								</div>
								<div class="float-right">
									{{number_format($data[$i][$j]['m_psell2'],2,',','.')}}
								</div>
							</td>
							<td>
								<div class="float-left">
									Rp.
								</div>
								<div class="float-right">
									{{number_format($data[$i][$j]['m_psell3'],2,',','.')}}
								</div>
							</td>
							
						</tr>
					@endfor


					<?php
					
						$kosong = [];
						$hitung = 20 - count($data[$i]);

						for ($a=0; $a < $hitung; $a++) { 
							array_push($kosong, 'a');
						}
					?>
					@foreach($kosong as $index => $coeg)
					<tr>
						<td class="text-center empty"></td>
						<td></td>
						<td></td>
						<td class="border-none-right"></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					@endforeach
					
					
					<tr>
						<td colspan="3" class=""></td>
						<td class="text-right border-none-right border-none-left top" style="height: 50px;">{{number_format($total[0]['total_qty'],2,',','.')}}</td>
						<td colspan="4"></td>
					</tr>
					<tr>
						<td colspan="8">
							<div class="top" style="margin-bottom: 50px;">
								<h1>Catatan :</h1>
								<small></small>
							</div>
							<div class="float-left text-center" style="margin-left: 50px;">
								<div class="top">
									Diserahkan oleh,
								</div>
								<div class="bottom" style="margin-top: 40px;">
									(........................................)
								</div>
							</div>
							<div class="float-right text-center" style="margin-right: 50px;">
								<div class="top">
									Diterima oleh,
								</div>
								<div class="bottom" style="margin-top: 40px;">
									(........................................)
								</div>
							</div>
						</td>
					</tr>
				</table>
						
		</div>
		
	@endfor
		
	</div>
</body>
</html>