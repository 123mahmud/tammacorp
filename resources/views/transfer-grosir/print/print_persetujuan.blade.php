<!DOCTYPE html>
<html>
<head>
	<title>Print Persetujuan Print</title>
</head>
<style type="text/css">
	.div-width{
		width: 95vw;
		margin: auto;
	}
	.float-left{
		float: left;
	}
	.float-right{
		float: right;
	}
	
	table, td, th{
		border: 1px solid black;
	}
	td{
		text-align: center;
	}
	@media print{
		
	}
	@page{
		size: portrait;
		margin:0;
	}
	.empty{
		height: 15px;
	}
	.ttd-kiri{
		margin-left: 10vw;
		float: left;
	}
	.ttd-kanan{
		margin-right: 10vw;
		float: right;
	}
	.text-center{
		text-align: center;
	}
	.bold{
		font-weight: bold;
	}
	.page-break-always{
		page-break-before: always;
	}
</style>
<body>
	<?php
	date_default_timezone_set('Asia/Jakarta');
	?>
	<div class="div-width">
		@for($i=0;$i < count($query_chunk); $i++)
			<div class="page-break-always">
				<div class="divheader float-right">
					<h1>PUKUL {{date('H:i')}}</h1>
				</div>
				<br>
				<table width="100%" cellspacing="0" cellpadding="3px">
					<thead>	
						<tr>
							<th width="5%">No</th>
							<th>Nama Barang</th>
							<th width="5%">Qnt</th>
							<th width="5%">Ditransfer</th>
							<th>KET</th>
						</tr>
					</thead>
					<tbody>
						@for($j=0;$j < count($query_chunk[$i]);$j++)
						<tr>
							<td>{{$j+1}}</td>
							<td>{{$query_chunk[$i][$j]->i_name}}</td>
							<td>{{$query_chunk[$i][$j]->tidt_qty}}</td>
							<td>{{$query_chunk[$i][$j]->tidt_qty_appr}}</td>
							<td></td>
						</tr>
						@endfor
						<?php
							$kosong = [];

					      	$hitung = 20 - count($query_chunk[$i]);

						    for ($a=0; $a < $hitung ; $a++) { 
						     
						       array_push($kosong, 'a');
						    }
						?>

						@foreach($kosong as $b)
						<tr>
							<td class="empty"></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						@endforeach
					</tbody>

				</table>
				
			</div>
			
		@endfor



		<div style="margin-top: 15px;">
			<div class="ttd-kiri text-center bold">
				Staf Sales Outlet
				<br>
				<div style="margin-top: 50px;">

				</div>
			</div>
			<div class="ttd-kanan text-center bold">
				Staf Sales Online
				<br>
				<div style="margin-top: 50px;">

				</div>
			</div>
		</div>
	</div>
</body>
</html>