<!DOCTYPE html>
<html>
  <head>
    <title>Analisa Pertumbuhan Aset</title>
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
          border: 1px solid #ccc;
        }

        #table-data tfoot td{
          padding: 5px;
          border: 1px solid #aaa;
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
            <div class="col-md-7" style="background: none; padding: 15px 15px; color: #fff; padding-left: 120px; padding: 15pt;">
              TammaFood
            </div>
            <div class="col-md-5" style="background: none; padding: 10px 15px 5px 15px">
              <ul>
                {{-- <li><i class="fa fa-sliders" style="cursor: pointer;" onclick="$('#modal_neraca_saldo').modal('show')" data-toggle="tooltip" data-placement="bottom" title="Tampilkan Setting Register Jurnal"></i></li>
                <li><i class="fa fa-print" style="cursor: pointer;" id="print" data-toggle="tooltip" data-placement="bottom" title="Print Laporan"></i></li> --}}
              </ul>
            </div>
          </div>
      </div>

      <div class="col-md-10 col-md-offset-1" style="background: white; padding: 10px 15px; margin-top: 80px;">
  
        <table width="100%" border="0" style="border-bottom: 1px solid #333;" id="contentnya">
          <thead>
            <tr>
              <th style="text-align: left; font-size: 14pt; font-weight: 600">
                Analisa Pertumbuhan Aset <small>({{ $request->tahun }})</small>
              </th>
            </tr>

            <tr>
              <th style="text-align: left; font-size: 12pt; font-weight: 500">Tamma Robbah Indonesia</th>
            </tr>

            <tr>
              <th style="text-align: left; font-size: 8pt; font-weight: 500; padding-bottom: 10px;">(Angka Disajikan Dalam Rupiah, Kecuali Dinyatakan Lain)</th>
            </tr>
          </thead>
        </table>

        <table id="table-data" width="100%" border="0">
          <thead>
            <tr>
              <th width="10%">Bulan</th>
              <th width="15%">Total Nilai Aset</th>
              <th width="15%">Penambahan/Pengurangan</th>
              <th width="30%">Status Dengan Periode Bulan Sebelumnya</th>
              <th width="30%">Persentase Perubahan</th>
            </tr>
          </thead>

          <tbody>

            @foreach($data as $key => $value)
              <tr>
                @if(date('Y-m', strtotime($value['periode'])) == date('Y-m'))

                  <td style="text-align: center; background: #eee;">{{ $value['namaBulan'] }}</td>
                  <td style="text-align: center; background: #eee; font-weight: 600;" colspan="4">Periode Sedang Berjalan</td>

                @else

                  <?php
                    $val = $value['nilaiSaldo'];
                    $valBefore = ($key > 0) ? $data[($key-1)]['nilaiSaldo'] : 0;
                    $selisih = $val - $valBefore;

                    if($selisih == 0)
                      $nilai = 0;
                    elseif($val == 0 || $valBefore == 0)
                      $nilai = 100;
                    else
                      $nilai = ($selisih / $val) * 100;
                  ?>

                  <td style="text-align: center;">{{ $value['namaBulan'] }}</td>
                  <td style="text-align: right;">{{ formatAccounting($value['nilaiSaldo']) }}</td>
                  <td style="text-align: right;">{{ formatAccounting($selisih) }}</td>

                  @if($selisih > 0)
                    <td style="text-align: center;">
                      <i class="fa fa-arrow-circle-o-up" style="color: green;"></i> &nbsp;Naik
                    </td>
                  @elseif($selisih < 0)
                    <td style="text-align: center;">
                      <i class="fa fa-arrow-circle-o-down" style="color: red;"></i> &nbsp;Turun
                    </td>
                  @else
                    <td style="text-align: center;">
                      <i class="fa fa-arrows-h" style="color: blue;"></i> &nbsp;Tetap
                    </td>
                  @endif
                  <td style="text-align: center;">{{ formatAccounting($nilai) }} %</td>

                @endif
              </tr>
            @endforeach

          </tbody>
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

      </script>

  </body>
</html>