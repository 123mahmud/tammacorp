@extends('main') 
@section('content')
<style>
  .ui-autocomplete { z-index:2147483647; }
  .error { border: 1px solid #f00; }
  .valid { border: 1px solid #8080ff; }
  .has-error .select2-selection {
    border: 1px solid #f00 !important;
  }
  .has-valid .select2-selection {
    border: 1px solid #8080ff !important;
  }
</style>
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Tambah Relasi Barang ke Supplier</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
        <i></i>&nbsp;Master&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Tambah Relasi Barang ke Supplier</li>
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
              <a href="#alert-tab" data-toggle="tab">Tambah Relasi Barang ke Supplier</a>
            </li>
          </ul>
          <div id="generalTabContent" class="tab-content responsive">
            <div id="alert-tab" class="tab-pane fade in active">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:-10px;margin-bottom: 15px;">
                  <div class="col-md-5 col-sm-6 col-xs-8">
                    <h4>Setting Relasi Barang ke Supplier</h4>
                  </div>
                  <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                    <a href="{{ url('master/databrgsup/index') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                  </div>
                </div>
                <div class="col-md-12">
                  <form method="POST" action="{{ url('master/databrgsup/simpan-relasi-barang') }}" id="form_relasi_barang">
                    {{ csrf_field() }}
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 20px; padding-bottom:5px;padding-top:10px;padding-left:-10px;padding-right: -10px; ">
                      
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <label class="tebal">Nama Barang</label>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="form-group">
                            <input type="text" name="namabrg" id="namabrg" class="form-control input-sm ui-autocomplete-input" placeholder="Masukkan nama barang" autocomplete="off">
                            <input type="hidden" name="idbrg" id="idbrg" readonly="" class="form-control input-sm">
                          </div>
                        </div>
                      </div>
                      
                      <div class="col-md-12 col-sm-12 col-xs-12" style="padding-bottom: 20px;"> 
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <label class="tebal">Daftar Supplier (Ceklist pada supplier terpilih)</label>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3" align="right">
                          <button type="button" class="btn btn-success btn-sm" id="btn-check-all">Check all</button>
                          <button type="button" class="btn btn-default btn-sm" id="btn-uncheck-all">Uncheck all</button>
                        </div>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px;">
                        @foreach ($data1 as $val1)
                          <label class="col-md-6 col-sm-6 col-xs-6 lbl-check">
                            <input type="checkbox" value="{{$val1->s_id}}" name="form_cek[]" class="ceklis_supplier">
                                {{$val1->s_company}}                        
                          </label>
                         @endforeach
                         @foreach ($data2 as $val2)
                          <label class="col-md-6 col-sm-6 col-xs-6 lbl-check">
                            <input type="checkbox" value="{{$val2->s_id}}" name="form_cek[]" class="ceklis_supplier">
                                {{$val2->s_company}}                        
                          </label>
                         @endforeach 
                      </div>
                      
                      <div class="col-md-6 col-sm-12 col-xs-12">
                        <a href="{{ url('master/databrgsup/index') }}" class="btn btn-danger btn-block"> Kembali </a>
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
<script type="text/javascript">
  $(document).ready(function() { 
    $('#btn-check-all').click(function() {
       $('.ceklis_supplier').iCheck('check');
    });
    $('#btn-uncheck-all').click(function() {
       $('.ceklis_supplier').iCheck('uncheck');
    });

    //autocomplete
    $( "#namabrg" ).focus(function() {
       var key = 1;
       $( "#namabrg" ).autocomplete({
          source: baseUrl+'/master/databrgsup/autocomplete-barang',
          minLength: 1,
          select: function(event, ui) {
            $('#idbrg').val(ui.item.id);
            $('#namabrg').val(ui.item.label);
          }
       });
       $('#idbrg').val("");
       $('#namabrg').val("");
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