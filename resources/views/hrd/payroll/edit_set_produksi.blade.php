@extends('main') @section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Setting Gaji</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
        <i></i>&nbsp;HRD&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Setting Gaji</li>
    </ol>
    <div class="clearfix">
    </div>
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
            <li class="active">
              <a href="#alert-tab" data-toggle="tab">Setting Gaji</a>
            </li>
            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
          </ul>
          <div id="generalTabContent" class="tab-content responsive">
            <div id="alert-tab" class="tab-pane fade in active">
              <div class="row">
                <div class="col-md-12">
                  <form method="POST" action="{{ url('hrd/payroll/update-gaji-pro') }}/{{ $data->c_id }}">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 20px; padding-bottom:5px;padding-top:15px;padding-left:-10px;padding-right: -10px; ">
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Nama Gaji:</label>
                      </div>
                      <div class="col-md-10 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" value="{{ $data->nm_gaji }}" name="nm_gaji" class="form-control input-sm">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Gaji:</label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="number" value="{{ $data->c_gaji }}" name="c_gaji" class="form-control input-sm">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Lembur:</label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="number" value="{{ $data->c_lembur }}" name="c_lembur" class="form-control input-sm">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Jenis Gaji</label>
                      </div>
                      <div class="col-md-10 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <select class="form-control form-control-sm" name="c_status">
                            @if ($data->c_status == 'HR')
                               <option value="HR">Harian</option>
                               <option value="GR">Garapan</option>
                            @else
                              <option value="GR">Garapan</option>
                              <option value="HR">Harian</option>
                            @endif
                          </select>
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Untuk Jabatan:</label>
                      </div>
                      <div class="col-md-10 col-sm-8 col-xs-12" style="margin-bottom:20px">
                        <div class="form-group">
                          
                          @foreach ($txt as $lis)
                            <label class="col-md-12 col-sm-12 col-xs-12 lbl-check">
                              @for ($i = 0; $i <count($list); $i++)
                                @if ($list[$i] == $lis->c_id)
                                  <input type="hidden" value="{{$list[$i]}}" class="ip_hidden" name="ip_cek[]">
                                @endif
                              @endfor
                              <input type="checkbox" value="{{$lis->c_id}}" name="form_cek[]" class="ceklis_tunjangan">
                                  {{$lis->c_jabatan_pro}}                         
                            </label>
                          @endforeach
                           
                        </div>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12">
                        <input type="button" value="Batal" class="btn btn-danger btn-block">
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12">
                        <input type="submit" value="Simpan" class="btn btn-primary btn-block">
                      </div>
                  </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endsection @section('extra_scripts')
          <script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
          <script src="{{ asset("js/inputmask/inputmask.jquery.js") }}"></script>
          <script type="text/javascript">
            $(document).ready(function() { 
              $('#btn-check-all').click(function() {
                 $('.ceklis_tunjangan').iCheck('check');
              });
              $('#btn-uncheck-all').click(function() {
                 $('.ceklis_tunjangan').iCheck('uncheck');
              });

              var numcheck = $(".ip_hidden").length;
              //alert(numcheck);
              // for (var i = 0; i < numcheck; i++) {
              //   alert($("input[name='form_cek]").val());
              // }
              $('input[name="form_cek[]"]').each(function() 
              {
                var ceklis = $(this).val();
                $('input[name="ip_cek[]"]').each(function() 
                {
                  var ipcek = $(this).val();
                  if (ipcek == ceklis) 
                  {
                    $('input.ceklis_tunjangan[value="'+ipcek+'"]').iCheck('check');
                  }
                });
              });    
            }); 
          </script>  @endsection