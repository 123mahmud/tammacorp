<!DOCTYPE html>
<html>
	<head>
		<title>Laporan Arus Kas</title>
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
	       	border-bottom: 1px dotted rgba(0,0,0,0.1);
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
	         	padding: 10px 5px 5px 0px;
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
	              {{-- <li><i class="fa fa-sliders" style="cursor: pointer;" onclick="$('#modal_neraca').modal('show')" data-toggle="tooltip" data-placement="bottom" title="Tampilkan Setting Arus Kas"></i></li> --}}

	              <li><i class="fa fa-print" style="cursor: pointer;" id="print" data-toggle="tooltip" data-placement="bottom" title="Print Laporan"></i></li>
	            </ul>
	          </div>
	        </div>
	</div>

    <div class="col-md-8 col-md-offset-2" style="background: white; padding: 10px 15px; margin-top: 80px;">
        <table width="100%" border="0" style="border-bottom: 1px solid #333;" id="contentnya">
          <thead>
            <tr>
              <th style="text-align: left; font-size: 14pt; font-weight: 600">Laporan Arus Kas Dalam {{ ucfirst($request->jenis) }}</th>
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
                	Bulan {{ date('m/Y', strtotime($durasi)) }}
                @else
                	Tahun {{ $request->durasi_1_neraca_tahun }}
                @endif
              </td>
            </tr>
          </thead>
        </table>

        <table border="0" width="85%" style="margin: 15px 0px 15px 30px; border-top: 1px dotted #aaa" class="table-ctn">
        	<?php $ocf = $icf = $fcf = 0; ?>
        	<tr>
	        	<td class="first" colspan="3">
	        		Arus Kas Dari kegiatan Operasional
	        	</td>

	        	@foreach($tipeTransaksi as $key => $tipe)

					<?php $totDetail = 0; ?>

	        		@if($tipe->tc_cashflow == 'OCF')
    					<tr>
    						<td style="padding: 5px 5px 3px 45px; font-weight: 500;" width="60%">
    							{{ $tipe->tc_name }}
    						</td>

    						<td width="20%" style="padding: 5px 20px 3px 5px; font-weight: 600; text-align: right; font-size: 9pt;">
    							@foreach($detail as $key => $numb)
    								@if($numb->jrdt_cashflow == $tipe->tc_id)
    									<?php 
    										$nilai = ($numb->posisi_akun == 'D') ? ($numb->jrdt_value * -1) : $numb->jrdt_value;
    										$totDetail += (double) $nilai;
    									?>
    								@endif
    							@endforeach
    							{{ formatAccounting($totDetail) }}
    							<?php $ocf += $totDetail; ?>
    						</td>
    						<td></td>
    					</tr>
    				@endif

				@endforeach

				<tr>
					<td style="padding: 5px 5px 3px 45px; font-weight: 600;" width="60%">
						Total Arus Kas Dari Kegiatan Operasional
					</td>

					<td style="border-top: 1px solid #aaa"></td>

					<td style="padding: 5px 20px 3px 5px; font-weight: 600; text-align: right; font-size: 9pt;border-top: 1px solid #aaa">
						{{ formatAccounting($ocf) }}
					</td>
				</tr>
	        </tr>

	        <tr>
	        	<td colspan="3">&nbsp;</td>
	        </tr>


	        <tr>
	        	<td class="first" colspan="3">
	        		Arus Kas Dari kegiatan Pendanaan
	        	</td>

	        	@foreach($tipeTransaksi as $key => $tipe)

					<?php $totDetail = 0; ?>

	        		@if($tipe->tc_cashflow == 'FCF')
    					<tr>
    						<td style="padding: 5px 5px 3px 45px; font-weight: 500;" width="60%">
    							{{ $tipe->tc_name }}
    						</td>

    						<td width="20%" style="padding: 5px 20px 3px 5px; font-weight: 600; text-align: right; font-size: 9pt;">
    							@foreach($detail as $key => $numb)
    								@if($numb->jrdt_cashflow == $tipe->tc_id)
    									<?php 
    										$nilai = ($numb->posisi_akun == 'D') ? ($numb->jrdt_value * -1) : $numb->jrdt_value;
    										$totDetail += (double) $nilai;
    									?>
    								@endif
    							@endforeach
    							{{ formatAccounting($totDetail) }}
    							<?php $fcf += $totDetail; ?>
    						</td>
    						<td></td>
    					</tr>
    				@endif

				@endforeach

				<tr>
					<td style="padding: 5px 5px 3px 45px; font-weight: 600;" width="60%">
						Total Arus Kas Dari Kegiatan Pendanaan
					</td>

					<td style="border-top: 1px solid #aaa"></td>

					<td style="padding: 5px 20px 3px 5px; font-weight: 600; text-align: right; font-size: 9pt;border-top: 1px solid #aaa">
						{{ formatAccounting($fcf) }}
					</td>
				</tr>
	        </tr>

	        <tr>
	        	<td colspan="3">&nbsp;</td>
	        </tr>

	        <tr>
	        	<td class="first" colspan="3">
	        		Arus Kas Dari kegiatan Investasi
	        	</td>

	        	@foreach($tipeTransaksi as $key => $tipe)

					<?php $totDetail = 0; ?>

	        		@if($tipe->tc_cashflow == 'ICF')
    					<tr>
    						<td style="padding: 5px 5px 3px 45px; font-weight: 500;" width="60%">
    							{{ $tipe->tc_name }}
    						</td>

    						<td width="20%" style="padding: 5px 20px 3px 5px; font-weight: 600; text-align: right; font-size: 9pt;">
    							@foreach($detail as $key => $numb)
    								@if($numb->jrdt_cashflow == $tipe->tc_id)
    									<?php 
    										$nilai = ($numb->posisi_akun == 'D') ? ($numb->jrdt_value * -1) : $numb->jrdt_value;
    										$totDetail += (double) $nilai;
    									?>
    								@endif
    							@endforeach
    							{{ formatAccounting($totDetail) }}
    							<?php $icf += $totDetail; ?>
    						</td>
    						<td></td>
    					</tr>
    				@endif

				@endforeach

				<tr>
					<td style="padding: 5px 5px 3px 45px; font-weight: 600;" width="60%">
						Total Arus Kas Dari Kegiatan Investasi
					</td>

					<td style="border-top: 1px solid #aaa"></td>

					<td style="padding: 5px 20px 3px 5px; font-weight: 600; text-align: right; font-size: 9pt;border-top: 1px solid #aaa">
						{{ formatAccounting($icf) }}
					</td>
				</tr>
	        </tr>

	        <tr>
	        	<td colspan="3">&nbsp;</td>
	        </tr>

	        <tr>
	        	<td colspan="3">&nbsp;</td>
	        </tr>

	        <tr>
		        <td style="border-top: 1px solid #aaa; padding: 6px 10px">
	        		Total Akumulasi Arus Kas Periode Ini
	        	</td>

	        	<td style="border-top: 1px solid #aaa;"></td>

	        	<td style="padding: 5px 20px 3px 5px; font-weight: 600; text-align: right; font-size: 9pt;border-top: 1px solid #aaa">
	        		{{ formatAccounting($ocf+$icf+$fcf) }}
	        	</td>
	        </tr>

	        <tr>
		        <td style="border-top: 1px solid #aaa; padding: 6px 10px">
	        		Saldo Awal Kas Pada Periode Ini
	        	</td>

	        	<td style="border-top: 1px solid #aaa;"></td>

	        	<td style="padding: 5px 20px 3px 5px; font-weight: 600; text-align: right; font-size: 9pt;border-top: 1px solid #aaa">
	        		{{ formatAccounting($saldoAwal->saldoAwal) }}
	        	</td>
	        </tr>

	        <tr>
		        <td style="border-top: 1px solid #aaa; padding: 6px 10px">
	        		Saldo Akhir Kas Seharusnya
	        	</td>

	        	<td style="border-top: 1px solid #aaa;"></td>

	        	<td style="padding: 5px 20px 3px 5px; font-weight: 600; text-align: right; font-size: 9pt;border-top: 1px solid #555">
	        		{{ formatAccounting($saldoAwal->saldoAwal+$ocf+$icf+$fcf) }}
	        	</td>

	        </tr>

        </table>
    </div>


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

            

            $('#print').click(function(evt){
              evt.preventDefault();

              window.print();
            })

	    </script>

	</body>
</html>