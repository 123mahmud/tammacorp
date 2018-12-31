<!DOCTYPE html>
<html>
	<head>
		<title>Laporan Piutang Customer</title>
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
				border: 1px solid #555;
		    }
		    #table-data th{
		    	text-align: center;
		    	border: 1px solid #aaa;
		    	border-collapse: collapse;
		    	background: #ccc;
		    	padding: 5px;
		    }

		    #table-data td{
		    	border-right: 1px solid #555;
		    	padding: 5px;
		    	vertical-align: top;
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

	    	.table-saldo{
		    	margin-top: 5px;
		    }

		   .table-saldo td{
		   		text-align: right;
		   		font-weight: 400;
		   		font-style: italic;
		   		padding: 7px 20px 7px 0px;
		   		border-top: 0px solid #efefef;
		    	font-size: 10pt;
		    	color: white;
		    	color: #555;
		   }

		   .table_total{
		    	font-size: 0.8em;
		    	margin-top: 5px;
		    }

		    .table_total th.typed{
		    	text-align: right;
		    	border: 1px solid #aaa;
		    	border-collapse: collapse;
		    	background: #ccc;
		    	padding: 5px 0px;
		    	padding-right: 3px;
		    }

		    .table-info{
		    	margin-bottom: 45px;
		    	font-size: 7pt;
		    	margin-top: 5px;
		    }

          #navigation ul{
            float: right;
            padding-right: 110px;
          }

          #navigation ul li{
            color: #fff;
            font-size: 15pt;
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
	    </style>

	    <style type="text/css" media="print">
	        @page { size: landscape; }
	        #navigation{
	            display: none;
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
	             
	              <li><i class="fa fa-print" style="cursor: pointer;" id="print" data-toggle="tooltip" data-placement="bottom" title="Print Laporan"></i></li>
	            </ul>
	          </div>
	        </div>
	    </div>

	    <div class="col-md-10 col-md-offset-1" style="background: white; padding: 10px 15px; margin-top: 80px;">
  
        <table width="100%" border="0" style="border-bottom: 1px solid #333;" id="contentnya">
          <thead>
            <tr>
              <th style="text-align: left; font-size: 14pt; font-weight: 600">Laporan Piutang Customer <small>({{ ucfirst($request->type) }})</small></th>
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
                Laporan Per {{ date('d/m/Y', strtotime($date_1)) }} s/d {{ date('d/m/Y', strtotime($date_2)) }}
              </td>
            </tr>
          </thead>
        </table>

        @if($request->type == 'detail')

			<table id="table-data" class="table_neraca tree" border="0" width="100%">
				<tbody>

					@foreach($supplier as $key => $supp)

						<tr>
							<td colspan="10" style="padding: 10px; border: 1px solid #555; font-size: 9pt; background: #2E2E2E; color: white; font-weight: bold;">{{ $supp->c_name }}</td>
						</tr>

						<tr>
							<td width="5%" style="text-align: center; border: 1px solid #2e2e2e; background: #eee;">No</td>
							<td width="15%" style="text-align: center; border: 1px solid #2e2e2e; background: #eee;">Nota Penjualan</td>
							<td width="10%" style="text-align: center; border: 1px solid #2e2e2e; background: #eee;">Tanggal Nota</td>
							<td width="10%" style="text-align: center; border: 1px solid #2e2e2e; background: #eee;">Jatuh Tempo</td>
							<td width="12%" style="text-align: center; border: 1px solid #2e2e2e; background: #eee;">Total Gross</td>
							<td width="12%" style="text-align: center; border: 1px solid #2e2e2e; background: #eee;">Total Net</td>
							<td width="12%" style="text-align: center; border: 1px solid #2e2e2e; background: #eee;">Sudah Dibayar</td>
							<td width="12%" style="text-align: center; border: 1px solid #2e2e2e; background: #eee;">Sisa Pelunasan</td>
							<td width="3%" style="text-align: center; border: 1px solid #2e2e2e; background: #eee;">#</td>
							<td width="5%" style="text-align: center; border: 1px solid #2e2e2e; background: #eee;">keterangan</td>
						</tr>

						<?php $empty = true; $no = 0; ?>

						@foreach($data as $key => $purchase)
							@if($purchase->s_customer == $supp->s_customer)

								<?php $empty = false; $no++ ?>

								<tr>
									<td style="text-align: center; border: 1px solid #ccc;">{{ $no }}</td>
									<td style="text-align: center; border: 1px solid #ccc;">{{ $purchase->s_note }}</td>
									<td style="text-align: center; border: 1px solid #ccc;">{{ date('d/m/Y', strtotime($purchase->s_date)) }}</td>
									<td style="text-align: center; border: 1px solid #ccc;">
										{{ ($purchase->s_jatuh_tempo == '0000-00-00') ?  '-' : date('d/m/Y', strtotime($purchase->s_jatuh_tempo)) }}
									</td>
									<td style="text-align: right; border: 1px solid #ccc;">{{ formatAccounting($purchase->s_gross) }}</td>
									<td style="text-align: right; border: 1px solid #ccc;">{{ formatAccounting($purchase->s_net) }}</td>
									<td style="text-align: right; border: 1px solid #ccc;">{{ formatAccounting($purchase->s_net - $purchase->s_sisa) }}</td>
									<td style="text-align: right; border: 1px solid #ccc;">{{ formatAccounting($purchase->s_sisa) }}</td>

									<?php
										$date1 = ($purchase->s_jatuh_tempo != '0000-00-00') ? date_create(date('Y-m-d', strtotime($purchase->s_jatuh_tempo))) : date_create(date('Y-m-d', strtotime($purchase->s_date)));
										$date2 = date_create(date('Y-m-d'));
										$diff=date_diff($date1,$date2);

										$show = '#007E33'; $status = 'On Going';

										if($diff->format("%a") == 0){
											$show = '#FF8800';
											$status = 'Warning';
										}
										else if($diff->format("%R") == '+'){
											$show = '#CC0000';
											$status = 'Overdue';
										}else if($diff->format("%R") == '-'){
											if($diff->format("%a") <= 3){
												$show = '#FF8800';
												$status = 'Warning';
											}
										}

										if($purchase->s_sisa == 0){
											$show = '#fff';
											$status = 'Complete';
										}
									?>

									<td style="text-align: center; border: 1px solid #ccc; padding-top: 8px;">
										<div style="width: 50%; height: 10px; border-radius: 50%; background: {{ $show }}; margin: 0 auto; border: 1px solid #ccc;"></div>
									</td>
									<td style="text-align: center; border: 1px solid #ccc; color: {{ ($status != "Complete") ? $show : '#666' }};">{{ $status }}</td>
								</tr>
							@endif

						@endforeach

						@if($empty)
							<tr>
								<td colspan="10" style="background: white; text-align: center;">Tidak Ada P.O</td>
							</tr>
						@endif

					@endforeach
					
				</tbody>
			</table>

		@else

			<table id="table-data" class="table_neraca tree" border="0" width="100%">
				<tbody>

					<tr>
						<td width="2%" style="text-align: center; color: #fff; background: #2E2E2E;">No</td>
						<td width="20%" style="text-align: center; color: #fff; background: #2E2E2E;">Customer</td>
						<td width="10%" style="text-align: center; color: #fff; background: #2E2E2E;">Min. Tanggal Nota</td>
						<td width="10%" style="text-align: center; color: #fff; background: #2E2E2E;">Maks. Jatuh Tempo</td>
						<td width="12%" style="text-align: center; color: #fff; background: #2E2E2E;">Total Gross</td>
						<td width="12%" style="text-align: center; color: #fff; background: #2E2E2E;">Total Net</td>
						<td width="12%" style="text-align: center; color: #fff; background: #2E2E2E;">Total Sudah Dibayar</td>
						<td width="12%" style="text-align: center; color: #fff; background: #2E2E2E;">Total Sisa Pelunasan</td>
						<td width="3%" style="text-align: center; color: #fff; background: #2E2E2E;">#</td>
						<td width="5%" style="text-align: center; color: #fff; background: #2E2E2E;">keterangan</td>
					</tr>


					<?php $no = 0 ?>
					@foreach($data as $key => $dat)
						<?php $no++ ?>
						<tr>
							<td style="text-align: center; border: 1px solid #ccc;">{{ $no }}</td>
							<td style="text-align: left; border: 1px solid #ccc;">{{ $dat->c_name }} ({{ $dat->total_po }})</td>
							<td style="text-align: center; border: 1px solid #ccc;">
								{{ date('d/m/Y', strtotime($dat->min_tanggal)) }}
							</td>
							<td style="text-align: center; border: 1px solid #ccc;">
								{{ ($dat->max_duedate != '0000-00-00') ? date('d/m/Y', strtotime($dat->max_duedate)) :  '-' }}
							</td>
							<td style="text-align: right; border: 1px solid #ccc;">{{ formatAccounting($dat->total_gross) }}</td>
							<td style="text-align: right; border: 1px solid #ccc;">{{ formatAccounting($dat->total_net) }}</td>
							<td style="text-align: right; border: 1px solid #ccc;">{{ formatAccounting($dat->total_net - $dat->total_sisa) }}</td>
							<td style="text-align: right; border: 1px solid #ccc;">{{ formatAccounting($dat->total_sisa) }}</td>
							<?php
								$date1 = ($dat->max_duedate != '0000-00-00') ? date_create(date('Y-m-d', strtotime($dat->max_duedate))) : date_create(date('Y-m-d', strtotime($dat->min_tanggal)));
								$date2 = date_create(date('Y-m-d'));
								$diff=date_diff($date1,$date2);

								$show = '#007E33'; $status = 'On Going';

								if($diff->format("%a") == 0){
									$show = '#FF8800';
									$status = 'Warning';
								}
								else if($diff->format("%R") == '+'){
									$show = '#CC0000';
									$status = 'Overdue';
								}else if($diff->format("%R") == '-'){
									if($diff->format("%a") <= 3){
										$show = '#FF8800';
										$status = 'Warning';
									}
								}

								if($dat->total_sisa == 0){
									$show = '#fff';
									$status = 'Complete';
								}
							?>

							<td style="text-align: center; border: 1px solid #ccc; padding-top: 8px;">
								<div style="width: 45%; height: 10px; border-radius: 50%; background: {{ $show }}; margin: 0 auto; border: 1px solid #ccc;"></div>
							</td>
							<td style="text-align: center; border: 1px solid #ccc; color: {{ ($status != "Complete") ? $show : '#666' }};">{{ $status }}</td>
						</tr>
					@endforeach
					
				</tbody>
			</table>

		@endif
      </div>

             <!-- Modal -->
              <div class="modal fade" id="modal_buku_besar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document" style="width: 35%;">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">Setting Buku Besar</h4>
                    </div>

                    <form id="form-jurnal" method="get" action="{{ route('laporan_buku_besar.index') }}" target="_self">
                    <div class="modal-body">
                      <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-3">
                          Periode
                        </div>

                        <div class="col-md-4 durasi_bulan_buku_besar">
                          <input type="text" name="durasi_1_buku_besar_bulan" placeholder="Pilih Periode" class="form-control" id="d1_buku_besar" autocomplete="off" required readonly style="cursor: pointer;">
                        </div>


                      </div>

                      <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-3">
                          Pilih Akun 1
                        </div>

                        <div class="col-md-9 durasi_bulan_buku_besar">

                        </div>

                      </div>

                      <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-3">
                          s/d Akun
                        </div>

                        <div class="col-md-9 durasi_bulan_buku_besar">
                          
                        </div>

                      </div>

                      <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-3">
                          Dengan Akun Lawan
                        </div>

                        <div class="col-md-9 durasi_bulan_buku_besar">
                          <select id="akun_2" class="form-control" name="akun_lawan">
                              <option value="true">Ya</option>
                              <option value="false">Tidak</option>
                          </select>
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
	    	$(document).ready(function(){
	    		// modal buku besar
			        $('#d2_buku_besar').datepicker( {
			            format: "yyyy-mm",
		                viewMode: "months", 
		                minViewMode: "months"
			        });

			        $('#d1_buku_besar').datepicker({
			          format: "yyyy-mm",
		              viewMode: "months", 
		              minViewMode: "months"
			        }).on("changeDate", function(){
			            $('#d2_buku_besar').val("");
			            $('#d2_buku_besar').datepicker("setStartDate", $(this).val());
			        });

			        $('#akun_1').change(function(evt){
			          evt.preventDefault();
			          let html = ''; let akun_1 = $('#akun_1'); let val = $(this).val(); let disabled = true;

			          akun_1.children('option').each(function(i){    

			            if($(this).val() == val)
			              disabled = false;

			            if(disabled){
			              html = html + '<option value="'+$(this).val()+'" disabled style="color:rgba(255, 0, 0, 0.6);">'+$(this).text()+'</option>';
			            }else{
			              html = html + '<option value="'+$(this).val()+'">'+$(this).text()+'</option>';
			            }
			          })

			          // alert(html);
			          $('#akun_2').html(html);
			        })
			    // modal buku besar

			    $('#print').click(function(evt){
	              evt.preventDefault();

	              window.print();
	            })
	    	})
	    </script>

	</body>
</html>