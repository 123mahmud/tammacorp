<!DOCTYPE html>
<html>
  <head>
    <title>Analisa Cashflow</title>
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

      <div class="col-md-12" style="background: white; padding: 10px 15px; width: 1600px; margin-top: 80px;">
  
        <table width="100%" border="0" style="border-bottom: 1px solid #333;" id="contentnya">
          <thead>
            <tr>
              <th style="text-align: left; font-size: 14pt; font-weight: 600">
                Analisa Cashflow <small>({{ ucfirst($request->jenis) }})</small>
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
              <th width="16%">Ket</th>
              <th width="7%">Januari</th>
              <th width="7%">Februari</th>
              <th width="7%">Maret</th>
              <th width="7%">April</th>
              <th width="7%">Mei</th>
              <th width="7%">Juni</th>
              <th width="7%">Juli</th>
              <th width="7%">Agustus</th>
              <th width="7%">September</th>
              <th width="7%">Oktober</th>
              <th width="7%">November</th>
              <th width="7%">Desember</th>
            </tr>
          </thead>

          <tbody>

            <tr>
              <td style="font-weight: 600;">Saldo Awal</td>
              @foreach($data as $key => $saldoAwal)
                <td style="text-align: right; background: #eee; font-weight: 600;">{{ formatAccounting($saldoAwal['saldoAwal']) }}</td>
              @endforeach
            </tr>

            <tr>
              <td style="background: #eee;">OCF IN</td>
              @foreach($data as $key => $ocfIn)
                <td style="text-align: right;">{{ formatAccounting($ocfIn['ocfIn']) }}</td>
              @endforeach
            </tr>

            <tr>
              <td style="background: #eee;">OCF OUT</td>
              @foreach($data as $key => $ocfOut)
                <td style="text-align: right;">{{ formatAccounting($ocfOut['ocfOut']) }}</td>
              @endforeach
            </tr>

            <tr>
              <td style="font-weight: 600;">Total OCF</td>
              @foreach($data as $key => $totalOcf)
                <td style="text-align: right; background: #eee; font-weight: 600;">{{ formatAccounting(($totalOcf['ocfIn'] - $totalOcf['ocfOut'])) }}</td>
              @endforeach
            </tr>

            <tr>
              <td style="background: #eee;">ICF IN</td>
              @foreach($data as $key => $icfIn)
                <td style="text-align: right;">{{ formatAccounting($icfIn['icfIn']) }}</td>
              @endforeach
            </tr>

            <tr>
              <td style="background: #eee;">ICF OUT</td>
              @foreach($data as $key => $icfOut)
                <td style="text-align: right;">{{ formatAccounting($icfOut['icfOut']) }}</td>
              @endforeach
            </tr>

            <tr>
              <td style="font-weight: 600;">Total ICF</td>
              @foreach($data as $key => $totalIcf)
                <td style="text-align: right; background: #eee; font-weight: 600;">{{ formatAccounting(($totalIcf['icfIn'] - $totalIcf['icfOut'])) }}</td>
              @endforeach
            </tr>

            <tr>
              <td style="background: #eee;">FCF IN</td>
              @foreach($data as $key => $fcfIn)
                <td style="text-align: right;">{{ formatAccounting($fcfIn['fcfIn']) }}</td>
              @endforeach
            </tr>

            <tr>
              <td style="background: #eee;">FCF OUT</td>
              @foreach($data as $key => $fcfOut)
                <td style="text-align: right;">{{ formatAccounting($fcfOut['fcfOut']) }}</td>
              @endforeach
            </tr>

            <tr>
              <td style="font-weight: 600;">Total FCF</td>
              @foreach($data as $key => $totalFcf)
                <td style="text-align: right; background: #eee; font-weight: 600;">{{ formatAccounting(($totalFcf['fcfIn'] - $totalFcf['fcfOut'])) }}</td>
              @endforeach
            </tr>

            <tr>
              <td colspan="13" style="background: #4B515D;"></td>
            </tr>

            <tr>
              <td style="background: #eee; text-align: center; font-weight: 600;">Total Cashflow</td>

              @foreach($data as $key => $tot)
                <?php 
                  $tots = ($tot['ocfIn'] - $tot['ocfOut']) + ($tot['icfIn'] - $tot['icfOut']) + ($tot['fcfIn'] - $tot['fcfOut']);
                ?>
                <td style="text-align: right; background: #eee; font-weight: 600;">{{ formatAccounting($tots) }}</td>
              @endforeach
            </tr>

            <tr>
              <td style="background: #eee; text-align: center; font-weight: 600;">Saldo Akhir</td>
              @foreach($data as $key => $tot)
                <?php 
                  $tots = ($tot['ocfIn'] - $tot['ocfOut']) + ($tot['icfIn'] - $tot['icfOut']) + ($tot['fcfIn'] - $tot['fcfOut']);
                ?>
                <td style="text-align: right; background: #eee; font-weight: 600;">{{ formatAccounting($tot['saldoAwal'] + $tots) }}</td>
              @endforeach
            </tr>

            <tr>
              <td colspan="13" style="background: #4B515D;"></td>
            </tr>

            @if($request->jenis == 'bulanan')
              <tr>
                <td style="background: #eee; text-align: center; font-weight: 600;">State Cashflow</td>
                @foreach($data as $key => $tot)
                  <?php 
                    $state = 0;
                    $opening = $tot['saldoAwal'];
                    $ocfIn = $tot['ocfIn'];
                    $cfOut = ($tot['ocfOut'] + $tot['icfOut'] + $tot['fcfOut']);
                    $ocf   = ($totalOcf['ocfIn'] - $totalOcf['ocfOut']);

                    if($ocfIn >= $cfOut){
                      $state = 1;
                    }else if(($opening + $ocfIn) >= $cfOut){
                      if($ocf >= 0)
                        $state = 2;
                      else
                        $state = 3;
                    }else if(($opening + $ocfIn) < $cfOut){
                      if($ocf >= 0)
                        $state = 4;
                      else
                        $state = 5;
                    }

                  ?>
                  <td style="text-align: center; background: #eee; font-weight: 600;">{{ $state }}</td>
                @endforeach
              </tr>
            @endif

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