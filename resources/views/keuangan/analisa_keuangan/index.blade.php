@extends('main')

@section('extra_styles')
    <link type="text/css" rel="stylesheet" href="{{ asset('js/chosen/chosen.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('js/datepicker/datepicker.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('js/toast/dist/jquery.toast.min.css') }}">

    <style>
      .transaksi-wrapper{
      	border: 1px solid #eee;
      	border-radius: 10px;
      	box-shadow: 0px 0px 10px #ccc;
      	text-align: center;
      	background: none;
      	margin-left: 4.8em;
      }

      .transaksi-wrapper .icon{
      	padding: 70px 0px 45px 0px;
      	background: none;
      	border-bottom: 1px solid #eee;
      }

      .transaksi-wrapper .icon i{
      	font-size: 75pt;
      }

      .transaksi-wrapper .text{
      	color: #999;
      	font-size: 11pt;
      	padding: 20px 0px;
      	cursor: pointer;
        font-weight: 500;
      }

      .transaksi-wrapper .text:hover{
      	color: #0d47a1;
      }
    </style>
@endsection

@section('content')
            <!--BEGIN PAGE WRAPPER-->
            <div id="vue-element">
              <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">Pilihan Laporan</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li> &nbsp;Keuangan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Pilihan Laporan</li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
                <div class="page-content fadeInRight">
                    <div id="tab-general">
                      <div class="row mbl">
                        <div class="col-lg-12">
                            
                          <div class="col-md-12">
                              <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
                              </div>
                          </div>
                             
                          <ul id="generalTab" class="nav nav-tabs">
                            {{-- <li class="active"><a href="#alert-tab" data-toggle="tab">Form Master Data Akun Keuangan</a></li> --}}
                            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
                          </ul>

                          <div id="generalTabContent" class="tab-content responsive">
                            <div id="alert-tab" class="tab-pane fade in active">
                              <div class="row">

                                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 40px;">

                                    <div class="col-md-3 transaksi-wrapper">
                                      <div class="col-md-12 icon">
                                        <i class="fa fa-bar-chart-o" style="color: #9933CC;"></i>
                                      </div>

                                      <div class="col-md-12 text">
                                        <a href="{{ url('/keuangan/analisaocf/analisa2') }}">Analisa Net Profit / OCF</a>
                                      </div>
                                    </div>

                                    <div class="col-md-3 transaksi-wrapper">
                                      <div class="col-md-12 icon">
                                        <i class="fa fa-bar-chart-o" style="color: #9933CC;"></i>
                                      </div>

                                      <div class="col-md-12 text">
                                        <a href="#" data-toggle="modal" data-target="#modal_analisa_pertumbuhan_aset">Analisa Pertumbuhan Aset</a>
                                      </div>
                                    </div>

                                    <div class="col-md-3 transaksi-wrapper">
                                      <div class="col-md-12 icon">
                                        <i class="fa fa-bar-chart-o" style="color: #9933CC;"></i>
                                      </div>

                                      <div class="col-md-12 text">
                                        <a href="#" data-toggle="modal" data-target="#modal_analisa_cashflow">Analisa Cashflow</a>
                                      </div>
                                    </div>

                                </div>     

                                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 40px;">

                                    {{-- <div class="col-md-3 transaksi-wrapper">
                                      <div class="col-md-12 icon">
                                        <i class="fa fa-bar-chart-o" style="color: #9933CC;"></i>
                                      </div>

                                      <div class="col-md-12 text">
                                        <a href="#">(Analisa Common Size dan Index)</a>
                                      </div>
                                    </div>

                                    <div class="col-md-3 transaksi-wrapper">
                                      <div class="col-md-12 icon">
                                        <i class="fa fa-bar-chart-o" style="color: #9933CC;"></i>
                                      </div>

                                      <div class="col-md-12 text">
                                        <a href="#">(Analisa Rasio Keuangan)</a>
                                      </div>
                                    </div>

                                    <div class="col-md-3 transaksi-wrapper">
                                      <div class="col-md-12 icon">
                                        <i class="fa fa-bar-chart-o" style="color: #9933CC;"></i>
                                      </div>

                                      <div class="col-md-12 text">
                                        <a href="#">(Analisa Three Bottom Line)</a>
                                      </div>
                                    </div> --}}

                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 40px;">

                                    {{-- <div class="col-md-3 transaksi-wrapper">
                                      <div class="col-md-12 icon">
                                        <i class="fa fa-bar-chart-o" style="color: #9933CC;"></i>
                                      </div>

                                      <div class="col-md-12 text">
                                        <a href="#">(Analisa ROE)</a>
                                      </div>
                                    </div> --}}

                                </div>       

                              </div>
                            </div>    
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

              <!-- Modal -->
              <div class="modal fade" id="modal_analisa_cashflow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document" style="width: 35%;">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">Setting Analisa Cashflow</h4>
                    </div>

                    <form id="form-jurnal" method="get" action="{{ route('analisa.cashflow') }}" target="_blank">

                    <div class="modal-body">
                      <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-4">
                          Type Analisa
                        </div>

                        <div class="col-md-8">
                          <select class="form-control" name="jenis">
                            <option value="bulanan">Bulanan</option>
                            <option value="akumulasi">Akmulasi</option>
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

              <!-- Modal -->
              <div class="modal fade" id="modal_analisa_pertumbuhan_aset" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document" style="width: 35%;">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">Setting Analisa Pertumbuhan Aset</h4>
                    </div>

                    <form id="form-jurnal" method="get" action="{{ route('analisa.aset') }}" target="_blank">

                    <div class="modal-body">
                      <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-4">
                          Tahun Analisa
                        </div>

                        <div class="col-md-8">
                          <?php
                              $before = (int) (date('Y') - 10);
                              $after = (int) (date('Y') + 10);
                           ?>
                          <select class="form-control select2" name="tahun">

                            @for($i = $before; $i <= $after; $i++)
                              @if($i == date('Y'))
                                <option value="{{ $i }}" selected>{{ $i }}</option>
                              @else
                                <option value="{{ $i }}">{{ $i }}</option>
                              @endif
                            @endfor

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
                            
@endsection

@section("extra_scripts")
  
  <script src="{{ asset("js/datepicker/datepicker.js") }}"></script>

  <script type="text/javascript">

      $(document).ready(function(){
        $('.select2').select2();
      })

  </script>

@endsection                            
