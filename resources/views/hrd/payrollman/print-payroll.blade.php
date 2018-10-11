<!DOCTYPE html>
<html>
<head>
	<title>Print Payroll</title>
	<style type="text/css">
		*:not(h1):not(h2):not(h3):not(h4):not(h5):not(h6):not(small):not(label){
			font-size: 14px;
		}
		.s16{
			font-size: 18px !important;
		}
		.div-width{
			width: 900px;
			padding: 50px 15px 15px 15px;
			background: transparent;
			position: relative;
		}
		.div-width-background{
			content: "";
			background-image: url("{{asset('assets/img/background-tammafood-surat.jpg')}}");
			background-repeat: no-repeat;
			background-position: center; 
			background-size: 700px 700px;
			position: absolute;
			z-index: -1;
			margin-top: 170px;
			top: 0;
			left: 0;
			bottom: 0;
			right: 0;
			opacity: 0.1; 
			width: 900px;
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
			width: 150px;
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
			margin:0 0 0 0;
		}
		@media print {
			.div-width{
				margin: auto;
				padding: 10px 15px 15px 15px;
				width: 95vw;
				position: relative;
			}
			.btn-print{
				display: none;
			}
			header{
				top:0;
				left: 0;
				right: 0;
				position: absolute;
				width: 100%;
			}
			footer{
				bottom: 0;
				left: 0;
				right: 0;
				position: absolute;
				width: 100%;
			}
			.div-width-background{
				content: "";
				background-image: url("{{asset('assets/img/background-tammafood-surat.jpg')}}");
				background-repeat: no-repeat;
				background-position: center; 
				background-size: 700px 700px;
				position: absolute;
				z-index: -1;
				margin: auto;
				opacity: 0.1; 
				width: 95vw;
			}
		}
		fieldset{
			border: 1px solid black;
			margin:-.5px;
		}
		header{
			top: 0;
			width: 900px;
		}
		footer{
			bottom: 0;
			width: 900px;
		}
		.border-top{
			border-top: 1px solid black;
		}
		.btn-print{
			position: fixed;
			width: 100%;
			text-align: right;
			left: 0;
			top: 0;
			background: rgba(0,0,0,.2);
		}
		.btn-print button, .btn-print a{
			margin: 10px;
		}
	</style>
</head>
<body>
	<div class="btn-print" align="right">
		<button onclick="javascript:window.print();">Print</button>
	</div>

	@php
		setlocale(LC_ALL, 'IND');

		$tanggal = str_replace(' s/d ', '', $rocknroll['d_pm_periode']);

		$tanggal1 = substr($tanggal,0,10);

		$tanggal2 = substr($tanggal,-10,10);

	@endphp
	
		


	<div class="div-width">
		<table width="100%" class="border-none" style="margin-bottom: 15px;">
			<tr>
				<td width="1%">
					<img src="{{asset('assets/img/tamma.png')}}" width="100" height="100">
				</td>
				<td align="center" valign="middle">
					<h1>PT. Tamma Robah Indonesia</h1>

					<h2>SLIP GAJI</h2>
					
				</td>
			</tr>
		</table>
					
		<table width="100%" class="border-none">
			<tr>
				<td width="10%">Tanggal</td>
				<td width="1%">:</td>
				<td width="45%">{{strftime('%e %B %Y', strtotime($rocknroll['d_pm_date']) ) }}</td>
			
				<td width="10%">Periode</td>
				<td width="1%">:</td>
				<td>{{ strftime('%e %B %Y', strtotime($tanggal1)) }} s/d {{strftime('%e %B %Y', strtotime($tanggal2))}} </td>
			</tr>
			<tr>
				<td>Divisi</td>
				<td>:</td>
				<td>{{$rocknroll['c_divisi']}}</td>
			
				<td>Jabatan</td>
				<td>:</td>
				<td>{{$rocknroll['c_posisi']}}</td>
				
			</tr>
			<tr>
				<td>Pegawai</td>
				<td>:</td>
				<td class="bold">{{$rocknroll['c_nama']}}</td>
			</tr>
		</table>

		<table width="100%" cellpadding="3px" style="margin-top: 15px;">
			<tr class="bold text-center">
				<td>Keterangan</td>
				<td>Nilai</td>
			</tr>

			@for($i=0;$i<count($tunjangan);$i++)
				<tr>
					<td>{{$tunjangan[$i]['tman_nama']}}</td>
					<td>
						<div class="float-left">
							Rp.
						</div>
						<div class="float-right">
							{{number_format($tunjangan[$i]['d_pmdt_nilai'],2,',','.')}}
						</div>
					</td>
				</tr>
			@endfor

			<tr class="bold">
				<td align="right">Total Tunjangan</td>
				<td>
					<div class="float-left">
						Rp.
					</div>
					<div class="float-right">
						{{number_format($rocknroll['d_pm_totaltun'],2,',','.')}}
					</div>
				</td>
			</tr>

			<tr class="bold">
				<td align="right">Gaji Pokok</td>
				<td>
					<div class="float-left">
						Rp.
					</div>
					<div class="float-right">
						{{number_format($rocknroll['d_pm_gapok'],2,',','.')}}
					</div>
				</td>
			</tr>

			<tr class="bold">
				<td align="right">Total Potongan</td>
				<td>
					<div class="float-left">
						Rp.
					</div>
					<div class="float-right">
						{{number_format($rocknroll['d_pm_totalpot'],2,',','.')}}
					</div>
				</td>
			</tr>

			<tr class="bold">
				<td class="s16" align="right">Total Gaji Nett</td>
				<td>
					<div class="s16 float-left">
						Rp.
					</div>
					<div class="s16 float-right">
						{{number_format($rocknroll['d_pm_totalnett'],2,',','.')}}
					</div>
				</td>
			</tr>

		</table>

	</div>

{{-- 	<footer>
		<img src="{{asset('assets/img/footer-tammafood-surat.png')}}" width="100%">
	</footer> --}}


</body>
</html>