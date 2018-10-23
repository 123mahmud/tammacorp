<!DOCTYPE html>
<html>
<head>
	<title>FORM LAPORAN LEADER</title>
	<style type="text/css">
		*:not(h1):not(h2):not(h3):not(h4):not(h5):not(h6):not(small):not(label){
			font-size: 14px;
		}
		.s16{
			font-size: 16px !important;
		}
		.div-width{
			width: 900px;
			padding: 0 15px 15px 15px;
			

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
		table,td,th{
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
				padding: 170px 15px 15px 15px;
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
			z-index: 99;
		}
		footer{
			bottom: 0;
			width: 900px;
			z-index: 99;
		}
		.border-top{
			border-top: 1px solid black;
		}
		.border-bottom{
			border-bottom: 1px solid black;
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
	@php
	setlocale(LC_ALL, "id_ID");
	@endphp

	<div class="btn-print">
		<button onclick="javascript:window.print();">Print</button>
	</div>
		<header>
			<img width="100%" src="{{asset('assets/img/header-tammafood-surat.png')}}">
		</header>
	<div class="div-width">

		<h2 style="margin: 30px 15px 0 15px;">FORM LAPORAN LEADER</h2>
		<small style="margin: 15px 15px 15px 15px;">FM-SDM-01-2018</small>

		<table width="100%" class="border-none" style="margin: 30px 15px 0 15px;">
			<tr>
				<td>PIC</td>
				<td>:</td>
				<td>{{$head[0]->fll_pic}}</td>
			</tr>
			<tr>
				<td>Divisi</td>
				<td>:</td>
				<td>{{$head[0]->fll_divisi}}</td>
			</tr>
			<tr>
				<td>Hari</td>
				<td>:</td>
				<td>{{strftime("%A, %e %B %Y", strtotime($head[0]->fll_hari))}}</td>
			</tr>
			<tr>
				<td class="italic" colspan="3">(Tuliskan 6 pekerjaan harian rutin dan 6 pekerjaan yang akan di lakukan besok)</td>
			</tr>
			
		</table>

		<table width="100%" style="margin-bottom: 15px;" cellpadding="3px">
			<thead class="top">
				<tr>
					<th width="5%" style="height: 30px;">No</th>
					<th>Aktivitas</th>
					<th>Keterangan</th>
				</tr>
			</thead>
			<tbody>
				@for($i=0;$i<count($list);$i++)
					<tr>
						<td align="center">{{$i+1}}</td>
						<td>{{$list[$i]->flldt_aktifitas}}</td>
						<td>{{$list[$i]->flldt_keterangan}}</td>
					</tr>
				@endfor


				@for($k=count($list);$k<12;$k++)
					<tr>
						<td align="center">{{$k+1}}</td>
						<td></td>
						<td></td>
					</tr>
				@endfor
			</tbody>
		</table>

		<div class="float-right border-bottom ttd" align="center" style="height: 70px;margin-bottom: 15px;margin-top: 30px;">
			<label class="bold">TTD</label>
		</div>

		
	</div>
		<footer>
			<img width="100%" src="{{asset('assets/img/footer-tammafood-surat.png')}}">
		</footer>
</body>
</html>