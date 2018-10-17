<!DOCTYPE html>
<html>
<head>
	<title>FORM PERMINTAAN KARYAWAN BARU</title>
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
				padding: 120px 15px 15px 15px;
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
		.border-bottom-dotted{
			border-bottom: 1px dotted black !important;
		}
		.div-page-break-after{
			page-break-after: always;
			width: 100%;
		}
		.min-width-100px{
			min-width: 100px;
		}
	</style>
</head>
<body>
	<div class="div-page-break-after">

		@php

		setlocale(LC_ALL, 'id_ID');

		@endphp

		<div class="btn-print" align="right">
			<button onclick="javascript:window.print();">Print</button>
		</div>
			<div class="div-width-background">
			</div>
			<header>
				<img width="100%" src="{{asset('assets/img/header-tammafood-surat.png')}}">
			</header>
				
		<div class="div-width">

			<h2 style="margin: 30px 0 0 0;">FORM PERMINTAAN KARYAWAN BARU</h2>
			<small>FM-SDM-01-2018</small>

			<table width="100%" class="border-none" cellpadding="5px">
				<tr>
					<td>Departement</td>
					<td width="1%">:</td>
					<td class="min-width-100px">{{$daita[0]->pkb_departement}}</td>
					<td>Tanggal Masuk</td>
					<td width="1%">:</td>
					<td class="min-width-100px">{{strftime("%A, %e %B %Y" ,strtotime($daita[0]->pkb_tgl_masuk))}}</td>
				</tr>
				<tr>
					<td>Tanggal Pengujian</td>
					<td>:</td>
					<td>{{strftime("%A, %e %B %Y" ,strtotime($daita[0]->pkb_tgl_pengujian))}}</td>
				</tr>
			</table>

			<table width="100%" cellpadding="5px" style="margin-top: 5px;">
				<tr>
					<td width="1%">No</td>
					<td align="center" class="bold" colspan="2">PERSYARATAN</td>
				</tr>
				<tr>
					<td>1</td>
					<td width="30%">Posisi</td>
					<td>{{$daita[0]->pkb_posisi}}</td>
				</tr>
				<tr>
	                <td>2</td>
	                <td>Jumlah yang dibutuhkan</td>
	                <td>{{$daita[0]->pkb_jumlah_butuh}}</td>
	              </tr>
	              <tr>
	                <td>3</td>
	                <td>Jumlah karyawan sekarang</td>
	                <td>{{$daita[0]->pkb_jumlah_karyawan}}</td>
	              </tr>
	              <tr>
	                <td>4</td>
	                <td>Untuk penambahan/penggantian</td>
	                <td>{{$daita[0]->pkb_penambahan}}</td>
	              </tr>
	              <tr>
	                <td>5</td>
	                <td>Alasan</td>
	                <td>{{$daita[0]->pkb_alasan}}</td>
	              </tr>
	              <tr>
	                <td>6</td>
	                <td>Usia</td>
	                <td>{{$daita[0]->pkb_usia}}</td>
	              </tr>
	              <tr>
	                <td>7</td>
	                <td>Jenis Kelamin</td>
	                <td>
	                	@if($daita[0]->pkb_jk === 'l')
	                		Laki-laki
	                	@elseif($daita[0]->pkb_jk === 'p')
	                		Perempuan
	                	@else
	                		Apache Helicopter
	                	@endif
	                </td>
	              </tr>
	              <tr>
	                <td>8</td>
	                <td>Pendidikan</td>
	                <td>{{$daita[0]->pkb_pendidikan}}</td>
	              </tr>
	              <tr>
	                <td>9</td>
	                <td>Pengalaman</td>
	                <td>{{$daita[0]->pkb_pengalaman}}</td>
	              </tr>
	              <tr>
	                <td>10</td>
	                <td>Keahlian Khusus</td>
	                <td>{{$daita[0]->pkb_keahlian}}</td>
	              </tr>
	              <tr>
	                <td>11</td>
	                <td>Gaji</td>
	                <td>Rp. {{number_format($daita[0]->pkb_gaji,2,',','.')}}</td>
	              </tr>
	              <tr>
	                <td>12</td>
	                <td>Keterangan</td>
	                <td>{{$daita[0]->pkb_keterangan}}</td>
	              </tr>
			</table>

			<table class="border-none" width="100%">
				<tr>
					<td></td>
					<td style="height: 100px;">Surabaya, </td>
				</tr>
				<tr align="center">
					<td>Diajukan oleh,</td>
					<td>Disetujui oleh,</td>
				</tr>
				<tr align="center">
					<td style="height: 70px;" valign="bottom"> (.............................) </td>
					<td valign="bottom"> (.............................) </td>
				</tr>
			</table>

		</div>
			<footer>
				<img width="100%" src="{{asset('assets/img/footer-tammafood-surat.png')}}">
			</footer>
	</div>
</body>
</html>