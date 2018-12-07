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
      	font-size: 14pt;
      	padding: 20px 0px;
      	cursor: pointer;
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
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="col-md-3 transaksi-wrapper">
                                    	<div class="col-md-12 icon">
                                    		<i class="fa fa-clipboard" style="color: #007E33;"></i>
                                    	</div>

                                    	<div class="col-md-12 text">
                                    		<a href="#" data-toggle="modal" data-target="#modal_jurnal">Jurnal Umum</a>
                                    	</div>
                                    </div>

                                    <div class="col-md-3 transaksi-wrapper">
                                    	<div class="col-md-12 icon">
                                    		<i class="fa fa-book" style="color: #FF8800;"></i>
                                    	</div>

                                    	<div class="col-md-12 text">
                                    		<a href="#" data-toggle="modal" data-target="#modal_buku_besar">Buku Besar</a>
                                    	</div>
                                    </div>

                                    <div class="col-md-3 transaksi-wrapper">
                                    	<div class="col-md-12 icon">
                                    		<i class="fa fa-random" style="color: #CC0000;"></i>
                                    	</div>

                                    	<div class="col-md-12 text">
                                    		<a href="#" data-toggle="modal" data-target="#modal_neraca_saldo">Neraca Saldo</a>
                                    	</div>
                                    </div>
                                </div> 

                                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 40px;">
                                    <div class="col-md-3 transaksi-wrapper">
                                      <div class="col-md-12 icon">
                                        <i class="fa fa-columns" style="color: #9933CC;"></i>
                                      </div>

                                      <div class="col-md-12 text">
                                        <a href="#" data-toggle="modal" data-target="#modal_neraca">Neraca</a>
                                      </div>
                                    </div>

                                    <div class="col-md-3 transaksi-wrapper">
                                      <div class="col-md-12 icon">
                                        <i class="fa fa-level-up" style="color: #00695c;"></i>
                                      </div>

                                      <div class="col-md-12 text">
                                        <a href="#" data-toggle="modal" data-target="#modal_laba_rugi">Laba Rugi</a>
                                      </div>
                                    </div>

                                    <div class="col-md-3 transaksi-wrapper">
                                      <div class="col-md-12 icon">
                                        <i class="fa fa-refresh" style="color: #0099CC;"></i>
                                      </div>

                                      <div class="col-md-12 text">
                                        <a href="#" data-toggle="modal" data-target="#modal_arus_kas">Arus Kas</a>
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
                </div>

              </div>

              <!-- Modal -->
              <div class="modal fade" id="modal_jurnal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document" style="width: 35%;">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">Setting Jurnal</h4>
                    </div>

                    <form id="form-jurnal" method="get" action="{{ route('laporan_jurnal.index') }}" target="_blank">
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
                          <input type="text" name="durasi_1_jurnal_bulan" placeholder="periode Mulai" class="form-control" id="d1_jurnal" autocomplete="off" required readonly style="cursor: pointer;">
                        </div>

                        <div class="col-md-4 durasi_tahun_jurnal" style="display: none;">
                          <input type="text" name="durasi_1_jurnal_tahun" placeholder="periode Mulai" class="form-control" id="d1_jurnal_tahun" autocomplete="none">
                        </div>

                        <div class="col-md-1">
                          s/d
                        </div>

                        <div class="col-md-4 durasi_bulan_jurnal">
                          <input type="text" name="durasi_2_jurnal_bulan" placeholder="Periode Akhir" class="form-control" id="d2_jurnal" autocomplete="off" required readonly style="cursor: pointer;">
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


              <!-- Modal -->
              <div class="modal fade" id="modal_buku_besar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document" style="width: 35%;">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">Setting Buku Besar</h4>
                    </div>

                    <form id="form-jurnal" method="get" action="{{ route('laporan_buku_besar.index') }}" target="_blank">
                    <div class="modal-body">
                      <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-3">
                          Periode
                        </div>

                        <div class="col-md-4 durasi_bulan_buku_besar">
                          <input type="text" name="durasi_1_buku_besar_bulan" placeholder="Pilih Periode" class="form-control" id="d1_buku_besar" autocomplete="off" required readonly style="cursor: pointer;">
                        </div>

                        {{-- <div class="col-md-1">
                          s/d
                        </div>

                        <div class="col-md-4 durasi_bulan_buku_besar">
                          <input type="text" name="durasi_2_buku_besar_bulan" placeholder="Periode Akhir" class="form-control" id="d2_buku_besar" autocomplete="off" required readonly style="cursor: pointer;">
                        </div> --}}

                      </div>

                      <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-3">
                          Pilih Akun 1
                        </div>

                        <div class="col-md-9 durasi_bulan_buku_besar">
                          <select id="akun_1" class="form-control select-2" name="akun_1">
                            @foreach($data as $key => $akun)
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
                          <select id="akun_2" class="form-control select-2" name="akun_2">
                              @foreach($data as $key => $akun)
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

              <!-- Modal -->
              <div class="modal fade" id="modal_neraca_saldo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document" style="width: 35%;">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">Setting Neraca Saldo</h4>
                    </div>

                    <form id="form-jurnal" method="get" action="{{ route('laporan_neraca_saldo.index') }}" target="_blank">
                    <div class="modal-body">
                      <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-3">
                          Periode
                        </div>

                        <div class="col-md-4 durasi_bulan_neraca_saldo">
                          <input type="text" name="durasi_1_neraca_saldo_bulan" placeholder="Pilih Periode" class="form-control" id="d1_neraca_saldo" autocomplete="off" required readonly style="cursor: pointer;">
                        </div>

                        {{-- <div class="col-md-1">
                          s/d
                        </div>

                        <div class="col-md-4 durasi_bulan_neraca_saldo">
                          <input type="text" name="durasi_2_neraca_saldo_bulan" placeholder="Periode Akhir" class="form-control" id="d2_neraca_saldo" autocomplete="off" required readonly style="cursor: pointer;">
                        </div> --}}
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
                            {{-- <option value="tahun">Tahun</option> --}}
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

              <!-- Modal -->
              <div class="modal fade" id="modal_laba_rugi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document" style="width: 35%;">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">Setting Laba Rugi</h4>
                    </div>

                    <form id="form-jurnal" method="get" action="{{ route('laporan_laba_rugi.index') }}" target="_blank">
                    <div class="modal-body">
                      <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-3">
                          Jenis Periode
                        </div>

                        <div class="col-md-4">
                          <select name="jenis" class="form-control" id="jenis_periode_laba_rugi">
                            <option value="bulan">Bulan</option>
                            {{-- <option value="tahun">Tahun</option> --}}
                          </select>
                        </div>
                    </div>

                      <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-3">
                          Periode
                        </div>

                        <div class="col-md-9 durasi_bulan_laba_rugi">
                          <input type="text" name="durasi_1_laba_rugi_bulan" placeholder="periode Mulai" class="form-control" id="d1_laba_rugi" autocomplete="off" required readonly style="cursor: pointer;">
                        </div>

                        <div class="col-md-9 durasi_tahun_laba_rugi" style="display: none;">
                          <input type="text" name="durasi_1_laba_rugi_tahun" placeholder="periode Mulai" class="form-control" id="d1_laba_rugi_tahun" autocomplete="off" required readonly style="cursor: pointer;">
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
              <div class="modal fade" id="modal_arus_kas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document" style="width: 35%;">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">Setting Arus Kas</h4>
                    </div>

                    <form id="form-jurnal" method="get" action="{{ route('laporan_arus_kas.index') }}" target="_blank">
                    <div class="modal-body">
                      <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-3">
                          Jenis Periode
                        </div>

                        <div class="col-md-4">
                          <select name="jenis" class="form-control" id="jenis_periode_arus_kas">
                            <option value="bulan">Bulan</option>
                            {{-- <option value="tahun">Tahun</option> --}}
                          </select>
                        </div>
                    </div>

                      <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-3">
                          Periode
                        </div>

                        <div class="col-md-9 durasi_bulan_arus_kas">
                          <input type="text" name="durasi_1_arus_kas_bulan" placeholder="periode Mulai" class="form-control" id="d1_arus_kas" autocomplete="off" required readonly style="cursor: pointer;">
                        </div>

                        <div class="col-md-9 durasi_tahun_arus_kas" style="display: none;">
                          <input type="text" name="durasi_1_arus_kas_tahun" placeholder="periode Mulai" class="form-control" id="d1_arus_kas_tahun" autocomplete="off" required readonly style="cursor: pointer;">
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


      // modal buku besar

        $('.select-2').select2();

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

      // modal neraca saldo

        $('#d2_neraca_saldo').datepicker( {
            format: "yyyy-mm",
            viewMode: "months", 
            minViewMode: "months"
        });

        $('#d1_neraca_saldo').datepicker({
          format: "yyyy-mm",
          viewMode: "months", 
          minViewMode: "months"
        }).on("changeDate", function(){
            $('#d2_buku_besar').val("");
            $('#d2_buku_besar').datepicker("setStartDate", $(this).val());
        });

      // modal neraca saldo

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

      // modal laba rugi

        $('#d2_laba_rugi').datepicker( {
            format: "yyyy-mm",
            viewMode: "months", 
            minViewMode: "months"
        });

        $('#d1_laba_rugi').datepicker({
          format: "yyyy-mm",
          viewMode: "months", 
          minViewMode: "months"
        })

        $('#d1_laba_rugi_tahun').datepicker({
          format: "yyyy",
          viewMode: "years", 
          minViewMode: "years"
        })

        $('#jenis_periode_laba_rugi').change(function(evt){
          evt.preventDefault();

          if($(this).val() == 'bulan'){
            $('.durasi_bulan_laba_rugi').show();
            $('.durasi_tahun_laba_rugi').hide();
          }else{
            $('.durasi_bulan_laba_rugi').hide();
            $('.durasi_tahun_laba_rugi').show();
          }
        })

      // modal laba rugi

      // modal arus kas

        $('#d1_arus_kas').datepicker({
          format: "yyyy-mm",
          viewMode: "months", 
          minViewMode: "months"
        })

        $('#d1_arus_kas_tahun').datepicker({
          format: "yyyy",
          viewMode: "years", 
          minViewMode: "years"
        })

        $('#jenis_periode_arus_kas').change(function(evt){
          evt.preventDefault();

          if($(this).val() == 'bulan'){
            $('.durasi_bulan_arus_kas').show();
            $('.durasi_tahun_arus_kas').hide();
          }else{
            $('.durasi_bulan_arus_kas').hide();
            $('.durasi_tahun_arus_kas').show();
          }
        })

      // modal arus kas

    });
  </script>

@endsection                            
