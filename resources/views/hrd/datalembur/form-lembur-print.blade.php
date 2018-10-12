<!DOCTYPE html>
<html>
<head>
	<title>FORM LEMBUR</title>
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
		<div class="div-width-background">
		</div>
		<header>
			<img width="100%" src="{{asset('assets/img/header-tammafood-surat.png')}}">
		</header>
			
	<div class="div-width">
		<h2 style="margin: 30px 0 0 0;">FORM LEMBUR</h2>
		<small style="margin: 15px 0 0 0;">No : {{$data[0]->d_lembur_code}}</small>
		<table width="96%" style="margin-top: 10px;" cellpadding="5px">
			<tr>
				<td colspan="3"><strong>Tanggal Pengajuan Lembur pada :</strong> {{$data2['hari_indo']}}, {{$data2['tgl_indo']}}
				</td>
			</tr>
			<tr>
				<td colspan="3"><strong>Divisi :</strong> {{$data2['divisiTxt']}}
				</td>
			</tr>
			<tr>
				<td class="top" style="height: 50px;" colspan="4">
					<label class="bold">Uraian Lembur : </label><br><br>
					{{$data[0]->d_lembur_keperluan}}
				</td>
			</tr>
			<tr>
				<td class="border-none-bottom" colspan="4"><strong>Yang Bertanda di bawah ini :</strong></td>
			</tr>
			<tr>
				<td>Nama</td>
				<td class="border-none-left border-none-right" width="1%">:</td>
				<td colspan="2">{{$data2['pegawai']}}</td>
			</tr>
			<tr>
				<td>NIK</td>
				<td class="border-none-left border-none-right" width="1%">:</td>
				<td colspan="2">{{$data[0]->c_nik}}</td>
			</tr>
			<tr>
				<td>Jabatan</td>
				<td class="border-none-left border-none-right" width="1%">:</td>
				<td colspan="2">{{$data2['jabatanTxt']}}</td>
			</tr>
			<tr>
				<td>Divisi</td>
				<td class="border-none-left border-none-right" width="1%">:</td>
				<td colspan="2">{{$data2['divisiTxt']}}</td>
			</tr>
		</table>
		<table width="96%" class="border-none-top" cellpadding="5px">
			<tr>
				<td align="center">Diajukan oleh,</td>
				<td align="center">Disetujui oleh,<br>Kepala Divisi</td>
				<td align="center">Diketahui oleh :<br>Ka. HRD & Umum</td>
			</tr>
			<tr>
				<td height="100px" valign="bottom" align="center">{{$data2['pegawai']}} (NIK : {{$data[0]->c_nik}})</td>
				<td valign="bottom" align="center">..................................</td>
				<td valign="bottom" align="center">..................................</td>
			</tr>
		</table>

	</div>
		<footer>
			<img width="100%" src="{{asset('assets/img/footer-tammafood-surat.png')}}">
		</footer>
</body>
</html>