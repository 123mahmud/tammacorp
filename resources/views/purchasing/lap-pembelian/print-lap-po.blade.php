<!DOCTYPE html>
<html>
<head>
	<title>Laporan Pembelian (PO)</title>
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
		
		@media print{
			.btn-group{
				display: none;
			}
		}
		@page{
			size: landscape;
			margin: 0;
		}

		@media print{
			.btn-print{
				display: none;
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

		.btn-group{
			right: 10px;
			position: absolute;
		}

	</style>
</head>
<body>
	<div class="button-group float-right">
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
							Laporan : Pembelian Barang <br>
							Periode : {{date('d M Y', strtotime($tgl1))}} s/d {{date('d M Y', strtotime($tgl2))}}
						</div>
		

		<table width="100%" cellpadding="2px" class="tabel" border="1px" style="margin-bottom: 10px;">
			<thead>
				<tr>
					<th width="100px">Nama Supplier</th>
					<th>No PO</th>
					<th>Tanggal</th>
					<th>Cara Bayar</th>
					<th>Total</th>
					<th>Diskon %</th>
					<th>Diskon Value</th>
					<th>PPN</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>

				@for($i=0;$i<count($pembelian);$i++)
					@for($j=0;$j<count($pembelian[$i]);$j++)
						<tr>
							@if($j == 0)
							<td class="border-none" rowspan="{{count($pembelian[$i]) + 1}}">{{$pembelian[$i][$j]['s_company']}}</td>
							@endif
							<td class="text-center">{{$pembelian[$i][$j]['d_pcs_code']}}</td>
							<td class="text-center">{{date("d M Y", strtotime($pembelian[$i][$j]['d_pcs_date_confirm']))}}</td>
							<td class="text-center">{{$pembelian[$i][$j]['d_pcs_method']}}</td>
							<td>
								<div class="float-left">
									Rp. 
								</div>
								<div class="float-right"> 
									{{number_format($pembelian[$i][$j]['d_pcs_total_gross'],2,',','.')}}
								</div>
							</td>
							<td class="text-right">{{$pembelian[$i][$j]['d_pcs_disc_percent']}} %</td>
							<td class="text-right">{{number_format($pembelian[$i][$j]['d_pcs_disc_value'],2,',','.')}} </td>
							<td class="text-right">{{number_format($pembelian[$i][$j]['d_pcs_tax_value'],2,',','.')}}</td>
							<td>
								<div class="float-left">
									Rp. 
								</div>
								<div class="float-right"> 
									{{number_format($pembelian[$i][$j]['d_pcs_total_net'],2,',','.')}}
								</div>
							</td>
						</tr>

						@if($j == count($pembelian[$i]) - 1)
							<tr>
								<td class="text-right bold" colspan="3">Total</td>
								<td class="text-center bold">
									<div class="float-left">
									Rp. 
									</div>
									<div class="float-right"> 
										{{number_format($data_sum[$i]['tot_gross'],2,',','.')}}
									</div>
								</td>
								<td class="text-right bold"></td>
								<td class="text-right bold">{{number_format($data_sum[$i]['tot_discval'],2,',','.')}}</td>
								<td class="text-right bold">{{number_format($data_sum[$i]['tot_ppn'],2,',','.')}}</td>
								<td class="text-center bold">
									<div class="float-left">
									Rp. 
									</div>
									<div class="float-right"> 
										{{number_format($data_sum[$i]['tot_nett'],2,',','.')}}
									</div>
								</td>
							</tr>
						@endif
						
					@endfor
				@endfor

			</tbody>

		</table>
		
		<div class="float-left" style="width: 30vw;">
			<table class="border-none" width="100%">
				<tr>
					<td>Total Gross</td>
					<td>:</td>
					<td>{{number_format($data_sum_all[0]['all_tot_gross'],2,',','.')}}</td>
				</tr>
				<tr>
					<td>Total Diskon</td>
					<td>:</td>
					<td>{{number_format($data_sum_all[0]['all_tot_discval'],2,',','.')}}</td>
				</tr>
				<tr>
					<td>Total Pajak</td>
					<td>:</td>
					<td>{{number_format($data_sum_all[0]['all_tot_ppn'],2,',','.')}}</td>
				</tr>
				<tr>
					<td>Total Nett</td>
					<td>:</td>
					<td>{{number_format($data_sum_all[0]['all_tot_nett'],2,',','.')}}</td>
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