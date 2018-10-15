<!DOCTYPE html>
<html>
<head>
	<title>SURAT PHK PENGURANGAN PEGAWAI</title>
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
					<td>Saudara <strong>{{$data->c_nama}}</strong></td></td>
				</tr>
				<tr>
					<td>di Tempat</td>
				</tr>
				<tr>
					<td height="40px" valign="bottom">Dengan hormat,</td>
				</tr>
				<tr>
					<td>
						<p class="paragraph-indent" style="text-align:justify; margin-right: 30px;">Sehubungan perusahaan akan mengadakan efisiensi dalam upaya penyeimbangan biaya operasional perusahaan yang akan disesuaikan dengan jumlah karyawan yang ada. Hal ini akan berakibat pada restrukturisasi kepengurusan serta pengurangan karyawan, maka dengan ini CV. Tamma Robah Indonesia melakukan pemutusan hubungan kerja sebagian karyawan.</p>

						<p class="paragraph-indent" style="text-align:justify; margin-right: 30px;">Sehubungan dengan kebijakan tersebut, maka CV. Tamma Robah Indonesia memutuskan untuk :<label class="bold"> Memberhentikan (Pemutusan Hubungan Kerja)</label> dengan saudara <strong>{{$data->c_nama}}</strong></p>

						<p class="paragraph-indent" style="text-align:justify; margin-right: 30px;">Dengan demikian, terhitung dari tanggal <strong>{{date('d',strtotime($data->c_tgl_phk))}}</strong> Bulan <strong>{{date('F',strtotime($data->c_tgl_phk))}}</strong> Tahun <strong>{{date('Y',strtotime($data->c_tgl_phk))}}</strong> hubungan kerja dengan saudara <strong>{{$data->c_nama}}</strong> kami nyatakan sudah berakhir.</p>

						<p class="paragraph-indent" style="text-align:justify; margin-right: 30px;">Kami selaku pihak perusahaan menyampaikan terima kasih untuk segala loyalitas saudara <strong>{{$data->c_nama}}</strong> yang diberikan, apabila kelak perusahaan sudah semakin membaik, kami akan menawarkan kesempatan kembali bagi saudara <strong>{{$data->c_nama}}</strong> untuk bergabung lagi di CV. Tamma Robah Indonesia.</p>
					</td>
				</tr>
			</table>
			<table width="100%" class="border-none" cellpadding="5px">
				<tr>
					<td width="49%"></td>
					<td align="center">Surabaya, {{date('d F Y',strtotime($data->c_tgl_phk))}}<br>Direktur Utama<br>CV. Tamma Robbah Indonesia</td>
					
				</tr>
				<tr>
					<td></td>
					<td height="70px" valign="bottom" align="center" class="underline">Vied Febrianto</td>
					
				</tr>
			</table>

		</div>
			<footer>
				<img width="100%" src="{{asset('assets/img/footer-tammafood-surat.png')}}">
			</footer>
	</div>
</body>
</html>