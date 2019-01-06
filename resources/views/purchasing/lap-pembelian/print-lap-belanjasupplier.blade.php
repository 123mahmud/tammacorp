<!DOCTYPE html>
<html>
<head>
	<title>Laporan Pembnelian Supplier</title>
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
				@foreach ($pembelian as $jual)
				<tr>
					<td>{{ $jual->s_company }}</td>
					<td>
						{{ date('d M Y', strtotime($jual->d_pcs_date_created)) }}
					</td>
					<td>{{ $jual->i_name }}</td>
					<td>
						<div class="text-right">
                          	{{ number_format($jual->d_pcsdt_price,2,",",".") }}
                        </div>
					</td>
					<td>
						<div class="text-right">
                          	{{ number_format($jual->d_pcsdt_qtyconfirm,0,",",".") }}
                        </div>
					</td>
					<td>{{ $jual->m_sname }}</td>
					<td>
						<div class="text-right">
                          	{{ number_format($jual->d_pcsdt_total,2,",",".") }}
                        </div>
                    </td>
				</tr>
				@endforeach
				
			</tbody>

		</table>

		<div class="float-left" style="width: 30vw;">
			<table class="border-none" width="100%">
				<tr>
					<td>Total Pembelian</td>
					<td>:</td>
					<td>{{number_format($totalPembelian[0]->total_pembelian,2,',','.')}}</td>
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