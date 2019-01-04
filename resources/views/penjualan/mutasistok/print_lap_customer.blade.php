<!DOCTYPE html>
<html>
<head>
	<title>Laporan Penjualan</title>
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
			border-right: none;
		}
		.border-none-left{
			border-left:none;
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
		table.border-none ,.border-none td{
			border:none !important;
					}
		.tabel table, .tabel td{
			border:1px solid black;
			

		}
		.button-group{
			position: fixed;
		}
		@media print {
			.button-group{
				display: none;
				padding: 0;
				margin: 0;
			}
			@page {
				size: landscape
			}
		}
		
		table.tabel th{
			white-space: nowrap;
			width: auto;
		}
		.no-border-head{
			border-top:hidden !important;
			border-left: hidden !important;
			border-right: hidden !important;
		}
		table.tabel tr {
			page-break-inside:auto; 
			page-break-after:avoid;
		}
		table.tabel {
			page-break-inside:auto;
		}


	</style>
</head>
<body>
	<div class="button-group">
		<button onclick="prints()">Print</button>
	</div>
	
		<div class="div-width">
		
						<div class="s16 bold">
							TAMMA ROBAH INDONESIA
						</div>
						<div>
							Jl. Raya Randu no.74<br>
							Sidotopo Wetan - Surabaya 60123<br>
						</div>
						<div class="bold" style="margin-top: 15px;">
							Laporan : Penjualan Per Barang - Detail <br>
							Pembayaran : Kredit &nbsp;&nbsp;&nbsp; PPn : Gabungan <br>
							Periode : {{date('d M Y', strtotime($tgl1))}} s/d {{date('d M Y', strtotime($tgl2))}}
						</div>
		

		<table width="100%" cellpadding="2px" class="tabel" border="1px" style="margin-bottom: 10px;">
			<thead>
				<tr>
					<th width="100px">Nama Pembeli</th>
					<th>Nota</th>
					<th>Tanggal</th>
					<th>Nama Barang</th>
					<th>Qty</th>
					<th>Harga</th>
					<th colspan="2">Diskon %</th>
					<th>Diskon Value</th>
					<th>PPN</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>

			

				@for($i=0;$i<count($penjualan);$i++)
					@for($j=0;$j<count($penjualan[$i]);$j++)
						<tr>
							@if($j == 0)
							<td class="border-none" rowspan="{{count($penjualan[$i]) + 1}}">{{$penjualan[$i][$j]->c_name}}</td>
							@endif
							<td class="text-center">{{$penjualan[$i][$j]->s_note}}</td>
							<td class="text-center">{{date('d M Y', strtotime($penjualan[$i][$j]->s_date))}}</td>
							<td>{{$penjualan[$i][$j]->i_name}}</td>
							<td class="text-center">{{$penjualan[$i][$j]->sd_qty}}</td>
							<td>
								<div class="float-right"> 
									{{number_format($penjualan[$i][$j]->sd_price,2,',','.')}}
								</div>
							</td>
							<td class="text-right">{{$penjualan[$i][$j]->sd_disc_percent}} %</td>
							<td class="text-right">{{number_format($penjualan[$i][$j]->sd_disc_vpercent,2,',','.')}} </td>
							<td class="text-right">{{$penjualan[$i][$j]->sd_disc_value}}</td>
							<td class="text-right">{{number_format(0,2,',','.')}}</td>
							<td class="text-right">{{number_format($penjualan[$i][$j]->sd_total,2,',','.')}}</td>
						</tr>

						@if($j == count($penjualan[$i]) - 1)
							<tr>
								<td class="text-right bold" colspan="3">Total</td>
								<td class="text-center bold">{{$data_sum[$i]->total_qty}}</td>
						{{-- 		<td class="text-right bold"></td>
								<td class="text-right bold" colspan="2">{{number_format($data_sum[$i]->sd_disc_vpercent,2,',','.')}}</td>
								<td class="text-right bold">{{number_format($data_sum[$i]->sd_disc_value,2,',','.')}}</td>
								<td class="text-right bold">{{number_format($data_sum[$i]->total_penjualan,2,',','.')}}</td>
								<td class="text-right bold">{{number_format($data_sum[$i]->total_penjualan,2,',','.')}}</td> --}}
							</tr>
						@endif
						
					@endfor
				@endfor

				

			</tbody>

		</table>
		
		<div class="float-left" style="width: 30vw;">
			<table class="border-none" width="100%">
				<tr>
					<td>Diskon %</td>
					<td>:</td>
					<td>{{number_format($data_sum_all[0]->allsd_disc_vpercent,2,',','.')}}</td>
				</tr>
				<tr>
					<td>Diskon Value</td>
					<td>:</td>
					<td>{{number_format($data_sum_all[0]->allsd_disc_value,2,',','.')}}</td>
				</tr>
				<tr>
					<td>DPP</td>
					<td>:</td>
					<td>{{number_format($data_sum_all[0]->total_semua_penjualan,2,',','.')}}</td>
				</tr>
				<tr>
					<td>Grand Total</td>
					<td>:</td>
					<td>{{number_format($data_sum_all[0]->total_semua_penjualan,2,',','.')}}</td>
				</tr>
			</table>
		</div>
		
	</div>
	<script type="text/javascript">
		function prints()
		{
			window.print();
		}

	</script>
</body>
</html>