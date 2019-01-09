@extends('main')

@section('extra_styles')
    <style>
      
        .dash-container{
            background: white;
            padding: 0px 0px 10px 0px;
        }

        .dash-container .title{
            font-size: 12pt;
            padding: 0px 10px 10px 10px;
            border-bottom: 1px solid #ccc;
        }

    </style>
@endsection

@section('content')
<!DOCTYPE html>
<div>
    <!-- <div id="loading"></div> -->
    <!--BEGIN BACK TO TOP-->
    <a id="totop" href="#"><i class="fa fa-angle-up"></i></a>
    <!--END BACK TO TOP-->
        <!--BEGIN PAGE WRAPPER-->
        <div id="page-wrapper">
            <!--BEGIN TITLE & BREADCRUMB PAGE-->
            <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">
                        Home</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a></li>
                </ol>
                <div class="clearfix">
                </div>
            </div>
            <!--END TITLE & BREADCRUMB PAGE-->
            <!--BEGIN CONTENT-->
            <div class="page-content">
                <div id="tab-general">
                    <div id="sum_box" class="row mbl">
                        <div class="col-sm-6 col-md-3">
                            <div class="panel profit db mbm">
                                <div class="panel-body">
                                    <p class="icon">
                                        <i class="icon fa fa-shopping-cart"></i>
                                    </p>
                                    <h4 class="value">
                                        <span data-counter="" data-start="10" data-end="50" data-step="1" data-duration="0">
                                        {{ $data['total_sales']->total_sales/1000 }}</span><span>K</span></h4>
                                    <p class="description">
                                        Total Penjualan</p>
                                    <div class="progress progress-sm mbn">
                                        <div role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"
                                            style="width: 80%;" class="progress-bar progress-bar-success">
                                            <span class="sr-only">80% Complete (success)</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="panel income db mbm">
                                <div class="panel-body">
                                    <p class="icon">
                                        <i class="icon fa fa-money"></i>
                                    </p>
                                    <h4 class="value">
                                        <span>{{ $data['total_purchase']->total_pembelian/1000 }}</span><span>K</span></h4>
                                    <p class="description">
                                        Total Pembelian</p>
                                    <div class="progress progress-sm mbn">
                                        <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                                            style="width: 60%;" class="progress-bar progress-bar-info">
                                            <span class="sr-only">60% Complete (success)</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="panel task db mbm">
                                <div class="panel-body">
                                    <p class="icon">
                                        <i class="icon fa fa-signal"></i>
                                    </p>
                                    <h4 class="value">
                                        <span>{{ $data['total_spk']->total_spk }}</span><span> SPK</span></h4>
                                    <p class="description">
                                        Total SPk Bulan Ini</p>
                                    <div class="progress progress-sm mbn">
                                        <div role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"
                                            style="width: 50%;" class="progress-bar progress-bar-danger">
                                            <span class="sr-only">50% Complete (success)</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="panel visit db mbm">
                                <div class="panel-body">
                                    <p class="icon">
                                        <i class="icon fa fa-group"></i>
                                    </p>
                                    <h4 class="value">
                                        <span>{{ $data['total_produksi']->total_produksi }}</span> pcs</h4>
                                    <p class="description">
                                        Total Produksi Bulan Ini/p>
                                    <div class="progress progress-sm mbn">
                                        <div role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"
                                            style="width: 70%;" class="progress-bar progress-bar-warning">
                                            <span class="sr-only">70% Complete (success)</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="sum_box" class="row mbl" style="padding: 0px 15px;">
                        <div class="col-md-8 dash-container">
                            <div class="col-md-12 content">
                                {{-- <canvas id="analisaocfChart" height="300" ></canvas> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--END CONTENT-->
            <!--BEGIN FOOTER-->
{{--             <div id="footer">
                <div class="copyright">
                    <a href="#">2017 © TammaFood</a></div>
            </div> --}}
            <!--END FOOTER-->
        </div>
        <!--END PAGE WRAPPER-->
</div>
               
@endsection

@section("extra_scripts")
    
    <script type="text/javascript">
        new Chart(document.getElementById("analisaocfChart"), {
              // Jenis Chart
              type: 'line',

              // Set Data Chart
              data: {
                labels: {!! $date_1 !!},
                datasets: [{ 
                    data: [13, 14, 15, 17, 13.5],
                    label: '',
                    borderColor: "#3e95cd",
                    fill: false
                  }
                ]
              },

              // Konfigurasi
              options: {
                title: {
                  display: true,
                  text: 'Record Pendapatan 5 Bulan Terakhir'
                }
                // responsive: true;
              }
        });
    </script>

@endsection