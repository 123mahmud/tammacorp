@extends('main') 
@section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Setting Tunjangan Pegawai</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
        <i></i>&nbsp;HRD&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Setting Tunjangan Pegawai</li>
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
              <a href="#alert-tab" data-toggle="tab">Setting Tunjangan Pegawai</a>
            </li>
          </ul>
          <div id="generalTabContent" class="tab-content responsive">
            <div id="alert-tab" class="tab-pane fade in active">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:-10px;margin-bottom: 15px;">
                  <div class="col-md-5 col-sm-6 col-xs-8">
                    <h4>Setting Tunjangan Pegawai</h4>
                  </div>
                  <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                    <a href="{{ url('hrd/payroll/set-tunjangan-pegawai-man') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                  </div>
                </div>
                <div class="col-md-12">
                  <form method="POST" action="{{ url('hrd/payroll/update-tunjangan-peg') }}/{{ $data->c_id }}" id="form_tunjangan_peg">
                    {{ csrf_field() }}
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 20px; padding-bottom:5px;padding-top:10px;padding-left:-10px;padding-right: -10px; ">

                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <label class="tebal">Nama Pegawai</label>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <input type="text" name="namapeg" id="namapeg" class="form-control input-sm" value="{{$data->c_nama}}" readonly>
                          <input type="hidden" name="idpeg" id="idpeg" readonly="" class="form-control input-sm"  value="{{$data->c_id}}">
                        </div>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <label class="tebal">Divisi</label>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <label class="tebal">Jabatan</label>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="form-group">
                          <input type="text" name="divisipeg" id="divisipeg" class="form-control input-sm" value="{{$data->c_divisi}}" readonly>
                          <input type="hidden" name="iddivisi" id="iddivisi" readonly="" class="form-control input-sm" value="{{$data->c_divisi_id}}">
                        </div>  
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="form-group">
                          <input type="text" name="jabatanpeg" id="jabatanpeg" class="form-control input-sm" value="{{$data->c_posisi}}" readonly>
                          <input type="hidden" name="idjabatan" id="idjabatan" readonly="" class="form-control input-sm" value="{{$data->c_jabatan_id}}">
                        </div>  
                      </div>
                      
                      <div class="col-md-9 col-sm-9 col-xs-9">
                        <label class="tebal">Daftar Tunjangan (Ceklist pada tunjangan terpilih)</label>
                      </div>
                      <div class="col-md-3 col-sm-3 col-xs-3" align="right">
                        <button type="button" class="btn btn-success btn-sm" id="btn-check-all">Check all</button>
                        <button type="button" class="btn btn-default btn-sm" id="btn-uncheck-all">Uncheck all</button>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px;">
                        @foreach ($tunjangan as $val)
                          @if ($val->tman_periode == 'HR')
                            <?php $periode = 'Harian'; ?>
                          @elseif($val->tman_periode == 'JM')
                            <?php $periode = 'Jam'; ?>
                          @elseif($val->tman_periode == 'MG')
                            <?php $periode = 'Mingguan'; ?>
                          @elseif($val->tman_periode == 'TH')
                            <?php $periode = 'Tahunan'; ?>
                          @else
                            <?php $periode = 'Statis'; ?>
                          @endif
                          <label class="col-md-12 col-sm-12 col-xs-12 lbl-check">
                            @for ($i = 0; $i <count($list); $i++)
                              @if ($list[$i] == $val->tman_id)
                                <input type="hidden" value="{{$list[$i]}}" class="ip_hidden" name="ip_cek[]">
                              @endif
                            @endfor
                            <input type="checkbox" value="{{$val->tman_id}}" name="form_cek[]" class="ceklis_tunjangan">
                                {{$val->tman_nama}} | Periode : {{$periode}}                        
                          </label>
                        @endforeach
                      </div>
                      
                      <div class="col-md-6 col-sm-12 col-xs-12">
                        <a href="{{ url('hrd/payroll/set-tunjangan-pegawai-man') }}" class="btn btn-danger btn-block"> Kembali </a>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12">
                        <input type="submit" value="Simpan" class="btn btn-primary btn-block">
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection 
@section('extra_scripts')
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
</script> 
@endsection