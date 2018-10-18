<!DOCTYPE html>
<html>
<head>
	<title>FORM OVERHANDLE</title>
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
	</style>
</head>
<body>
	<div class="div-page-break-after">

		@php

		setlocale(LC_ALL, "id_ID");

		

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

			<h2 class="text-center underline" style="margin: 30px 0 0 0;">SURAT SERAH TERIMA TUGAS</h2>
			<small class="text-center" style="display: block;">No : {{$daita[0]->foh_surat}}</small>

			<table class="border-none" width="100%" style="margin-top: 30px;" cellpadding="5px">
				<tr>
					<td colspan="3">Yang bertanda tangan dibawah ini :</td>
				</tr>
				<tr>
					<td width="20%">Nama</td>
					<td width="1%">:</td>
					<td class="border-bottom-dotted">{{$daita[0]->fohdt_nama1}}</td>
				</tr>
				<tr>
					<td>Jabatan</td>
					<td>:</td>
					<td class="border-bottom-dotted">{{$daita[0]->fohdt_posisi1}}</td>
				</tr>
				<tr>
					<td>NIP</td>
					<td>:</td>
					<td class="border-bottom-dotted">{{$daita[0]->fohdt_nik1}}</td>
				</tr>
				<tr>
					<td>Alamat</td>
					<td>:</td>
					<td class="border-bottom-dotted">{{$daita[0]->fohdt_alamat1}}</td>
				</tr>
				<tr>
					<td>No. KTP/SIM</td>
					<td>:</td>
					<td class="border-bottom-dotted">{{$daita[0]->fohdt_ktp1}}</td>
				</tr>
				<tr>
					<td colspan="3" style="padding: 10px 5px 10px 5px;">
						Telah Melakukan serah terima tugas sebagai {{$daita[0]->foh_tugas}} CV. Tamma Robah Indonesia, sebagai berikut :
					</td>
				</tr>
				<tr>
					<td>Nama</td>
					<td>:</td>
					<td class="border-bottom-dotted">{{$daita[0]->fohdt_nama2}}</td>
				</tr>
				<tr>
					<td>Jabatan</td>
					<td>:</td>
					<td class="border-bottom-dotted">{{$daita[0]->fohdt_posisi2}}</td>
				</tr>
				<tr>
					<td>NIP</td>
					<td>:</td>
					<td class="border-bottom-dotted">{{$daita[0]->fohdt_nik2}}</td>
				</tr>
				<tr>
					<td>Alamat</td>
					<td>:</td>
					<td class="border-bottom-dotted">{{$daita[0]->fohdt_alamat2}}</td>
				</tr>
				<tr>
					<td>No. KTP/SIM</td>
					<td>:</td>
					<td>{{$daita[0]->fohdt_ktp2}}</td>
				</tr>
				<tr>
					<td colspan="3" style="padding: 10px 5px 10px 5px;">Serah terima tugas ini dilakukan sehubungan dengan Pelaksanaan Cuti/Izin selama {{$count_day}} hari, terhitung tanggal {{strftime("%A, %e %B %Y", strtotime($daita[0]->foh_awal_tanggal))}} sampai dengan {{strftime("%A, %e %B %Y", strtotime($daita[0]->foh_akhir_tanggal))}} </td>
				</tr>
				<tr>
					<td colspan="3" style="padding: 10px 5px 10px 5px;">Apabila karyawan yang diberi surat serah terima tidak melaksanakan tugasnya dengan baik maka tidak mendapatkan uang makan selama sehari. </td>
				</tr>
				<tr>
					<td colspan="3" style="padding: 10px 5px 10px 5px;">Demikian surat serah terima tugas ini kami buat untuk dijadikan bahan seperlunya.</td>
				</tr>
				<tr>
					<td>Dibuat di</td>
					<td>:</td>
					<td>{{$daita[0]->foh_dibuat_di}}</td>
				</tr>
				<tr>
					<td>Tanggal</td>
					<td>:</td>
					<td>{{strftime("%A, %e %B %Y", strtotime($daita[0]->foh_tanggal))}}</td>
				</tr>
			</table>
			<table width="100%" class="border-none" cellpadding="5px">
				<tr>
					<td align="center">Yang Menerima</td>
					<td align="center">Yang Menyerahkan</td>
					
				</tr>
				<tr>
					<td height="70px" valign="bottom" align="center">..................................</td>
					<td valign="bottom" align="center">..................................</td>
					
				</tr>
				<tr>
					<td align="center">Menyetujui,<br>Atasan Langsung</td>
					<td align="center">Mengetahui,<br>HRD & GA</td>
					
				</tr>
				<tr>
					<td height="70px" valign="bottom" align="center">..................................</td>
					<td valign="bottom" align="center">..................................</td>
					
				</tr>
			</table>

		</div>
			<footer>
				<img width="100%" src="{{asset('assets/img/footer-tammafood-surat.png')}}">
			</footer>
	</div>
</body>
</html>