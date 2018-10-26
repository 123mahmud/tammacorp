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
      <li class="active">Edit Relasi Barang ke Supplier</li>
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
              <a href="#alert-tab" data-toggle="tab">Edit Relasi Barang ke Supplier</a>
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
                  <form method="POST" action="{{ url('master/databrgsup/update-relasi-barang') }}/{{$data[0]->d_bs_itemid}}" id="form_relasi_barang">
                    {{ csrf_field() }}
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 20px; padding-bottom:5px;padding-top:10px;padding-left:-10px;padding-right: -10px; ">
                      
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <label class="tebal">Nama Barang</label>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="form-group">
                            <input type="text" name="namabrg" id="namabrg" class="form-control input-sm" value="{{$data[0]->i_code.' '.$data[0]->i_name}}" readonly>
                            <input type="hidden" name="idbrg" id="idbrg" class="form-control input-sm" value="{{$data[0]->d_bs_itemid}}" readonly>
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
                        @foreach ($datasup1 as $list1)
                          <label class="col-md-6 col-sm-6 col-xs-6 lbl-check">
                            @for ($i = 0; $i <count($data); $i++)
                              @if ($list1->s_id == $data[$i]->d_bs_supid)
                                <input type="hidden" value="{{$list1->s_id}}" class="ip_hidden" name="ip_cek[]">
                              @endif
                            @endfor
                            <input type="checkbox" value="{{$list1->s_id}}" name="form_cek[]" class="ceklis_supplier">
                                {{$list1->s_company}}                        
                          </label>
                         @endforeach
                         @foreach ($datasup2 as $list2)
                          <label class="col-md-6 col-sm-6 col-xs-6 lbl-check">
                            @for ($i = 0; $i <count($data); $i++)
                              @if ($list2->s_id == $data[$i]->d_bs_supid)
                                <input type="hidden" value="{{$list2->s_id}}" class="ip_hidden" name="ip_cek[]">
                              @endif
                            @endfor
                            <input type="checkbox" value="{{$list2->s_id}}" name="form_cek[]" class="ceklis_supplier">
                                {{$list2->s_company}}                        
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
          $('input.ceklis_supplier[value="'+ipcek+'"]').iCheck('check');
        }
      });
    });    
  }); 
</script> 
@endsection