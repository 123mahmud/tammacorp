<!DOCTYPE html>
<html>
<head>
	<title>SURAT PHK KESALAHAN BERAT</title>
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
		.paragraph-indent{
			text-indent: 30px;
			line-height: 1.5;
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

			<h2 class="text-center underline" style="margin: 30px 0 0 0;">SURAT PEMUTUSAN HUBUNGAN KERJA</h2>
			<small class="text-center" style="display: block;">No : {{$data->c_kode}}</small>

			<table class="border-none" width="100%" style="margin-top: 30px;" cellpadding="5px">
				<tr>
					<td>Kepada Yth:</td>
				</tr>
				<tr>
					<td>Saudara <strong>{{$data->c_nama}}</strong></td>
				</tr>
				<tr>
					<td>di Tempat</td>
				</tr>
				<tr>
					<td height="40px" valign="bottom">Dengan hormat,</td>
				</tr>
				<tr>
					<td>
						<p class="paragraph-indent" style="text-align:justify; margin-right: 30px;">Sehubungan dengan hasil evaluasi kinerja saudara  selama <strong>{{$data->c_bulan_terakhir}}</strong> bulan terakhir, maka kami menilai tidak ada peningkatan dan perbaikan kinerja. Menimbang dari sisi kedisiplinan dan tanggung jawab pekerjaan. maka dari itu kami memutuskan untuk tidak melanjutkan kontrak kerja (Pemutusan Hubungan Kerja) dengan saudara <strong>{{$data->c_nama}}</strong> </p>

						<p class="paragraph-indent" style="text-align:justify; margin-right: 30px;">Dengan demikian, terhitung mulai tanggal    bulan   tahun 2018, hubungan kerja antara CV. Tamma Robah Indonesia dengan saudara <strong>{{$data->c_nama}}</strong> dinyatakan berakhir. Atas nama perusahaan, kami menyampaikan banyak terima kasih atas kinerja yang saudara berikan selama ini.</p>

						<p class="paragraph-indent" style="text-align:justify; margin-right: 30px;">Demikian surat pemutusan hubungan kerja kami sampaikan dan atas perhatian dan pengertian saudara kami ucapkan terima kasih.</p>
					</td>
				</tr>
			</table>
			<table width="100%" class="border-none" cellpadding="5px">
				<tr>
					<td width="49%"></td>
					<td align="center">Surabaya, {{date('d F Y',strtotime($data->c_tgl_phk))}}<br>CV. Tamma Robbah Indonesia</td>
				</tr>
				<tr>
					<td></td>
					<td height="70px" valign="bottom" align="center"><label class="underline">Nasikhatul Insaniyah, S.Psi</label><br>Ka.HRD & GA</td>
					
				</tr>
			</table>

		</div>
			<footer>
				<img width="100%" src="{{asset('assets/img/footer-tammafood-surat.png')}}">
			</footer>
	</div>
</body>
</html>