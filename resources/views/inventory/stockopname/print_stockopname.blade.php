<!DOCTYPE html>
<html>
<head>
	<title>Stock Opname</title>
	<style type="text/css">
		html,body{
			padding: 0;
			margin: 0;
			height: 99%
		}
		*:not(h1):not(h2):not(h3):not(h4):not(h5):not(h6):not(small):not(label){
			font-size: 14px;
			font-family: "calibri";
		}
		.names { font-weight: bold; }
		.s16{
			font-size: 16px !important;
		}
		.calibri{
			font-family: 'calibri';
		}
		.div-width{
			width: 900px;
			margin-top:70px;

			padding: 0 15px 15px 15px;
			background: transparent;
			position: absolute;
		}
		.div-width-background{
			/*background-image: url("{{asset('assets/images/atonergi-bg2.png')}}");
			background-repeat: no-repeat;
			background-position: center; */
			position: relative;
			z-index: -1;
			
			padding: 0;
			top: 0;
			left: 0;
			bottom: 0;
			right: 0;
			/*opacity: 0.1; */
			width: 900px;
			height: 100%;
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
			html, body {
		        height: auto;    
		    }
			.div-width{
				margin: auto;
				padding: 15px 15px 15px 15px;
				width: 95vw;
				position: absolute;
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
				/*background-image: url("{{asset('assets/images/atonergi-bg2.png')}}");
				background-repeat: no-repeat;
				background-position: center; */
				
				position: relative;
				z-index: -1;
				margin: auto;
				/*opacity: 0.1; */
				width: 100vw;
				height: 100vh;
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
		}
		.div-page-break-after:last-child{
			page-break-after: auto;
		}
		.block{
			display: block;
		}
		.grey{
			color: grey;
		}
		.m-auto{
			margin: auto;
		}
		.w-50percent{
			width: 50%;
		}
		.mb-1{
			margin-bottom: 1rem;
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
				
		<div class="div-width">
			
			<table cellpadding="3px" width="100%" class="border-none mb-1">
				<tr>
					<td>
						<label class="bold">Nota</label>
					</td>
					<td width="1%">:</td>
					<td>
						{{ $data[0]->o_nota }}
					</td>
				</tr>
				<tr>
					<td>
						<label class="bold">Pemilik</label>
					</td>
					<td width="1%">:</td>
					<td>
						{{ $data[0]->comp }}
					</td>
					<td>
						<label class="bold">Posisi</label>
					</td>
					<td width="1%">:</td>
					<td>
						{{ $data[0]->position }}
					</td>
				</tr>
			</table>
			<table width="100%" cellpadding="3px">
				<tr>
					<td width="1%"><span class="names">No</span></td>
					<td><span class="names">Kode - Nama Item</span></td>
					<td><span class="names">i_type</span></td>
					<td><span class="names">Opname</span></td>
					<td><span class="names">Satuan</span></td>
				</tr>
				@foreach ($data as $index => $opname)
				<tr>
					<td align="center">{{ $index+1 }}</td>
					<td>{{ $opname->i_code }} - {{ $opname->i_name }}</td>
					<td>{{ $opname->i_type }}</td>
					<td align="right">{{ (int)$opname->od_opname }}</td>
					<td>{{ $opname->m_sname }}</td>
				</tr>
				@endforeach
				
			</table>
		</div>
			
	</div>
</body>
</html>