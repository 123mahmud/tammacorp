@extends('main')
@section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Analisa OCF Terhadap Net Profit</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li><i></i>&nbsp;Keuangan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Analisa OCF Terhadap Net Profit</li>
    </ol>
    <div class="clearfix">
    </div>
  </div>

  <div class="page-content fadeInRight">
      <div class="row" style="padding: 0px 10px;">
        <div class="col-md-12 text-center" style="padding-right:10px;">
          <canvas id="analisaocfChart" height="400px;" style="margin: 0 auto;"></canvas>
        </div>

        <div class="col-md-12" style="margin-top: 30px; background: white; padding: 10px; box-shadow: 0px 0px 20px #4B515D;">
          <table class="table table-bordered table-stripped" style="margin-bottom: 0px;">
            <thead>
              <tr>
                <th class="text-center" style="background: #FF8800; color: white; font-size: 8pt;">Ket</th>
                @foreach(json_decode($date) as $key => $a)
                  <th class="text-center" style="background: #FF8800; color: white; font-size: 8pt;">{{ $a }}</th>
                @endforeach
              </tr>
            </thead>

            <tbody>
              <tr>
                <td class="text-center" style="background: #3E4551; color: white; font-size: 8pt;">OCF</td>
                @foreach(json_decode($tot_ocf) as $key => $a)
                  <th class="text-right" style="font-size: 8pt;">{{ formatAccounting($a) }} Jt</th>
                @endforeach
              </tr>

              <tr>
                <td class="text-center" style="background: #3E4551; color: white; font-size: 8pt;">Net Profit</td>
                @foreach(json_decode($tot_pendapatan) as $key => $a)
                  <th class="text-right" style="font-size: 8pt;">{{ formatAccounting($a) }} Jt</th>
                @endforeach
              </tr>
            </tbody>
          </table>
        </div>

        {{--< div class="col-md-3" style="background: white; box-shadow: 0px 0px 10px #aaa; min-height: 250px;">
          <div class="row">
            <div class="col-md-6 text-center" style="background: #FF8800; border-right: 1px solid white;padding: 5px 0px;">
              <a href="#piutang-tab" data-toggle="tab" style="color: white;">Piutang</a>
            </div>

            <div class="col-md-6 text-center" style="background: #FF8800; padding: 5px 0px;">
              <a href="#hutang-tab" data-toggle="tab" style="color: white;">Hutang</a>
            </div>
          </div>

          <div class="row tab-content" style="padding: 0px 5px; border: 0px; background: none;">

            <div id="piutang-tab" class="tab-pane fade in active">
              
              <table class="table table-stripped" style="margin-top: 10px; font-size: 9pt; margin-bottom: 0px;">
                <thead>
                  <tr>
                    <td>Saldo Awal Piutang</td>
                    <td>:</td>
                    <td class="text-right"><b>{{ formatAccounting($piutang["Saldo_awal"]) }}</b></td>
                  </tr>

                  <tr>
                    <td colspan="3" style="padding: 10px 0px;">&nbsp;</td>
                  </tr>

                  <tr>
                    <td>Piutang Baru</td>
                    <td>:</td>
                    <td class="text-right"><b>{{ formatAccounting($piutang["baru"]) }}</b></td>
                  </tr>
                  <tr>
                    <td>Yang Sudah Dibayar</td>
                    <td>:</td>
                    <td class="text-right"><b>{{ formatAccounting($piutang["dibayar"]) }}</b></td>
                  </tr>
                  <tr>
                    <td>Sisa Seharusnya</td>
                    <td>:</td>
                    <td class="text-right"><b>{{ formatAccounting($piutang["Saldo_awal"] + ($piutang["baru"] - $piutang["dibayar"])) }}</b></td>
                  </tr>
                </thead>
              </table>

            </div>

            <div id="hutang-tab" class="tab-pane fade">
              
              <table class="table table-stripped" style="margin-top: 10px; font-size: 9pt; margin-bottom: 0px;">
                <thead>
                  <tr>
                    <td>Saldo Awal Hutang</td>
                    <td>:</td>
                    <td class="text-right"><b>{{ formatAccounting($hutang["Saldo_awal"]) }}</b></td>
                  </tr>

                  <tr>
                    <td colspan="3" style="padding: 10px 0px;">&nbsp;</td>
                  </tr>

                  <tr>
                    <td>Hutang Baru</td>
                    <td>:</td>
                    <td class="text-right"><b>{{ formatAccounting($hutang["baru"]) }}</b></td>
                  </tr>
                  <tr>
                    <td>Yang Sudah Dibayar</td>
                    <td>:</td>
                    <td class="text-right"><b>{{ formatAccounting($hutang["dibayar"]) }}</b></td>
                  </tr>
                  <tr>
                    <td>Sisa Seharusnya</td>
                    <td>:</td>
                    <td class="text-right"><b>{{ formatAccounting($hutang["Saldo_awal"] + ($hutang["baru"] - $hutang["dibayar"])) }}</b></td>
                  </tr>
                </thead>
              </table>

            </div>

          </div>

          <div class="row text-center" style="font-weight: bold; border-top: 1px solid #eee; padding: 10px 0px;">
            Periode {{ date('m/Y') }}
          </div>
        </div> --}}
    </div>
  </div>

</div>

@endsection

@section("extra_scripts")


<script type="text/javascript">

 new Chart(document.getElementById("analisaocfChart"), {

  // Jenis Chart
  type: 'line',

  // Set Data Chart
  data: {
    labels: {!! $date !!},
    datasets: [{ 
        data: {!! $tot_pendapatan !!},
        label: "Net Profit",
        borderColor: "#FF8800",
        fill: false
      }, { 
        data: {!! $tot_ocf !!},
        label: "OCF",
        borderColor: "#3E4551",
        fill: false
      }
    ]
  },

  // Konfigurasi
  options: {
    title: {
      display: true,
      text: 'Nilai OCF Terhadap Net Profit (Juta)'
    }
    // responsive: true;
  }
});
</script>
@endsection()