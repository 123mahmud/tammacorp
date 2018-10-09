<!DOCTYPE html>
<html>
	<head>
		<title>Laporan Neraca Perbandingan</title>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta name="csrf-token" content="{{ csrf_token() }}" />
	    <link rel="shortcut icon" href="{{ asset ('assets/images/icons/favicon.ico') }}">
	    <link rel="apple-touch-icon" href="{{ asset ('assets/images/icons/favicon.png') }}">
	    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset ('assets/images/icons/favicon-72x72.png') }}">
	    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset ('assets/images/icons/favicon-114x114.png') }}">
	    <!--Loading bootstrap css-->
	{{--     <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,700">
	    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,700,300">
	    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet"> --}}
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/jquery-ui-1.10.4.custom.min.css') }}">
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/font-awesome.min.css') }}">
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/bootstrap.min.css') }}">
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/animate.css') }}">
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/all.css') }}">
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/main.css') }}">
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/style-responsive.css') }}">
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/zabuto_calendar.min.css') }}">
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/pace.css') }}">
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/jquery.news-ticker.css') }}">
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/bootstrap-datepicker.min.css') }}">
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/dataTables.bootstrap.css') }}">
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/jquery.dataTables.css') }}">
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/jquery.dataTables.min.css') }}">
	    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/toastr/toastr.css') }}">
	    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/toastr/toastr.min.css') }}">
	    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/select2/select2.min.css') }}">
	    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/select2/select2-bootstrap.css') }}">
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/timepicker.min.css') }}">
	    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/css/ladda-themeless.min.css') }}">

	    <style type="text/css">
	      @page { margin: 10px; }

	       table{
	       	color: #333;
	       }

	      .page_break { page-break-before: always; }

	      .page-number:after { content: counter(page); }

	     	 #table-data{
				font-size: 8pt;
				margin-top: 10px;
				border: 0px solid #555;
				color: #222;
		    }
		    #table-data th{
		    	text-align: center;
		    	border: 1px solid #aaa;
		    	border-collapse: collapse;
		    	background: #ccc;
		    	padding: 5px;
		    }

		    #table-data td{
		    	border-right: 0px solid #555;
		    	padding: 5px;
		    }

		    #table-data td.currency{
		    	text-align: right;
		    	padding-right: 5px;
		    }

		    #table-data td.no-border{
		    	border: 0px;
		    }

		    #table-data td.total{
		    	background: #ccc;
		    	padding: 5px;
		    	font-weight: bold;
		    }

		    #table-data td.total.not-same{
	    		 color: red !important;
	    		 -webkit-print-color-adjust: exact;
	    	}

	      #navigation ul{
	        float: right;
	        padding-right: 110px;
	      }

	      #navigation ul li{
	        color: #fff;
	        list-style-type: none;
	        display: inline-block;
	        margin-left: 40px;
	      }

	      #navigation ul li i{ 
	      	font-size: 15pt;
	      	margin-top: 10px;
	      }

	       #form-table{
	          font-size: 8pt;
	        }

	        #form-table td{
	          padding: 5px 0px;
	        }

	        #form-table .form-control{
	          height: 30px;
	          width: 90%;
	          font-size: 8pt;
	        }

	       .table-ctn td{
	       	border: 1px dotted rgba(0,0,0,0.2);
	       }

	       .table-ctn td.first{
	       	padding: 10px 5px 5px 15px;
	       	font-weight: bold;
	       }

	       .table-ctn td.second{
	       	padding: 5px 5px 3px 45px;
	       	font-weight: 500;
	       }

	       .table-ctn td.number{
	       	padding: 5px 20px 3px 5px;
	       	font-weight: 600;
	       	text-align: right;
	       	font-size: 9pt;
	       }

	    </style>

	    <style type="text/css" media="print">
	        @page { size: portrait; }
	        #navigation{
	            display: none;
	         }

	         .table-ctn td.first{
	         	padding: 10px 5px 5px 5px;
	         }

	         .table-ctn td.second{ 
	         	padding: 5px 5px 3px 35px;;
	         }

	         .table-ctn td.first.pasiva{
	         	padding: 10px 5px 5px 15px;
	         }

	         #contentnya{
	         	margin-top: -80px;
	         }

	        #table-data td.total{
		         background-color: #ccc !important;
		         -webkit-print-color-adjust: exact;
	      	}

		     #table-data td.not-same{
		         color: red !important;
		         -webkit-print-color-adjust: exact;
		    }

	        .page-break { display: block; page-break-before: always; }
	    </style>
      
	</head>

	<body style="background: #555;">

	<div class="col-md-12" id="navigation" style="background: rgba(0, 0, 0, 0.4); box-shadow: 0px 2px 5px #444; position: fixed; z-index: 2;">
	        <div class="row">
	          <div class="col-md-7" style="background: none; padding: 15px 15px; color: #fff; padding-left: 120px; font-size: 15pt;">
	            TammaFood
	          </div>
	          <div class="col-md-5" style="background: none; padding: 10px 15px 5px 15px">
	            <ul>
	              <li><i class="fa fa-sliders" style="cursor: pointer;" onclick="$('#modal_neraca_perbandingan').modal('show')" data-toggle="tooltip" data-placement="bottom" title="Tampilkan Setting Neraca Perbandingan"></i></li>

	              <li><i class="fa fa-columns" style="cursor: pointer;" onclick="$('#modal_neraca').modal('show')" data-toggle="tooltip" data-placement="bottom" title="Buka Laporan Neraca"></i></li>

	              <li><i class="fa fa-print" style="cursor: pointer;" id="print" data-toggle="tooltip" data-placement="bottom" title="Print Laporan"></i></li>
	            </ul>
	          </div>
	        </div>
	</div>

    <div class="col-md-10 col-md-offset-1" style="background: white; padding: 10px 15px; margin-top: 80px;">
        <table width="100%" border="0" style="border-bottom: 1px solid #333;" id="contentnya">
          <thead>
            <tr>
              <th style="text-align: left; font-size: 14pt; font-weight: 600">Laporan Neraca Perbandingan Dalam {{ ucfirst($request->jenis) }}</th>
            </tr>

            <tr>
              <th style="text-align: left; font-size: 12pt; font-weight: 500">Tamma Robbah Indonesia</th>
            </tr>

            <tr>
              <th style="text-align: left; font-size: 8pt; font-weight: 500; padding-bottom: 10px;">(Angka Disajikan Dalam Rupiah, Kecuali Dinyatakan Lain)</th>
            </tr>
          </thead>
        </table>

        <table width="100%" border="0" style="font-size: 8pt;">
          <thead>
            <tr>
              <td style="text-align: left; padding-top: 5px;">
                Laporan Per  
                @if($request->jenis == 'bulan')
                	Bulan {{ date('m/Y', strtotime($data_real_1)) }} dan {{ date('m/Y', strtotime($data_real_2)) }}
                @else
                	Tahun {{ $request->durasi_1_neraca_tahun }}
                @endif
              </td>
            </tr>
          </thead>
        </table>

        <table border="0" width="100%" style="margin-top: 15px; font-size: 10pt;" class="table-ctn">
        	<thead>
        		<tr>
	        		<td style="text-align: center; padding: 8px 0px; font-weight: bold; border: 1px dotted #888; border-right: 1px dotted #888; border-top: 1px dotted #888;" width="30%">Keterangan</td>

	        		<td style="text-align: center; padding: 5px 0px; font-weight: bold; border: 1px dotted #888; border-top: 1px dotted #888;" width="13%">
	        			
	        			Periode {{ date('m/Y', strtotime($data_real_1)) }}

	        		</td>

	        		<td style="text-align: center; padding: 8px 0px; font-weight: bold; border: 1px dotted #888; border-top: 1px dotted #888;" width="13%">
	        			
	        			Periode {{ date('m/Y', strtotime($data_real_2)) }}

	        		</td>

	        		<td style="text-align: center; padding: 8px 0px; font-weight: bold; border: 1px dotted #888; border-top: 1px dotted #888;" width="10%">
	        			
	        			Net Change

	        		</td>

	        		<td style="text-align: center; padding: 8px 0px; font-weight: bold; border: 1px dotted #888; border-top: 1px dotted #888;" width="5%">
	        			
	        			<i class="fa fa-flash"></i>

	        		</td>

	        		<td style="text-align: center; padding: 8px 0px; font-weight: bold; border: 1px dotted #888; border-top: 1px dotted #888;" width="13%">
	        			
	        			Net Cash Value

	        		</td>
	        	</tr>
        	</thead>

        	<tbody>

        		<tr>
        			<td colspan="6" style="background: #eee; text-align: center; font-weight: 600; padding: 8px; border: 1px solid #ccc;">
        				Aktiva
        			</td>
        		</tr>

        		{{-- Aktiva Lancar --}}

        		<tr>
        			<td class="first">
						Aset Lancar
					</td>
					
					<td class="number">
						&nbsp;
					</td>

					<td class="number">
						&nbsp;
					</td>

					<td class="number">
						&nbsp;
					</td>

					<td class="number">
						&nbsp;
					</td>

					<td class="number">
						&nbsp;
					</td>
        		</tr>

        		<?php $total_parrent_1 = $total_parrent_2 = $total_aktiva_1 = $total_aktiva_2 = $total_pasiva_1 = $total_pasiva_2 = 0 ?>

				@foreach($data as $key => $data_neraca)
					@if(substr($data_neraca->no_group, 0, 1) == 'A' && $data_neraca->id_group <= 11)
    					<tr>
    						<td class="second">
    							{{ $data_neraca->nama_group }}
    						</td>

    						<td class="number" style="font-weight: normal;">
    							<?php 
    								$nilai_1 = count_neraca($data, $data_neraca->id_group, 'aktiva', $data_real_1);
    								$print = ($nilai_1 < 0) ? '('.str_replace('-', '', number_format($nilai_1, 2)).')' : number_format($nilai_1, 2);

    								$total_parrent_1 += $nilai_1;
    							?>

    							{{ $print }}
    						</td>

    						<td class="number" style="font-weight: normal;">
    							<?php 
    								$nilai_2 = count_neraca($data_2, $data_neraca->id_group, 'aktiva', $data_real_2);
    								$print = ($nilai_2 < 0) ? '('.str_replace('-', '', number_format($nilai_2, 2)).')' : number_format($nilai_2, 2);

    								$total_parrent_2 += $nilai_2;
    							?>

    							{{ $print }}
    						</td>

    						<td style="font-size: 8pt; text-align: center; font-weight: 500; padding-right: 10px;">
    							<?php 
			                        $selisih = $nilai_1 - $nilai_2;

			                        if(max([$nilai_1, $nilai_2]) > 0)
			                            $premi = ($selisih / max([$nilai_1, $nilai_2]));
			                        else
			                            $premi = 0;

			                        $icon = '<i class="fa fa-arrow-up" style="color:#00C851; font-size:9pt;"></i>';

			                        if($premi < 0){
			                            $icon = '<i class="fa fa-arrow-down" style="color:#ff4444; font-size:9pt;"></i>';
			                        }elseif($premi == 0){
			                            $icon = '<i class="fa fa-minus" style="color:#ffbb33; font-size:9pt;"></i>';
			                        }

			                    ?>

    							{{ ($premi < 0) ? number_format(str_replace('-', '', ($premi * 100)), 0) : number_format(($premi * 100), 0) }}%

    						</td>

    						<td style="text-align: center;">
    							 {!! $icon !!}
    						</td>

    						<td class="number" style="font-weight: normal;">
    							{{ ($nilai_1 - $nilai_2 < 0) ? '('.number_format(str_replace('-', '', ($nilai_1 - $nilai_2))).')' : number_format(($nilai_1 - $nilai_2), 2) }}
    						</td>
    					</tr>
    				@endif
				@endforeach

						<tr>
    						<td class="first" style="font-weight: normal;">
    							Total Aktiva Lancar
    						</td>

    						<td class="number" style="border-top: 1px solid #777;">
    							<?php 
    								$nilai_1 = $total_parrent_1;
    								$print = ($nilai_1 < 0) ? '('.str_replace('-', '', number_format($nilai_1, 2)).')' : number_format($nilai_1, 2);

    								$total_parrent_1 += $nilai_1;
    								$total_aktiva_1 += $nilai_1;
    							?>

    							{{ $print }}
    						</td>

    						<td class="number" style="border-top: 1px solid #777;">
    							<?php 
    								$nilai_2 = $total_parrent_2;
    								$print = ($nilai_2 < 0) ? '('.str_replace('-', '', number_format($nilai_2, 2)).')' : number_format($nilai_2, 2);

    								$total_parrent_2 += $nilai_2;
    								$total_aktiva_2 += $nilai_2;
    							?>

    							{{ $print }}
    						</td>

    						<td style="font-size: 8pt; text-align: center; font-weight: 500; padding-right: 10px; border-top: 1px solid #777;">
    							<?php 
			                        $selisih = $nilai_1 - $nilai_2;

			                        if(max([$nilai_1, $nilai_2]) > 0)
			                            $premi = ($selisih / max([$nilai_1, $nilai_2]));
			                        else
			                            $premi = 0;

			                        $icon = '<i class="fa fa-arrow-up" style="color:#00C851; font-size:9pt;"></i>';

			                        if($premi < 0){
			                            $icon = '<i class="fa fa-arrow-down" style="color:#ff4444; font-size:9pt;"></i>';
			                        }elseif($premi == 0){
			                            $icon = '<i class="fa fa-minus" style="color:#ffbb33; font-size:9pt;"></i>';
			                        }

			                    ?>

    							{{ ($premi < 0) ? number_format(str_replace('-', '', ($premi * 100)), 0) : number_format(($premi * 100), 0) }}%

    						</td>

    						<td style="text-align: center; border-top: 1px solid #777;">
    							 {!! $icon !!}
    						</td>

    						<td class="number" style="border-top: 1px solid #777;">
    							{{ ($nilai_1 - $nilai_2 < 0) ? '('.number_format(str_replace('-', '', ($nilai_1 - $nilai_2))).')' : number_format(($nilai_1 - $nilai_2), 2) }}
    						</td>
    					</tr>

    			{{-- END Aktiva Lancar --}}

    			<tr>
    				<td colspan="6">&nbsp;</td>
    			</tr>

    			{{-- Aktiva Lancar Tidak Lancar --}}

        		<tr>
        			<td class="first">
						Aset Tidak Lancar
					</td>
					
					<td class="number">
						&nbsp;
					</td>

					<td class="number">
						&nbsp;
					</td>

					<td class="number">
						&nbsp;
					</td>

					<td class="number">
						&nbsp;
					</td>

					<td class="number">
						&nbsp;
					</td>
        		</tr>

        		<?php $total_parrent_1 = $total_parrent_2 = 0 ?>

				@foreach($data as $key => $data_neraca)
					@if(substr($data_neraca->no_group, 0, 1) == 'A' && $data_neraca->id_group >= 12 && $data_neraca->id_group <= 16)
    					<tr>
    						<td class="second">
    							{{ $data_neraca->nama_group }}
    						</td>

    						<td class="number" style="font-weight: normal;">
    							<?php 
    								$nilai_1 = count_neraca($data, $data_neraca->id_group, 'aktiva', $data_real_1);
    								$print = ($nilai_1 < 0) ? '('.str_replace('-', '', number_format($nilai_1, 2)).')' : number_format($nilai_1, 2);

    								$total_parrent_1 += $nilai_1;
    							?>

    							{{ $print }}
    						</td>

    						<td class="number" style="font-weight: normal;">
    							<?php 
    								$nilai_2 = count_neraca($data_2, $data_neraca->id_group, 'aktiva', $data_real_2);
    								$print = ($nilai_2 < 0) ? '('.str_replace('-', '', number_format($nilai_2, 2)).')' : number_format($nilai_2, 2);

    								$total_parrent_2 += $nilai_2;
    							?>

    							{{ $print }}
    						</td>

    						<td style="font-size: 8pt; text-align: center; font-weight: 500; padding-right: 10px;">
    							<?php 
			                        $selisih = $nilai_1 - $nilai_2;

			                        if(max([$nilai_1, $nilai_2]) > 0)
			                            $premi = ($selisih / max([$nilai_1, $nilai_2]));
			                        else
			                            $premi = 0;

			                        $icon = '<i class="fa fa-arrow-up" style="color:#00C851; font-size:9pt;"></i>';

			                        if($premi < 0){
			                            $icon = '<i class="fa fa-arrow-down" style="color:#ff4444; font-size:9pt;"></i>';
			                        }elseif($premi == 0){
			                            $icon = '<i class="fa fa-minus" style="color:#ffbb33; font-size:9pt;"></i>';
			                        }

			                    ?>

    							{{ ($premi < 0) ? number_format(str_replace('-', '', ($premi * 100)), 0) : number_format(($premi * 100), 0) }}%

    						</td>

    						<td style="text-align: center;">
    							 {!! $icon !!}
    						</td>

    						<td class="number" style="font-weight: normal;">
    							{{ ($nilai_1 - $nilai_2 < 0) ? '('.number_format(str_replace('-', '', ($nilai_1 - $nilai_2))).')' : number_format(($nilai_1 - $nilai_2), 2) }}
    						</td>
    					</tr>
    				@endif
				@endforeach

						<tr>
    						<td class="first" style="font-weight: normal;">
    							Total Aset Tidak Lancar
    						</td>

    						<td class="number" style="border-top: 1px solid #777;">
    							<?php 
    								$nilai_1 = $total_parrent_1;
    								$print = ($nilai_1 < 0) ? '('.str_replace('-', '', number_format($nilai_1, 2)).')' : number_format($nilai_1, 2);

    								$total_parrent_1 += $nilai_1;
    								$total_aktiva_1 += $nilai_1;
    							?>

    							{{ $print }}
    						</td>

    						<td class="number" style="border-top: 1px solid #777;">
    							<?php 
    								$nilai_2 = $total_parrent_2;
    								$print = ($nilai_2 < 0) ? '('.str_replace('-', '', number_format($nilai_2, 2)).')' : number_format($nilai_2, 2);

    								$total_parrent_2 += $nilai_2;
    								$total_aktiva_2 += $nilai_2;
    							?>

    							{{ $print }}
    						</td>

    						<td style="font-size: 8pt; text-align: center; font-weight: 500; padding-right: 10px; border-top: 1px solid #777;">
    							<?php 
			                        $selisih = $nilai_1 - $nilai_2;

			                        if(max([$nilai_1, $nilai_2]) > 0)
			                            $premi = ($selisih / max([$nilai_1, $nilai_2]));
			                        else
			                            $premi = 0;

			                        $icon = '<i class="fa fa-arrow-up" style="color:#00C851; font-size:9pt;"></i>';

			                        if($premi < 0){
			                            $icon = '<i class="fa fa-arrow-down" style="color:#ff4444; font-size:9pt;"></i>';
			                        }elseif($premi == 0){
			                            $icon = '<i class="fa fa-minus" style="color:#ffbb33; font-size:9pt;"></i>';
			                        }

			                    ?>

    							{{ ($premi < 0) ? number_format(str_replace('-', '', ($premi * 100)), 0) : number_format(($premi * 100), 0) }}%

    						</td>

    						<td style="text-align: center; border-top: 1px solid #777;">
    							 {!! $icon !!}
    						</td>

    						<td class="number" style="border-top: 1px solid #777;">
    							{{ ($nilai_1 - $nilai_2 < 0) ? '('.number_format(str_replace('-', '', ($nilai_1 - $nilai_2))).')' : number_format(($nilai_1 - $nilai_2), 2) }}
    						</td>
    					</tr>

    			{{-- END Aktiva Lancar --}}

    			<tr>
    				<td colspan="6">&nbsp;</td>
    			</tr>

    			<tr>
    				<td class="first" style="text-align: center;">Total Aktiva</td>
    				<td class="number">
    					{{ ($total_aktiva_1 < 0) ? '('.str_replace('-', '', number_format($total_aktiva_1, 2)).')' : number_format($total_aktiva_1, 2) }}
    				</td>
    				<td class="number">
    					{{ ($total_aktiva_2 < 0) ? '('.str_replace('-', '', number_format($total_aktiva_2, 2)).')' : number_format($total_aktiva_2, 2) }}
    				</td>
    			</tr>

    			<tr>
        			<td colspan="6" style="background: #eee; text-align: center; font-weight: 600; padding: 8px; border: 1px solid #ccc; border-top: 1px solid #555;">
        				Pasiva
        			</td>
        		</tr>


    			{{-- Liabilitas/Kewajiban --}}

        		<tr>
        			<td class="first">
						Liabilitas/Kewajiban
					</td>
					
					<td class="number">
						&nbsp;
					</td>

					<td class="number">
						&nbsp;
					</td>

					<td class="number">
						&nbsp;
					</td>

					<td class="number">
						&nbsp;
					</td>

					<td class="number">
						&nbsp;
					</td>
        		</tr>

        		<?php $total_parrent_1 = $total_parrent_2 = 0 ?>

				@foreach($data as $key => $data_neraca)
					@if(substr($data_neraca->no_group, 0, 1) == 'P' && $data_neraca->id_group >= 17 && $data_neraca->id_group <= 22)
    					<tr>
    						<td class="second">
    							{{ $data_neraca->nama_group }}
    						</td>

    						<td class="number" style="font-weight: normal;">
    							<?php 
    								$nilai_1 = count_neraca($data, $data_neraca->id_group, 'pasiva', $data_real_1);
    								$print = ($nilai_1 < 0) ? '('.str_replace('-', '', number_format($nilai_1, 2)).')' : number_format($nilai_1, 2);

    								$total_parrent_1 += $nilai_1;
    							?>

    							{{ $print }}
    						</td>

    						<td class="number" style="font-weight: normal;">
    							<?php 
    								$nilai_2 = count_neraca($data_2, $data_neraca->id_group, 'pasiva', $data_real_2);
    								$print = ($nilai_2 < 0) ? '('.str_replace('-', '', number_format($nilai_2, 2)).')' : number_format($nilai_2, 2);

    								$total_parrent_2 += $nilai_2;
    							?>

    							{{ $print }}
    						</td>

    						<td style="font-size: 8pt; text-align: center; font-weight: 500; padding-right: 10px;">
    							<?php 
			                        $selisih = $nilai_1 - $nilai_2;

			                        if(max([$nilai_1, $nilai_2]) > 0)
			                            $premi = ($selisih / max([$nilai_1, $nilai_2]));
			                        else
			                            $premi = 0;

			                        $icon = '<i class="fa fa-arrow-up" style="color:#00C851; font-size:9pt;"></i>';

			                        if($premi < 0){
			                            $icon = '<i class="fa fa-arrow-down" style="color:#ff4444; font-size:9pt;"></i>';
			                        }elseif($premi == 0){
			                            $icon = '<i class="fa fa-minus" style="color:#ffbb33; font-size:9pt;"></i>';
			                        }

			                    ?>

    							{{ ($premi < 0) ? number_format(str_replace('-', '', ($premi * 100)), 0) : number_format(($premi * 100), 0) }}%

    						</td>

    						<td style="text-align: center;">
    							 {!! $icon !!}
    						</td>

    						<td class="number" style="font-weight: normal;">
    							{{ ($nilai_1 - $nilai_2 < 0) ? '('.number_format(str_replace('-', '', ($nilai_1 - $nilai_2))).')' : number_format(($nilai_1 - $nilai_2), 2) }}
    						</td>
    					</tr>
    				@endif
				@endforeach

						<tr>
    						<td class="first" style="font-weight: normal;">
    							Total Liabilitas/Kewajiban
    						</td>

    						<td class="number" style="border-top: 1px solid #777;">
    							<?php 
    								$nilai_1 = $total_parrent_1;
    								$print = ($nilai_1 < 0) ? '('.str_replace('-', '', number_format($nilai_1, 2)).')' : number_format($nilai_1, 2);

    								$total_parrent_1 += $nilai_1;
    								$total_pasiva_1 += $nilai_1;
    							?>

    							{{ $print }}
    						</td>

    						<td class="number" style="border-top: 1px solid #777;">
    							<?php 
    								$nilai_2 = $total_parrent_2;
    								$print = ($nilai_2 < 0) ? '('.str_replace('-', '', number_format($nilai_2, 2)).')' : number_format($nilai_2, 2);

    								$total_parrent_2 += $nilai_2;
    								$total_pasiva_2 += $nilai_2;
    							?>

    							{{ $print }}
    						</td>

    						<td style="font-size: 8pt; text-align: center; font-weight: 500; padding-right: 10px; border-top: 1px solid #777;">
    							<?php 
			                        $selisih = $nilai_1 - $nilai_2;

			                        if(max([$nilai_1, $nilai_2]) > 0)
			                            $premi = ($selisih / max([$nilai_1, $nilai_2]));
			                        else
			                            $premi = 0;

			                        $icon = '<i class="fa fa-arrow-up" style="color:#00C851; font-size:9pt;"></i>';

			                        if($premi < 0){
			                            $icon = '<i class="fa fa-arrow-down" style="color:#ff4444; font-size:9pt;"></i>';
			                        }elseif($premi == 0){
			                            $icon = '<i class="fa fa-minus" style="color:#ffbb33; font-size:9pt;"></i>';
			                        }

			                    ?>

    							{{ ($premi < 0) ? number_format(str_replace('-', '', ($premi * 100)), 0) : number_format(($premi * 100), 0) }}%

    						</td>

    						<td style="text-align: center; border-top: 1px solid #777;">
    							 {!! $icon !!}
    						</td>

    						<td class="number" style="border-top: 1px solid #777;">
    							{{ ($nilai_1 - $nilai_2 < 0) ? '('.number_format(str_replace('-', '', ($nilai_1 - $nilai_2))).')' : number_format(($nilai_1 - $nilai_2), 2) }}
    						</td>
    					</tr>

    			{{-- END Liabilitas/Kewajiban --}}

    			<tr>
    				<td colspan="6">&nbsp;</td>
    			</tr>

    			{{-- Ekuitas/Modal --}}

        		<tr>
        			<td class="first">
						Ekuitas / Modal
					</td>
					
					<td class="number">
						&nbsp;
					</td>

					<td class="number">
						&nbsp;
					</td>

					<td class="number">
						&nbsp;
					</td>

					<td class="number">
						&nbsp;
					</td>

					<td class="number">
						&nbsp;
					</td>
        		</tr>

        		<?php $total_parrent_1 = $total_parrent_2 = 0 ?>

				@foreach($data as $key => $data_neraca)
					@if(substr($data_neraca->no_group, 0, 1) == 'P' && $data_neraca->id_group >= 23 && $data_neraca->id_group <= 25)
    					<tr>
    						<td class="second">
    							{{ $data_neraca->nama_group }}
    						</td>

    						<td class="number" style="font-weight: normal;">
    							<?php 
    								$nilai_1 = count_neraca($data, $data_neraca->id_group, 'pasiva', $data_real_1);
    								$print = ($nilai_1 < 0) ? '('.str_replace('-', '', number_format($nilai_1, 2)).')' : number_format($nilai_1, 2);

    								$total_parrent_1 += $nilai_1;
    							?>

    							{{ $print }}
    						</td>

    						<td class="number" style="font-weight: normal;">
    							<?php 
    								$nilai_2 = count_neraca($data_2, $data_neraca->id_group, 'pasiva', $data_real_2);
    								$print = ($nilai_2 < 0) ? '('.str_replace('-', '', number_format($nilai_2, 2)).')' : number_format($nilai_2, 2);

    								$total_parrent_2 += $nilai_2;
    							?>

    							{{ $print }}
    						</td>

    						<td style="font-size: 8pt; text-align: center; font-weight: 500; padding-right: 10px;">
    							<?php 
			                        $selisih = $nilai_1 - $nilai_2;

			                        if(max([$nilai_1, $nilai_2]) > 0)
			                            $premi = ($selisih / max([$nilai_1, $nilai_2]));
			                        else
			                            $premi = 0;

			                        $icon = '<i class="fa fa-arrow-up" style="color:#00C851; font-size:9pt;"></i>';

			                        if($premi < 0){
			                            $icon = '<i class="fa fa-arrow-down" style="color:#ff4444; font-size:9pt;"></i>';
			                        }elseif($premi == 0){
			                            $icon = '<i class="fa fa-minus" style="color:#ffbb33; font-size:9pt;"></i>';
			                        }

			                    ?>

    							{{ ($premi < 0) ? number_format(str_replace('-', '', ($premi * 100)), 0) : number_format(($premi * 100), 0) }}%

    						</td>

    						<td style="text-align: center;">
    							 {!! $icon !!}
    						</td>

    						<td class="number" style="font-weight: normal;">
    							{{ ($nilai_1 - $nilai_2 < 0) ? '('.number_format(str_replace('-', '', ($nilai_1 - $nilai_2))).')' : number_format(($nilai_1 - $nilai_2), 2) }}
    						</td>
    					</tr>
    				@endif
				@endforeach

						<tr>
    						<td class="first" style="font-weight: normal;">
    							Total Ekuitas/Modal
    						</td>

    						<td class="number" style="border-top: 1px solid #777;">
    							<?php 
    								$nilai_1 = $total_parrent_1;
    								$print = ($nilai_1 < 0) ? '('.str_replace('-', '', number_format($nilai_1, 2)).')' : number_format($nilai_1, 2);

    								$total_parrent_1 += $nilai_1;
    								$total_pasiva_1 += $nilai_1;
    							?>

    							{{ $print }}
    						</td>

    						<td class="number" style="border-top: 1px solid #777;">
    							<?php 
    								$nilai_2 = $total_parrent_2;
    								$print = ($nilai_2 < 0) ? '('.str_replace('-', '', number_format($nilai_2, 2)).')' : number_format($nilai_2, 2);

    								$total_parrent_2 += $nilai_2;
    								$total_pasiva_2 += $nilai_2;
    							?>

    							{{ $print }}
    						</td>

    						<td style="font-size: 8pt; text-align: center; font-weight: 500; padding-right: 10px; border-top: 1px solid #777;">
    							<?php 
			                        $selisih = $nilai_1 - $nilai_2;

			                        if(max([$nilai_1, $nilai_2]) > 0)
			                            $premi = ($selisih / max([$nilai_1, $nilai_2]));
			                        else
			                            $premi = 0;

			                        $icon = '<i class="fa fa-arrow-up" style="color:#00C851; font-size:9pt;"></i>';

			                        if($premi < 0){
			                            $icon = '<i class="fa fa-arrow-down" style="color:#ff4444; font-size:9pt;"></i>';
			                        }elseif($premi == 0){
			                            $icon = '<i class="fa fa-minus" style="color:#ffbb33; font-size:9pt;"></i>';
			                        }

			                    ?>

    							{{ ($premi < 0) ? number_format(str_replace('-', '', ($premi * 100)), 0) : number_format(($premi * 100), 0) }}%

    						</td>

    						<td style="text-align: center; border-top: 1px solid #777;">
    							 {!! $icon !!}
    						</td>

    						<td class="number" style="border-top: 1px solid #777;">
    							{{ ($nilai_1 - $nilai_2 < 0) ? '('.number_format(str_replace('-', '', ($nilai_1 - $nilai_2))).')' : number_format(($nilai_1 - $nilai_2), 2) }}
    						</td>
    					</tr>

    			{{-- END Ekuitas/Modal --}}

    			<tr>
    				<td colspan="6">&nbsp;</td>
    			</tr>

    			<tr>
    				<td class="first" style="text-align: center;">Total Pasiva</td>
    				<td class="number">
    					{{ ($total_pasiva_1 < 0) ? '('.str_replace('-', '', number_format($total_pasiva_1, 2)).')' : number_format($total_pasiva_1, 2) }}
    				</td>
    				<td class="number">
    					{{ ($total_pasiva_2 < 0) ? '('.str_replace('-', '', number_format($total_pasiva_2, 2)).')' : number_format($total_pasiva_2, 2) }}
    				</td>
    			</tr>

        	</tbody>
        </table>

    </div>

	      <!-- modal -->
              <!-- Modal -->
              <div class="modal fade" id="modal_neraca" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document" style="width: 35%;">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">Setting Neraca</h4>
                    </div>

                    <form id="form-jurnal" method="get" action="{{ route('laporan_neraca.index') }}" target="_blank">
                    <div class="modal-body">
                      <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-3">
                          Jenis Periode
                        </div>

                        <div class="col-md-4">
                          <select name="jenis" class="form-control" id="jenis_periode_neraca">
                            <option value="bulan">Bulan</option>
                            <option value="tahun">Tahun</option>
                          </select>
                        </div>
                    </div>

                      <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-3">
                          Periode
                        </div>

                        <div class="col-md-9 durasi_bulan_neraca">
                          <input type="text" name="durasi_1_neraca_bulan" placeholder="periode Mulai" class="form-control" id="d1_neraca" autocomplete="off" required readonly style="cursor: pointer;">
                        </div>

                        <div class="col-md-9 durasi_tahun_neraca" style="display: none;">
                          <input type="text" name="durasi_1_neraca_tahun" placeholder="periode Mulai" class="form-control" id="d1_neraca_tahun" autocomplete="off" required readonly style="cursor: pointer;">
                        </div>
                      </div>
                    </div>
                    
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary">Proses</button>
                    </div>

                    </form>
                  </div>
                </div>
              </div>
		  <!-- modal -->

		  <!-- modal -->
              <!-- Modal -->
              <div class="modal fade" id="modal_neraca_perbandingan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document" style="width: 35%;">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">Setting Neraca Perbandingan</h4>
                    </div>

                    <form id="form-jurnal-perbandingan" method="get" action="{{ route('laporan_neraca_perbandingan.index') }}" target="_self">
                    <div class="modal-body">
                      <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-3">
                          Jenis Periode
                        </div>

                        <div class="col-md-4">
                          <select name="jenis" class="form-control" id="jenis_periode_neraca_perbandingan">
                            <option value="bulan">Bulan</option>
                            <option value="tahun">Tahun</option>
                          </select>
                        </div>
                    </div>

                      <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-3">
                          Periode 1
                        </div>

                        <div class="col-md-9 durasi_bulan_neraca_perbandingan">
                          <input type="text" name="durasi_bulan_1" placeholder="Pilih Periode Bulan 1" class="form-control" id="bulan_neraca_1" autocomplete="off" required readonly style="cursor: pointer;">
                        </div>

                        <div class="col-md-9 durasi_tahun_neraca_perbandingan" style="display: none;">
                          <input type="text" name="durasi_tahun_1" placeholder="Pilih Periode Tahun 1" class="form-control" id="tahun_neraca_1" autocomplete="off" required readonly style="cursor: pointer;">
                        </div>

                      </div>

                      <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-3">
                          Periode 2
                        </div>

                        <div class="col-md-9 durasi_bulan_neraca_perbandingan">
                          <input type="text" name="durasi_bulan_2" placeholder="Pilih Periode Bulan 2" class="form-control" id="bulan_neraca_2" autocomplete="off" required readonly style="cursor: pointer;">
                        </div>

                        <div class="col-md-9 durasi_tahun_neraca_perbandingan" style="display: none;">
                          <input type="text" name="durasi_tahun_2" placeholder="Pilih Periode Tahun 2" class="form-control" id="tahun_neraca_2" autocomplete="off" required readonly style="cursor: pointer;">
                        </div>

                      </div>
                    </div>
                    
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary">Proses</button>
                    </div>

                    </form>
                  </div>
                </div>
              </div>
		  <!-- modal -->

		<script src="{{ asset ('assets/script/jquery-2.2.4.min.js') }}"></script>
	    <script src="{{ asset ('assets/js/date-uk.js') }}"></script>
	{{--     <script src="{{ asset ('assets/js/my.js') }}"></script> --}}
	    <script src="{{ asset ('assets/js/js_ssb.js') }}"></script>
	{{--     <script src="{{ asset ('assets/script/jquery-1.10.2.min.js') }}"></script> --}}
	{{--     <script src="{{ asset ('assets/script/jquery-2.2.4.min.js') }}"></script> --}}
	    <script src="{{ asset ('assets/script/jquery-migrate-1.2.1.min.js') }}"></script>
	    <script src="{{ asset ('assets/script/jquery-ui.js') }}"></script>
	    <script src="{{ asset ('assets/script/bootstrap-datepicker.js') }}"></script>
	    <script src="{{ asset ('assets/script/bootstrap.min.js') }}"></script>
	    <script src="{{ asset ('assets/script/bootstrap-hover-dropdown.js') }}"></script>
	{{--     <script src="{{ asset ('assts/script/html5shiv.js') }}"></script> --}}
	    <script src="{{ asset ('assets/script/respond.min.js') }}"></script>
	    <script src="{{ asset ('assets/script/jquery.metisMenu.js') }}"></script>
	    <script src="{{ asset ('assets/script/jquery.slimscroll.js') }}"></script>
	    <script src="{{ asset ('assets/script/jquery.cookie.js') }}"></script>
	    <script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
	    <script src="{{ asset ('assets/script/custom.min.js') }}"></script>
	    <script src="{{ asset ('assets/script/jquery.news-ticker.js') }}"></script>
	    <script src="{{ asset ('assets/script/jquery.menu.js') }}"></script>
	    <script src="{{ asset ('assets/script/pace.min.js') }}"></script>
	    <script src="{{ asset ('assets/script/holder.js') }}"></script>
	    <script src="{{ asset ('assets/script/responsive-tabs.js') }}"></script>
	    <script src="{{ asset ('assets/script/jquery.flot.js') }}"></script>
	    <script src="{{ asset ('assets/script/jquery.flot.categories.js') }}"></script>
	    <script src="{{ asset ('assets/script/jquery.flot.pie.js') }}"></script>
	    <script src="{{ asset ('assets/script/jquery.flot.tooltip.js') }}"></script>
	    <script src="{{ asset ('assets/script/jquery.flot.resize.js') }}"></script>
	    <script src="{{ asset ('assets/script/jquery.flot.fillbetween.js') }}"></script>
	    <script src="{{ asset ('assets/script/jquery.flot.stack.js') }}"></script>
	    <script src="{{ asset ('assets/script/jquery.flot.spline.js') }}"></script>
	    <script src="{{ asset ('assets/script/zabuto_calendar.min.js') }}"></script>
	    {{-- <script src="{{ asset ('assets/script/index.js') }}"></script> --}}
	    <script src="{{ asset ('assets/script/dataTables.bootstrap.js') }}"></script>
	    <script src="{{ asset ('assets/script/jquery.dataTables.js') }}"></script>
	    <script src="{{ asset ('assets/toastr/toastr.min.js') }}"></script>
	    <script src="{{ asset ('assets/select2/select2.min.js') }}"></script>
	    <!--LOADING SCRIPTS FOR CHAfRTS-->
	    <script src="{{ asset ('assets/script/highcharts.js') }}"></script>
	    <script src="{{ asset ('assets/script/data.js') }}"></script>
	    <script src="{{ asset ('assets/script/drilldown.js') }}"></script>
	    <script src="{{ asset ('assets/script/exporting.js') }}"></script>
	    <script src="{{ asset ('assets/script/highcharts-more.js') }}"></script>
	    <script src="{{ asset ('assets/script/charts-highchart-pie.js') }}"></script>
	    <script src="{{ asset ('assets/script/charts-highchart-more.js') }}"></script>
	    <!--CORE JAVASCRIPT-->
	    <script src="{{ asset ('assets/script/main.js') }}"></script>
	    <script src="{{ asset ('assets/script/timepicker.min.js') }}"></script>
	    <script src="{{asset('assets/script/jquery.maskMoney.js')}}"></script>
	    <script src="{{asset('assets/script/accounting.min.js')}}"></script>
	    <script src="{{ asset('js/iziToast.min.js') }}"></script>
	    <script src="{{asset('js/jquery-validation.min.js')}}"></script>

	    <script type="text/javascript">
	    	  // modal neraca

            $('#d2_neraca').datepicker( {
                format: "yyyy-mm",
                viewMode: "months", 
                minViewMode: "months"
            });

            $('#d1_neraca').datepicker({
              format: "yyyy-mm",
              viewMode: "months", 
              minViewMode: "months"
            })

            $('#d1_neraca_tahun').datepicker({
              format: "yyyy",
              viewMode: "years", 
              minViewMode: "years"
            })

            $('#jenis_periode_neraca').change(function(evt){
              evt.preventDefault();

              if($(this).val() == 'bulan'){
                $('.durasi_bulan_neraca').show();
                $('.durasi_tahun_neraca').hide();
              }else{
                $('.durasi_bulan_neraca').hide();
                $('.durasi_tahun_neraca').show();
              }
            })

          // modal neraca

          // modal neraca perbandingan

            $('#bulan_neraca_2').datepicker( {
                format: "yyyy-mm",
                viewMode: "months", 
                minViewMode: "months"
            });

            $('#tahun_neraca_2').datepicker( {
                format: "yyyy",
                viewMode: "years", 
                minViewMode: "years"
            });

            $('#tahun_neraca_1').datepicker( {
                format: "yyyy",
                viewMode: "years", 
                minViewMode: "years"
            }).on("changeDate", function(){
	              $('#tahun_neraca_2').val("");
	              $('#tahun_neraca_2').datepicker("setStartDate", $(this).val());
	        });

            $('#bulan_neraca_1').datepicker({
              format: "yyyy-mm",
              viewMode: "months", 
              minViewMode: "months"
            }).on("changeDate", function(){
	              $('#bulan_neraca_2').val("");
	              $('#bulan_neraca_2').datepicker("setStartDate", $(this).val());
	        });

            $('#d1_neraca_tahun').datepicker({
              format: "yyyy",
              viewMode: "years", 
              minViewMode: "years"
            })

            $('#jenis_periode_neraca_perbandingan').change(function(evt){
              evt.preventDefault();

              if($(this).val() == 'bulan'){
                $('.durasi_bulan_neraca_perbandingan').show();
                $('.durasi_tahun_neraca_perbandingan').hide();
              }else{
                $('.durasi_bulan_neraca_perbandingan').hide();
                $('.durasi_tahun_neraca_perbandingan').show();
              }
            })

          // modal neraca perbandingan

            $('#print').click(function(evt){
              evt.preventDefault();

              window.print();
            })

	    </script>

	</body>
</html>