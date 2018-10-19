<!DOCTYPE html>
<html>
<head>
	<title>FORM KETERANGAN KERJA</title>
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



		<div class="btn-print" align="right">
			<button onclick="javascript:window.print();">Print</button>
		</div>
			<div class="div-width-background">
			</div>
			<header>
				<img width="100%" src="{{asset('assets/img/header-tammafood-surat.png')}}">
			</header>
				
		<div class="div-width">

			<h2 class="text-center underline" style="margin: 30px 0 0 0;">SURAT KETERANGAN KERJA</h2>
			<small class="text-center" style="display: block;">No : {{$daita[0]->fkj_kode}}</small>

			<table class="border-none" width="100%" style="margin-top: 30px;" cellpadding="5px">
				<tr>
					<td colspan="3">Yang bertanda tangan dibawah ini :</td>
				</tr>
				<tr>
					<td width="20%">Nama</td>
					<td width="1%">:</td>
					<td class="border-bottom-dotted">{{$daita[0]->fkjdt_nama1}}</td>
				</tr>
				<tr>
					<td>Jabatan</td>
					<td>:</td>
					<td class="border-bottom-dotted">{{$daita[0]->fkjdt_jabatan1}}</td>
				</tr>
				<tr>
					<td>Alamat</td>
					<td>:</td>
					<td class="border-bottom-dotted">{{$daita[0]->fkjdt_alamat1}}</td>
				</tr>
				<tr>
					<td colspan="3" style="padding: 30px 5px 10px 5px;">
						Menerangkan, bahwa yang bertanda tangan dibawah ini : 
					</td>
				</tr>
				<tr>
					<td>Nama</td>
					<td>:</td>
					<td class="border-bottom-dotted">{{$daita[0]->fkjdt_nama2}}</td>
				</tr>
				<tr>
					<td>Jenis Kelamin</td>
					<td>:</td>
					<td class="border-bottom-dotted">
						@if($daita[0]->fkjdt_jk2 === 'l')
						Laki-laki
						@elseif($daita[0]->fkjdt_jk2 === 'P')
						Perempuan
						@else
						Apache Helicopter
						@endif
					</td>
				</tr>
				<tr>
					<td>Tempat/Tanggal Lahir</td>
					<td>:</td>
					<td class="border-bottom-dotted">{{$daita[0]->fkjdt_ttl2}}</td>
				</tr>
				<tr>
					<td>Alamat</td>
					<td>:</td>
					<td class="border-bottom-dotted">{{$daita[0]->fkjdt_alamat2}}</td>
				</tr>
				<tr>
					<td colspan="3" style="padding: 30px 5px 10px 5px;">Merupakan karyawan CV. Tamma Robbah Indonesia dari bulan {{$daita[0]->fkj_tanggal_awal}} hingga {{$daita[0]->fkj_tanggal_akhir}} saat ini dengan posisi sebagai {{$daita[0]->fkjdt_posisi2}} </td>
				</tr>
				<tr>
					<td colspan="3" style="padding: 10px 5px 10px 5px;">Demikian surat keterangan ini kami buat agar digunakan sebagaimana mestinya. </td>
				</tr>
				
			</table>
			<table width="100%" class="border-none" cellpadding="5px">
				<tr>
					<td width="49%" align="center"></td>
					<td align="center">Surabaya, .......................<br><span class="bold">HRD dan GA</span></td>
					
				</tr>
				<tr>
					<td height="70px" valign="bottom" align="center"></td>
					<td class="bold underline" valign="bottom" align="center">Nasikhatul Insaniyah, S.Psi</td>
					
				</tr>
				
			</table>

		</div>
			<footer>
				<img width="100%" src="{{asset('assets/img/footer-tammafood-surat.png')}}">
			</footer>
	</div>
</body>
</html>