<!DOCTYPE html>
<html>
<head>
	<title>Laporan Belanja Supplier</title>
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
							Laporan : Belanja Supplier <br>
							Periode : {{date('d M Y', strtotime($tgl1))}} s/d {{date('d M Y', strtotime($tgl2))}}
						</div>
		

		<table width="100%" cellpadding="2px" class="tabel" border="1px" style="margin-bottom: 10px;">
			<thead>
				<tr>
	                <th>Nama Supplier</th>
	                <th>Tanggal</th>
	                <th>Nama Item</th>
	                <th>Harga</th>
	                <th>Qty</th>
	                <th>Satuan</th>
	                <th>Total Harga</th>
				</tr>
			</thead>
			<tbody>

				@for($i=0;$i<count($pembelian);$i++)
					@for($j=0;$j<count($pembelian[$i]);$j++)
						<tr>
							<td class="text-center">{{$pembelian[$i][$j]['d_pcsh_code']}}</td>
							<td class="text-center">{{date("d M Y", strtotime($pembelian[$i][$j]['d_pcsh_date']))}}</td>
							<td class="text-center">{{$pembelian[$i][$j]['m_name']}}</td>
							<td class="text-center">{{$pembelian[$i][$j]['d_pcsh_peminta']}}</td>
							<td class="text-center">{{$pembelian[$i][$j]['d_pcsh_keperluan']}}</td>
							<td>
								<div class="float-left">
									Rp. 
								</div>
								<div class="float-right"> 
									{{number_format($pembelian[$i][$j]['d_pcsh_totalprice'],2,',','.')}}
								</div>
							</td>
						</tr>
					@endfor
				@endfor

			</tbody>

		</table>
		
		<div class="float-left" style="width: 30vw;">
			<table class="border-none" width="100%">
				<tr>
					<td>Total Biaya</td>
					<td>:</td>
					<td>{{number_format($data_sum_all[0]['tot_nett'],2,',','.')}}</td>
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