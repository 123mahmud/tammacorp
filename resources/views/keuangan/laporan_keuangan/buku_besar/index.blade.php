<!DOCTYPE html>
<html>
	<head>
		<title>Laporan Buku Besar</title>
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
	              <li><i class="fa fa-sliders" style="cursor: pointer;" onclick="$('#modal_buku_besar').modal('show')" data-toggle="tooltip" data-placement="bottom" title="Tampilkan Setting Register Jurnal"></i></li>
	              <li><i class="fa fa-print" style="cursor: pointer;" id="print" data-toggle="tooltip" data-placement="bottom" title="Print Laporan"></i></li>
	            </ul>
	          </div>
	        </div>
	    </div>

	    <div class="col-md-10 col-md-offset-1" style="background: white; padding: 10px 15px; margin-top: 80px;">
  
        <table width="100%" border="0" style="border-bottom: 1px solid #333;" id="contentnya">
          <thead>
            <tr>
              <th style="text-align: left; font-size: 14pt; font-weight: 600">Laporan Buku Besar  </th>
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
              	Periode : {{ $request->durasi_1_buku_besar_bulan }} s/d {{ $request->durasi_2_buku_besar_bulan }}
              </td>
              
            </tr>
          </thead>
        </table>

        <?php $urt = 0; ?>

		@foreach($data as $key => $ledger)
		 	<?php 
		    	$mt = ($urt == 0) ? "m-t" : "m-t-lg"; $saldo = 0; 
				$tot_deb = $tot_kred = 0;
		    ?>

		     <table width="100%" border="0" class="table-saldo" style="margin-top: 10px;">
				<thead>
					<tr>
						<td style="font-weight: bold; text-align: left;border-top: 1px solid #ccc; padding-top: 10px; padding-bottom: 0px;">Nama Perkiraan : {{ $ledger->id_akun }} - &nbsp; {{ $ledger->nama_akun }}</td>
					</tr>
				</thead>
			</table>

			<table id="table-data" class="table_neraca tree" border="0" width="100%">
				<thead>
					<tr>
						<th width="7%">Tanggal</th>
				        <th width="10%">No.Bukti</th>
				        <th width="25%">Keterangan</th>

				        @if($request->akun_lawan == 'true')
					        <th width="5%">Seq</th>
					        <th width="5%">D/K</th>
					        <th width="6%">Acc.Lawan</th>
					    @endif

				        <th width="10%">Debet</th>
				        <th width="10%">Kredit</th>
				        <th width="10%">Saldo</th>
					</tr>
				</thead>

				<tbody>

					<tr>
		              <td></td>
		              <td></td>
		              <td style="padding-left: 50px; font-weight: 600;">

		              	Saldo Awal {{ $request->durasi_1_buku_besar_bulan }}

		          	  </td>

		              @if($request->akun_lawan == 'true')
			              <td></td>
			              <td></td>
			              <td></td>
			          @endif

			          <?php

			          	$deb = (count($data_saldo[$key]->mutasi_bank_debet) > 0) ? $data_saldo[$key]->mutasi_bank_debet->first()->total : 0;
                        $kredit = (count($data_saldo[$key]->mutasi_bank_kredit) > 0) ? $data_saldo[$key]->mutasi_bank_kredit->first()->total : 0;

                        $saldo = $data_saldo[$key]->total + ($deb + $kredit);

                        //$totdeb = $totkred = 0;

                        if(strtotime($data_date) < strtotime($data_saldo[$key]->opening_date)){
                          $saldo = 0;
                        }

			          ?>

		              <td style="padding-left: 8px;" class="money"></td>
		              <td style="padding-left: 8px;" class="money"></td>
		              <td style="padding-right: 8px; font-weight: 600;" class="money text-right">
		              	{{ 
                    		($saldo < 0) ? '('.number_format(str_replace('-', '', $saldo), 2).')' : number_format($saldo,2) 
                    	}}
		              </td>
		            </tr>

					@foreach($ledger->jurnal_detail as $jurnal)

						<?php 
		                    $debet = $kredit = 0;

		                    $saldo += $jurnal->jrdt_value;

		                    if($jurnal->jrdt_dk == "D"){
		                      $debet = str_replace("-", "", $jurnal->jrdt_value);
		                      $tot_deb += $debet;
		                    }
		                    else{
		                      $kredit = str_replace("-", "", $jurnal->jrdt_value);
		                      $tot_kred += $kredit;
		                    }

		                ?>

						<tr>
		                    <td style="padding-left: 5px;" class="text-center">{{ $jurnal->jurnal->tanggal_jurnal }}</td>
		                    <td style="padding-left: 5px;">{{ $jurnal->jurnal->no_jurnal }}</td>
		                    <td style="padding-left: 5px;">{{ $jurnal->jurnal->keterangan }}</td>

		                    @if($request->akun_lawan == 'true')
			                    <td style="padding-left: 5px;" class="text-center">001</td>
			                    <td style="padding-left: 5px;" class="text-center">{{ $jurnal->jrdt_dk }}</td>
			                    <td style="padding-left: 5px;" class="text-center">{{ $jurnal->jrdt_acc }}</td>
			                @endif

		                    <td class="money text-right" style="padding-right: 8px;">{{ number_format($debet,2) }}</td>
		                    <td class="money text-right" style="padding-right: 8px;">{{ number_format($kredit,2) }}</td>
		                    <td class="money text-right" style="padding-right: 8px;font-weight: 600;">
		                    	{{ 
		                    		($saldo < 0) ? '('.number_format(str_replace('-', '', $saldo), 2).')' : number_format($saldo,2) 
		                    	}}
		                    </td>
		                </tr>

		                @if($request->akun_lawan == 'true')
		                  	@foreach($jurnal->jurnal->detail as $key => $data_detail)
		                  		@if($data_detail->jrdt_acc != $jurnal->jrdt_acc)
			                  		<tr>
					                    <td style="padding-left: 5px;" class="text-center">&nbsp;</td>
					                    <td style="padding-left: 5px;" class="text-center">&nbsp;</td>
					                    <td style="padding-left: 5px;">{{ $jurnal->jurnal->keterangan }}</td>

					                    @if($request->akun_lawan == 'true')
						                    <td style="padding-left: 5px;" class="text-center">{{ str_pad(($key + 1), 3, "0",STR_PAD_LEFT) }}</td>
					                    	<td style="padding-left: 5px;" class="text-center">{{ $data_detail->jrdt_dk }}</td>
					                    	<td style="padding-left: 5px;" class="text-center">{{ $data_detail->jrdt_acc }}</td>
					                    @endif

					                    <td class="money text-right" style="padding-right: 8px;">{{ number_format(0,2) }}</td>
					                    <td class="money text-right" style="padding-right: 8px;">{{ number_format(0,2) }}</td>
					                    <td class="money text-right" style="padding-right: 8px;font-weight: 600;">
					                    	{{ 
					                    		($saldo < 0) ? '('.number_format(str_replace('-', '', $saldo), 2).')' : number_format($saldo,2) 
					                    	}}
					                    </td>
					                </tr>
					            @endif
		                  	@endforeach
		                @endif

	                  	@if($request->akun_lawan == 'true')
		                  	<tr style="background: #f1f1f1;">
			                    <td style="padding-left: 5px;">&nbsp;</td>
			                    <td style="padding-left: 5px;">&nbsp;</td>
			                    <td style="padding-left: 5px;">&nbsp;</td>
			                    <td style="padding-left: 5px;"></td>
			                    <td style="padding-left: 5px;"></td>
			                    <td style="padding-left: 5px;"></td>
			                    <td class="money text-right" style="padding-right: 8px;">&nbsp;</td>
			                    <td class="money text-right" style="padding-right: 8px;">&nbsp;</td>
			                    <td class="money text-right" style="padding-right: 8px;font-weight: 600;">
			                    	&nbsp;
			                    </td>
			                </tr>
			            @endif
					@endforeach
				</tbody>
			</table>

			<table class="table_total tree" border="0" width="100%">
				<thead>
					<tr>
						<th width="8%"></th>
				        <th width="8%"></th>
				        <th width="25%"></th>

				        @if($request->akun_lawan == 'true')
					        <th width="5%"></th>
					        <th width="5%"></th>
					        <th width="6%"></th>
					    @endif

				        <th width="10%" class="typed" style="padding-right: 8px;">{{ number_format($tot_deb, 2) }}</th>
				        <th width="10%" class="typed" style="padding-right: 8px;">{{ number_format($tot_kred, 2) }}</th>
				        <th width="10%" class="typed" style="padding-right: 8px;">
				        	{{ 
	                    		($saldo < 0) ? '('.number_format(str_replace('-', '', $saldo), 2).')' : number_format($saldo,2) 
	                    	}}
				        </th>
					</tr>
				</thead>
			</table>

			<table width="100%" border="0" class="table-info">
				<thead>
					<tr>
						<td style="text-align: right; font-weight: 400; padding: 0px 5px 0px 0px; border-top: 0px solid #efefef;">Laporan Buku Besar Bulan {{ $request->durasi_1_buku_besar_bulan }} &nbsp;s/d &nbsp; {{ $request->durasi_2_buku_besar_bulan }}</td>
					</tr>
				</thead>
			</table>
		@endforeach

        <table id="table" width="100%" border="0" style="font-size: 8pt; margin-top: 4px;">
          <thead>
            <tr>
              
            </tr>
          </thead>
        </table>

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
                          <input type="text" name="durasi_1_buku_besar_bulan" placeholder="periode Mulai" class="form-control" id="d1_buku_besar" autocomplete="off" required readonly style="cursor: pointer;">
                        </div>

                        <div class="col-md-1">
                          s/d
                        </div>

                        <div class="col-md-4 durasi_bulan_buku_besar">
                          <input type="text" name="durasi_2_buku_besar_bulan" placeholder="Periode Akhir" class="form-control" id="d2_buku_besar" autocomplete="off" required readonly style="cursor: pointer;">
                        </div>

                      </div>

                      <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-3">
                          Pilih Akun 1
                        </div>

                        <div class="col-md-9 durasi_bulan_buku_besar">
                          <select id="akun_1" class="form-control" name="akun_1">
                            @foreach($data_akun as $key => $akun)
                              <option value="{{ $akun->id_akun }}">{{ $akun->id_akun }} - {{ $akun->nama_akun }}</option>
                            @endforeach
                          </select>
                        </div>

                      </div>

                      <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-3">
                          s/d Akun
                        </div>

                        <div class="col-md-9 durasi_bulan_buku_besar">
                          <select id="akun_2" class="form-control" name="akun_2">
                              @foreach($data_akun as $key => $akun)
                                <option value="{{ $akun->id_akun }}">{{ $akun->id_akun }} - {{ $akun->nama_akun }}</option>
                              @endforeach
                          </select>
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