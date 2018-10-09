<!DOCTYPE html>
<html>
	<head>
		<title>Laporan Jurnal</title>
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
		    	border-right: 1px solid #555;
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
	        font-size: 15pt;
	        list-style-type: none;
	        display: inline-block;
	        margin-left: 40px;
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
          <div class="col-md-7" style="background: none; padding: 15px 15px; color: #fff; padding-left: 120px;">
            TammaFood
          </div>
          <div class="col-md-5" style="background: none; padding: 10px 15px 5px 15px">
            <ul>
              <li><i class="fa fa-sliders" style="cursor: pointer;" onclick="$('#modal_jurnal').modal('show')" data-toggle="tooltip" data-placement="bottom" title="Tampilkan Setting Register Jurnal"></i></li>
              <li><i class="fa fa-print" style="cursor: pointer;" id="print" data-toggle="tooltip" data-placement="bottom" title="Print Laporan"></i></li>
            </ul>
          </div>
        </div>
    </div>

	<div class="col-md-10 col-md-offset-1" style="background: white; padding: 10px 15px; margin-top: 80px;">
  
        <table width="100%" border="0" style="border-bottom: 1px solid #333;">
          <thead>
            <tr>
              <th style="text-align: left; font-size: 14pt; font-weight: 600">Laporan Jurnal {{ ucfirst($request->jenis) }}</th>
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
                Transaksi : Bulan {{ $d1 }} s/d {{ $d2 }}
              </td>
              
            </tr>
          </thead>
        </table>

        <table id="table-data" width="100%" border="0">
			<thead>
				<tr>
					<th width="8%">Tanggal</th>
					<th width="12%">No.Bukti</th>
					<th width="8%">No.Perkiraan</th>

					@if($request->nama_perkiraan)
						<th width="20%">Nama Perkiraan</th>
					@endif
					<th>Uraian</th>

					<th width="11%">Debet</th>
					<th width="11%">Kredit</th>
				</tr>
			</thead>

			<tbody>
				
				<?php $sum_debet = $sum_kredit = 0; ?>
				@foreach($data as $data_jr)
					<?php $tot_debet = $tot_kredit = 0; ?>
					@foreach($detail[$data_jr->jurnal_id] as $key => $data_detail)
						<tr>
							<td style="padding-left: 3px;">{{ date('d-m-Y', strtotime($data_jr->tanggal_jurnal)) }}</td>
							<td style="padding-left: 3px;">{{ $data_jr->no_jurnal }}</td>
							<td style="padding-left: 3px;">{{ $data_detail->jrdt_acc }}</td>

							@if($request->nama_perkiraan)
								<td style="padding-left: 3px;">{{ $data_detail->nama_akun }}</td>
							@endif

							<td style="padding-left: 3px;">{{ $data_jr->keterangan }}</td>
							
							<?php 
								$deb = $kre = 0;
								if($data_detail->jrdt_dk == "D") {
									$deb = str_replace("-", "", $data_detail->jrdt_value);
									$tot_debet += $deb;
									$sum_debet += $deb;
								}else{
									$kre = str_replace("-", "", $data_detail->jrdt_value);
									$tot_kredit += $kre;
									$sum_kredit += $kre;
								}
							?>

							<td class="currency">{{ number_format($deb, 2) }}</td>
							<td class="currency no-border">{{ number_format($kre, 2) }}</td>
						</tr>
					@endforeach

					<tr>
						<td style="background: #f1f1f1;">&nbsp;</td>
						<td style="background: #f1f1f1;">&nbsp;</td>
						<td style="background: #f1f1f1;">&nbsp;</td>

						@if($request->nama_perkiraan)
							<td style="background: #f1f1f1;">&nbsp;</td>
						@endif

						<?php
							$not = "";

							if(number_format($tot_debet, 2) != number_format($tot_kredit, 2))
								$not = "not-same"
						?>

						<td style="background: #f1f1f1;">&nbsp;</td>
						<td class="currency total {{$not}}">{{ number_format($tot_debet, 2) }}</td>
						<td class="currency total no-border {{$not}}">{{ number_format($tot_kredit, 2) }}</td>
					</tr>

				@endforeach
				
			</tbody>
		</table>

		<table id="table" width="100%" border="0" style="font-size: 8pt; margin-top: 4px;">
			<thead>
				<tr>
					<th width="8%"></th>
					<th width="12%"></th>
					<th width="8%"></th>

					@if($request->nama_perkiraan)
						<th width="25%"></th>
					@endif
					<th></th>

					<th width="11%" style="text-align: right; padding: 7px 5px; border-bottom: 1px solid #999;">{{ number_format($sum_debet, 2) }}</th>
					<th width="11%" style="text-align: right; padding: 7px 5px; border-bottom: 1px solid #999;">{{ number_format($sum_kredit, 2) }}</th>
				</tr>
			</thead>
		</table>

        <table id="table" width="100%" border="0" style="font-size: 8pt; margin-top: 4px;">
          <thead>
            <tr>
              
            </tr>
          </thead>
        </table>

      </div>

	      <!-- modal -->
		<!-- Modal -->
              <div class="modal fade" id="modal_jurnal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document" style="width: 35%;">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">Setting Jurnal</h4>
                    </div>

                    <form id="form-jurnal" method="get" action="{{ route('laporan_jurnal.index') }}" target="_self">
                    <div class="modal-body">
                      <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-3">
                          Jenis Transaksi
                        </div>

                        <div class="col-md-9">
                          <select class="form-control" name="jenis">
                            <option value="kas">Jurnal Kas</option>
                            <option value="bank">Jurnal Bank</option>
                            <option value="memorial">Jurnal Memorial</option>
                          </select>
                        </div>
                      </div>

                      <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-3">
                          Periode
                        </div>

                        <div class="col-md-4 durasi_bulan_jurnal">
                          <input type="text" name="durasi_1_jurnal_bulan" placeholder="periode Mulai" class="form-control" id="d1_jurnal" autocomplete="off" required>
                        </div>

                        <div class="col-md-4 durasi_tahun_jurnal" style="display: none;">
                          <input type="text" name="durasi_1_jurnal_tahun" placeholder="periode Mulai" class="form-control" id="d1_jurnal_tahun" autocomplete="none">
                        </div>

                        <div class="col-md-1">
                          s/d
                        </div>

                        <div class="col-md-4 durasi_bulan_jurnal">
                          <input type="text" name="durasi_2_jurnal_bulan" placeholder="Periode Akhir" class="form-control" id="d2_jurnal" autocomplete="off" required>
                        </div>

                        <div class="col-md-4 durasi_tahun_jurnal" style="display: none;">
                          <input type="text" name="durasi_2_jurnal_tahun" placeholder="Periode Akhir" class="form-control" id="d2_jurnal_tahun" autocomplete="none">
                        </div>
                      </div>

                      <div class="row" style="margin-bottom: 0px;">
                        <div class="col-md-3">
                          Dengan Nama Perkiraan
                        </div>

                        <div class="col-md-4">
                          <select class="form-control" name="nama_perkiraan">
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
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
	    	// modal_jurnal

	          $('#d2_jurnal').datepicker( {
	              format: 'dd-mm-yyyy',
	          });

	          $('#d1_jurnal').datepicker({
	            format: 'dd-mm-yyyy',
	          }).on("changeDate", function(){
	              $('#d2_jurnal').val("");
	              $('#d2_jurnal').datepicker("setStartDate", $(this).val());
	          });

	          $('#d2_jurnal_tahun').datepicker( {
	              format: "yyyy",
	              viewMode: "years", 
	              minViewMode: "years"
	          });

	          $('#d1_jurnal_tahun').datepicker({
	              format: "yyyy",
	              viewMode: "years", 
	              minViewMode: "years"
	          }).on("changeDate", function(){
	              $('#d2_jurnal_tahun').val("");
	              $('#d2_jurnal_tahun').datepicker("setStartDate", $(this).val());
	          });

	          $('#durasi_jurnal').change(function(evt){
	              evt.preventDefault();

	              if($(this).val() == 'bulan'){
	                $('.durasi_bulan_jurnal').show();
	                $('.durasi_tahun_jurnal').hide();
	              }else{
	                $('.durasi_bulan_jurnal').hide();
	                $('.durasi_tahun_jurnal').show();
	              }
	          })

	      // modal_jurnal end

	      	$('#print').click(function(evt){
              evt.preventDefault();

              window.print();
            })
	    </script>

	</body>
</html>